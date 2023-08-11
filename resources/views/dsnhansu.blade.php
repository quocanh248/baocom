@extends ('default1')

@section('content')
    <div class="header">
        <div class="header-cont">
            <div class="header-cont-title">
                <span>
                    @php
                        $gio = $dsnhansu[0]->gio;               
                        $date = new DateTime($gio);
                        $gioFormatted = $date->format('d/m/Y');
                    @endphp
                    Ngày {{ substr($gioFormatted, 0, 10) }} --  NS: <b>{{count($dsnhansu )}}</b>, DD: <b>{{count($dd )}}</b>
                </span>              
            </div>
            <div class="header-cont-content">
            </div>
            <div class="search-box">
                <input type="search" id="manhanvienInput" placeholder="Nhập mã nhân viên">           
                @php
                if(count(Session::get('q' )) > 0)
                {
                $q = Session::get('q' );  
                if($q[0]->maquyen==1 || $q[0]->maquyen==2){           
                @endphp
                <button class="search" style="text-decoration: none; padding: 12px" href="/laythongtinnhansu" id="laythongtinnhansu">Nhân sự</button> 
                <button class="search" style="text-decoration: none; padding: 12px" href="/diemdanh" id="diemdanh">Điểm danh</button> 
                @php
                }}
                @endphp         
            </div>

        </div>
    </div>
    <div class="container-content">
        <table class="table-mom" id="bangNhanVien">
            <thead>
                <tr>
                    <th >Mã</th>
                    <th >Tag</th>
                    <th >Tên</th>
                    <th >Nhóm</th>
                    <th >Giờ</th>
                    <th >Xưởng</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dsnhansu as $data)
                    <tr>
                        <td >{{ $data->manhanvien }}</td>
                        <td ><span class="tag tag-success">{{ $data->tag }}</span></td>
                        <td >{{ $data->tennhanvien }}</td>
                        <td >{{ $data->tennhom }}</td>                       
                        <td>{{ substr($data->gio, 10, 6) }}</td>
                        <td>{{ $data->xuong }}</td>
                        <td></td>
                    </tr>
                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <td>Tổng {{ count($dsnhansu) }}</td>
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
        $("#laythongtinnhansu").click(function() {

            window.location.href = "/laythongtinnhansu";
        });
        $("#diemdanh").click(function() {

            window.location.href = "/diemdanh";
        });
    </script>
@endsection
