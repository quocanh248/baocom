@extends ('welcome')

@section('content')
    <div class="header-right">
        <label class="title" for="">
            Thống kê cơm hôm nay
        </label>
        <label class="title" for="" id="totalCount">

        </label>
        <div class="search-box">
            <form action="/timtkcom" method="POST">
                @csrf
                <input type="date" id="manhanvienInput" name="ngay" placeholder="Nhập ngày để tìm kiếm" readonly>
                {{-- <button class="search" type="submit" id="highlightButton">Chọn</button> --}}
            </form>
        </div>

    </div>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 20px;
            text-align: center;
        }

        th,
        td {
            text-align: left;
            padding: 6px;
            height: 30px;
            border: 2px solid #ccc;
            text-align: center;


        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }

        th {
            background-color: #04AA6D;
            color: white;
            text-align: center;
        }
    </style>
    <div class="container">
        @php
            $mcounts = 0;
            $mcountc = 0;
            $mcount10 = 0;
            $mcount103 = 0;
            $mcount11 = 0;
            $mcount113 = 0;
            $mcount153 = 0;
            $mcount16 = 0;
            $mcount163 = 0;
            $m1counts = 0;
            $m1countc = 0;
            $m1count10 = 0;
            $m1count103 = 0;
            $m1count11 = 0;
            $m1count113 = 0;
            $m1count153 = 0;
            $m1count16 = 0;
            $m1count163 = 0;
            $counts = 0;
            $countc = 0;
            $count10 = 0;
            $count103 = 0;
            $count11 = 0;
            $count113 = 0;
            $count153 = 0;
            $count16 = 0;
            $count163 = 0;
            $c1ounts = 0;
            $c1ountc = 0;
            $c1ount10 = 0;
            $c1ount103 = 0;
            $c1ount11 = 0;
            $c1ount113 = 0;
            $c1ount153 = 0;
            $c1ount16 = 0;
            $c1ount163 = 0;
            if (count($results) > 0 || count($comman) > 0) {
                foreach ($results as $data) {
                    if ($data->ip == '30.30.30.32' || $data->ip == '30.30.30.36') {
                        if ($data->khunggio == 'S') {
                            $c1ounts++;
                        } elseif ($data->khunggio == 'C') {
                            $c1ountc++;
                        } elseif ($data->khunggio == '10:00') {
                            $c1ount10++;
                        } elseif ($data->khunggio == '10:30') {
                            $c1ount103++;
                        } elseif ($data->khunggio == '11:00') {
                            $c1ount11++;
                        } elseif ($data->khunggio == '11:30') {
                            $c1ount113++;
                        } elseif ($data->khunggio == '16:00') {
                            $c1ount16++;
                        } elseif ($data->khunggio == '15:30') {
                            $c1ount153++;
                        } elseif ($data->khunggio == '16:30') {
                            $c1ount163++;
                        }
                    } else {
                        if ($data->khunggio == 'S') {
                            $counts++;
                        } elseif ($data->khunggio == 'C') {
                            $countc++;
                        } elseif ($data->khunggio == '10:00') {
                            $count10++;
                        } elseif ($data->khunggio == '10:30') {
                            $count103++;
                        } elseif ($data->khunggio == '11:00') {
                            $count11++;
                        } elseif ($data->khunggio == '11:30') {
                            $count113++;
                        } elseif ($data->khunggio == '16:00') {
                            $count16++;
                        } elseif ($data->khunggio == '15:30') {
                            $count153++;
                        } elseif ($data->khunggio == '16:30') {
                            $count163++;
                        }
                    }
                }
                foreach ($comman as $data) {
                   
                    if ($data->ip == '30.30.30.50') {
                        if ($data->khunggio == 'S') {
                            $m1counts++;
                        } elseif ($data->khunggio == 'C') {
                            $m1countc++;
                        } elseif ($data->khunggio == '10:00') {
                            $m1count10++;
                        } elseif ($data->khunggio == '10:30') {
                            $m1count103++;
                        } elseif ($data->khunggio == '11:00') {
                            $m1count11++;
                        } elseif ($data->khunggio == '11:30') {
                            $m1count113++;
                        } elseif ($data->khunggio == '16:00') {
                            $m1count16++;
                        } elseif ($data->khunggio == '15:30') {
                            $m1count153++;
                        } elseif ($data->khunggio == '16:30') {
                            $m1count163++;
                        }
                    } else {
                       
                        if ($data->khunggio == 'S') {
                            $mcounts++;
                        } elseif ($data->khunggio == 'C') {
                            $mcountc++;
                        } elseif ($data->khunggio == '10:00') {
                            $mcount10++;
                        } elseif ($data->khunggio == '10:30') {
                            $mcount103++;
                        } elseif ($data->khunggio == '11:00') {
                            $mcount11++;
                        } elseif ($data->khunggio == '11:30') {
                            $mcount113++;
                        } elseif ($data->khunggio == '16:00') {
                            $mcount16++;
                        } elseif ($data->khunggio == '15:30') {
                            $mcount153++;
                        } elseif ($data->khunggio == '16:30') {
                            $mcount163++;
                        }
                    }
                }
            }
        @endphp
        <table id="">
            <thead>
                <tr>
                    <th colspan="12" style="background-color: #ffa500"><b> DS dự đoán theo ngày 
                        @if(count($results)> 0)
                        {{ $results[0]->ngaydk }}
                        @endif
                            (Chay theo giờ đăng ký - mặn theo
                            giờ nhận)</b>
                    </th>
                </tr>
                <tr>
                    <th rowspan="2">Xưởng</th>
                    <th colspan="9">Khung giờ</th>
                    <th rowspan="2">Tổng</th>
                    <th rowspan="2">TC</th>
                </tr>
                <tr>
                    <th>10:00</th>
                    <th>10:30</th>
                    <th>11:00</th>
                    <th>11:30</th>
                    <th>Sáng</th>
                    <th>15:30</th>
                    <th>16:00</th>
                    <th>16:30</th>
                    <th>Chiều</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td rowspan="2">VT1</td>
                    <td>{{ $m1count10 }}</td>
                    <td>{{ $m1count103 }}</td>
                    <td>{{ $m1count11 }}</td>
                    <td>{{ $m1count113 }}</td>
                    <td>{{ $m1counts }}</td>
                    <td>{{ $m1count153 }}</td>
                    <td>{{ $m1count16 }}</td>
                    <td>{{ $m1count163 }}</td>
                    <td>{{ $m1countc }}</td>
                    <td>{{ $m1count10 + $m1count103 + $m1count11 + $m1count113 + $m1counts + $m1count153 + $m1count163 + $m1count16 + $m1countc }}
                    </td>
                    <td rowspan="2">
                      <b>  {{ $m1count10 + $m1count103 + $m1count11 + $m1count113 + $m1counts + $m1count153 + $m1count163 + $m1count16 + $m1countc + $c1ount10 + $c1ount103 + $c1ount11 + $c1ount113 + $c1ounts + $c1ount153 + $c1ount163 + $c1ount16 + $c1ountc }}</b>
                    </td>
                </tr>
                <tr>
                    <td>{{ $c1ount10 }}</td>
                    <td>{{ $c1ount103 }}</td>
                    <td>{{ $c1ount11 }}</td>
                    <td>{{ $c1ount113 }}</td>
                    <td>{{ $c1ounts }}</td>
                    <td>{{ $c1ount153 }}</td>
                    <td>{{ $c1ount16 }}</td>
                    <td>{{ $c1ount163 }}</td>
                    <td>{{ $c1ountc }}</td>
                    <td>{{ $c1ount10 + $c1ount103 + $c1ount11 + $c1ount113 + $c1ounts + $c1ount153 + $c1ount163 + $c1ount16 + $c1ountc }}
                    </td>
                </tr>
                <tr>


                </tr>
                <tr>
                    <td rowspan="2">VT2</td>
                    <td>{{ $mcount10 }}</td>
                    <td>{{ $mcount103 }}</td>
                    <td>{{ $mcount11 }}</td>
                    <td>{{ $mcount113 }}</td>
                    <td>{{ $mcounts }}</td>
                    <td>{{ $mcount153 }}</td>
                    <td>{{ $mcount16 }}</td>
                    <td>{{ $mcount163 }}</td>
                    <td>{{ $mcountc }}</td>
                    <td>{{ $mcount10 + $mcount103 + $mcount11 + $mcount113 + $mcounts + $mcount153 + $mcount163 + $mcount16 + $mcountc }}
                    </td>
                    <td rowspan="2">
                       <b> {{ $mcount10 + $mcount103 + $mcount11 + $mcount113 + $mcounts + $mcount153 + $mcount163 + $mcount16 + $mcountc + $count10 + $count103 + $count11 + $count113 + $counts + $count153 + $count163 + $count16 + $countc }}
                       </b> </td>
                </tr>
                <tr>
                    <td>{{ $count10 }}</td>
                    <td>{{ $count103 }}</td>
                    <td>{{ $count11 }}</td>
                    <td>{{ $count113 }}</td>
                    <td>{{ $counts }}</td>
                    <td>{{ $count153 }}</td>
                    <td>{{ $count16 }}</td>
                    <td>{{ $count163 }}</td>
                    <td>{{ $countc }}</td>
                    <td>{{ $count10 + $count103 + $count11 + $count113 + $counts + $count153 + $count163 + $count16 + $countc }}
                    </td>
                </tr>
                <tr>


                </tr>
            </tbody>
        </table>
        <br>
        @php
            $mansang1 = 0;
            $manchieu1 = 0;
            $mansang2 = 0;
            $manchieu2 = 0;
            $chaysang1 = 0;
            $chaychieu1 = 0;
            $chaysang2 = 0;
            $chaychieu2 = 0;
            if (count($slcom) > 0) {
                foreach ($slcom as $data) {
                    $mansang1 = $data->mansang1;
                    $manchieu1 = $data->manchieu1;
                    $mansang2 = $data->mansang2;
                    $manchieu2 = $data->manchieu2;
                    $chaysang1 = $data->chaysang1;
                    $chaychieu1 = $data->chaychieu1;
                    $chaysang2 = $data->chaysang2;
                    $chaychieu2 = $data->chaychieu2;
                }
            }
        @endphp
        <style>
            input{
                font-size: 18px;
            }
        </style>
        <form action="/nhapsoluongcom" method="POST">
            @csrf
            <table>
                <thead>
                    <tr>
                        <th colspan="8" style="background-color: #ffa500"><b>Số lượng dựa trên chấm công:
                                {{ count($diemdanh) }}</b></th>
                    </tr>
                    <tr>
                        <th rowspan="3">Xưởng</th>
                        <th colspan="3">Đăng ký chay</th>
                        <th colspan="4">Số lượng thực tế</th>

                    </tr>
                    <tr>
                        <th rowspan="2">Đăng ký</th>
                        <th rowspan="2">Vắng</th>
                        <th rowspan="2">Còn lại</th>
                        <th colspan="2">Sáng </th>
                        <th colspan="2">Chiều</th>


                    </tr>
                    <tr>
                        <th>Mặn</th>
                        <th>Chay</th>
                        <th>Mặn</th>
                        <th>Chay</th>


                    </tr>
                </thead>
                <tbody>
                    <tr>

                        <td>VT1</td>
                        <td>{{ $c1ount10 + $c1ount103 + $c1ount11 + $c1ount113 + $c1ounts + $c1ount153 + $c1ount163 + $c1ount16 + $c1ountc }}
                        </td>
                        <td style="color: red;">{{ $soluong1 }}</td>
                        <td>{{ $c1ount10 + $c1ount103 + $c1ount11 + $c1ount113 + $c1ounts + $c1ount153 + $c1ount163 + $c1ount16 + $c1ountc - $soluong1 }}
                        </td>
                        <td><input type="number" id="1" name="man1s" required value="{{ $mansang1 }}"
                                style="border: 1px solid #ccc; border-radius: 5px; width: 70px; height: 30px; text-align: center;">
                        </td>
                        <td><input type="number" id="2" name="chay1s" required value="{{ $chaysang1 }}"
                                style="border: 1px solid #ccc; border-radius: 5px; width: 70px; height: 30px; text-align: center;">
                        </td>
                        <td><input type="number" id="3" name="man1c" required value="{{ $manchieu1 }}"
                                style="border: 1px solid #ccc; border-radius: 5px; width: 70px; height: 30px; text-align: center;">
                        </td>
                        <td><input type="number" id="4" name="chay1c" required value="{{ $chaychieu1 }}"
                                style="border: 1px solid #ccc; border-radius: 5px; width: 70px; height: 30px; text-align: center;">
                        </td>

                    </tr>
                    <tr>

                        <td>VT2</td>
                        <td>{{ $count10 + $count103 + $count11 + $count113 + $counts + $count153 + $count163 + $count16 + $countc }}
                        </td>
                        <td style="color: red;">{{ $soluong2 }}</td>
                        <td>{{ $count10 + $count103 + $count11 + $count113 + $counts + $count153 + $count163 + $count16 + $countc - $soluong2 }}
                        </td>
                        <td><input type="number" id="5" name="man2s" required value="{{ $mansang2 }}"
                                style="border: 1px solid #ccc; border-radius: 5px; width: 70px; height: 30px; text-align: center;">
                        </td>
                        <td><input type="number" id="6" name="chay2s" required value="{{ $chaysang2 }}"
                                style="border: 1px solid #ccc; border-radius: 5px; width: 70px; height: 30px; text-align: center;">
                        </td>
                        <td><input type="number" id="7" name="man2c" required value="{{ $manchieu2 }}"
                                style="border: 1px solid #ccc; border-radius: 5px; width: 70px; height: 30px; text-align: center;">
                        </td>
                        <td><input type="number" id="8" name="chay2c" required value="{{ $chaychieu2 }}"
                                style="border: 1px solid #ccc; border-radius: 5px; width: 70px; height: 30px; text-align: center;">
                        </td>

                    </tr>
                </tbody>
            </table>

            <button class="search" style="float: right; margin: 20px;" id="">Cập nhật</button>
        </form>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        
        document.getElementById('1').addEventListener('click', clearInput);
        document.getElementById('2').addEventListener('click', clearInput);
        document.getElementById('3').addEventListener('click', clearInput);
        document.getElementById('4').addEventListener('click', clearInput);
        document.getElementById('5').addEventListener('click', clearInput);
        document.getElementById('6').addEventListener('click', clearInput);
        document.getElementById('7').addEventListener('click', clearInput);
        document.getElementById('8').addEventListener('click', clearInput);

        function clearInput() {
            this.value = '';
        }
    </script>
    <script>
        // Lấy ngày hiện tại
        var today = new Date().toISOString().split('T')[0];

        // Thiết lập giá trị mặc định cho trường input
        document.getElementById('manhanvienInput').value = today;
    </script>
    <script>
        var highlightButton = document.getElementById("highlightButton");
        highlightButton.addEventListener("click", function() {
            var table = document.getElementById("bangNhanVien");
            var rows = table.getElementsByTagName("tr");

            var selectedText = "";
            for (var i = 0; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName("td");
                for (var j = 0; j < cells.length; j++) {
                    selectedText += cells[j].innerText + "\t";
                }
                selectedText += "\n";
                rows[i].style.backgroundColor = "#ccccc0";
            }

            // Sao chép dữ liệu vào clipboard
            var tempInput = document.createElement("textarea");
            tempInput.value = selectedText;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);

        });
    </script>
@endsection
