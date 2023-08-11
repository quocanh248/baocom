<?php

namespace App\Http\Controllers;

use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use DB;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Exception;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use App\Models\Modelnhansu;
use App\Models\Modelnhomlamviec;
use DateTime;
use DateTimeZone;
use App\Models\Modelquyenuser;
use Illuminate\Support\Facades\File;
use PhpParser\Node\Stmt\Return_;

class Nhansucontroller extends Controller
{


    public function laythongtinnhansu()
    {
        $query = [
            "size" => 2584,    "_source" => [
                "includes" => ["idNo", "gender", "tag", "address", "name", "workgroup"],
            ],
            "query" => [
                "bool" => [
                    "filter" => [
                        ["exists" => ["field" => "tag"]],
                        [
                            "bool" => [
                                "must_not" => [
                                    ["match" => ["tag" => "null"]],
                                ],
                            ],
                        ],
                        ["term" => ["status" => "active"]],
                    ],
                ],
            ],
            "sort" => [
                ["workgroup" => ["order" => "asc"]],
                ["_id" => ["order" => "asc"]],
            ],
        ];

        $hosts = [
            [
                'host' => "es-discovery-vt.vietnhatcorp.com.vn",
                'port' => "443",
                'scheme' => "https",
                'user' => env('ELASTICSEARCH_USER'),
                'pass' => env('ELASTICSEARCH_PASSWORD'),

            ],
        ];


        $client = ClientBuilder::create()->setSSLVerification(false)->setHosts($hosts)->build();
        $index = "vtc-personnel-v1";
        $params = ["index" => $index, "body" => $query];

        $response = $client->search($params);
        $hits = $response["hits"]["hits"];
        $workCapabilities = [];

        foreach ($hits as $hit) {
            $workCapability = $hit['_source'];

            $workCapability['id'] = $hit['_id'];
            $workCapability['workgroup'] = $workCapability['workgroup'];
            $workCapability['name'] = $workCapability['name'];
            $workCapability['tag'] = $workCapability['tag'];
            $workCapabilities[] = $workCapability;
        }

        $nhom_data = array();
        for ($i = 0; $i < count($workCapabilities); $i++) {

            $kr = Modelnhomlamviec::where('tennhom', $workCapabilities[$i]['workgroup'])->first();
            if ($kr == null) {
                $nhom_row = array(
                    'tennhom' => $workCapabilities[$i]['workgroup'],

                );
                if (!in_array($nhom_row, $nhom_data)) {
                    array_push($nhom_data, $nhom_row);
                }
            } else {
            }
        }
        Modelnhomlamviec::insert($nhom_data);
        $day_data = array();
        for ($i = 0; $i < count($workCapabilities); $i++) {
            $ktrban = Modelnhansu::where('manhanvien', $workCapabilities[$i]['id'])->first();
            $kr = Modelnhomlamviec::where('tennhom', $workCapabilities[$i]['workgroup'])->first();
            if ($ktrban) {
                if ($ktrban->manhom != $kr->manhom) {
                    DB::table('nhansu')
                        ->where('manhanvien', '=', $workCapabilities[$i]['id'])
                        ->update(['manhom' => $kr->manhom]);
                }
            } else {
                $day_row = array(
                    'manhanvien' => $workCapabilities[$i]['id'],
                    'tennhanvien' => $workCapabilities[$i]['name'],
                    'tag' => $workCapabilities[$i]['tag'],
                    'manhom' => $kr->manhom,
                    // 'ttlot' => "",
                );
                Modelnhansu::insert($day_row);
            }
        }
        $dsnhansu =  DB::table('nhansu')
            ->leftjoin('nhomlamviec', 'nhomlamviec.manhom', '=', 'nhansu.manhom')
            ->leftjoin('diemdanh', 'diemdanh.manhanvien', '=', 'nhansu.manhanvien')
            ->select('nhomlamviec.manhom', 'tennhom', 'nhansu.manhanvien',  'tennhanvien', 'tag', 'gio', 'xuong')
            ->groupBy('nhomlamviec.manhom', 'tennhom', 'nhansu.manhanvien', 'tennhanvien', 'tag', 'gio', 'xuong')
            ->orderBy('manhom')
            ->get();
        $dd = DB::table('diemdanh')->get();
        return view('dsnhansu', [
            'dsnhansu' => $dsnhansu,
            'dd' => $dd
        ]);
    }
    public function themnhansu(Request $request)
    {
        // Lưu trữ các giá trị dữ liệu vào cơ sở dữ liệu
        $manhanvien = $request->input('manhanvien');
        $tag = $request->input('tag');
        $name = $request->input('name');
        $tennhom = $request->input('tennhom');;
        $nhom_data = array();
        for ($i = 0; $i < count($tennhom); $i++) {
            $kr = Modelnhomlamviec::where('tennhom', $tennhom[$i])->first();
            if ($kr == null) {
                $nhom_row = array(
                    'tennhom' => $tennhom[$i],

                );
                if (!in_array($nhom_row, $nhom_data)) {
                    array_push($nhom_data, $nhom_row);
                }
            } else {
            }
        }
        Modelnhomlamviec::insert($nhom_data);
        $day_data = array();
        for ($i = 0; $i < count($manhanvien); $i++) {
            $ktrban = Modelnhansu::where('manhanvien', $manhanvien[$i])->first();
            $kr = Modelnhomlamviec::where('tennhom', $tennhom[$i])->first();
            if ($ktrban) {
            } else {
                $day_row = array(
                    'manhanvien' => $manhanvien[$i],
                    'tennhanvien' => "$name[$i]",
                    'tag' => "$tag[$i]",
                    'manhom' => $kr->manhom,
                    // 'ttlot' => "",
                );
                Modelnhansu::insert($day_row);
            }
        }
    }
    public function lichlamviec()
    {
        $currentDate = Carbon::tomorrow();
        $t = $currentDate->setTimezone('Asia/Ho_Chi_Minh')->startOfDay();
        // Chuyển đổi ngày của ngày mai sang epoch
        $epoch = $t->timestamp;
        // $epoch = 1684688400;
        $query = [
            'size' => 10000,
            'query' => [
                'bool' => [
                    'must' => [
                        ['exists' => ['field' => 'regularHours']],
                        [
                            'range' => [
                                'startTimestamp' => [
                                    'gte' => $epoch,
                                    'lte' => $epoch + 86340
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            "sort" => [
                ["workgroup" => ["order" => "asc"]],
                ["_id" => ["order" => "asc"]],
            ],
        ];

        $hosts = [
            [
                'host' => "es-discovery-vt.vietnhatcorp.com.vn",
                'port' => "443",
                'scheme' => "https",
                'user' => env('ELASTICSEARCH_USER'),
                'pass' => env('ELASTICSEARCH_PASSWORD'),


            ],
        ];


        $client = ClientBuilder::create()->setSSLVerification(false)->setHosts($hosts)->build();
        $index = "vtc-work_capability-v1";
        $params = ["index" => $index, "body" => $query];

        $response = $client->search($params);



        $workCapabilities = [];
        foreach ($response['hits']['hits'] as $hit) {
            $workCapability = $hit['_source'];
            $workCapability['startTimestamp'] = Carbon::createFromTimestamp($workCapability['startTimestamp'],  'Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
            $workCapability['endTimestamp'] = Carbon::createFromTimestamp($workCapability['endTimestamp'],  'Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
            $workCapabilities[] = $workCapability;
        }
        //dd($workCapabilities[0]['shift']);
        $insertData = [];
        $existingIds = [];
        for ($j = 0; $j < count($workCapabilities); $j++) {
            $id = $workCapabilities[$j]['personId'];

            // Kiểm tra xem 'id' đã tồn tại trong mảng tạm thời hay chưa
            if (!in_array($id, $existingIds)) {
                // Thêm 'id' vào mảng tạm thời
                $existingIds[] = $id;

                // Thêm dữ liệu vào mảng $insertData
                $insertData[] = [
                    'manhanvien' => $id,
                    'giobatdau' => $workCapabilities[$j]['startTimestamp'],
                    'gionghi' => $workCapabilities[$j]['endTimestamp'],
                    'ca' => $workCapabilities[$j]['shift'],
                    // ...
                ];
            }
        }
        $batchSize = count($workCapabilities); // Số lượng dòng dữ liệu trong mỗi batch
        $dataChunks = array_chunk($insertData, $batchSize);
        // Thực hiện batch insert từng batch vào cơ sở dữ liệu       
        DB::table('lichlamviec')->delete();
        foreach ($dataChunks as $dataChunk) {
            DB::table('lichlamviec')->insert($dataChunk);
        }
        $lichlamviec =  DB::table('nhansu')
            ->join('nhomlamviec', 'nhomlamviec.manhom', '=', 'nhansu.manhom')
            ->join('lichlamviec', 'lichlamviec.manhanvien', '=', 'nhansu.manhanvien')
            ->select('nhomlamviec.manhom', 'lichlamviec.manhanvien', 'tennhom', 'tennhanvien', 'ca', 'giobatdau', 'gionghi')
            ->groupBy('nhomlamviec.manhom', 'giobatdau', 'lichlamviec.manhanvien', 'tennhom', 'tennhanvien', 'ca', 'gionghi')
            ->get();
        return view('lichlamviec', ['results' => $lichlamviec]);
    }
    public function dslichlamviec()
    {
        $lichlamviec =  DB::table('nhansu')
            ->join('nhomlamviec', 'nhomlamviec.manhom', '=', 'nhansu.manhom')
            ->join('lichlamviec', 'lichlamviec.manhanvien', '=', 'nhansu.manhanvien')
            ->select('nhomlamviec.manhom', 'lichlamviec.manhanvien', 'tennhom', 'tennhanvien', 'ca', 'giobatdau', 'gionghi')
            ->groupBy('nhomlamviec.manhom', 'giobatdau', 'lichlamviec.manhanvien', 'tennhom', 'tennhanvien', 'ca', 'gionghi')
            ->get();
        return view('lichlamviec', ['results' => $lichlamviec]);
    }
    public function checkcn($manhanvien)
    {
        $wkid = $manhanvien;
        DB::table('maus')->insert([
            'mamau' =>  $wkid,
            'tenmau' =>  $wkid,
        ]);
        $responseData = [
            'op' => 'created',
            'id' => '49C2C90F_1686623924_8419249',
            'success' => true
        ];
        return response()->json(200);
        // return response()->json([
        //     'status' => 200,
        //     'body' => json_encode($responseData)
        // ]);
        $client = new Client();
        $response = $client->GET('http://30.0.60.200/md5/0:/evtcap/ktcom', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => '1684221464.d2c3101829da4134783cc6d2137bde9d', // (tùy chọn) Nếu máy IoT yêu cầu xác thực
            ],
            'json' => 200

        ]);
        if ($response->getStatusCode() === 200) {
            // return $response;
        } else {
            return 'Yêu cầu khởi động lại máy IoT không thành công.';
        }
    }
    public function check()
    {
        $wkid = 8423001;
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => '1684221464.d2c3101829da4134783cc6d2137bde9d', // (tùy chọn) Nếu máy IoT yêu cầu xác thực
        ])->get('http://30.0.60.200/md5/0:/evtcap/ktcom', [
            "checkcn" => [
                "code" => 200
            ]
            // Các trường khác ở đây...
        ]);

        // Xử lý phản hồi từ máy IoT
        $responseData = $response->json();
        // ...

        // Trả về phản hồi cho máy IoT
        return response()->json($responseData);
    }



    public function con()
    {


        $client = new Client();

        try {
            $response = $client->GET('http://30.0.60.200/reboot', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => '1684221464.d2c3101829da4134783cc6d2137bde9d', // (tùy chọn) Nếu máy IoT yêu cầu xác thực
                ],
                'json' => [
                    // Các thông tin khác cần gửi đi (nếu có)
                ]
            ]);

            // Xử lý phản hồi thành công
            if ($response->getStatusCode() === 200) {
                return 'Yêu cầu khởi động lại máy IoT thành công.';
            } else {
                return 'Yêu cầu khởi động lại máy IoT không thành công.';
            }
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            return 'Đã xảy ra lỗi: ' . $e->getMessage();
        }

        $data = [
            'temperature' => 25,
            'humidity' => 60,
            'timestamp' => time()
        ];

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => '1684204513.580563680488b4f0a2f305d273587db8',
            'Origin' => 'https://momvt.viettranvtntv.asia',
            'User-Agent' => 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Mobile Safari/537.36',
        ])
            ->get('http://30.0.60.200/md5/0:/evtcap/ktcom');

        if ($response->successful()) {
            // Phản hồi thành công, nhận được dữ liệu từ máy IoT
            $data = $response->json();
            return view('ttnv', ['data' => 101]);
            // Xử lý dữ liệu theo yêu cầu của bạn
        } else {
            // Xử lý lỗi khi gửi yêu cầu đến máy IoT
            $statusCode = $response->status();
            return view('ttnv', ['data' => $statusCode]);
            // Thực hiện các hành động phù hợp với mã trạng thái (status code) nhận được
        }
    }
    public function restore()
    {
        $hosts = [
            [
                'host' => 'elasticsearch-discovery.viettranvtntv.asia',
                'port' => 80,
                'scheme' => 'http',
            ],
        ];

        $client = ClientBuilder::create()
            ->setHosts($hosts)
            ->build();


        $response = $client->cat()->snapshots(['repository' => 's3_backup']);

        // Xử lý dữ liệu phản hồi theo nhu cầu của bạn
        // Ví dụ: in dữ liệu phản hồi
        $t = end($response)['id'];

        $params = [
            'index' => '*',
            'format' => 'json'
        ];
        $index = $client->cat()->indices($params);

        $indices = array_column($index, 'index');


        foreach ($indices as $index) {
            if ($index === "vtc-meta-v1" || $index === "vtc-log-v1") {
                continue;
            } else {
                $param1 = [
                    'index' => $index
                ];

                $response = $client->indices()->delete($param1);
            }
        }
        $paramr = [
            'repository' => 's3_backup',
            'snapshot' => $t,
            'body' => [
                'indices' =>  'vtc-activity,vtc-work_definiton,vtc-sqc-v1,vtc-material-v1,vtc-audit-v1,vtc-document,vtc-work_definition-v1,vtc-personnel-v1,vtc-resource_network-v1,vtc-work_alert-v1,vtc-spc-v1,vtc-work_capability-v1,vtc-tag-v1,vtc-kpi-infomation-v1,vtc-physical_asset-v1,vtc-work_performance-v1,vtc-hierarchy_scope-v1,vtc-work_schedule-v1',
                'ignore_unavailable' => true,
                'include_global_state' => false
            ]
        ];

        $responser = $client->snapshot()->restore($paramr);
    }
    // public function diemdanh()
    // {
    //     $currentDate = Carbon::now();
    //     $t = $currentDate->setTimezone('Asia/Ho_Chi_Minh')->startOfDay();
    //     $epochTime = $t->timestamp;
    //     $query = [
    //         "size" => 5000,
    //         'query' => [
    //             'bool' => [
    //                 'must' => [
    //                     [
    //                         'range' => [
    //                             'timestamp' => [
    //                                 'gte' => $epochTime,
    //                                 'lt' => $epochTime + 86340
    //                             ]
    //                         ]
    //                     ],
    //                     [
    //                         'term' => [
    //                             'category' => 'attendance'
    //                         ]
    //                     ]
    //                 ]
    //             ]
    //         ],
    //     ];

    //     $hosts = [
    //         [
    //             'host' => "es-discovery-vt.vietnhatcorp.com.vn",
    //             'port' => "443",
    //             'scheme' => "https",
    //             'user' => env('ELASTICSEARCH_USER'),
    //             'pass' => env('ELASTICSEARCH_PASSWORD'),

    //         ],
    //     ];


    //     $client = ClientBuilder::create()->setSSLVerification(false)->setHosts($hosts)->build();
    //     $index = "vtc-work_alert-v1";
    //     $params = ["index" => $index, "body" => $query];

    //     $response = $client->search($params);



    //     $workCapabilities = [];

    //     $count = 0;
    //     $addedIds = "";
    //     foreach ($response['hits']['hits'] as $hit) {
    //         $workCapability = $hit['_source'];
    //         $workCapability['timestamp'] = Carbon::createFromTimestamp($workCapability['timestamp'], 'Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
    //         $workCapability['id'] = $workCapability['properties'][1]['attribute'];
    //         $workCapability['may'] = $workCapability['properties'][0]['attribute'];
    //         $workCapabilities[] = $workCapability;
    //     }
    //     // for ($j = 0; $j < count($workCapabilities); $j++) {

    //     //     $nhomban = DB::table('diemdanh')
    //     //         ->select('id')
    //     //         ->where('id', '=', $workCapabilities[$j]['id'])
    //     //         ->first();
    //     //     if ($nhomban) {
    //     //     } else {
    //     //         DB::table('diemdanh')->insert(['id' => $workCapabilities[$j]['id'],  'gio' =>  $workCapabilities[$j]['timestamp']]);
    //     //         $count++;
    //     //     }
    //     // } 
    //     // $insertData = [];
    //     // for ($j = 0; $j < count($workCapabilities); $j++) {
    //     //     $id = $workCapabilities[$j]['id'];
    //     //     // Kiểm tra xem 'id' đã tồn tại trong mảng tạm thời hay chưa
    //     //     $insertData[] = [
    //     //         'id' => $id,
    //     //         'gio' => $workCapabilities[$j]['timestamp'],
    //     //         // ...
    //     //     ];
    //     // }
    //     $insertData = [];
    //     $existingIds = [];

    //     for ($j = 0; $j < count($workCapabilities); $j++) {
    //         $id = $workCapabilities[$j]['id'];

    //         // Kiểm tra xem 'id' đã tồn tại trong mảng tạm thời hay chưa
    //         if (!in_array($id, $existingIds)) {
    //             // Thêm 'id' vào mảng tạm thời
    //             $existingIds[] = $id;

    //             // Thêm dữ liệu vào mảng $insertData
    //             $insertData[] = [
    //                 'manhanvien' => $id,
    //                 'gio' => $workCapabilities[$j]['timestamp'],
    //                 'xuong' => substr($workCapabilities[$j]['may'], 0, 3),
    //                 // ...
    //             ];
    //         }
    //     }
    //     $batchSize = count($workCapabilities); // Số lượng dòng dữ liệu trong mỗi batch
    //     $dataChunks = array_chunk($insertData, $batchSize);
    //     // Thực hiện batch insert từng batch vào cơ sở dữ liệu       
    //     DB::table('diemdanh')->delete();
    //     foreach ($dataChunks as $dataChunk) {
    //         DB::table('diemdanh')->insert($dataChunk);
    //         $count++;
    //     }
    //     $diemdanh =  DB::table('nhansu')
    //         ->join('nhomlamviec', 'nhomlamviec.manhom', '=', 'nhansu.manhom')
    //         ->join('diemdanh', 'diemdanh.manhanvien', '=', 'nhansu.manhanvien')
    //         ->select('diemdanh.manhanvien', 'tennhom', 'tennhanvien', 'xuong', 'gio')
    //         ->get();
    //     $dsnhansu =  DB::table('nhansu')
    //         ->leftjoin('nhomlamviec', 'nhomlamviec.manhom', '=', 'nhansu.manhom')
    //         ->leftjoin('diemdanh', 'diemdanh.manhanvien', '=', 'nhansu.manhanvien')
    //         ->select('nhomlamviec.manhom', 'nhansu.manhanvien', 'tennhom', 'tennhanvien', 'tag', 'gio', 'xuong')
    //         ->groupBy('nhomlamviec.manhom', 'tennhom', 'nhansu.manhanvien', 'tennhanvien', 'tag', 'gio', 'xuong')
    //         ->orderBy('manhom')
    //         ->get();
    //     $dd = DB::table('diemdanh')->get();
    //     return view('dsnhansu', [
    //         'dsnhansu' => $dsnhansu,
    //         'dd' => $dd
    //     ]);
    // }   
    public function dsdiemdanh()
    {
        $diemdanh =  DB::table('nhansu')
            ->join('nhomlamviec', 'nhomlamviec.manhom', '=', 'nhansu.manhom')
            ->join('diemdanh', 'diemdanh.manhanvien', '=', 'nhansu.manhanvien')
            ->select('diemdanh.manhanvien', 'tennhom', 'tennhanvien', 'xuong', 'gio')
            ->get();
        return view('diemdanh', ['results' => $diemdanh]);
    }
    public function dsnhansu()
    {
        $dsnhansu =  DB::table('nhansu')
            ->leftjoin('nhomlamviec', 'nhomlamviec.manhom', '=', 'nhansu.manhom')
            ->leftjoin('diemdanh', 'diemdanh.manhanvien', '=', 'nhansu.manhanvien')
            ->select('nhomlamviec.manhom', 'nhansu.manhanvien', 'tennhom', 'tennhanvien', 'tag', 'gio', 'xuong')
            ->groupBy('nhomlamviec.manhom', 'tennhom', 'nhansu.manhanvien', 'tennhanvien', 'tag', 'gio', 'xuong')
            ->orderBy('manhom')
            ->get();
        $dd = DB::table('diemdanh')->get();
        return view('dsnhansu', [
            'dsnhansu' => $dsnhansu,
            'dd' => $dd
        ]);
    }
    public function lichlamviec0()
    {
        $currentDate = Carbon::now();
        $t = $currentDate->setTimezone('Asia/Ho_Chi_Minh')->startOfDay();
        // Chuyển đổi ngày của ngày mai sang epoch
        $epoch = $t->timestamp;
        // $epoch = 1684688400;
        $query = [
            'size' => 10000,
            'query' => [
                'bool' => [
                    'must' => [
                        ['exists' => ['field' => 'regularHours']],
                        [
                            'range' => [
                                'startTimestamp' => [
                                    'gte' => $epoch,
                                    'lte' => $epoch + 86340
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            "sort" => [
                ["workgroup" => ["order" => "asc"]],
                ["_id" => ["order" => "asc"]],
            ],
        ];

        $hosts = [
            [
                'host' => "es-discovery-vt.vietnhatcorp.com.vn",
                'port' => "443",
                'scheme' => "https",
                'user' => env('ELASTICSEARCH_USER'),
                'pass' => env('ELASTICSEARCH_PASSWORD'),


            ],
        ];


        $client = ClientBuilder::create()->setSSLVerification(false)->setHosts($hosts)->build();
        $index = "vtc-work_capability-v1";
        $params = ["index" => $index, "body" => $query];

        $response = $client->search($params);



        $workCapabilities = [];
        foreach ($response['hits']['hits'] as $hit) {
            $workCapability = $hit['_source'];
            $workCapability['startTimestamp'] = Carbon::createFromTimestamp($workCapability['startTimestamp'],  'Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
            $workCapability['endTimestamp'] = Carbon::createFromTimestamp($workCapability['endTimestamp'],  'Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
            $workCapabilities[] = $workCapability;
        }
        //dd($workCapabilities[0]['shift']);
        $insertData = [];
        $existingIds = [];
        for ($j = 0; $j < count($workCapabilities); $j++) {
            $id = $workCapabilities[$j]['personId'];

            // Kiểm tra xem 'id' đã tồn tại trong mảng tạm thời hay chưa
            if (!in_array($id, $existingIds)) {
                // Thêm 'id' vào mảng tạm thời
                $existingIds[] = $id;

                // Thêm dữ liệu vào mảng $insertData
                $insertData[] = [
                    'manhanvien' => $id,
                    'giobatdau' => $workCapabilities[$j]['startTimestamp'],
                    'gionghi' => $workCapabilities[$j]['endTimestamp'],
                    'ca' => $workCapabilities[$j]['shift'],
                    // ...
                ];
            }
        }
        $batchSize = count($workCapabilities); // Số lượng dòng dữ liệu trong mỗi batch
        $dataChunks = array_chunk($insertData, $batchSize);
        // Thực hiện batch insert từng batch vào cơ sở dữ liệu       
        DB::table('lichlamviec0')->delete();
        foreach ($dataChunks as $dataChunk) {
            DB::table('lichlamviec0')->insert($dataChunk);
        }
        $lichlamviec =  DB::table('nhansu')
            ->join('nhomlamviec', 'nhomlamviec.manhom', '=', 'nhansu.manhom')
            ->join('lichlamviec0', 'lichlamviec0.manhanvien', '=', 'nhansu.manhanvien')
            ->select('nhomlamviec.manhom', 'lichlamviec0.manhanvien', 'tennhom', 'tennhanvien', 'ca', 'giobatdau', 'gionghi')
            ->groupBy('nhomlamviec.manhom', 'giobatdau', 'lichlamviec0.manhanvien', 'tennhom', 'tennhanvien', 'ca', 'gionghi')
            ->get();
        return view('lichlamviec', ['results' => $lichlamviec]);
    }
    public function lichlamviec1()
    {
        $lichlamviec =  DB::table('nhansu')
            ->join('nhomlamviec', 'nhomlamviec.manhom', '=', 'nhansu.manhom')
            ->join('lichlamviec0', 'lichlamviec0.manhanvien', '=', 'nhansu.manhanvien')
            ->select('nhomlamviec.manhom', 'lichlamviec0.manhanvien', 'tennhom', 'tennhanvien', 'ca', 'giobatdau', 'gionghi')
            ->groupBy('nhomlamviec.manhom', 'giobatdau', 'lichlamviec0.manhanvien', 'tennhom', 'tennhanvien', 'ca', 'gionghi')
            ->get();
        return view('lichlamviec', ['results' => $lichlamviec]);
    }
    public function viewcaptaikhoan()
    {
        $hp = Modelquyenuser::get();
        $gv = new Modelquyenuser;
        // $dstaikhoan = DB::table('nhansu')
        //     ->leftjoin('users', 'users.manhanvien', '=', 'nhansu.manhanvien')
        //     ->leftjoin('nhansu_bophan', 'nhansu_bophan.manhanvien', '=', 'nhansu.manhanvien')
        //     ->leftjoin('bophan', 'bophan.mabophan', '=', 'nhansu_bophan.mabophan')
        //     ->select('nhansu.manhanvien', 'tag', 'tennhanvien',  'name', 'tengoinho')
        //     ->where('nhansu_bophan.tt', 'bophanchinh')
        //     ->orderBy('name', 'desc')
        //     ->orderBy('tengoinho', 'desc')
        //     ->get();
        $dstaikhoan = DB::table('nhansu')
            ->join('users', 'users.manhanvien', '=', 'nhansu.manhanvien')
            ->join('nhansu_bophan', 'nhansu_bophan.manhanvien', '=', 'nhansu.manhanvien')
            ->join('bophan', 'bophan.mabophan', '=', 'nhansu_bophan.mabophan')
            ->select('nhansu.manhanvien', 'tag', 'tennhanvien',  'name', 'tengoinho')
            ->where('nhansu_bophan.tt', 'bophanchinh')
            ->orderBy('name', 'desc')
            ->orderBy('tengoinho', 'desc')
            ->get();

        $nhansuWithoutUsers = DB::table('nhansu')
            ->leftJoin('users', 'nhansu.manhanvien', '=', 'users.manhanvien')
            ->whereNull('users.manhanvien')
            ->select('nhansu.*')
            ->get();
        // dd($nhansuWithoutUsers);
        $q = DB::table('quyen')
            ->select('maquyen', 'tenquyen')
            ->get();
        return view('captaikhoan', [
            'dschuctaikhoan' => $nhansuWithoutUsers,
            'dstaikhoan' => $dstaikhoan,
            'q' => $q,
            'gv' => $gv,
        ]);
    }
    public function timsoi()
    {
        return view('timsoi');
    }
    public function timlot(Request $r)
    {
        $lot = $r->lot;
        $date = $r->date;

        $date1 = new DateTime($date);
        $formattedDate = $date1->format('Y-m-d\TH:i');
        $dateTime = new DateTime($formattedDate);
        $timestamp = $dateTime->getTimestamp();
        $timestamp1 = $timestamp + 86340;

        $query = [
            "size" => 45000,
            "_source" => [
                "includes" =>  ["materialActuals.definition", "materialActuals.lot", "_id", "workDirective", "startTimestamp", "personnelActuals.id", "personnelActuals.name"],
            ],
            'query' => [
                'bool' => [
                    'must' => [
                        [
                            'range' => [
                                'startTimestamp' => [
                                    'gte' => $timestamp,
                                    'lte' => $timestamp1,
                                ]
                            ]
                        ]
                    ]
                ]
            ]

        ];
        $hosts = [
            [
                'host' => 'elasticsearch-discovery.viettranvtntv.asia',
                'port' => 80,
                'scheme' => 'http',
            ],
        ];
        $client = ClientBuilder::create()->setSSLVerification(false)->setHosts($hosts)->build();
        $index = "vtc-work_performance-v1";
        $params = ["index" => $index, "body" => $query];

        $response = $client->search($params);
        $hits = $response['hits']['hits'];
        $workCapabilities = [];

        foreach ($hits as $hit) {
            $workCapability = $hit['_source'];

            if (isset($workCapability['personnelActuals'])) {

                $workCapability['startTimestamp'] = Carbon::createFromTimestamp($workCapability['startTimestamp'],  'Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
                $workCapability['id1'] = $hit['_id'];
                $workCapability['definition'] = $workCapability['materialActuals'][0]['definition'];
                $workCapability['lot'] = $workCapability['materialActuals'][0]['lot'];
                $workCapability['id'] = $workCapability['personnelActuals'][0]['id'];
                $workCapability['name'] = $workCapability['personnelActuals'][0]['name'];
            } else {
                $workCapability['startTimestamp'] = Carbon::createFromTimestamp($workCapability['startTimestamp'],  'Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
                $workCapability['id1'] = $hit['_id'];
                $workCapability['definition'] = $workCapability['materialActuals'][0]['definition'];
                $workCapability['lot'] = $workCapability['materialActuals'][0]['lot'];
                $workCapability['id'] = "";
                $workCapability['name'] = "";
            }

            $workCapabilities[] = $workCapability;
        }
        // ,
        // [
        //     'nested' => [
        //         'path' => 'materialActuals',
        //         'query' => [
        //             'term' => [
        //                 'materialActuals.lot' => $lot
        //             ]
        //         ]
        //     ]
        // ]
        return view('timsoi', ['data' => $workCapabilities]);
    }
    public function timmodel()
    {
        return view('timmodel');
    }
    public function timmodel1(Request $r)
    {
        $lot = $r->lot;
        $date = $r->date;

        $date1 = new DateTime($date);
        $formattedDate = $date1->format('Y-m-d\TH:i');
        $dateTime = new DateTime($formattedDate);
        $timestamp = $dateTime->getTimestamp();
        $timestamp1 = $timestamp + 86340;

        $query = [
            "size" => 45000,
            'query' => [
                'bool' => [
                    'must' => [
                        [
                            'range' => [
                                'updateAt' => [
                                    'gte' => $timestamp,
                                    'lt' => $timestamp1
                                ]
                            ]
                        ],
                        [
                            'bool' => [
                                'must_not' => [
                                    [
                                        'term' => [
                                            'status' => 'none'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'aggs' => [
                'group_by_definition' => [
                    'terms' => [
                        'field' => 'definition',
                        'size' => 10
                    ]
                ]
            ]
        ];


        $hosts = [
            [
                'host' => 'elasticsearch-discovery.viettranvtntv.asia',
                'port' => 80,
                'scheme' => 'http',
            ],
        ];
        $client = ClientBuilder::create()->setSSLVerification(false)->setHosts($hosts)->build();
        $index = "vtc-material-v1";
        $params = ["index" => $index, "body" => $query];

        $response = $client->search($params);
        $hits = $response['hits']['hits'];
        $workCapabilities = [];

        foreach ($hits as $hit) {
            $workCapability = $hit['_source'];
            if (isset($workCapability['definition'])) {
                $workCapability['updateAt'] = Carbon::createFromTimestamp($workCapability['updateAt'],  'Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
                $workCapability['id'] = $hit['_id'];
                $workCapability['definition'] = $workCapability['definition'];
                $workCapability['status'] = $workCapability['status'];
                $workCapability['lot'] = $workCapability['lot'];
            } else {
                $workCapability['updateAt'] = Carbon::createFromTimestamp($workCapability['updateAt'],  'Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
                $workCapability['id'] = $hit['_id'];
                $workCapability['definition'] = "";
                $workCapability['status'] = "";
                $workCapability['lot'] = "";
            }

            $workCapabilities[] = $workCapability;
        }
        // ,
        // [
        //     'nested' => [
        //         'path' => 'materialActuals',
        //         'query' => [
        //             'term' => [
        //                 'materialActuals.lot' => $lot
        //             ]
        //         ]
        //     ]
        // ]
        return view('timmodel', ['data' => $workCapabilities]);
    }
    public function testapi(Request $r)
    {
        // $data = $r->getContent();
        // $file = 'C:/Users/NSVT/Desktop/data.txt';
        // File::append($file, $data . "\n");

        // return response()->json(['message' => 'Data received successfully'], 200);
        $ngayHomTruoc = Carbon::now()->subDay();
        $ngayHomTruoc = $ngayHomTruoc->toDateTimeString();
        $coDuLieuNgayHomTruoc = DB::table('diemdanh')
            ->where('gio', '>=', $ngayHomTruoc)
            ->where('gio', '<', Carbon::now()->toDateTimeString())
            ->exists();
        if ($coDuLieuNgayHomTruoc) {
            DB::table('diemdanh')->delete();
        } else {
            $gio1 =  Carbon::createFromTimestamp($r->timestamp,  'Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
            $gio = Carbon::createFromTimestamp($r->timestamp, 'Asia/Ho_Chi_Minh');
            if (!$gio->isToday()) {
                // Không đi tiếp
                // Thực hiện các hành động khác nếu cần
            } else {
                $startOfDay = Carbon::parse($gio1)->startOfDay()->hour(1);
                $endOfDay = Carbon::parse($gio1)->startOfDay()->hour(23);
                $ktr = DB::table('diemdanh')
                    ->where('manhanvien', '=', $r->person)
                    ->whereBetween('gio', [$startOfDay, $endOfDay])
                    ->get();

                if (count($ktr) == 0) {
                    DB::table('diemdanh')->insert([
                        'manhanvien' => $r->person,
                        'gio' => $gio,
                        'xuong' => $r->scope,
                        'uid' => $r->tag,
                    ]);
                }
            }
        }
    }
    public function diemdanh(Request $r)
    {
        $gio =  Carbon::createFromTimestamp($r->timestamp,  'Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        DB::table('diemdanh')->insert([
            'manhanvien' => $r->person,
            'gio' => $gio,
            'xuong' => $r->scope,
        ]);

        $diemdanh =  DB::table('nhansu')
            ->join('nhomlamviec', 'nhomlamviec.manhom', '=', 'nhansu.manhom')
            ->join('diemdanh', 'diemdanh.manhanvien', '=', 'nhansu.manhanvien')
            ->select('diemdanh.manhanvien', 'tennhom', 'tennhanvien', 'xuong', 'gio')
            ->get();
        $dsnhansu =  DB::table('nhansu')
            ->leftjoin('nhomlamviec', 'nhomlamviec.manhom', '=', 'nhansu.manhom')
            ->leftjoin('diemdanh', 'diemdanh.manhanvien', '=', 'nhansu.manhanvien')
            ->select('nhomlamviec.manhom', 'nhansu.manhanvien', 'tennhom', 'tennhanvien', 'tag', 'gio', 'xuong')
            ->groupBy('nhomlamviec.manhom', 'tennhom', 'nhansu.manhanvien', 'tennhanvien', 'tag', 'gio', 'xuong')
            ->orderBy('manhom')
            ->get();
        $dd = DB::table('diemdanh')->get();
        return view('dsnhansu', [
            'dsnhansu' => $dsnhansu,
            'dd' => $dd
        ]);
    }
    public function testmaycon(Request $r)
    {
        return response()->json([

            'status' => 200,
            'body' => [
                'message' => 'ok'
            ]

        ]);
    }
    function getToken($u, $password) {
        $token = null; // Khởi tạo token
    
        if ($token) {
            return $token;
        }
        $password = "12345678";
        $docDomain = 'https://momvt.vietnhatcorp.com.vn/graphql';
        $username = "tiennm@leanwell.co";
        $response = Http::post($docDomain, [
            [
                "operationName" => null,
                "variables" => [
                    "username" => "tiennm@leanwell.co",
                    "password" => "12345678",
                    "strategy" => "local"
                ],
                "extensions" => [],
                "query" => "mutation ($username: String!, $password: String!) {\n  authentication {\n    login(username: $username, password: $password) {\n      responseResult {\n        succeeded\n        errorCode\n        slug\n        message\n        __typename\n      }\n      jwt\n      mustChangePwd\n      mustProvideTFA\n      mustSetupTFA\n      continuationToken\n      redirect\n      tfaQRImage\n      __typename\n    }\n    __typename\n  }\n}\n"
            ]
        ]);
        return $response; 
        if ($response->successful() &&
            isset($response['data'][0]['data']['authentication']['login']['jwt'])) {
            $token = $response['data'][0]['data']['authentication']['login']['jwt'];
        }
    
        if ($token) {
            echo "Get token success: $token\n";
            return "Bearer $token";
        } else {
            return "không có";
        }
    }
}
