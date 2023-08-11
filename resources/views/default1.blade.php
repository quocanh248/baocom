<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="/dist/css/cssindex.css">
    <script type="text/javascript" src="/dist/jquery/jquery36.js"></script>
</head>

<body>
    <main class="container">
        <div class="content">
            <div class="menu">
                <div class="menu-left">
                    <div class="menu-left-left">
                        <ul>
                            <li>
                                <a href="" class="btn__submenu">Nhân sự</a>
                                <ul class="submenu">
                                    <li><a href="/dsnhansu">DS nhân sự</a></li>
                                    <li><a href="/dslichlamviec">Lịch làm việc</a></li>
                                    @if (count(Session::get('q')) > 0)
                                        @php
                                            $q = Session::get('q');
                                        @endphp
                                        @if ($q[0]->maquyen == 1 || $q[0]->maquyen == 2)
                                            <li><a href="/viewcaptaikhoan">Quản lý tài khoản</a></li>
                                        @endif
                                        @if ($q[0]->maquyen == 1 || $q[0]->maquyen == 30)
                                            <li><a href="/sodo">Cập nhật sơ đồ</a></li>
                                        @endif
                                    @endif
                                    <li><a href="/xemsodo">xem sơ đồ</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="" class="btn__submenu">Báo cơm</a>
                                <ul class="submenu">
                                    <li><a href="/dscomchay">DS ĐK cơm chay</a></li>
                                    <li><a href="/dscomman">DS ĐK cơm mặn</a></li>
                                    <li><a href="/tkcomtheongay">TK cơm ngày</a></li>
                                    <li><a href="/thongkecomthang">TK cơm tháng</a></li>
                                    <li><a href="/dkcomchay">Đăng ký cơm chay</a></li>
                                    <li><a href="/ktrcomchay">Kiểm tra cơm chay</a></li>
                                    <li><a href="/convert">Đăng ký cơm mặn</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="" class="btn__submenu">Công việc </a>
                                <ul class="submenu">
                                    @if (count(Session::get('q')) > 0)
                                        @php
                                            $q = Session::get('q');
                                        @endphp
                                        @foreach ($q as $data)
                                            @if ($data->maquyen == 1 || $data->maquyen == 10 || $data->maquyen == 20)
                                                <li><a href="/viewpccv">DS các bộ phận</a></li>
                                            @break
                                        @endif
                                    @endforeach
                                @endif
                                <li><a href="/viewpccvcc">Xem cv cá nhân</a></li>
                            </ul>
                        </li>                        
                    </ul>
                </div>

            </div>
        </div>
        @yield('content')

    </div>
</main>

</body>
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

    function adjustColumnWidths() {
        const table = document.getElementById("bangNhanVien1");
        const totalColumns = table.rows[0].cells.length;
        const tableWidth = table.offsetWidth;
        const columnMinWidth = 200; // Độ rộng tối thiểu của cột
        // const columnMaxWidth = 200; // Độ rộng tối đa của cột
        const columnCount = Math.min(totalColumns, Math.floor(tableWidth / columnMinWidth));

        const columnWidth = Math.floor(tableWidth / columnCount);
        console.log(totalColumns, tableWidth, columnWidth);
        // Cài đặt độ rộng tối thiểu cho các tiêu đề (th)
        const tableCells1 = table.getElementsByTagName("th");
        for (let i = 0; i < tableCells1.length; i++) {
            tableCells1[i].style.minWidth = columnWidth + "px";
        }
    }
</script>

</html>
