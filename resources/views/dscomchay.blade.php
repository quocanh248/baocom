@extends ('default1')

@section('content')
    <div class="header">
        <div class="header-cont">
            <div class="header-cont-title">
                <span>
                    DS đăng ký cơm chay
                </span>
            </div>
            <div class="header-cont-content">
            </div>
            <div class="search-box">
                <input type="text" id="manhanvienInput1" placeholder="Nhập xưởng để tìm kiếm">
                <input type="date" id="manhanvienInput" placeholder="Nhập ngày nhận  để tìm kiếm">
                <button class="search" id="highlightButton">Chọn</button>
            </div>

        </div>
    </div>   
    <div class="container-content">
        <table class="table-mom" id="bangNhanVien">
            <thead>
                <tr style="font-size: 13px">
                    <th style="text-align: left">Mã</th>
                    <th style="text-align: left">Tên</th>
                    <th style="text-align: left">Nhóm</th>
                    <th style="text-align: left">Xưởng</th>
                    <th style="text-align: left">Ngày đăng ký</th>
                    <th style="text-align: left">GĐK</th>
                    <th style="text-align: left">Khung giờ</th>
                    <th style="text-align: left">Ngày nhận</th>
                    <th style="text-align: left">Giờ nhận</th>
                    <th style="text-align: left">Trạng thái</th>
                    {{-- <th style="text-align: left">Máy đăng ký</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $data)
                    @php
                        $c = 0;
                        for ($i = 0; $i < count($nvn); $i++) {
                            if ($nvn[$i] == $data->manhanvien && $ngaydk == $data->ngaydk) {
                                $c++;
                                break;
                            }
                        }
                    @endphp
                    @if ($c == 0)
                        <tr style="font-size: 13px">
                            <td style="text-align: left">{{ $data->manhanvien }}</td>
                            <td style="text-align: left; font-size: 11px">{{ $data->tennhanvien }}</td>
                            <td style="text-align: left">{{ $data->tennhom }}</td>
                            @if ($data->ip == '30.30.30.32')
                                <td style="text-align: left">VT1</td>
                            @else
                                <td style="text-align: left">VT2</td>
                            @endif
                            <td style="text-align: left">{{ substr($data->created_at, 0, 10) }}</td>
                            <td style="text-align: left">{{ substr($data->created_at, 10, 6) }}</td>
                            <td style="text-align: left">{{ $data->khunggio }}</td>
                            <td style="text-align: left">{{ $data->ngaydk }}</td>
                            @if ($data->tt == 'dn')
                                <td style="text-align: left">{{ substr($data->updated_at, 10, 6) }}</td>
                                <td style="text-align: left">Đã nhận</td>
                            @else
                                <td></td>
                                <td></td>
                            @endif
                            <td></td>
                        </tr>
                    @else
                        <tr style="font-size: 11px; color: red">

                            <td style="text-align: left">{{ $data->manhanvien }}</td>

                            <td style="text-align: left">{{ $data->tennhanvien }}</td>
                            <td style="text-align: left">{{ $data->tennhom }}</td>
                            @if ($data->ip == '30.30.30.32')
                                <td style="text-align: left">VT1</td>
                            @else
                                <td style="text-align: left">VT2</td>
                            @endif
                            <td style="text-align: left">{{ substr($data->created_at, 0, 10) }}</td>
                            <td style="text-align: left">{{ substr($data->created_at, 10, 6) }}</td>
                            <td style="text-align: left">{{ $data->khunggio }}</td>
                            <td style="text-align: left">{{ $data->ngaydk }}</td>
                            @if ($data->tt == 'dn')
                                <td style="text-align: left">{{ substr($data->updated_at, 10, 6) }}</td>
                                <td style="text-align: left">Đã nhận</td>
                            @else
                                <td></td>
                                <td></td>
                            @endif
                            <td></td>
                        </tr>
                    @endif
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
