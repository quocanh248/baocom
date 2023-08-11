<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chấm cơm mặn</title>
    <link rel="stylesheet" href="/dist/css/comman.css">
</head>

<body>
    <div class="header">
        <div class="header-left">
            <p>Chấm cơm mặn</p>
        </div>
        <div class="header-right">
            <div class="number">
                <p id="error-1">SL: 0</p>
            </div>
            <div class="day">
                <p>Ngày:</p>
                <input type="text" id="ngay">
                <button class="btnnew" id="reset-btn">Làm mới</button>
            </div>
        </div>
    </div>
    <div class="info">
        @csrf
        <input type="text" id="manhanvien" value="">
        <input type="text" id="hoten" value="">
    </div>
    <div class="footer">
        <p id="ok" style="display: none;">OK</p>
        <p id="ok1" style="background-color: red; display: none;">NG</p>
    </div>
</body>

</html>




<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    var currentDate = new Date();
    var today = new Date();
    // Lấy thông tin ngày, tháng và năm
    var day = today.getDate();
    var month = today.getMonth() + 1; // Lưu ý: Tháng trong JavaScript đếm từ 0 (0 = Tháng 1)
    var year = today.getFullYear();
    // Định dạng ngày để đưa vào input
    var formattedDate = (day < 10 ? '0' : '') + day + '/' + (month < 10 ? '0' : '') + month + '/' + year;
    // Đưa giá trị vào input có id="ngay"
    document.getElementById("ngay").value = formattedDate;
    var sl = 0;
    // Lấy ngày trước đó từ localStorage (nếu đã lưu trước đó)
    var previousDate = localStorage.getItem('previousDate');
    console.log(currentDate.getDate() == previousDate);
    // So sánh ngày hiện tại với ngày trước đó
    if (currentDate.getDate() != previousDate) {
        localStorage.setItem('previousDate', currentDate.getDate()); // Lưu ngày hiện tại vào localStorage
        sl = 0;
        sessionStorage.clear();
        location.reload();
    } else {
        var resetBtn = document.getElementById('reset-btn');
        resetBtn.addEventListener('click', function() {
            sessionStorage.clear();
            location.reload();
        });
        var barcodeValue = "";

        document.addEventListener("keypress", function(event) {
            barcodeValue += event.key;
            // Xử lý khi quét xong barcode
            if (event.key === "Enter") {
                processBarcode(barcodeValue);
                barcodeValue = "";
            }
        });

        console.log(barcodeValue);

        function processBarcode(barcode) {
            var manhanvien = document.getElementById("manhanvien");
            var hoten = document.getElementById("hoten");
            var result = barcode.slice(0, -5);
            console.log(barcode, result);
            console.log(manhanvien, hoten, result)
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    }
                });
                $.ajax({
                    type: 'GET',
                    datatype: 'JSON',
                    data: {
                        result: result,
                    },
                    url: '/laythongtin',
                    success: function(res) {
                        console.log(res);
                        var element = document.getElementById("ok");
                        var element1 = document.getElementById("ok1");

                        if (res.length < 1) {

                            setTimeout(function() {
                                element1.innerHTML = "NG";
                                element1.style.color =
                                    "white"; // Đặt độ mờ thành 1 để hiển thị phần tử
                                element1.style.display = 'none';
                            }, 300);
                            element.style.display = 'none';
                            element1.style.display = 'block';
                        } else {

                            setTimeout(function() {
                                element.innerHTML = "OK";
                                element.style.color =
                                    "white"; // Đặt độ mờ thành 1 để hiển thị phần tử
                                element.style.display = 'none';
                            }, 300);
                            element.style.display = 'block';
                            element1.style.display = 'none';
                            let dschamcom = JSON.parse(sessionStorage
                                .getItem('dschamcom')) || [];
                            $.each(res, function(i, item) {
                                hoten.value = item.tennhanvien,
                                    manhanvien.value = item.manhanvien,
                                    console.log(dschamcom);
                                const existingItem = dschamcom.some(element =>
                                    element.manhanvien === item.manhanvien);
                                console.log(existingItem)
                                if (!existingItem) {
                                    dschamcom.push({
                                        manhanvien: item.manhanvien,
                                    });
                                    sessionStorage.setItem('dschamcom', JSON.stringify(
                                        dschamcom));
                                    sl = sl + 1;
                                    document.getElementById("error-1").innerHTML =
                                        "SL: " + sl;

                                }

                            });

                        }

                    }
                });
            });
        }
    }
</script>
