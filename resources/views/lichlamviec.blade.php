@extends ('default1')

@section('content')
    <div class="header">
        <div class="header-cont">
            <div class="header-cont-title">
                <span>
                    @php
                        $gio = $results[0]->giobatdau;
                        $date = new DateTime($gio);
                        $gioFormatted = $date->format('d/m/Y');
                    @endphp
                    Lập lịch ngày {{ substr($gioFormatted, 0, 10) }}
                </span>
            </div>
            <div class="header-cont-content">
            </div>
            <div class="search-box">
                <input type="text" id="manhanvienInput" placeholder="Nhập mã nhân viên">
                @if (count(Session::get('q')) > 0)
                    @php
                        $q = Session::get('q');
                    @endphp
                    @if ($q[0]->maquyen == 1 || $q[0]->maquyen == 2)
                        <button class="search" style="text-decoration: none; padding: 8px" href="/lichlamviec"
                            id="lichlamviec">Làm mới</button>
                    @endif
                @endif
                <button class="search" id="highlightButton">Chọn</button>
            </div>

        </div>
    </div>
    <div class="container-content">
        <table class="table-mom" id="bangNhanVien">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Nhóm</th>
                    <th>Ca</th>
                    <th>Giờ vào ca</th>
                    <th>Giờ ra ca</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $c = 0;
                @endphp
                @foreach ($results as $hit)
                    <tr>
                        <td>{{ $c }}</td>
                        <td>{{ $hit->manhanvien }}</td>
                        <td>{{ $hit->tennhanvien }}</td>
                        <td>{{ $hit->tennhom }}</td>
                        <td>{{ $hit->ca }}</td>
                        <td>{{ substr($hit->giobatdau, 10, 6) }}</td>
                        <td>{{ substr($hit->gionghi, 10, 6) }}</td>
                        <td></td>
                    </tr>
                    @php
                        $c++;
                    @endphp
                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <td>Tổng {{ count($results) }}</td>
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
