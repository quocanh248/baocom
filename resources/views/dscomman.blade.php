@extends ('default1')

@section('content')
    <div class="header">
        <div class="header-cont">
            <div class="header-cont-title">
                <span>
                    DS đăng ký cơm mặn
                </span>
            </div>
            <div class="header-cont-content">
            </div>
            <div class="search-box">
                <input type="text" id="manhanvienInput" placeholder="Nhập ngày để tìm kiếm">
                <button class="search" id="highlightButton">Chọn</button>
            </div>

        </div>
    </div>
    <div class="container-content">
        <table class="table-mom" id="bangNhanVien">
            <thead>
                <tr>
                    <th>Mã</th>
                    <th>Tên</th>
                    <th>Nhóm</th>
                    <th>Xưởng</th>
                    <th>Ngày nhận</th>
                    <th>Giờ nhận</th>
                    <th>Khung giờ</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $data)
                    <tr>
                        <td>{{ $data->manhanvien }}</td>
                        <td style="text-align: left">{{ $data->tennhanvien }}</td>
                        <td style="text-align: left">{{ $data->tennhom }}</td>
                        @php
                            if ($data->ip == '30.30.30.42' || $data->ip == '30.30.30.43' || $data->ip == '30.30.30.44' || $data->ip == '30.30.30.45') {
                                $tenmay = 'VT2';
                            } else {
                                $tenmay = 'VT1';
                            }
                        @endphp
                        <td style="text-align: left">{{ $tenmay }}</td>
                        <td style="text-align: left">{{ $data->created_at }}</td>
                        <td>{{ substr($data->updated_at, 10, 6) }}</td>
                        @php                            
                            $k = substr($data->updated_at, 14, 2);
                            $thoiGian = \Carbon\Carbon::parse(substr($data->updated_at, 10, 6));
                            if ($k < 30) {
                                $thoiGianLamTron = $thoiGian->minute(0);
                            } else {
                                $thoiGianLamTron = $thoiGian->minute(30);
                            }                            
                        @endphp
                        <td>{{ substr($thoiGianLamTron, 10, 6) }}</td>
                        <td></td>
                    </tr>
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
            const columnMinWidth = 80; // Độ rộng tối thiểu của cột
            // const columnMaxWidth = 200; // Độ rộng tối đa của cột
            const columnCount = Math.min(totalColumns, Math.floor(tableWidth / columnMinWidth));

            const columnWidth = Math.floor(tableWidth / columnCount);
            console.log(totalColumns, tableWidth, columnWidth);

            // Cài đặt độ rộng cho các cột
            const tableCells = table.getElementsByTagName("td");
            for (let i = 0; i < tableCells.length; i++) {
                tableCells[i].style.minWidth = columnWidth + "px";
                tableCells[i].style.maxWidth = columnWidth + "px";
                // tableCells[i].style.minWidth = 100 + "px";
                // tableCells[i].style.maxWidth = 100 + "px";
                tableCells[i].style.whiteSpace = "nowrap";
                tableCells[i].style.overflow = "hidden";
                tableCells[i].style.textOverflow = "ellipsis";
            }
            // Cài đặt độ rộng tối thiểu cho các tiêu đề (th)
            const tableCells1 = table.getElementsByTagName("th");
            for (let i = 0; i < tableCells1.length; i++) {
                tableCells1[i].style.minWidth = columnWidth + "px";
                // tableCells1[i].style.minWidth = 100 + "px";
            }
        }
    </script>
@endsection
