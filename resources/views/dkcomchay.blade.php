<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Đăng ký cơm chay</title>
    <link rel="stylesheet" href="/dist/css/comman.css">
</head>

<body>
    <div class="header">
        <div class="header-left">
            <p>Đăng ký cơm chay</p>
        </div>
        <div class="header-right">
            <div class="number">
                <p id="error-1">SL: </p>
            </div>
            <div class="day">
                <p>Ngày đăng ký</p>
                <input type="text" id="ngay">
                <button class="btnnew" id="reset-btn">Làm mới</button>
            </div>
        </div>
    </div>
    <div class="info">
        <input type="text" id="manhanvien">
        <input type="text" id="hoten">
    </div>
    <div class="footer">
        <p id="ok" style="display: none;">OK</p>
        <p id="ok1" style="background-color: red; display: none;">NG</p>
        <p id="ok2"
            style="background-color: #f58b00; font-size: 200px; font-weight: bold;  text-align: center;display: none">Đã
            đăng ký
        </p>
    </div>


    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        var currentDate = new Date();
        var year = currentDate.getFullYear(); // Năm (ví dụ: 2023)
        var month = currentDate.getMonth() + 1; // Tháng (giá trị từ 0-11, nên cần cộng thêm 1)
        var day = currentDate.getDate(); // Ngày (ví dụ: 25)
        var hours = currentDate.getHours(); // Giờ (ví dụ: 10)
        var minutes = currentDate.getMinutes(); // Phút (ví dụ: 30)
        var seconds = currentDate.getSeconds(); // Giây (ví dụ: 45)
        var sl = 0;
        console.log(currentDate);
        // Lấy ngày trước đó từ localStorage (nếu đã lưu trước đó)
        var previousDate = localStorage.getItem('previousDate1');
        console.log(currentDate.getDate() != previousDate);
        // So sánh ngày hiện tại với ngày trước đó
        if (currentDate.getDate() != previousDate) {
            localStorage.setItem('previousDate1', currentDate.getDate()); // Lưu ngày hiện tại vào localStorage
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

            function processBarcode(barcode) {
                var manhanvien = document.getElementById("manhanvien");
                var ngay = document.getElementById("ngay");
                var hoten = document.getElementById("hoten");
                var result = barcode.slice(0, -5);
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
                        url: '/laythongtincomchay',
                        success: function(res) {
                            console.log(res);
                            var element = document.getElementById("ok");
                            var element1 = document.getElementById("ok1");
                            var element2 = document.getElementById("ok2");
                            if (res.length < 1) {

                                setTimeout(function() {
                                    element1.innerHTML = "NG";
                                    element1.style.color =
                                        "white"; // Đặt độ mờ thành 1 để hiển thị phần tử
                                    element1.style.display = 'none';
                                }, 300);
                                element.style.display = 'none';
                                element2.style.display = 'none';
                                element1.style.display = 'block';
                            } else {

                                let dschamcom = JSON.parse(sessionStorage
                                    .getItem('dschamcom')) || [];
                                $.each(res, function(i, item) {
                                    hoten.value = item.tennhanvien,
                                        manhanvien.value = item.manhanvien,
                                        ngay.value = day + '-' + month + '-' + year + ' ' +
                                        hours + ':' + minutes + ':' + seconds;
                                    console.log(dschamcom);
                                    const existingItem = dschamcom.some(element =>
                                        element.manhanvien === item.manhanvien);
                                    console.log(existingItem)
                                    if (!existingItem) {

                                        setTimeout(function() {
                                            element.innerHTML = "OK";
                                            element.style.color =
                                                "white"; // Đặt độ mờ thành 1 để hiển thị phần tử
                                            element.style.display = 'none';
                                        }, 300);
                                        element.style.display = 'block';
                                        element1.style.display = 'none';
                                        element2.style.display = 'none';
                                        dschamcom.push({
                                            manhanvien: item.manhanvien,
                                        });
                                        sessionStorage.setItem('dschamcom', JSON.stringify(
                                            dschamcom));
                                        sl = sl + 1;
                                        document.getElementById("error-1").innerHTML =
                                            "SL: " + sl;

                                    } else {
                                        setTimeout(function() {

                                            element2.style.display = 'none';
                                        }, 300);
                                        element2.style.display = 'block';
                                        element.style.display = 'none';
                                        element1.style.display = 'none';
                                    }

                                });

                            }

                        }
                    });
                });
            }
        }
    </script>

</body>

</html>
