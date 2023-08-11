@extends ('welcome')

@section('content')
    <div class="header-right">
        <label class="title" for="">
            DS đăng ký cơm mặn
        </label>
        <label class="title" for="" id="totalCount">
            Tổng: {{count($results)}}
        </label>
        <div class="search-box">
            <input type="text" id="manhanvienInput" placeholder="Nhập ngày để tìm kiếm">
            <button class="search" id="highlightButton">Chọn</button>
        </div>

    </div>
    <div class="container">

        <table class="fixed_header" id="bangNhanVien">
            <thead>
                <tr>
                    <th>Mã</th>
                    <th>Tên</th>
                    <th>Nhóm</th>
                    <th >Xưởng</th>
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
                        if($data->ip =="30.30.30.42" || $data->ip =="30.30.30.43" || $data->ip =="30.30.30.44" || $data->ip =="30.30.30.45")
                        {
                            $tenmay = "VT2";
                        } else{
                            $tenmay = "VT1";
                        }
                        @endphp    
                        <td style="text-align: left">{{ $tenmay }}</td>
                        <td style="text-align: left">{{ $data->created_at}}</td>
                        <td >{{  substr($data->updated_at, 10, 6 )}}</td>
                        @php
                        
                        $k = substr($data->updated_at, 14, 2 );
                        $thoiGian = \Carbon\Carbon::parse(substr($data->updated_at, 10, 6 ));
                        if($k<30)
                        {
                            $thoiGianLamTron = $thoiGian->minute(0);

                        }else{
                            $thoiGianLamTron = $thoiGian->minute(30);
                        }
                        
                        @endphp                   
                       
                       <td >{{ substr($thoiGianLamTron, 10, 6 )}}</td>
                         <td></td>
                    </tr>
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
            var count = 0; // Biến đếm tổng số dòng tìm thấy

            for (var i = 0; i < tr.length; i++) {
                var td = tr[i].getElementsByTagName("td")[7];
                if (td) {
                    var txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                        count++; // Tăng giá trị biến đếm nếu tìm thấy dòng phù hợp
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }

            var totalCountElement = document.getElementById("totalCount");
            totalCountElement.textContent = "Tổng: " + count;
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
