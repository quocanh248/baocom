<!doctype html>
<html lang="en" translate="no">

<head>
    <meta charset="utf-8">
    <title>Leanwell System</title>
    <base href="/">
    <link rel="stylesheet" href="/dist/css/modal.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <head>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {
                packages: ["orgchart"]
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Name');
                data.addColumn('string', 'Manager');
                data.addColumn('string', 'ToolTip');

                // For each orgchart box, provide the name, manager, and tooltip to show.
                data.addRows([
                    @foreach ($dsnhansu as $data)
                        [{
                                v: '{{ $data->machucdanh }}',
                                f: '<div style="color:red; font-style:italic"><img src="http://30.0.2.8:8001/{{ $data->hinhanh }}" alt="" id="htimg" style="width: 60px; height: 60px"><br><button id="1" value="{{ $data->id }}" class="buton1" onclick="handleButtonClick(this)" style="color:red; background-color: transparent; border: none;">{{ $data->mota }}</button></div>{{ $data->tennhanvien }}'
                            },
                            '{{ $data->chucdanhql }}', '{{ $data->mota }}'
                        ],
                    @endforeach

                ]);
                // Create the chart.
                var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
                // Draw the chart, setting the allowHtml option to true for the tooltips.
                chart.draw(data, {
                    'allowHtml': true
                });
            }
        </script>
    </head>

    <body>
    <div class="container1" id="con" style="display: none">
        <div id="myModal1" class="modal" style="display: none">
            <div class="modal-content1" style="height: 650px;">
                <div class="modal-header">
                    <span class="close1">&times;</span>
                    <h3 id="h3">Thêm nhân sự cấp dưới</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">

                        <div class="row">
                            <div class="col-6">
                                <label for="input1">Mã người Quản lý:</label>
                                <input type="text" name="manhanvien" id="maquanly" class="form-control" readonly
                                    autocomplete="off" required list="">

                            </div>
                            <div class="col-6">
                                <label for="input1">Tên người Quản lý:</label>
                                <input type="text" name="manhanvien" id="tenquanly" class="form-control" readonly
                                    autocomplete="off" required>

                            </div>


                        </div>
                        <div class="row">
                            <div class="col-2">
                                <label for="input1">Cập nhật quản lý:</label>
                                <input type="checkbox" name="" id="checkbox" class="form-control"
                                    autocomplete="off" required>

                            </div>
                        </div>
                        <div class="row" id="divthemnhanvien">
                            <div class="col-4">
                                <label for="input1">Mã nhân viên</label>
                                <input type="text" name="manhanvien" id="manhanvien" class="form-control"
                                    autocomplete="off" required list="dsnhanvien">
                                <datalist id="dsnhanvien">

                                </datalist>
                            </div>
                            <div class="col-4">
                                <label for="input1">Tên nhân viên:</label>
                                <input type="text" name="manhanvien" id="tennhanvien" class="form-control" readonly
                                    autocomplete="off" required>

                            </div>
                            <div class="col-4">
                                <label for="input1">Chức danh:</label>
                                <input type="text" name="manhanvien" id="mota" class="form-control"
                                    autocomplete="off" required>

                            </div>
                        </div>
                        <div class="row" id="divcapnhatvitri" style="display:none">
                            <div class="col-4">
                                <label for="input1">Mã người quản lý mới</label>
                                <input type="text" name="manhanvien" id="maquanlymoi" class="form-control"
                                    autocomplete="off" required list="dsquanly">
                                <datalist id="dsquanly">

                                </datalist>
                            </div>
                            <div class="col-4">
                                <label for="input1">Tên người quản lý mới:</label>
                                <input type="text" name="manhanvien" id="tenquanlymoi" class="form-control" readonly
                                    autocomplete="off" required>

                            </div>
                            <div class="col-4">
                                <label for="input1">Chức danh:</label>
                                <input type="text" name="manhanvien" id="motaquanly" class="form-control"
                                    autocomplete="off" required>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="input1">Thêm hình ảnh</label>
                                <input type="file" name="" id="image-input" class="form-control">
                                <input type="hidden" value="" name="filename">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <button class="search1"
                                    style="text-decoration: none; padding: 12px; margin-top: 50px;"
                                    id="capnhatsodo">Thêm</button>
                                <button class="search"
                                    style="display:none; text-decoration: none; padding: 12px; margin-top: 50px;background-color: #04AA6D;"
                                    id="capnhatsodo1">Cập nhật</button>

                            </div>
                            <div class="col-4">
                                <button class="search"
                                    style="display:none; text-decoration: none; padding: 12px; margin-top: 50px;background-color: #961a1a;"
                                    id="xoanode">Xóa</button>
                            </div>
                            <div class="col-4">
                                <img id="preview-image" style="display:none" src="#" alt="Preview Image">
                            </div>
                        </div>
                        <br>
                        <div class="row">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container" id="con2">
        <div class="scroll-wrapper">
            <div class="scrollable-content">

                <button class="search" style=" margin: 15px;background-color: #af6c1a;" onclick="goBack()">Quay
                    về</button>
                <div id="chart_div"></div>
            </div>
        </div>
    </div>
</body>

<script>
    function goBack() {
        history.back();
    }
    $(document).ready(function() {
        var containerWidth = $('.container').width();
        var contentWidth = $('.scrollable-content').width();
        var scrollableDistance = contentWidth - containerWidth;

        $('.container').scrollLeft(scrollableDistance / 2);
    });
    var imageInput = document.getElementById('image-input');
    var previewImage = document.getElementById('preview-image');
    imageInput.addEventListener('change', function(event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        preview.style.display = "block";
        reader.onload = function(e) {
            previewImage.src = e.target.result;
        };

        reader.readAsDataURL(file);
    });
    var myModal1 = document.getElementById("myModal1");
    var con = document.getElementById("con");
    var closeButton1 = document.getElementsByClassName("close1")[0];
    var manhanvien = document.getElementById("manhanvien");
    var dsnhanvien = document.getElementById("dsnhanvien");
    var tennhanvien = document.getElementById("tennhanvien");
    var checkbox = document.getElementById("checkbox");
    var divcapnhatvitri = document.getElementById("divcapnhatvitri");
    var divthemnhanvien = document.getElementById("divthemnhanvien");
    var capnhatsodo1 = document.getElementById("capnhatsodo1");
    var capnhatsodo = document.getElementById("capnhatsodo");
    var h3 = document.getElementById("h3");
    var preview = document.getElementById("preview-image");
    checkbox.addEventListener("change", function() {
        if (checkbox.checked) {
            divcapnhatvitri.style.display = "flex";
            divcapnhatvitri.style.display = "-ms-flexbox";
            capnhatsodo1.style.display = "block";
            preview.style.display = "block";
            divthemnhanvien.style.display = "none";
            capnhatsodo.style.display = "none";
            h3.innerHTML = "Cập nhật vị trí";
            
        } else {
            divcapnhatvitri.style.display = "none";
            capnhatsodo1.style.display = "none";
            divthemnhanvien.style.display = "flex";
            // divthemnhanvien.style.display = "-ms-flexbox";
            capnhatsodo.style.display = "block";
            h3.innerHTML = "Thêm nhân sự cấp dưới";
            document.getElementById('preview-image').src = "";
        }

    });
    manhanvien.addEventListener("change", function() {
        var selectedOption = manhanvien.value;
        var options = dsnhanvien.options;
        var optionText, optionValue;

        for (var i = 0; i < options.length; i++) {
            if (options[i].value === selectedOption) {
                optionText = options[i].label;
                optionValue = options[i].value;
                break;
            }
        }
        tennhanvien.value = optionText;
    });
    var maquanly = document.getElementById("maquanlymoi");
    var dsquanly = document.getElementById("dsquanly");
    var tenquanly = document.getElementById("tenquanlymoi");
    maquanly.addEventListener("change", function() {
        var selectedOption = maquanly.value;
        var options = dsquanly.options;
        var optionText, optionValue;

        for (var i = 0; i < options.length; i++) {
            if (options[i].value === selectedOption) {
                optionText = options[i].label;
                optionValue = options[i].value;
                break;
            }
        }
        tenquanly.value = optionText;
    });
    closeButton1.addEventListener("click", function() {
        myModal1.style.display = "none";
        con.style.display = "none";
        con2.style.display = "block";

    });
    window.onload = function() {
        myModal1.style.display = "none";
        con2.style.display = "block";
        con.style.display = "none";
    };
    // Bắt sự kiện click cho các button có class "buton1"
    function handleButtonClick(button) {
        document.getElementById("xoanode").style.display = "none";
        document.getElementById("xoanode").value = "";
        myModal1.style.display = "block";
        con2.style.display = "none";
        con.style.display = "block";
        var buttonValue = button.value;
        var inputs = document.querySelectorAll("#myModal1 input");
        document.getElementById('preview-image').src = "";
        // Xóa giá trị của mỗi input
        inputs.forEach(function(input) {
            input.value = "";
        });
        // Thực hiện các hành động mong muốn với giá trị của button
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
                url: '/laythongtinchucdanh/' + buttonValue,
                success: function(response) {
                    var chucdanh = response.chucdanh;
                    var ttcn = response.ttcn;
                    var ttcn1 = response.ttcn1;
                    var dsnhansu = response.dsnhansu;
                    var dem = response.d;

                    console.log(dem, chucdanh, ttcn['manhanvien']);
                    if (dem == 0) {
                        document.getElementById("xoanode").style.display = "block";
                        document.getElementById("xoanode").value = buttonValue;
                    }
                    document.getElementById("maquanly").value = ttcn['manhanvien'];
                    document.getElementById("tenquanly").value = ttcn['tennhanvien'];
                    document.getElementById("capnhatsodo1").value = ttcn1['id'];
                    document.getElementById("motaquanly").value = ttcn1['mota'];
                    $('#dsnhanvien').empty();
                    $('#dsquanly').empty();
                    console.log(ttcn1['id']);
                    if (ttcn1['hinhanh'] != null) {

                        var baseUrl = window.location.origin;
                        var imageUrl = baseUrl + '/' + ttcn1['hinhanh'];
                        document.getElementById('preview-image').src = imageUrl;
                    }
                    $.each(dsnhansu, function(i, item) {
                        $('#dsnhanvien').append($('<option>', {
                            value: item.manhanvien,
                            text: item.tennhanvien,
                        }));
                        $('#dsquanly').append($('<option>', {
                            value: item.manhanvien,
                            text: item.tennhanvien,
                        }));
                    });


                }
            });


        });
    }
    $("#capnhatsodo1").click(function() {
        var id = document.getElementById("capnhatsodo1").value;
        var maquanly = document.getElementById("maquanlymoi").value;
        var mota = document.getElementById("motaquanly").value;
        var imageInput = document.getElementById('image-input');
        var formData = new FormData();
        formData.append('tmpFile', imageInput.files[0]);
        formData.append('mota', mota);
        formData.append('maquanly', maquanly);
        formData.append('id', id);
        if (mota == "" || maquanly == "") {
            alert("Vui lòng  nhập đầy đủ thông tin");
        } else {
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/capnhatsodochucdanh1',
                    method: 'POST',
                    data: formData,
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
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
        //location.reload();
    });
    $("#capnhatsodo").click(function() {
        var maquanly = document.getElementById("maquanly").value;
        var manhanvien = document.getElementById("manhanvien").value;
        var mota = document.getElementById("mota").value;

        var imageInput = document.getElementById('image-input');
        var formData = new FormData();
        formData.append('tmpFile', imageInput.files[0]);
        formData.append('mota', mota);
        formData.append('maquanly', maquanly);
        formData.append('manhanvien', manhanvien);
        if (mota == "" || manhanvien == "" || maquanly == "") {
            alert("Vui lòng  nhập đầy đủ thông tin");
        } else {
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/capnhatsodochucdanh',
                    method: 'POST',
                    data: formData,
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
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
        //location.reload();
    });
    $("#xoanode").click(function() {
        var buttonValue = $(this).val();
        var formData = new FormData();
        if (confirm('Bạn có chắc muốn xóa?')) {
            formData.append('id', buttonValue);
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/xoanode',
                    method: 'POST',
                    data: formData,
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        alert("Xóa thành công");
                        location.reload();

                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
        }
        //location.reload();
    });
</script>

</html>
