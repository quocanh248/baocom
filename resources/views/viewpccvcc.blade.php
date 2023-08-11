@extends ('welcome')

@section('content')
    <div class="header-right">
        <label class="title" for="">
           
            Công việc cá nhân - {{ $ttcn[0]->tennhanvien }}

        </label>
        <label class="title" for="">
            <input type="text" id="ipmanhanvien" value="{{ $ttcn[0]->manhanvien }}" hidden>
        </label>
        <div class="search-box">
            <button class="search1" style="text-decoration: none; padding: 12px; width: 150px; background-color: #C70039"
                href="/cvsaphethan" id="cvsaphethan">Sắp hết hạn</button>
            <button class="search1" style="text-decoration: none; padding: 12px; width: 150px; background-color: #b2771e"
                id="lscvcc">Xem lịch sử</button>
            <button class="search" style="margin-right: 50px;  background-color: #23b912;" id="taotaikhoan">Tạo mới
                +</button>
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

        .col-8 img {
            width: 70%;
            height: 250px;
        }
    </style>
    <div class="container">
        <div class="form-group">
            <div class="row">
                <div class="col-3-1">
                    <table class="fixed_header1" id="bangNhanVien">
                        <thead>
                            <tr>
                                <th>Công việc không xác định</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nhom as $data)
                                <tr>
                                    @if ($data->tenloai == 'Không xác định')
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
                <div class="col-3-1">
                    <table class="fixed_header1" id="bangNhanVien">
                        <thead>
                            <tr>
                                <th>Công việc Ngày</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nhom as $data)
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
                <div class="col-2-1">
                    <table class="fixed_header1" id="bangNhanVien">
                        <thead>
                            <tr>
                                <th>Công việc tuần</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nhom as $data)
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
                <div class="col-2-1">
                    <table class="fixed_header1" id="bangNhanVien">
                        <thead>
                            <tr>
                                <th>Công việc Tháng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nhom as $data)
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
                <div class="col-2-1">
                    <table class="fixed_header1" id="bangNhanVien">
                        <thead>
                            <tr>
                                <th>Công việc năm</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nhom as $data)
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
                            <div class="col-2" id="nhh">
                                <label for="input1">Ngày hết hạn</label>

                                <input type="date" id="ngayhethan" readonly class="form-control" autocomplete="off"
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
                                <textarea id="noidung" class="form-control" style="height: 70px" rows="4" cols="50"></textarea>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="input1">Thêm hình ảnh</label>
                                <input type="file" name="" id="image-input" class="form-control">
                                <input type="hidden" value="" name="filename">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-2">
                                <button class="search1" style="background-color: #a3121b" id="huycongviec">Hủy
                                    CV</button>
                            </div>
                            <div class="col-2">
                                <button class="search1" id="hoanthanh">Hoàn thành</button>
                            </div>
                            <div class="col-8">
                                <img id="preview-image" src="#" alt="Preview Image">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div id="myModal" class="modal" style="margin-top: 0;display: none">
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
                            <div class="col-4" id="nhh1" style="display:block">
                                <label for="input1">Ngày hết hạn</label>

                                <input type="date" id="ngayhethan1" class="form-control" autocomplete="off" required>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="input1">Tiêu đề:</label>
                                <input type="text" name="" id="tieude1" class="form-control"
                                    autocomplete="off" required list="listtieude">
                                <datalist id="listtieude">
                                    @foreach ($laytieude as $data)
                                        <option value="{{ $data->tieude }}"></option>
                                    @endforeach
                                </datalist>
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

                            <div class="col-8">
                                <label for="input1">Nội dung</label>
                                <textarea id="noidung1" class="form-control" style="height: 70px" rows="4" cols="50"></textarea>

                            </div>
                            <div class="col-4">
                                <label for="input1">Hình ảnh</label>
                                <input type="file" id="ipimg" class="form-control" style="height: 70px">
                                <input type="hidden" value="" name="filename">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12" id="divtable">
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
                            <div class="col-8" id="divimg" style="display: none">
                                <img id="preview-image12" src="#" alt="Preview Image">
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-8">

                            </div>
                            <div class="col-2" id="colht" style="visibility: visible">
                                <button class="search1" id="hoanthanh12"
                                    style="margin-top: 30px; background-color:#23b912 ">Hoàn thành
                                </button>
                            </div>
                            <div class="col-2">
                                <button class="search1" id="themcv" style=" margin-top: 30px; ">Thêm
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
        var inputElement = document.getElementById("tieude1"); // Thay "inputId" bằng id của phần tử input thực tế
        inputElement.addEventListener("input", function() {
            const inputValue = inputElement.value;
            console.log(inputValue);
            if (inputValue.length > 30) {
                inputElement.value = inputValue.slice(0, 30); // Cắt bớt chuỗi nhập vào chỉ còn 22 ký tự
            }
        });
        var imageInput = document.getElementById('image-input');
        var previewImage = document.getElementById('preview-image');
        var divtable = document.getElementById('divtable');
        var divimg = document.getElementById('divimg');
        imageInput.addEventListener('change', function(event) {
            var file = event.target.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
            };

            reader.readAsDataURL(file);
        });
        var ipimg = document.getElementById('ipimg');
        var previewImage12 = document.getElementById('preview-image12');

        ipimg.addEventListener('change', function(event) {
            var file12 = event.target.files[0];
            var reader12 = new FileReader();
            divimg.style.display = "block";
            divtable.style.display = "none";
            reader12.onload = function(e) {
                previewImage12.src = e.target.result;
            };

            reader12.readAsDataURL(file12);
        });
        var myModal1 = document.getElementById("myModal1");
        var closeButton1 = document.getElementsByClassName("close1")[0];
        var manhanvien = document.getElementById("manhanvien");
        var loaicongviec = document.getElementById("loaicongviec1");
        var nhh1 = document.getElementById("nhh1");
        var themduongdan1 = document.getElementById("themduongdan1");
        var dd1 = document.getElementById("dd1");
        var colht = document.getElementById("colht");
        themduongdan1.addEventListener("click", function() {
            dd1.style.display = "block";
        });
        loaicongviec.addEventListener("change", function() {
            var inputValue = loaicongviec.value;
            if (inputValue == 5) {
                nhh1.style.display = "block";
                colht.style.visibility = "visible";
                document.getElementById('ipimg').disabled = false;
            } else {
                nhh1.style.display = "none";
                colht.style.visibility = "hidden";
                document.getElementById('ipimg').value = '';
                document.getElementById('ipimg').disabled = true;
            }
        });
        //thực hiện hoàn thành
        var link = document.getElementById("hoanthanh");
        var macongviec = document.getElementById("macongviec123");
        link.addEventListener("click", function(event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định khi click vào liên kết
            var hrefValue = link.value;
            var lastFourChars = hrefValue.slice(-4);
            var imageInput = document.getElementById('image-input');
            var noidung = document.getElementById("noidung");
            var formData = new FormData();
            formData.append('tmpFile', imageInput.files[0]);
            formData.append('macongviec', macongviec.value);
            formData.append('noidung', noidung.value);
            console.log(formData)
            if (lastFourChars != "null") {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/capnhattrangthaicv',
                    method: "POST",
                    data: formData,
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(res) {

                        window.open(hrefValue, "_blank");
                        window.location.href = window.location.href;
                    }
                });
            } else {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/capnhattrangthaicv',
                    method: "POST",
                    data: formData,
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(res) {
                        var imagePath = res.path;
                        var imageElement = document.getElementById('image-input');
                        imageElement.src = imagePath;
                        window.location.href = window.location.href;
                    }
                });

            }



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
            location.reload();
        });
        window.onload = function() {
            myModal1.style.display = "none";
            myModal.style.display = "none";
        };
        $(".search-mini").click(function() {
            myModal1.style.display = "block";
            myModal.style.display = "none";
            var inputs = document.querySelectorAll("#myModal1 input");
            document.getElementById('image-input').disabled = false;
            document.getElementById("noidung").readOnly = false;
            // Xóa giá trị của mỗi input
            inputs.forEach(function(input) {
                input.value = "";
            });
            document.getElementById('preview-image').src = "";
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
                                console.log(item.ngayhethan);
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
                            document.getElementById("hoanthanh").value = item.duongdan;
                            if (item.hinhanh != null) {
                                var imagePath = item.hinhanh;
                                var baseUrl = window.location.origin;
                                var imageUrl = baseUrl + '/' + imagePath.substring(
                                    imagePath
                                    .lastIndexOf("\\") + 1);
                                document.getElementById('preview-image').src = imageUrl;
                            }
                            console.log(imageUrl);
                            if (item.trangthai == "Hoàn thành") {
                                document.getElementById('image-input').disabled = true;
                                document.getElementById("noidung").readOnly = true;
                            }
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
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();
            var formattedDate = yyyy + '-' + mm + '-' + dd;

            document.getElementById("ngayhethan1").value = formattedDate;
            console.log(ngayhethan1.value, formattedDate);
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
        $("#hoanthanh12").click(function() {
            var tieude = document.getElementById("tieude1").value;
            var noidung = document.getElementById("noidung1").value;
            var manhanvien = document.getElementById("manhanvien").value;
            var loaicongviec = document.getElementById("loaicongviec1").value;
            var ngayhethan = document.getElementById("ngayhethan1").value;
            var duongdan = document.getElementById("duongdan1").value;
            var ipimg = document.getElementById('ipimg');
            var formData12 = new FormData();
            formData12.append('tmpFile', ipimg.files[0]);
            formData12.append('manhanvien', manhanvien);
            formData12.append('loaicongviec', loaicongviec);
            formData12.append('ngayhethan', ngayhethan);
            formData12.append('tieude', tieude);
            formData12.append('noidung', noidung);
            formData12.append('duongdan', duongdan);
            console.log(formData12)
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/themcongviecht',
                    method: 'POST',
                    data: formData12,
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        document.createElement('divtable').style.display = "block";
                        document.createElement('img').style.display = "none";
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
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });

        });
        $("#cvsaphethan").click(function() {

            window.location.href = "/cvsaphethan";
        });
        $("#lscvcc").click(function() {

            window.location.href = "/xemlscvcc";
        });
    </script>
@endsection
