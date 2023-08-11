@extends ('welcome')

@section('content')
    <div class="header-right">
        <label class="title" for="">
            @php
                $gio = $results[0]->gio; // Giả sử $results[0]->gio chứa giá trị ngày tháng
                
                // Định dạng ngày tháng
                $date = new DateTime($gio);
                $gioFormatted = $date->format('d/m/Y');
            @endphp
            Điểm danh trong ngày {{ substr($gioFormatted, 0, 10) }}
        </label>
        <label class="title" for="">
            <b>Tổng: {{ count($results) }}</b>
        </label>

        <div class="search-box">
            <input type="text" id="manhanvienInput" placeholder="Nhập mã nhân viên">
            @php
            if(count(Session::get('q' )) > 0)
            {
                $q = Session::get('q' );  
                if($q[0]->maquyen==1 || $q[0]->maquyen==2){           
                @endphp
    
                <a class="search" style="text-decoration: none; padding: 12px" href="/diemdanh">Làm mới</a>
                @php
                }
            }

            @endphp
            <button class="search" id="highlightButton">Chọn</button>
        </div>

    </div>
    <div class="container">

        <table class="fixed_header" id="bangNhanVien">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Nhóm</th>
                    <th>Giờ</th>
                    <th>Xưởng</th>

                </tr>
            </thead>
            <tbody>
                @php
                    $c = 1;
                @endphp
                @foreach ($results as $hit)
                    <tr>
                        <td>{{ $c }}</td>
                        <td>{{ $hit->manhanvien }}</td>
                        <td>{{ $hit->tennhanvien }}</td>
                        <td>{{ $hit->tennhom }}</td>
                        <td>{{ substr($hit->gio, 10, 6) }}</td>
                        <td>{{ $hit->xuong }}</td>

                    </tr>
                    @php
                        $c++;
                    @endphp
                @endforeach

            </tbody>
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
