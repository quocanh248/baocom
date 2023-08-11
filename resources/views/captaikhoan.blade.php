@extends ('default1')

@section('content')
    <div class="header">
        <div class="header-cont">
            <div class="header-cont-title">
                <span>
                    Cấp tài khoản
                </span>
            </div>
            <div class="header-cont-content">
            </div>
            <div class="search-box">
                <input type="text" id="manhanvienInput" placeholder="Nhập mã nhân viên">
                <button class="search-mini" style="margin-right: 50px;" id="taotaikhoan">Tạo mới +</button>
            </div>

        </div>
    </div>
    <div class="container-content">
        <div id="myModal" class="modal" style="display: none">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h3>Tạo tài khoản</h3>

                </div>
                <div class="modal-body">
                    <p style="text-align: center; padding-bottom:15px"><b>Điền tên đăng nhập và mật khẩu</b></p>
                    <div class="form-group">

                        <div class="row">
                            <div class="col-12">
                                <label for="input1">Nhập tên nhân viên:</label>
                                <datalist id="cities">
                                    @foreach ($dschuctaikhoan as $data)
                                        <option value="{{ $data->manhanvien }}">{{ $data->tennhanvien }}</option>
                                    @endforeach

                                </datalist>
                                <input type="text" name="manhanvien" id="manhanvien" class="form-control"
                                    autocomplete="off" required list="cities">

                            </div>
                            {{-- <div class="col-6">
                                <label for="input1">Họ tên:</label>

                                <input type="text" name="hoten" id="hoten" list="version" readonly
                                    class="form-control" autocomplete="off" required>
                            </div> --}}
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="input1">Tên đăng nhập:</label>

                                <input type="text" name="username" id="username" class="form-control" autocomplete="off"
                                    required>

                            </div>
                            <div class="col-4">
                                <label for="input1">Mật khẩu:</label>

                                <input type="password" name="password" id="password" list="version" class="form-control"
                                    autocomplete="off" required>
                            </div>
                            <div class="col-4">
                                <label for="input1">Xác nhận mật khẩu:</label>

                                <input type="password" name="xnpassword" id="xnpassword" list="version" class="form-control"
                                    autocomplete="off" required>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-10">
                            </div>
                            <div class="col-2">
                                <button class="search" id="taotaikhoan12" style="margin-left: 80px">Tạo </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div id="myModal1" class="modal" style="display: none">
            <div class="modal-content1" style="height: 650px;">
                <div class="modal-header">
                    <span class="close1">&times;</span>
                    <h3>Thêm vai trò</h3>
                </div>
                <div class="modal-body">
                    <p style="text-align: center; padding-bottom:15px"><b>Chọn vai trò sao đó bấm vào thêm</b></p>
                    <div class="form-group">

                        <div class="row">
                            <div class="col-6">
                                <label for="input1">Mã:</label>

                                <input type="text" name="manhanvien" id="manhanvien1" readonly class="form-control"
                                    autocomplete="off" required>

                            </div>
                            <div class="col-6">
                                <label for="input1">Họ tên:</label>

                                <input type="text" name="hoten" id="hoten1" list="version" readonly
                                    class="form-control" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-12">
                                <label for="input1">Vai trò:</label>
                                <select class="form-control" id="vaitro">
                                    @foreach ($q as $data)
                                        <option value="{{ $data->maquyen }}">{{ $data->tenquyen }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-10"> </div>


                            <div class="col-2">
                                <button class="search" id="taotaikhoan123"
                                    style="margin-left: 60px; margin-top: 12px; ">Thêm </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="input1">Danh sách vai trò:</label>
                                <table class="fixed_header1" id="bangvaitro">
                                    <thead>
                                        <tr>
                                            <th>Tên vai trò</th>
                                            <th>Hủy vai trò</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bangvaitroBody">

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- modal cv1 --}}
        <div id="myModalcv1" class="modal" style="display: none">
            <div class="modal-content1" style="height: 680px;">
                <div class="modal-header">
                    <span class="closecv1">&times;</span>
                    <h3>Chi tiết</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="input1">Mã:</label>

                                <input type="text" name="manhanvien" id="manhanviencv1" readonly class="form-control"
                                    autocomplete="off" required>

                            </div>
                            <div class="col-6">
                                <label for="input1">Họ tên:</label>

                                <input type="text" name="hoten" id="hotencv1" list="version" readonly
                                    class="form-control" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2" id="col6c">
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        {{-- Modal cv2 --}}
        <div id="myModalcv2" class="modal" style="display: none">
            <div class="modal-content1" style="height: 680px;">
                <div class="modal-header">
                    <span class="closecv2">&times;</span>
                    <h3>Thêm vai trò</h3>
                </div>
                <div class="modal-body">
                    <p style="text-align: center; padding-bottom:15px"><b>Chọn vai trò sao đó bấm vào thêm</b></p>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="input1">Mã:</label>

                                <input type="text" name="manhanvien" id="manhanviencv2" readonly class="form-control"
                                    autocomplete="off" required>

                            </div>
                            <div class="col-6">
                                <label for="input1">Họ tên:</label>

                                <input type="text" name="hoten" id="hotencv2" list="version" readonly
                                    class="form-control" autocomplete="off" required>
                            </div>
                        </div>

                    </div>
                    <div class="checkbox-container" id="checkbox-container">


                        <!-- Thêm các checkbox khác tại đây -->
                    </div>
                    <br>
                    <button class="search-mini-cv3" id="update-button">Cập nhật</button>
                </div>
            </div>
        </div>
        <table class="table-mom" id="bangNhanVien">
            <thead>
                <tr>
                    <th>Mã</th>
                    <th>Tag</th>
                    <th>Họ tên</th>
                    <th>Tên tài khoản</th>
                    <th>Tên bộ phận</th>
                    <th>Vai trò</th>
                    <th>Thêm vai trò</th>
                    <th>Thêm nhóm QL</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dstaikhoan as $data)
                    <tr>
                        <td>{{ $data->manhanvien }}</td>
                        <td><span class="tag tag-success">{{ $data->tag }}</span></td>
                        <td>{{ $data->tennhanvien }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->tengoinho }}</td>

                        @php
                            $gv1 = $gv->getquyenuser($data->manhanvien);
                            $dem = 0;
                        @endphp
                        @if (count($gv1) > 0)
                            <td>
                                @foreach ($gv1 as $d)
                                    {{ $d->tenquyen }},
                                    @if ($d->tenquyen == 'Quản lý pro')
                                        @php $dem++; @endphp
                                    @endif
                                @endforeach
                            </td>
                        @else
                            <td></td>
                        @endif
                        @if ($data->name != '')
                            <td><button class="search-mini-1" value="{{ $data->manhanvien }}"
                                    id="captaikhoan{{ $data->manhanvien }}">+Vai trò</button></td>
                        @else
                            <td></td>
                        @endif
                        @if ($dem == 0)
                            <td></td>
                        @else
                            <td><button class="search-mini-cv2" value="{{ $data->manhanvien }}"
                                    style="background-color: rgb(204, 116, 23)"
                                    id="themnhomql{{ $data->manhanvien }}">+Nhóm QL</button></td>
                        @endif

                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td>Tổng {{ count($dstaikhoan) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
        window.addEventListener("resize", adjustColumnWidths);
        window.addEventListener("DOMContentLoaded", adjustColumnWidths);

        function adjustColumnWidths() {
            const table = document.getElementById("bangNhanVien");
            const totalColumns = table.rows[0].cells.length;
            const tableWidth = table.offsetWidth;
            const columnMinWidth = 200; // Độ rộng tối thiểu của cột
            // const columnMaxWidth = 200; // Độ rộng tối đa của cột
            const columnCount = Math.min(totalColumns, Math.floor(tableWidth / columnMinWidth));

            const columnWidth = Math.floor(tableWidth / columnCount);
            console.log(totalColumns, tableWidth, columnWidth);

            // Cài đặt độ rộng cho các cột
            const tableCells = table.getElementsByTagName("td");
            for (let i = 0; i < tableCells.length; i++) {
                tableCells[i].style.minWidth = columnWidth + "px";
                tableCells[i].style.maxWidth = columnWidth + "px";
                tableCells[i].style.whiteSpace = "nowrap";
                tableCells[i].style.overflow = "hidden";
                tableCells[i].style.textOverflow = "ellipsis";
            }
            // Cài đặt độ rộng tối thiểu cho các tiêu đề (th)
            const tableCells1 = table.getElementsByTagName("th");
            for (let i = 0; i < tableCells1.length; i++) {
                tableCells1[i].style.minWidth = columnWidth + "px";
            }
        }
    </script>
    <script>
        var myModal = document.getElementById("myModal");
        var myModal1 = document.getElementById("myModal1");
        var closeButton = document.getElementsByClassName("close")[0];
        var closeButton1 = document.getElementsByClassName("close1")[0];
        var myModalcv1 = document.getElementById("myModalcv1");
        var myModalcv2 = document.getElementById("myModalcv2");
        var closeButtoncv1 = document.getElementsByClassName("closecv1")[0];
        var closeButtoncv2 = document.getElementsByClassName("closecv2")[0];
        closeButton.addEventListener("click", function() {
            myModal.style.display = "none";
            myModal1.style.display = "none";
            myModalcv1.style.display = "none";
            myModalcv2.style.display = "none";
        });
        closeButton1.addEventListener("click", function() {
            myModal.style.display = "none";
            myModal1.style.display = "none";
            myModalcv1.style.display = "none";
            myModalcv2.style.display = "none";
            // $('#vaitro').empty();
        });
        closeButtoncv1.addEventListener("click", function() {
            myModal.style.display = "none";
            myModal1.style.display = "none";
            myModalcv1.style.display = "none";
            myModalcv2.style.display = "none";
        });
        closeButtoncv2.addEventListener("click", function() {
            myModal.style.display = "none";
            myModal1.style.display = "none";
            myModalcv1.style.display = "none";
            myModalcv2.style.display = "none";
            // $('#vaitro').empty();
        });
        window.onload = function() {
            myModal.style.display = "none";
            myModal1.style.display = "none";
            myModalcv1.style.display = "none";
            myModalcv2.style.display = "none";
        };
    </script>
    <script>
        var manhanvien = document.getElementById("manhanvien");
        var hoten = document.getElementById("hoten");
        $(".search-mini").click(function() {
            myModal.style.display = "block";
            var row = $(this).closest("tr");

            // Lấy giá trị của các ô trong hàng
            var cell1Value = row.find("td:eq(0)").text();
            var cell2Value = row.find("td:eq(2)").text();
            hoten.value = cell2Value;
            manhanvien.value = cell1Value;
        });

        //Modal 2
        var manhanvien1 = document.getElementById("manhanvien1");
        var vaitro = document.getElementById("vaitro");
        var hoten1 = document.getElementById("hoten1");
        var selectBox = document.getElementById("vaitro");
        var options = selectBox.options;
        var nhomql = document.getElementById("nhomql");
        var colvt = document.getElementById("colvt");

        $(".search-mini-1").click(function() {
            myModal1.style.display = "block";
            var row = $(this).closest("tr");

            // Lấy giá trị của các ô trong hàng
            var cell1Value = row.find("td:eq(0)").text();
            var cell2Value = row.find("td:eq(2)").text();
            var cell3Value = row.find("td:eq(4)").text();
            var vaitro = row.find("td:eq(5)").text();


            hoten1.value = cell2Value;
            manhanvien1.value = cell1Value;
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
                    url: '/layvaitrouser/' + cell1Value,
                    success: function(res) {
                        var tbody = document.getElementById('bangvaitroBody');
                        tbody.innerHTML = '';
                        $.each(res, function(i, item) {
                            $
                            var row = document.createElement('tr');
                            // Tạo các ô dữ liệu và đặt giá trị cho chúng
                            var cell1 = document.createElement('td');
                            cell1.textContent = item.tenquyen;

                            var button = document.createElement("button");
                            button.className = "search-mini-cv4";
                            button.textContent = "Hủy vai trò";
                            button.setAttribute('type', 'button');
                            button.setAttribute('value', item.maquyen);

                            button.addEventListener('click', function() {
                                // Xử lý khi button được nhấp                                
                                var buttonValue = this.value;
                                if (confirm('Bạn có muốn hủy vai trò này?')) {
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $(
                                                'meta[name="csrf-token"]'
                                                ).attr('content')
                                        }
                                    });
                                    $.ajax({
                                        processData: false,
                                        contentType: false,
                                        type: 'GET',
                                        dataType: 'JSON',
                                        url: '/huyvaitro/' +
                                            buttonValue + '/' +
                                            cell1Value,
                                        success: function(res) {
                                            location.reload();

                                        }
                                    });
                                }

                            });
                            var td = document.createElement("td");

                            // Thêm button vào ô td
                            td.appendChild(button);
                            row.appendChild(cell1);
                            row.appendChild(td);

                            // Thêm hàng vào tbody
                            tbody.appendChild(row);
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
                    url: '/layvaitro/' + cell1Value,
                    success: function(res) {

                        $('#vaitro').empty();
                        $.each(res, function(i, item) {
                            $('#vaitro').append($('<option>', {
                                value: item.maquyen,
                                text: item.tenquyen,
                            }));
                        });

                    }
                });


            });
        });
    </script>
    <script>
        document.getElementById("taotaikhoan12").addEventListener("click", function() {
            // Lấy thông tin tài khoản từ người dùng (ví dụ: nhập vào các input fields)
            var manhanvien = document.getElementById("manhanvien").value;
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;
            var xnpassword = document.getElementById("xnpassword").value;
            console.log(password, xnpassword);
            if (username == "" || password == "") {
                alert("Nhập thông tin đầy đủ");
            } else if (xnpassword != password) {
                alert("Mật khẩu không khớp");
            } else {
                $(document).ready(function() {
                    $.ajax({
                        url: '/themtaikhoan',
                        method: 'POST',
                        data: {
                            manhanvien: manhanvien,
                            username: username,
                            password: password,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                alert("Tạo tài khoản thành công");
                            } else {

                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                });
                location.reload();
            }
        });
        document.getElementById("taotaikhoan123").addEventListener("click", function() {
            // Lấy thông tin tài khoản từ người dùng (ví dụ: nhập vào các input fields)
            var manhanvien1 = document.getElementById("manhanvien1").value;
            var vaitro = document.getElementById("vaitro").value;

            $(document).ready(function() {
                $.ajax({
                    url: '/themvaitro',
                    method: 'POST',
                    data: {
                        manhanvien: manhanvien1,
                        vaitro: vaitro,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert("Thêm vai trò thành công");
                        var d = response.kt;
                        var d1 = response.filteredQuyen;
                        console.log(d1, d);
                        var tbody = document.getElementById('bangvaitroBody');
                        tbody.innerHTML = '';
                        $.each(d, function(i, item) {
                            $
                            var row = document.createElement('tr');
                            // Tạo các ô dữ liệu và đặt giá trị cho chúng
                            var cell1 = document.createElement('td');
                            cell1.textContent = item.tenquyen;
                            var button = document.createElement("button");
                            button.textContent = "Hủy vai trò";
                            button.setAttribute('type', 'button');
                            button.setAttribute('value', item.maquyen);
                            button.className = "search-mini-cv4";
                            button.addEventListener('click', function() {
                                // Xử lý khi button được nhấp                                
                                var buttonValue = this.value;
                                if (confirm('Bạn có muốn hủy vai trò này?')) {
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $(
                                                'meta[name="csrf-token"]'
                                                ).attr('content')
                                        }
                                    });
                                    $.ajax({
                                        processData: false,
                                        contentType: false,
                                        type: 'GET',
                                        dataType: 'JSON',
                                        url: '/huyvaitro/' +
                                            buttonValue + '/' +
                                            manhanvien1,
                                        success: function(res) {
                                            location.reload();

                                        }
                                    });
                                }

                            });
                            var td = document.createElement("td");

                            // Thêm button vào ô td
                            td.appendChild(button);
                            row.appendChild(cell1);
                            row.appendChild(td);

                            // Thêm hàng vào tbody
                            tbody.appendChild(row);
                        });
                        $('#vaitro').empty();
                        $.each(d1, function(i, item) {
                            $('#vaitro').append($('<option>', {
                                value: item.maquyen,
                                text: item.tenquyen,
                            }));
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
    {{-- Chi tiết CV1 --}}
    <script>
        var manhanviencv1 = document.getElementById("manhanviencv1");
        var hotencv1 = document.getElementById("hotencv1");
        $(".search-mini-cv1").click(function() {
            myModalcv1.style.display = "block";
            var row = $(this).closest("tr");
            var inputs = document.querySelectorAll("#myModalcv1 input");
            // Xóa giá trị của mỗi input
            var col6cDiv = document.getElementById("col6c");
            col6cDiv.innerHTML = "";
            inputs.forEach(function(input) {
                input.value = "";
                if (input.type === "checkbox") {
                    input.remove();
                }
            });
            // Lấy giá trị của các ô trong hàng
            var cell1Value = row.find("td:eq(0)").text();
            var cell2Value = row.find("td:eq(2)").text();
            hotencv1.value = cell2Value;
            manhanviencv1.value = cell1Value;
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
                    url: '/layvaitrouser/' + cell1Value,
                    success: function(res) {
                        var col6cDiv = document.getElementById("col6c");
                        $.each(res, function(i, item) {
                            var input = document.createElement("input");
                            var label = document.createElement("lable");
                            input.type = "checkbox";
                            input.checked = true;
                            input.value = item.tenquyen;
                            label.textContent = item.tenquyen;
                            input.className = "form-control";
                            col6cDiv.appendChild(label);
                            col6cDiv.appendChild(input);
                        });
                    }
                });


            });
        });
    </script>
    {{-- Chi tiết CV2 --}}
    <script>
        var manhanviencv2 = document.getElementById("manhanviencv2");
        var hotencv2 = document.getElementById("hotencv2");
        $(".search-mini-cv2").click(function() {
            myModalcv2.style.display = "block";
            var row = $(this).closest("tr");
            var checkboxContainer = document.getElementById("checkbox-container");
            checkboxContainer.innerHTML = "";
            var inputs = document.querySelectorAll("#myModalcv2 input");
            inputs.forEach(function(input) {
                input.value = "";
                if (input.type === "checkbox") {
                    input.remove();
                }
            });
            // Lấy giá trị của các ô trong hàng
            var cell1Value = row.find("td:eq(0)").text();
            var cell2Value = row.find("td:eq(2)").text();
            hotencv2.value = cell2Value;
            manhanviencv2.value = cell1Value;
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
                    url: '/laybophanuser/' + cell1Value,
                    success: function(res) {
                        var d = res.kt;
                        var d1 = res.vaitro;
                        console.log(d);
                        var checkboxContainer = document.getElementById('checkbox-container');

                        for (var i = 0; i < d1.length; i++) {
                            var bophan = d1[i];
                            console.log(bophan.mabophan, d);
                            var checkbox = document.createElement('input');
                            checkbox.type = 'checkbox';
                            checkbox.name = 'bophan';
                            checkbox.className = "custom-checkbox";
                            checkbox.value = bophan.mabophan;

                            // Kiểm tra nếu mabophan có trong mảng mangMaBophanCanDanhDau thì đánh dấu checked
                            if (d.some(function(item) {
                                    return item.mabophan === bophan.mabophan;
                                })) {
                                checkbox.checked = true;
                            }

                            checkboxContainer.appendChild(checkbox);
                            var label = document.createElement('label');
                            label.appendChild(checkbox);
                            label.appendChild(document.createTextNode(bophan.tenbophan));

                            checkboxContainer.appendChild(label);
                        }
                    }
                });


            });
        });
    </script>
    <script>
        var updateButton = document.getElementById('update-button');
        updateButton.addEventListener('click', function() {
            var checkboxes = document.getElementsByName('bophan');
            var selectedValues = [];

            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    selectedValues.push(checkboxes[i].value);
                }
            }

            // Cập nhật giá trị đã chọn tại đây
            console.log('Giá trị đã chọn:', selectedValues);
            $(document).ready(function() {
                $.ajax({
                    url: '/capnhatnhomql',
                    method: 'POST',
                    data: {
                        nhom: selectedValues,
                        manhanvien: manhanviencv2.value,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                            alert("cập nhật thành công");

                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
