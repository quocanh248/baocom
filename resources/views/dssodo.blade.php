@extends ('welcome')

@section('content')
    <div class="header-right">
        <label class="title" for="">

            Sơ đồ dạng list
        </label>

        <div class="search-box">
            <input type="text" id="manhanvienInput" placeholder="Nhập mã nhân viên">
            <button class="search" id="highlightButton">Chọn</button>
        </div>

    </div>
    <div class="container">

        <table class="fixed_header" id="bangNhanVien">
            <thead>
                <tr>
                    <th>Mã</th>
                    <th>Họ Tên</th>
                    <th>Chức danh</th>
                    <th>người quản lý</th>
                    <th>Chức danh</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($dsnhansu as $data)
                    <tr>
                        <td>{{ $data->manhanvien }}</td>
                        <td>{{ $data->tennhanvien }}</td>
                        <td>{{ $data->mota }}</td>
                        @php
                            $gv1 = $gv->getchucdanhql($data->id);
                        @endphp
                        @if (count($gv1) > 0)
                            @foreach ($gv1 as $data1)
                                <td>{{ $data1->tennhanvien }}</td>
                                <td>{{ $data1->mota }}</td>
                            @endforeach
                        @else
                            <td></td>
                            <td></td>
                        @endif
                        <td> <button class="search-mini-cv1" style="width:130px" value="{{ $data->id }}">Sửa</button>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
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
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        var myModal1 = document.getElementById("myModal1");
        var closeButton1 = document.getElementsByClassName("close1")[0];
        closeButton1.addEventListener("click", function() {
            myModal1.style.display = "none";
            location.reload();
        });
        window.onload = function() {
            myModal1.style.display = "none";
        };
        $(".search-mini-cv1").click(function() {
            var buttonValue = $(this).val();
            myModal1.style.display = "block";
            var inputs = document.querySelectorAll("#myModal1 input");

            inputs.forEach(function(input) {
                input.value = "";
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
                    url: '/laythongtinnode/' + buttonValue,
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
