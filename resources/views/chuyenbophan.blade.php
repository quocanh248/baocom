@extends ('welcome')

@section('content')
    <div class="header-right">
        <label class="title" for="">
            Bàn giao và chuyển bộ phận

        </label>

        <div class="search-box">
            <input type="text" id="manhanvienInput" placeholder="Nhập tên nhân viên để tìm">
            {{-- <a class="search1" style="text-decoration: none; padding: 12px; width: 150px; background-color: #C70039"
                href="/cvsaphethan">Sắp hết hạn</a> --}}
            <button class="search" style="margin-right: 50px;  background-color: #d58619;" onclick="goBack()">Quay về</button>
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

        label {
            font-size: 20px;
            color: #1565c0;
        }
    </style>
    <div class="container" style="justify-items: center; justify-content: center;">
        <table class="fixed_header" id="bangNhanVien">
            <thead>
                <tr>
                    <th style="text-align: left">Mã Nhân viên</th>
                    <th>Tên Tên nhân viên</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tbody">
                @foreach ($nhom as $data)
                    <tr>
                        <td style="text-align: left">{{ $data->manhanvien }}</td>
                        <td style="">{{ $data->tennhanvien }}</td>
                        @php $gv1 = $ktrcv->getcv1($data->manhanvien); @endphp
                        @if (count($gv1) > 0)
                            <td><button class="search-mini-cv2" style="width:130px" value="{{ $data->manhanvien }}"
                                    id="bangiaocv{{ $data->manhanvien }}">Bàn giao CV</button></td>
                        @else
                            <td></td>
                        @endif
                        <td><button class="search-mini-1" style="width:130px; background-color: #e38a1d"
                                value="{{ $data->manhanvien }}" id="chuyenbophan{{ $data->manhanvien }}">Chuyển bộ
                                phận</button></td>

                    </tr>
                @endforeach

            </tbody>
        </table>
        <div id="myModal1" class="modal" style="margin-top: 0; display: none">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close1">&times;</span>
                    <h3>Chuyển bộ phận</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="input1">Mã nhân viên:</label>
                                <input type="text" name="manhanvien" id="tennhanvien" class="form-control" readonly
                                    autocomplete="off" required>
                            </div>
                            <div class="col-6">
                                <label for="input1">Tên nhân viên:</label>
                                <input type="text" class="form-control" autocomplete="off" readonly id="tennhanvien1"
                                    required>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="input1">Chọn bộ phận đến:</label>
                                <input type="text" name="manhom" id="tenbophan" class="form-control" autocomplete="off"
                                    required list="listnhom">
                                <datalist id="listnhom">
                                    @foreach ($ds as $data)
                                        <option value="{{ $data->tenbophan }}" label="{{ $data->mabophan }}"></option>
                                    @endforeach

                                </datalist>
                            </div>
                            <div class="col-6">
                                <label for="input1">Mã bộ phận:</label>
                                <input type="text" name="manhanvien" id="manhom" class="form-control" readonly
                                    autocomplete="off" required>
                            </div>

                        </div>
                        <div class="row" style="">


                        </div>
                        <div class="row" id="col6">
                            <div class="col-6" id="">
                                <label for="input1">Người tiếp nhận công việc:</label>
                                <input type="text" name="tiepnhan" id="tiepnhan" class="form-control" autocomplete="off"
                                    list="listtiepnhan">
                                <datalist id="listtiepnhan">

                                </datalist>
                            </div>
                            <div class="col-6">
                                <label for="input1">Tên người tiếp nhận:</label>
                                <input type="text" name="tiepnhan" id="tennguoitiepnhan" class="form-control"
                                    autocomplete="off" readonly>


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-7"></div>
                            <div class="col-3" id="col4">
                                <input type="checkbox" id="checkbox" class="form-control" style="margin-left: 0">
                                <label for="input1"><b>Không</b> bàn giao công việc:</label>
                            </div>
                            <div class="col-2">

                                <button type="submit" id="btbangiao" style="margin-left: 60px;"
                                    value="{{ $nhom[0]->mabophan }}" class="search1">Chuyển</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div id="myModal" class="modal" style="margin-top: 0; display: none">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h3>Bàn giao công việc</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="input1">Mã nhân viên:</label>
                                <input type="text" name="manhanvien" id="tennhanvien0" class="form-control" readonly
                                    autocomplete="off" required>
                            </div>
                            <div class="col-6">
                                <label for="input1">Tên nhân viên:</label>
                                <input type="text" class="form-control" autocomplete="off" readonly id="tennhanvien2"
                                    required>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-6" id="">
                                <label for="input1">Người tiếp nhận công việc:</label>
                                <input type="text" name="tiepnhan" id="tiepnhan0" class="form-control"
                                    autocomplete="off" list="listtiepnhan1">

                                <datalist id="listtiepnhan1">

                                </datalist>
                            </div>
                            <div class="col-6">
                                <label for="input1">Tên người tiếp nhận:</label>
                                <input type="text" name="tiepnhan" id="tennguoitiepnhan0" class="form-control"
                                    autocomplete="off" readonly>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-10"></div>
                            <div class="col-2">
                                <button type="submit" id="btbangiao0" style="margin-left: 60px;"
                                    value="{{ $nhom[0]->mabophan }}" class="search1">Bàn giao</button>
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
            //thực hiện hoàn thành
            var btbangiao = document.getElementById("btbangiao");
            var tennhanvien = document.getElementById("tennhanvien");
            var manhom = document.getElementById("manhom");
            var tiepnhan = document.getElementById("tiepnhan");
            // var bangiao = document.getElementById("bangiao");
            var col4 = document.getElementById("col4");
            var col6 = document.getElementById("col6");
            var listnhom = document.getElementById("listnhom");
            var listtiepnhan = document.getElementById("listtiepnhan");
            var tenbophan = document.getElementById("tenbophan");
            var tennguoitiepnhan = document.getElementById("tennguoitiepnhan");
            var cell2Value = "";
            var checkbox = document.getElementById("checkbox");
            checkbox.addEventListener("change", function() {
                if (checkbox.checked) {
                    col6.style.visibility = "hidden";
                    tiepnhan.value = "";
                    tennguoitiepnhan.value = "";
                } else {
                    col6.style.visibility = "visible";
                }

            });
            tenbophan.addEventListener("change", function() {
                var selectedOption = tenbophan.value;
                var options = listnhom.options;
                var optionText, optionValue;

                for (var i = 0; i < options.length; i++) {
                    if (options[i].value === selectedOption) {
                        optionText = options[i].label;
                        optionValue = options[i].value;
                        break;
                    }
                }
                manhom.value = optionText;
            });
            tiepnhan.addEventListener("change", function() {
                var selectedOption = tiepnhan.value;
                var options = listtiepnhan.options;
                var optionText, optionValue;

                for (var i = 0; i < options.length; i++) {
                    if (options[i].value === selectedOption) {
                        optionText = options[i].label;
                        optionValue = options[i].value;
                        break;
                    }
                }
                tennguoitiepnhan.value = optionText;
            });
            btbangiao.addEventListener("click", function(event) {
                event.preventDefault(); // Ngăn chặn hành vi mặc định khi click vào liên kết 

                if (checkbox.checked) {
                    if (tennhanvien.value === "") {
                        alert("Vui lòng nhập đày đủ thông tin");
                    } else {
                        $(document).ready(function() {
                            $.ajax({
                                url: '/chuyenbophanmoi',
                                method: 'POST',
                                data: {
                                    manhanvien: tennhanvien.value,
                                    bangiao: "false",
                                    tiepnhan: tiepnhan.value,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    if (response.success) {
                                        alert(response.message);
                                        location.reload();

                                    } else {
                                        alert(response.message);
                                    }

                                },
                                error: function(xhr, status, error) {
                                    console.log(xhr.responseText);
                                }
                            });
                        });

                    }
                } else {
                    if (cell2Value == "") {
                        var temp = "none";
                    } else {
                        var temp = tiepnhan.value;
                    }
                    if (tennhanvien.value === "" || manhom.value === "" || temp === "") {
                        alert("Vui lòng nhập đày đủ thông tin");
                    } else {
                        $(document).ready(function() {
                            $.ajax({
                                url: '/chuyenbophanmoi',
                                method: 'POST',
                                data: {
                                    manhanvien: tennhanvien.value,
                                    manhom: manhom.value,
                                    bangiao: "true",
                                    tiepnhan: temp,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    if (response.success) {
                                        alert(response.message);
                                        location.reload();
                                    } else {
                                        alert(response.message);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.log(xhr.responseText);
                                }
                            });
                        });
                    }
                }
            });
            var myModal1 = document.getElementById("myModal1");
            var tennhanvien2 = document.getElementById("tennhanvien2");
            var closeButton1 = document.getElementsByClassName("close1")[0];
            var myModal = document.getElementById("myModal");
            var closeButton = document.getElementsByClassName("close")[0];
            closeButton1.addEventListener("click", function() {
                myModal.style.display = "none";
                myModal1.style.display = "none";
            });
            window.onload = function() {
                myModal1.style.display = "none";
                myModal.style.display = "none";
            };
            $(".search-mini-1").click(function() {
                myModal1.style.display = "block";
                var inputs = document.querySelectorAll("#myModal1 input");
                // Xóa giá trị của mỗi input
                inputs.forEach(function(input) {
                    input.value = "";
                });
                var buttonValue = $(this).val();
                tennhanvien.value = buttonValue;
                var row = $(this).closest("tr");

                // Lấy giá trị của các ô trong hàng
                var cell1Value = row.find("td:eq(1)").text();
                cell2Value = row.find("td:eq(2)").text();
                var col4 = document.getElementById("col4");
                if (cell2Value == "") {
                    col4.style.visibility = "hidden";
                    col6.style.visibility = "hidden";
                } else {
                    col6.style.visibility = "visible";
                    col4.style.visibility = "visible";
                }
                tennhanvien1.value = cell1Value;
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
                        url: '/laynhanvientiepnhan/' + tennhanvien.value + '/' + btbangiao.value,
                        success: function(res) {
                            $('#listtiepnhan').empty();
                            console.log(res);
                            $.each(res, function(i, item) {
                                $('#listtiepnhan').append($('<option>', {
                                    value: item.manhanvien,
                                    text: item.tennhanvien,
                                }));
                            });
                        }
                    });


                });

            });
        </script>
        {{-- Modal bàn giao --}}
        <script>
            //thực hiện hoàn thành
            var btbangiao0 = document.getElementById("btbangiao0");
            var tennhanvien0 = document.getElementById("tennhanvien0");
            var tiepnhan0 = document.getElementById("tiepnhan0");
            var listnhom = document.getElementById("listnhom");
            var listtiepnhan1 = document.getElementById("listtiepnhan1");
            var tennguoitiepnhan0 = document.getElementById("tennguoitiepnhan0");
            var cell2Value = "";
            tiepnhan0.addEventListener("change", function() {
                var selectedOption = tiepnhan0.value;
                var options = listtiepnhan1.options;
                var optionText, optionValue;

                for (var i = 0; i < options.length; i++) {
                    if (options[i].value === selectedOption) {
                        optionText = options[i].label;
                        optionValue = options[i].value;
                        break;
                    }
                }
                tennguoitiepnhan0.value = optionText;
            });
            btbangiao0.addEventListener("click", function(event) {
                event.preventDefault(); // Ngăn chặn hành vi mặc định khi click vào liên kết               
                if (tiepnhan0.value === "") {
                    alert("Vui lòng nhập đày đủ thông tin");
                } else {
                    $(document).ready(function() {
                        $.ajax({
                            url: '/bangiaocv',
                            method: 'POST',
                            data: {
                                manhanvien: tennhanvien0.value,
                                tiepnhan: tiepnhan0.value,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    alert(response.message);
                                    location.reload();

                                } else {
                                    alert(response.message);
                                }

                            },
                            error: function(xhr, status, error) {
                                console.log(xhr.responseText);
                            }
                        });
                    });
                }
            });
            var myModal1 = document.getElementById("myModal1");
            var tennhanvien2 = document.getElementById("tennhanvien2");
            var myModal = document.getElementById("myModal");
            var closeButton = document.getElementsByClassName("close")[0];
            closeButton.addEventListener("click", function() {
                myModal.style.display = "none";
                myModal1.style.display = "none";
            });
            window.onload = function() {
                myModal1.style.display = "none";
                myModal.style.display = "none";
            };
            $(".search-mini-cv2").click(function() {
                myModal.style.display = "block";
                var inputs = document.querySelectorAll("#myModal1 input");
                // Xóa giá trị của mỗi input
                inputs.forEach(function(input) {
                    input.value = "";
                });
                var buttonValue = $(this).val();
                tennhanvien0.value = buttonValue;
                var row = $(this).closest("tr");
                // Lấy giá trị của các ô trong hàng
                var cell1Value = row.find("td:eq(1)").text();
                tennhanvien2.value = cell1Value;
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
                        url: '/laynhanvientiepnhan/' + tennhanvien0.value + '/' + btbangiao.value,
                        success: function(res) {
                            $('#listtiepnhan').empty();
                            console.log(res);
                            $.each(res, function(i, item) {
                                $('#listtiepnhan').append($('<option>', {
                                    value: item.manhanvien,
                                    text: item.tennhanvien,
                                }));
                            });
                            $('#listtiepnhan1').empty();
                            $.each(res, function(i, item) {
                                $('#listtiepnhan1').append($('<option>', {
                                    value: item.manhanvien,
                                    text: item.tennhanvien,
                                }));
                            });
                        }
                    });


                });

            });
        </script>
    @endsection
