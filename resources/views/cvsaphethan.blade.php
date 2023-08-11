@extends ('welcome')

@section('content')
    <div class="header-right">
        <label class="title" for="">
            Danh sách công việc sắp hết hạn

        </label>
        <label class="title" for="">
            Tên nhân viên: <td>{{ $ttcc[0]->tennhanvien }}</td>
            <input type="text" id="ipmanhanvien" value="{{ $ttcc[0]->manhanvien }}" hidden>
        </label>
        <div class="search-box">
            {{-- <input type="text" id="manhanvienInput" placeholder="Nhập tên nhân viên để tìm"> --}}
            {{-- <button class="search" style="margin-right: 50px;  background-color: #23b912;" id="taotaikhoan">Tạo mới
                +</button> --}}
        </div>

    </div>
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

        .col-12-1,
        .col-6-1,
        .col-4-1,
        .col-3-1,
        .col-2-1 {
                {
                position: relative;
                width: 100%;
            }
        }

        .col-4-1 {
            -ms-flex: 0 0 33.333333%;
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        .col-6-1 {
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
            max-width: 50%;
        }

        .col-12-1 {
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%;
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
    @php
        $count = 0;
        $col1 = 3;
        $col2 = 3;
        $col3 = 2;
        $col4 = 2;
        $col5 = 2;
        
        if (count($cvkxd) > 0) {
            $count++;
        }
        if (count($cvngay) > 0) {
            $count++;
        }
        if (count($cvtuan) > 0) {
            $count++;
        }
        if (count($cvthang) > 0) {
            $count++;
        }
        if (count($cvnam) > 0) {
            $count++;
        }
        if ($count == 1) {
            $col1 = 12;
            $col2 = 12;
            $col3 = 12;
            $col4 = 12;
            $col5 = 12;
        } elseif ($count == 2) {
            $col1 = 6;
            $col2 = 6;
            $col3 = 6;
            $col4 = 6;
            $col5 = 6;
        } elseif ($count == 3) {
            $col1 = 4;
            $col2 = 4;
            $col3 = 4;
            $col4 = 4;
            $col5 = 4;
        } elseif ($count == 4) {
            $col1 = 3;
            $col2 = 3;
            $col3 = 3;
            $col4 = 3;
            $col5 = 3;
        }
    @endphp
    <div class="container">
        <div class="form-group">
            <div class="row">
                @if (count($cvkxd) > 0)
                    <div class="col-{{ $col1 }}-1">
                        <table class="fixed_header1" id="bangNhanVien">
                            <thead>
                                <tr>
                                    <th>Công việc không xác định</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cvkxd as $data)
                                    <tr>
                                        @if ($data['tenloai'] == 'Không xác định')
                                            @if ($data['trangthai'] == 'Chưa thực hiện')
                                                <td><button class="search-mini" value="{{ $data['macongviec'] }}"
                                                        style="background-color: #C70039">{{ $data['tieude'] }}</button>
                                                </td>
                                            @endif
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if (count($cvngay) > 0)
                    <div class="col-{{ $col2 }}-1">
                        <table class="fixed_header1" id="bangNhanVien">
                            <thead>
                                <tr>
                                    <th>Công việc Ngày</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cvngay as $data)
                                    <tr>
                                        @if ($data->tenloai == 'Công việc ngày')
                                            @if ($data->trangthai == 'Chưa thực hiện')
                                                <td><button class="search-mini" value="{{ $data->macongviec }}"
                                                        style="background-color: #C70039">{{ $data->tieude }}</button></td>
                                            @else
                                                <td><button value="{{ $data->macongviec }}"
                                                        class="search-mini">{{ $data->tieude }}</button></td>
                                            @endif
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if (count($cvtuan) > 0)
                    <div class="col-{{ $col3 }}-1">
                        <table class="fixed_header1" id="bangNhanVien">
                            <thead>
                                <tr>
                                    <th>Công việc tuần</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cvtuan as $data)
                                    <tr>
                                        @if ($data->tenloai == 'Công việc Tuần')
                                            @if ($data->trangthai == 'Chưa thực hiện')
                                                <td><button class="search-mini" value="{{ $data->macongviec }}"
                                                        style="background-color: #C70039">{{ $data->tieude }}</button></td>
                                            @else
                                                <td><button value="{{ $data->macongviec }}"
                                                        class="search-mini">{{ $data->tieude }}</button></td>
                                            @endif
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if (count($cvthang) > 0)
                    <div class="col-{{ $col4 }}-1">
                        <table class="fixed_header1" id="bangNhanVien">
                            <thead>
                                <tr>
                                    <th>Công việc Tháng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cvthang as $data)
                                    <tr>
                                        @if ($data->tenloai == 'Công việc Tháng')
                                            @if ($data->trangthai == 'Chưa thực hiện')
                                                <td><button class="search-mini" value="{{ $data->macongviec }}"
                                                        style="background-color: #C70039">{{ $data->tieude }}</button></td>
                                            @else
                                                <td><button value="{{ $data->macongviec }}"
                                                        class="search-mini">{{ $data->tieude }}</button></td>
                                            @endif
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if (count($cvnam) > 0)
                    <div class="col-{{ $col5 }}-1">
                        <table class="fixed_header1" id="bangNhanVien">
                            <thead>
                                <tr>
                                    <th>Công việc năm</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cvnam as $data)
                                    <tr>
                                        @if ($data->tenloai == 'Công việc Năm')
                                            @if ($data->trangthai == 'Chưa thực hiện')
                                                <td><button class="search-mini" value="{{ $data->macongviec }}"
                                                        style="background-color: #C70039">{{ $data->tieude }}</button></td>
                                            @else
                                                <td><button value="{{ $data->macongviec }}"
                                                        class="search-mini">{{ $data->tieude }}</button></td>
                                            @endif
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
        <div id="myModal1" class="modal">
            <div class="modal-content">
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
                            <div class="col-10">

                            </div>
                            <div class="col-2">
                                <a class="search1" style="text-decoration: none; padding: 12px; margin-top: 50px;"
                                    id="hoanthanh">Hoàn thành</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div id="myModal" class="modal" style="margin-top: 0; ">
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
            } else {
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
                            window.location.href = window.location.href;
                        }
                    });


                });
            }



        });
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
                            document.getElementById("hoanthanh").href = item.duongdan;
                        });
                    }
                });


            });

        });
        //hiển thị modal thêm công việc
        $(".search").click(function() {
            myModal.style.display = "block";
            myModal1.style.display = "none";
            var inputs = document.querySelectorAll("#myModal input");
            var tableBody = document.getElementById("bangNhanVienBody");
            tableBody.innerHTML = "";
            // Xóa giá trị của mỗi input
            inputs.forEach(function(input) {
                input.value = "";
            });
            var ipmanhanvien = document.getElementById("ipmanhanvien");
            var manhanvien = document.getElementById("manhanvien");
            console.log(manhanvien.value);
            manhanvien.value = ipmanhanvien.value;
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
                    url: '/laydscongviec/' + ipmanhanvien.value,
                    success: function(res) {
                        var tbody = document.getElementById('bangNhanVienBody');
                        $.each(res, function(i, item) {
                            var row = document.createElement('tr');

                            // Tạo các ô dữ liệu và đặt giá trị cho chúng
                            var cell1 = document.createElement('td');
                            cell1.textContent = item.noidung;
                            var cell2 = document.createElement('td');
                            cell2.textContent = item.tenloai;
                            var cell3 = document.createElement('td');
                            cell3.textContent = item.trangthai;

                            // Thêm các ô vào hàng
                            row.appendChild(cell1);
                            row.appendChild(cell2);
                            row.appendChild(cell3);

                            // Thêm hàng vào tbody
                            tbody.appendChild(row);
                        });
                    }
                });


            });
        });
        //thêm công việc
        $("#themcv").click(function() {
            var tieude = document.getElementById("tieude1").value;
            var noidung = document.getElementById("noidung1").value;
            var manhanvien = document.getElementById("manhanvien").value;
            var loaicongviec = document.getElementById("loaicongviec1").value;
            var ngayhethan = document.getElementById("ngayhethan1").value;
            var duongdan = document.getElementById("duongdan1").value;
            $(document).ready(function() {
                $.ajax({
                    url: '/themcongviec',
                    method: 'POST',
                    data: {
                        manhanvien: manhanvien,
                        loaicongviec: loaicongviec,
                        ngayhethan: ngayhethan,
                        tieude: tieude,
                        noidung: noidung,
                        duongdan: duongdan,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        var tbody = document.getElementById('bangNhanVienBody');
                        tbody.innerHTML = '';
                        $.each(response, function(i, item) {
                            var row = document.createElement('tr');

                            // Tạo các ô dữ liệu và đặt giá trị cho chúng
                            var cell1 = document.createElement('td');
                            cell1.textContent = item.tieude;
                            var cell2 = document.createElement('td');
                            cell2.textContent = item.tenloai;
                            var cell3 = document.createElement('td');
                            cell3.textContent = item.trangthai;

                            // Thêm các ô vào hàng
                            row.appendChild(cell1);
                            row.appendChild(cell2);
                            row.appendChild(cell3);

                            // Thêm hàng vào tbody
                            tbody.appendChild(row);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
            //location.reload();
        });
    </script>
@endsection
