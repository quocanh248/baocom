@extends ('welcome')

@section('content')
    <div class="header-right">
        <label class="title" for="">
            Lịch sử  công việc của bộ phận

        </label>

        <div class="search-box">
            <form action="/timkiemlscvnhom" method="POST">
                @csrf
            <input type="text" id="" name="manhanvien" placeholder="Nhập mã nhân viên để tìm" list="listnhansu">
            {{-- <input type="date" id="" name="ngayhoanthanh" placeholder="Ngày hoàn thành" > --}}
            <datalist id="listnhansu">
                @foreach ($nhom1 as $data)
                    <option value="{{ $data->manhanvien }}">{{ $data->tennhanvien }}</option>
                @endforeach

            </datalist>
             <button class="search-mini-1" type="submit" name="manhom"  value="{{$manhom}}" style="margin-right: 50px;" id="taotaikhoan">Tìm kiếm</button> 
            </form>
            <button class="search-mini-1" style="margin-right: 50px;  background-color: #d58619;" onclick="goBack()">Quay về</button>
            <button class="search-mini-1" style="margin-right: 50px;  background-color: #2d1da9;" id="copy">Chọn</button>
        </div>

    </div>
    <style>
        .fixed_header1 {
            width: 100%;
            height: 90%;          
            border-collapse: collapse;
        }
        .fixed_header1 thead{
           background-color: #04AA6D;
           color: #fff;
        }
        .fixed_header1 tbody {
            display: block;
            width: 100%;
            overflow: auto;
            height: 90%;
        }
        .fixed_header1 thead tr {
        display: block;
       
        }
        .fixed_header1 th,
        .fixed_header1 td {
            padding-bottom: 5px;
            padding-left: 10px;
            text-align: center;
            width: 500px;
            border-bottom: 1px solid #ccc;
        }
        .fixed_header1  td {
            text-align: left;
            padding: 6px;
            height: 25px;
            border: 1px solid #ccc;
            text-align: center;


        }
        .fixed_header1 th {
            text-align: left;
            padding: 6px;
            height: 25px;            
            text-align: center;


        }
        .container {
            padding-bottom: 0;
            margin-bottom: 0;
        }

        .container .fixed_header1 table {
            margin: 0;
            width: 100%;
        }

        .fixed_header1 tbody {
            overflow-y: scroll;

        }

        .search-mini {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            color: #fff;
            background-color: #1565c0;
            border: none;
            width: 130px;
            height: 32px;
            border-radius: 4px;
            cursor: pointer;
        }
        /* .search-box input {
            margin-right: 50px;
            border-radius: 5px;
            font-size: 18px;
            width: 200px;
            height: 40px;
            padding: 10px;
            border-color: #8b8b8b;
            background-color: #f6f6f6;

        } */
    </style>
    <div class="container">
        <table class="fixed_header1" id="bangNhanVien" style="font-size: 14px;">
            <thead>
                <tr>
                    <th>Mã</th>
                    <th>Tên nhân viên</th>
                    <th>Loại công việc</th>
                    <th>Ngày phân công</th>
                    <th>Tiêu đề</th>
                    <th>Nội dung</th>
                    <th>Người thực hiện</th>
                    <th>Ngày hết hạn</th>
                    <th>Ngày hoàn thành</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($nhom as $data)
                    @php $gv1 = $gv->getlscv($data->manhanvien); 
                    if(count($gv1) > 0){  
                                          
                    @endphp
                    <tr>
                        <td rowspan="{{count($gv1) +1}}">{{ $data->manhanvien }}</td>
                        <td rowspan="{{count($gv1)+1}}">{{ $data->tennhanvien }}</td>
                    </tr>
                    @foreach ($gv1 as $d)
                    <tr>
                  
                        <td>{{$d->tenloai}}</td>
                        <td>
                            @php
                            $formattedDate0 = "";
                            $date0 = $d->created_at;
                            if($date0 != null){
                            $formattedDate0 = date("d - m - Y", strtotime($date0));               
                             }            
                            @endphp
                            {{$formattedDate0}}
                           
                        </td>
                        @if ($d->trangthai == 'Chưa thực hiện')
                        <td><button class="search-mini" value="{{ $d->malscongviec }}"style="background-color: #C70039;">{{ $d->tieude }}</button></td>
                        @else
                        <td><button  value="{{ $d->malscongviec }}"class="search-mini">{{ $d->tieude }}</button></td>
                        @endif
                        <td>{{ $d->noidung }}</td>
                        <td>{{$d->nguoithuchien}}</td>
                        <td>
                            @php
                            $formattedDate = "";
                            $date = $d->ngayhethan;
                            if($date != null){
                            $formattedDate = date("d-m -Y", strtotime($date));               
                             }            
                            @endphp
                            {{$formattedDate}}
                        </td>
                        @php                      

                        $updatedAt = \Carbon\Carbon::parse($d->updated_at);
                        $createdAt = \Carbon\Carbon::parse($d->created_at);

                        $minutesDifference = $updatedAt->diffInMinutes($createdAt);
                        @endphp
                        @if($d->tenloai == 'Không xác định')
                        <td>
                            @php
                                $dateString = $d->updated_at;
                                $timestamp = strtotime($dateString);
                                $formattedDate1 = date('d-m-Y H:i:s', $timestamp);
                            @endphp
                            {{$formattedDate1}} ({{$minutesDifference}}p)</td>
                        @else
                        <td></td>
                        @endif
                    </tr>
                        @endforeach
                    @php } @endphp       


                   
                @endforeach

            </tbody>
        </table>
        <div id="myModal1" class="modal" style="display: none">
            <div class="modal-content1" style="height: 680px;">
                <div class="modal-header">
                    <span class="close1">&times;</span>
                    <h3>Chi tiết công việc</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">

                        <div class="row">
                            <div class="col-3">
                                <label for="input1">Tên nhân viên:</label>
                                <input type="text" name="manhanvien" id="tennhanvien" class="form-control" readonly
                                    autocomplete="off" required>
                                <input type="text" name="macongviec" style="display: none;" id="macongviec123"
                                    class="form-control">
                            </div>

                            <div class="col-2">
                                <label for="input1">Loại công việc</label>

                                <input type="text" name="manhanvien" id="tenloai" class="form-control" readonly
                                    autocomplete="off" required>
                            </div>
                            <div class="col-2" id="nhh" style="display:block">
                                <label for="input1">Ngày hết hạn</label>

                                <input type="date" id="ngayhethan" class="form-control" readonly autocomplete="off" required>
                            </div>
                            <div class="col-5">
                                <label for="input1">Tiêu đề:</label>
                                <input type="text" name="" id="tieude" class="form-control" readonly
                                    autocomplete="off" required>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-12">
                                <label for="input1">Nội dung</label>
                                <textarea id="noidung" class="form-control" readonly style="height: 70px" rows="4" cols="50"></textarea>

                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <img src="" alt="" id="htimg" style="width: 300px; height: 300px">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        //thực hiện hoàn thành
        function goBack() {
                history.back();
            }
        var link = document.getElementById("hoanthanh");
        var macongviec = document.getElementById("macongviec123");
        link.addEventListener("click", function(event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định khi click vào liên kết
            var hrefValue = link.href;
            var lastFourChars = hrefValue.slice(-4);
            if (lastFourChars != "null") {
                $(function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        processData: false,
                        contentType: false,
                        type: 'GET',
                        dataType: 'JSON',
                        url: '/capnhattrangthaicv/' + macongviec.value,
                        success: function(res) {
                            window.location.href = hrefValue;
                        }
                    });


                });
            }



        });
    </script>
    <script>
        var myModal1 = document.getElementById("myModal1");
        var closeButton1 = document.getElementsByClassName("close1")[0];
        closeButton1.addEventListener("click", function() {
            myModal1.style.display = "none";
        });
        window.onload = function() {
            myModal1.style.display = "none";
        };
        $(".search-mini").click(function() {
            myModal1.style.display = "block";
            var inputs = document.querySelectorAll("#myModal1 input");
            document.getElementById('htimg').src = "";
            // Xóa giá trị của mỗi input
            inputs.forEach(function(input) {
                input.value = "";
            });
            var row = $(this).closest("tr");
            var buttonValue = $(this).val();
            var nhh = document.getElementById("nhh");
            console.log(buttonValue);
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    processData: false,
                    contentType: false,
                    type: 'GET',
                    dataType: 'JSON',
                    url: '/laythongtinlscongviec/' + buttonValue,
                    success: function(res) {
                        $.each(res, function(i, item) {
                            if (item.ngayhethan != null) {
                                nhh.style.display = "block";
                                document.getElementById("ngayhethan").value = item
                                    .ngayhethan;
                            } else {
                                // nhh.style.display = "none";
                            }
                            document.getElementById("tennhanvien").value = item
                                .tennhanvien;
                            document.getElementById("tenloai").value = item.tenloai;
                            document.getElementById("macongviec123").value = item
                                .macongviec;
                            document.getElementById("tieude").value = item.tieude;
                            document.getElementById("noidung").value = item.noidung;
                            if(item.duongdan != null)
                            {
                            document.getElementById("hoanthanh").href = item.duongdan;
                            }
                            var imagePath = item.hinhanh;
                            console.log(imagePath);
                            var baseUrl = window.location.origin;
                            var imageUrl = baseUrl + '/' + imagePath.substring(imagePath.lastIndexOf("\\") + 1);
                            document.getElementById('htimg').src = imageUrl;
                        });
                    }
                });


            });

        });
    </script>
    <script>
        var input = document.getElementById("manhanvienInput");
        input.addEventListener("input", timKiem);

        function timKiem() {
            var filter = input.value.toUpperCase();
            var table = document.getElementById("bangNhanVien");
            var tr = table.getElementsByTagName("tr");

            for (var i = 0; i < tr.length; i++) {
                var td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    var txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
         <script>
            var highlightButton = document.getElementById("copy");
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
