@extends ('welcome')

@section('content')
    <div class="header-right">
        <label class="title" for="" style="font-size: 20px;">
        Công việc bộ phận @if(count($nhom)>0){{$nhom[0]->tengoinho}}@endif

        </label>

        <div class="search-box">
            <form action="/timkiemcvnhom" method="POST">
                @csrf
            <input type="text" id="" name="manhanvien" placeholder="Nhập mã nhân viên để tìm" list="listnhansu">
            <datalist id="listnhansu">
                @foreach ($nhom1 as $data)
                    <option value="{{ $data->manhanvien }}">{{ $data->tennhanvien }}</option>
                @endforeach

            </datalist>
             <button class="search" type="submit" name="manhom"  value="{{$manhom}}" style="margin-right: 20px;" id="taotaikhoan">Tìm kiếm</button> 
            </form>
            <button class="search" style="margin-right: 30px;  background-color: #d58619;" onclick="goBack()">Quay về</button>
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
        .search-box input {
            margin-right: 50px;
            border-radius: 5px;
            font-size: 18px;
            ;
            width: 260px;
            height: 45px;
            padding: 10px;
            border-color: #8b8b8b;
            background-color: #f6f6f6;

        }
    </style>
    <div class="container">
        <table class="fixed_header1" id="bangNhanVien">
            <thead>
                <tr>
                    <th>Mã</th>
                    <th>Tên nhân viên</th>
                    <th>Loại công việc</th>
                    <th>Tiêu đề</th>
                    {{-- <th>Người thực hiện</th> --}}
                    <th>Ngày hết hạn</th>
                </tr>
            </thead>
        
            <tbody>
                @foreach ($nhom as $data)
                    @php $gv1 = $gv->getcv($data->manhanvien); 
                    if(count($gv1) > 0){  
                                          
                    @endphp
                    <tr>
                        <td rowspan="{{count($gv1) +1}}">{{ $data->manhanvien }}</td>
                        <td rowspan="{{count($gv1)+1}}">{{ $data->tennhanvien }}</td>
                    </tr>
                    @foreach ($gv1 as $d)
                    <tr>
                  
                        <td>{{$d->tenloai}}</td>
                        @if ($d->trangthai == 'Chưa thực hiện')
                        <td><button class="search-mini"  value="{{ $d->macongviec }}"style="background-color: #C70039; width: 95%">{{ $d->tieude }}</button></td>
                        @else
                        <td><button value="{{ $d->macongviec }}"class="search-mini" style="width: 95%">{{ $d->tieude }}</button></td>
                        @endif
                       
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
                        @endforeach
                   </tr>
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
                            <div class="col-2" id="nhh" >
                                <label for="input1">Ngày hết hạn</label>

                                <input type="date" id="ngayhethan" class="form-control" autocomplete="off" required readonly>
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
                            <button class="search1"
                                style="text-decoration: none; padding: 12px; margin-top: 50px;background-color: #a3121b"
                                id="huycongviec">Hủy CV</button>
                            <div class="col-10">
                                <img src="" alt="" id="htimg" style="width: 300px; height: 300px">
                            </div>
                            {{-- <div class="col-10">

                            </div>
                            <div class="col-2">
                                <a class="search1"
                                style="text-decoration: none; padding: 12px; margin-top: 50px;background-color: #a3121b"
                                id="huycongviec">Hủy CV</a>
                            </div> --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function goBack() {
                history.back();
        }
        //thực hiện hoàn thành
        // var link = document.getElementById("hoanthanh");
        // var macongviec = document.getElementById("macongviec123");
        // link.addEventListener("click", function(event) {
        //     event.preventDefault(); // Ngăn chặn hành vi mặc định khi click vào liên kết
        //     var hrefValue = link.href;
        //     var lastFourChars = hrefValue.slice(-4);
        //     if (lastFourChars != "null") {
        //         $(function() {
        //             $.ajaxSetup({
        //                 headers: {
        //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //                 }
        //             });
        //             $.ajax({
        //                 processData: false,
        //                 contentType: false,
        //                 type: 'GET',
        //                 dataType: 'JSON',
        //                 url: '/capnhattrangthaicv/' + macongviec.value,
        //                 success: function(res) {
        //                     window.location.href = hrefValue;
        //                 }
        //             });


        //         });
        //     }



        // });
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
                    url: '/laythongtincongviec/' + buttonValue,
                    success: function(res) {
                        $.each(res, function(i, item) {
                            if (item.ngayhethan != null) {
                                nhh.style.display = "block";
                                document.getElementById("ngayhethan").value = item
                                    .ngayhethan;
                            } else {
                                nhh.style.display = "none";
                            }
                            document.getElementById("tennhanvien").value = item
                                .tennhanvien;
                            document.getElementById("tenloai").value = item.tenloai;
                            document.getElementById("macongviec123").value = item
                                .macongviec;
                            document.getElementById("tieude").value = item.tieude;
                            document.getElementById("noidung").value = item.noidung;   
                            if(item.hinhanh !=  null)
                            {                        
                            var imagePath = item.hinhanh;
                            console.log(imagePath);
                            var baseUrl = window.location.origin;
                            var imageUrl = baseUrl + '/' + imagePath.substring(imagePath.lastIndexOf("\\") + 1);
                            document.getElementById('htimg').src = imageUrl;        
                            }                    
                        });
                    }
                });


            });

        });
        var huycongviec = document.getElementById("huycongviec");
        var macongviec = document.getElementById("macongviec123");
        huycongviec.addEventListener("click", function(event) {
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
                    url: '/huycongviec/' + macongviec.value,
                    success: function(res) {
                        if (res.success) {
                            alert("Hủy công việc hoàn tất");
                            location.reload();
                        } else {
                            alert(res.message);
                        }
                    }
                });               
               

            });
        });
    </script>

@endsection
