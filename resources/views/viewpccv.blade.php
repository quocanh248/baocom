@extends ('welcome')

@section('content')
    <div class="header-right">
        <label class="title" for="">
            Phân công công việc cho bộ phận

        </label>

        <div class="search-box">
            <input type="text" id="manhanvienInput" placeholder="Nhập tên bộ phận để tìm">
            {{-- <button class="search-mini" style="margin-right: 50px;" id="taotaikhoan">Tạo mới +</button> --}}
        </div>

    </div>
    <style>
        .fixed_header1 {
            border-collapse: collapse;
            width: 100%;
            font-size: 18px;
            text-align: center;
            top: 0;
            text-align: left;

        }

        .fixed_header1 th {
            text-align: left;
            height: 35px;
            border: 1px solid #ccc;
            text-align: center;


        }

        .fixed_header1 td {
            text-align: left;
            padding: 6px;
            height: 25px;
            border: 1px solid #ccc;
            text-align: center;


        }

        .fixed_header1 tr:nth-child(even) {
            background-color: #f2f2f2
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

        .fixed_header tbody tr td:nth-child(6),
        .fixed_header tbody tr td:nth-child(5) {
            /* Ẩn các cột mặc định */
            visibility: hidden;

        }

        .fixed_header tbody tr:hover td:nth-child(6),
        .fixed_header tbody tr:hover td:nth-child(5) {
            /* Hiển thị các cột khi hover vào */
            visibility: visible;

        }
    </style>
    <div class="container">

        <div id="myModal1" class="modal" style="margin-top: 0; display: none">
            <div class="modal-content1" style="height: 680px;">
                <div class="modal-header">
                    <span class="close1">&times;</span>
                    <h3>Thêm Công việc</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">

                        <div class="row">
                            <div class="col-3">
                                <label for="input1">Nhập tên nhân viên:</label>
                                <datalist id="cities">


                                </datalist>
                                <input type="text" name="manhanvien" id="manhanvien" class="form-control"
                                    autocomplete="off" required list="cities">
                            </div>
                            <div class="col-3">
                                <label for="input1">Tên nhân viên:</label>

                                <input type="text" name="tennhanvien" id="tennhanvien" class="form-control"
                                    autocomplete="off" required readonly>
                            </div>
                            <div class="col-3">
                                <label for="input1">Loại công việc</label>

                                <select class="form-control" id="loaicongviec">
                                    @foreach ($loaicongviec as $data)
                                        <option value="{{ $data->maloai }}">{{ $data->tenloai }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-3" id="nhh" style="display:block">
                                <label for="input1">Ngày hết hạn</label>

                                <input type="date" id="ngayhethan" class="form-control" autocomplete="off" required>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="input1">Tiêu đề:</label>
                                <input type="text" name="" id="tieude" class="form-control" autocomplete="off"
                                    required list="listtieude">
                                <datalist id="listtieude">

                                </datalist>
                            </div>
                            <div class="col-2">
                                <label for="input1">Thêm đường dẫn:</label>
                                <button class="search" style="background-color: #15c040" id="themduongdan">+ </button>
                            </div>
                            <div class="col-4" id="dd" style="display:none">
                                <label for="input1">Đường dẫn:</label>
                                <datalist id="listduongdan">
                                    @foreach ($link as $data)
                                        <option value="{{ $data->duongdan }}">{{ $data->tenlink }}</option>
                                    @endforeach

                                </datalist>
                                <input type="text" name="duongdan" id="duongdan" class="form-control" autocomplete="off"
                                    required list="listduongdan">
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-12">
                                <label for="input1">Nội dung</label>
                                <textarea id="noidung" class="form-control" style="height: 70px" rows="4" cols="50"></textarea>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
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
                        </div>
                        <div class="row">
                            <div class="col-10">

                            </div>
                            <div class="col-2">
                                <button class="search" id="themcv" style=" margin-top: 30px; ">Thêm
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <table class="fixed_header" id="bangNhanVien">
            <thead>
                <tr>
                    <th>Mã bộ phận</th>
                    <th>Tên bộ phận</th>
                    <th></th>
                    <th></th>
                    <th></th>

                </tr>
            </thead>
            <tbody id="tbody">
                @foreach ($nhom as $data)
                    <tr>
                        <td>{{ $data->mabophan }}</td>
                        <td style="text-align: left;">{{ $data->tengoinho }}</td>
                        <td><button class="search-mini-1" value="{{ $data->mabophan }}"
                                id="captaikhoan{{ $data->mabophan }}" style="width:130px">+Thêm CV</button></td>
                        <td> <button class="search-mini-cv1" style="width:130px" value="{{ $data->mabophan }}">Xem
                                CV</button> </td>
                        <td> <button class="search-mini-cv2" style="width:130px; background-color: #e38a1d"
                                value="{{ $data->mabophan }}">Xem LS</button>
                            <button class="search-mini-cv3" style="width:130px; background-color: #411de3"
                                value="{{ $data->mabophan }}">Chuyển</a> </button>

                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        var inputElement = document.getElementById("tieude"); // Thay "inputId" bằng id của phần tử input thực tế
        inputElement.addEventListener("input", function() {
            const inputValue = inputElement.value;
            console.log(inputValue);
            if (inputValue.length > 30) {
                inputElement.value = inputValue.slice(0, 30); // Cắt bớt chuỗi nhập vào chỉ còn 22 ký tự
            }
        });
        var input = document.getElementById("manhanvienInput");
        input.addEventListener("input", timKiem);

        function timKiem() {
            var filter = input.value.toUpperCase();           
            var table = document.getElementById("tbody");
            var tr = table.getElementsByTagName("tr");
            for (var i = 0; i < tr.length; i++) {
                var td = tr[i].getElementsByTagName("td")[1];

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
        var myModal1 = document.getElementById("myModal1");
        var closeButton1 = document.getElementsByClassName("close1")[0];
        var manhanvien = document.getElementById("manhanvien");
        var loaicongviec1 = document.getElementById("loaicongviec");
        var nhh = document.getElementById("nhh");
        var themduongdan = document.getElementById("themduongdan");
        var dd = document.getElementById("dd");
        var tennhanviena = document.getElementById("tennhanvien");

        manhanvien.addEventListener("change", function() {
            var selectedOption = manhanvien.value;
            var options = cities.options;
            var optionText, optionValue;

            for (var i = 0; i < options.length; i++) {
                if (options[i].value === selectedOption) {
                    optionText = options[i].label;
                    optionValue = options[i].value;
                    break;
                }
            }
            tennhanviena.value = optionText;
        });
        themduongdan.addEventListener("click", function() {
            dd.style.display = "block";
        });
        loaicongviec1.addEventListener("change", function() {
            var inputValue = loaicongviec1.value;
            if (inputValue == 5) {
                nhh.style.display = "block";
            } else {
                nhh.style.display = "none";
            }
        });

        manhanvien.addEventListener("change", function() {
            // Lấy dữ liệu từ input
            var inputValue = manhanvien.value;
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
                    url: '/laydscongviec/' + inputValue,
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
        var hoten = document.getElementById("hoten");

        closeButton1.addEventListener("click", function() {
            myModal1.style.display = "none";
            location.reload();
        });
        window.onload = function() {
            myModal1.style.display = "none";
        };

        $("#themcv").click(function() {
            var tieude = document.getElementById("tieude").value;
            var noidung = document.getElementById("noidung").value;
            var manhanvien = document.getElementById("manhanvien").value;
            var loaicongviec = document.getElementById("loaicongviec").value;
            var ngayhethan = document.getElementById("ngayhethan").value;
            var duongdan = document.getElementById("duongdan").value;
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
                        document.getElementById("tieude").value = "";
                        document.getElementById("noidung").value = "";
                        // document.getElementById("ngayhethan").value = "";
                        document.getElementById("duongdan").value = "";

                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
            //location.reload();
        });

        // Lặp qua từng option và lấy giá trị             
        $(".search-mini-1").click(function() {
            myModal1.style.display = "block";
            var noidung = document.getElementById("noidung");
            noidung.value = "";
            var inputs = document.querySelectorAll("#myModal1 input");
            var tableBody = document.getElementById("bangNhanVienBody");
            tableBody.innerHTML = "";
            // Xóa giá trị của mỗi input
            inputs.forEach(function(input) {
                input.value = "";
            });
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();
            var formattedDate = yyyy + '-' + mm + '-' + dd;

            document.getElementById("ngayhethan").value = formattedDate;
            console.log(ngayhethan.value, formattedDate);
            var row = $(this).closest("tr");
            // Lấy giá trị của các ô trong hàng
            var cell1Value = row.find("td:eq(0)").text();
            var cell2Value = row.find("td:eq(1)").text();
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
                    url: '/laytieudenhom/' + cell1Value,
                    success: function(res) {
                        $('#listtieude').empty();
                        console.log(res)
                        $.each(res, function(i, item) {
                            $('#listtieude').append($('<option>', {
                                value: item.tieude,
                            }));
                        });
                    }
                });


            });
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
                    url: '/laynhansunhom/' + cell1Value,
                    success: function(res) {
                        $('#cities').empty();
                        console.log(res)
                        $.each(res, function(i, item) {
                            $('#cities').append($('<option>', {
                                value: item.manhanvien,
                                text: item.tennhanvien,
                            }));
                        });
                    }
                });


            });
        });
    </script>

    <script>
        $(".search-mini-cv1").click(function() {
            var buttonValue = $(this).val();
            window.location.href = "/xemcongviecnhom/" + buttonValue;
        });
        $(".search-mini-cv2").click(function() {
            var buttonValue = $(this).val();
            window.location.href = "/xemlscvnhom/" + buttonValue;
        });
        $(".search-mini-cv3").click(function() {
            var buttonValue = $(this).val();
            window.location.href = "/chuyenbophan/" + buttonValue;
        });
    </script>
@endsection
