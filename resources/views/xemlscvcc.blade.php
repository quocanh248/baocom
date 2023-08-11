@extends ('welcome')

@section('content')
    <style>
        .fixed_header1 {
            border-collapse: collapse;
            width: 100%;
            font-size: 18px;
            text-align: center;
            top: 0;
            margin: 0;
            padding: 0;
        }

        .fixed_header1 th {
            text-align: left;
            height: 35px;
            border: 1px solid #ccc;
            text-align: center;


        }

        #bangNhanVienBody td {
            text-align: left;
            padding-top: 6px;
            padding-bottom: 6px;
            height: 25px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .fixed_header1 td {
            text-align: left;
            padding-top: 6px;
            padding-bottom: 6px;
            height: 25px;
            /* border: 1px solid #ccc; */
            text-align: center;


        }

        .fixed_header1 tr:nth-child(even) {
            /* background-color: #f2f2f2 */
        }

        .fixed_header1 th {
            background-color: #04AA6D;
            color: white;
            text-align: center;
        }

        .container {
            position: fixed;
            top: 0;
            left: 0;
            width: 98%;
            margin-top: 125px;
            margin-left: 20px;
            margin-right: 20px;
            padding: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            height: 85%;
            background-color: #fff;
            overflow-y: auto;
            margin-bottom: 0px;
        }

        .fixed_header1 thead {
            position: sticky;
            top: 0;
            background-color: #ffffff;
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

        .col-3-1,
        .col-2-1 {
                {
                position: relative;
                width: 100%;
            }
        }

        .col-2-1 {
            -ms-flex: 0 0 16.666667%;
            flex: 0 0 16.666667%;
            max-width: 16.666667%;
        }

        .col-3-1 {
            -ms-flex: 0 0 25%;
            flex: 0 0 25%;
            max-width: 25%;
        }

        .search-mini {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 15px;
            color: #fff;
            background-color: #1565c0;
            border: none;
            width: 95%;
            height: 32px;
            padding: 5px;
            border-radius: 4px;
            cursor: pointer;
        }

      
    </style>
    <div class="header-right">
        <label class="title" for="">
            Lịch sử thực hiện công việc cá nhân

        </label>
        <label class="title" for="">
            Tên nhân viên: <td>{{ $ttcn[0]->tennhanvien }}</td>
            <input type="text" id="ipmanhanvien" value="{{ $ttcn[0]->manhanvien }}" hidden>

        </label>
        <div class="search-box">
            {{-- <input type="text" id="manhanvienInput" placeholder="Nhập tên nhân viên để tìm"> --}}
            <button class="search" style="margin-right: 30px;  background-color: #d58619;" onclick="goBack()">Quay
                về</button>
        </div>

    </div>
    <div class="container">
        <div class="form-group">
            <div class="row">
                <div class="col-3-1">
                    <table class="fixed_header1" id="bangNhanVien">
                        <thead>
                            <tr>
                                <th colspan="2">Công việc không xác định</th>
                            </tr>
                            <tr>
                                <th>Tiêu đề</th>
                                <th>người thực hiện</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nhom as $data)
                                <tr>
                                    @if ($data->tenloai == 'Không xác định')
                                        @if ($data->trangthai == 'Chưa thực hiện')
                                            <td><button class="search-mini" value="{{ $data->malscongviec }}"
                                                    style="background-color: #C70039">{{ $data->tieude }}</button></td>
                                        @else
                                            <td><button value="{{ $data->malscongviec }}"
                                                    class="search-mini">{{ $data->tieude }}</button></td>
                                        @endif
                                        <td>{{ $data->nguoithuchien }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-3-1">
                    <table class="fixed_header1" id="bangNhanVien" style="font-size: 15px;">
                        <thead>
                            <tr>
                                <th colspan="2">Công việc Ngày</th>
                            </tr>
                            <tr>
                                <th>Tiêu đề</th>
                                <th>người thực hiện</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nhom as $data)
                                <tr>
                                    @if ($data->tenloai == 'Công việc ngày')
                                        @if ($data->trangthai == 'Chưa thực hiện')
                                            <td><button class="search-mini" value="{{ $data->malscongviec }}"
                                                    style="background-color: #C70039; ">{{ $data->tieude }}</button></td>
                                        @else
                                            <td><button value="{{ $data->malscongviec }}"
                                                    class="search-mini">{{ $data->tieude }}</button></td>
                                        @endif
                                        <td>{{ $data->nguoithuchien }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-2-1">
                    <table class="fixed_header1" id="bangNhanVien" style="font-size: 15px;">
                        <thead>
                            <tr>
                                <th colspan="2">Công việc tuần</th>
                            </tr>
                            <tr>
                                <th>Tiêu đề</th>
                                <th>người thực hiện</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nhom as $data)
                                <tr>
                                    @if ($data->tenloai == 'Công việc Tuần')
                                        @if ($data->trangthai == 'Chưa thực hiện')
                                            <td><button class="search-mini" value="{{ $data->malscongviec }}"
                                                    style="background-color: #C70039">{{ $data->tieude }}</button></td>
                                        @else
                                            <td><button value="{{ $data->malscongviec }}"
                                                    class="search-mini">{{ $data->tieude }}</button></td>
                                        @endif
                                        <td>{{ $data->nguoithuchien }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-2-1">
                    <table class="fixed_header1" id="bangNhanVien" style="font-size: 15px;">
                        <thead>
                            <tr>
                                <th colspan="2">Công việc Tháng</th>
                            </tr>
                            <tr>
                                <th>Tiêu đề</th>
                                <th>người thực hiện</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nhom as $data)
                                <tr>
                                    @if ($data->tenloai == 'Công việc Tháng')
                                        @if ($data->trangthai == 'Chưa thực hiện')
                                            <td><button class="search-mini" value="{{ $data->malscongviec }}"
                                                    style="background-color: #C70039">{{ $data->tieude }}</button></td>
                                        @else
                                            <td><button value="{{ $data->malscongviec }}"
                                                    class="search-mini">{{ $data->tieude }}</button></td>
                                        @endif
                                        <td>{{ $data->nguoithuchien }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-2-1">
                    <table class="fixed_header1" id="bangNhanVien" style="font-size: 15px;">
                        <thead>
                            <tr>
                                <th colspan="2">Công việc năm</th>
                            </tr>
                            <tr>
                                <th>Tiêu đề</th>
                                <th>người thực hiện</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nhom as $data)
                                <tr>
                                    @if ($data->tenloai == 'Công việc Năm')
                                        @if ($data->trangthai == 'Chưa thực hiện')
                                            <td><button class="search-mini" value="{{ $data->malscongviec }}"
                                                    style="background-color: #C70039">{{ $data->tieude }}</button></td>
                                        @else
                                            <td><button value="{{ $data->malscongviec }}"
                                                    class="search-mini">{{ $data->tieude }}</button></td>
                                        @endif
                                        <td>{{ $data->nguoithuchien }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
                            <div class="col-2" id="nhh" style="display:none">
                                <label for="input1">Ngày hết hạn</label>

                                <input type="date" id="ngayhethan" class="form-control" readonly autocomplete="off"
                                    required>
                            </div>
                            <div class="col-3">
                                <label for="input1">Tiêu đề:</label>
                                <input type="text" name="" id="tieude" class="form-control" readonly
                                    autocomplete="off" required>
                            </div>
                            <div class="col-2">
                                <label for="input1">Ngày tạo</label>

                                <input type="text" id="ngaytao" class="form-control" autocomplete="off" required
                                    readonly>
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
        <div id="myModal" class="modal" style="margin-top: 0; display: none;">
            <div class="modal-content1" style="height: 680px;">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h3>Thêm Công việc cho bản thân</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">

                        <div class="row">
                            <div class="col-4">
                                <label for="input1">Mã nhân viên:</label>
                                <input type="text" name="manhanvien" id="manhanvien" class="form-control" readonly
                                    autocomplete="off" required>
                            </div>

                            <div class="col-4">
                                <label for="input1">Loại công việc</label>

                                <select class="form-control" id="loaicongviec1">
                                    @foreach ($loaicongviec as $data)
                                        <option value="{{ $data->maloai }}">{{ $data->tenloai }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-4" id="nhh1" style="display:none">
                                <label for="input1">Ngày hết hạn</label>

                                <input type="date" id="ngayhethan1" class="form-control" autocomplete="off" required>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="input1">Tiêu đề:</label>
                                <input type="text" name="" id="tieude1" class="form-control"
                                    autocomplete="off" required>
                            </div>
                            <div class="col-2">
                                <label for="input1">Thêm đường dẫn:</label>
                                <button class="search1" style="background-color: #15c040" id="themduongdan1">Thêm
                                </button>
                            </div>
                            <div class="col-4" id="dd1" style="display:none">
                                <label for="input1">Đường dẫn:</label>
                                <datalist id="listduongdan">
                                    @foreach ($link as $data)
                                        <option value="{{ $data->duongdan }}">{{ $data->tenlink }}</option>
                                    @endforeach

                                </datalist>
                                <input type="text" name="duongdan" id="duongdan1" class="form-control"
                                    autocomplete="off" required list="listduongdan">
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-12">
                                <label for="input1">Nội dung</label>
                                <textarea id="noidung1" class="form-control" style="height: 70px" rows="4" cols="50"></textarea>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-10">
                                <label for="input1">DS công việc:</label>
                                <table class="fixed_header1" id="bangNhanVien">
                                    <thead>
                                        <tr>
                                            <th>Tiêu đề</th>
                                            <th>Loại công việc</th>
                                            <th>Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bangNhanVienBody">

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-10">

                            </div>
                            <div class="col-2">
                                <button class="search1" id="themcv" style="margin-left: 60px; margin-top: 30px; ">Thêm
                                </button>
                            </div>
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
        var myModal1 = document.getElementById("myModal1");
        var closeButton1 = document.getElementsByClassName("close1")[0];
        var manhanvien = document.getElementById("manhanvien");
        var loaicongviec = document.getElementById("loaicongviec1");
        var nhh1 = document.getElementById("nhh1");
        var themduongdan1 = document.getElementById("themduongdan1");
        var dd1 = document.getElementById("dd1");
        themduongdan1.addEventListener("click", function() {
            dd1.style.display = "block";
        });
        loaicongviec.addEventListener("change", function() {
            var inputValue = loaicongviec.value;
            if (inputValue == 5) {
                nhh1.style.display = "block";
            } else {
                nhh1.style.display = "none";
            }
        });
        //thực hiện hoàn thành
    </script>
    <script>
        var myModal1 = document.getElementById("myModal1");
        var myModal = document.getElementById("myModal");
        var closeButton1 = document.getElementsByClassName("close1")[0];
        var closeButton = document.getElementsByClassName("close")[0];
        closeButton1.addEventListener("click", function() {
            myModal1.style.display = "none";
            myModal.style.display = "none";
        });
        closeButton.addEventListener("click", function() {
            myModal1.style.display = "none";
            myModal.style.display = "none";
        });
        window.onload = function() {
            myModal1.style.display = "none";
            myModal.style.display = "none";
        };
        $(".search-mini").click(function() {
            myModal1.style.display = "block";
            myModal.style.display = "none";
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
                            var date = item.created_at;

                            if (item.ngayhethan != null) {
                                nhh.style.display = "block";
                                document.getElementById("ngayhethan").value = item
                                    .ngayhethan;
                            } else {
                                nhh.style.display = "none";
                            }
                            document.getElementById("tennhanvien").value = item
                                .tennhanvien;
                            document.getElementById("ngaytao").value = date.substring(0,
                                10);
                            document.getElementById("tenloai").value = item.tenloai;
                            document.getElementById("macongviec123").value = item
                                .macongviec;
                            document.getElementById("tieude").value = item.tieude;
                            document.getElementById("noidung").value = item.noidung;
                            console.log(item.duongdan);
                            if (item.duongdan != null) {
                                document.getElementById("hoanthanh").href = item
                                    .duongdan;
                            }
                            var imagePath = item.hinhanh;
                            console.log(imagePath);
                            var baseUrl = window.location.origin;
                            var imageUrl = baseUrl + '/' + imagePath.substring(imagePath
                                .lastIndexOf("\\") + 1);
                            document.getElementById('htimg').src = imageUrl;
                        });
                    }
                });


            });

        });
        //hiển thị modal thêm công việc

        //thêm công việc
    </script>
@endsection
