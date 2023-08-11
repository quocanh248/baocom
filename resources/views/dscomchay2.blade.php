@extends ('welcome')

@section('content')
    <div class="header-right">
        <label class="title" for="">
            DS đăng ký cơm chay
        </label>
        <label class="title" for="" id="totalCount">
            Tổng: {{count($results)}}
        </label>
        <div class="search-box">
            <input type="text" id="manhanvienInput1" placeholder="Nhập xưởng để tìm kiếm">
            <input type="date" id="manhanvienInput" placeholder="Nhập ngày nhận  để tìm kiếm">
            <button class="search" id="highlightButton">Chọn</button>
        </div>

    </div>
    <div class="container">
<style>
    .fixed_header th,
    .fixed_header td {
    padding-bottom: 15px;
    padding-left: 10px;
    text-align: center;
    min-width: 150px;
    border-bottom: 1px solid #ccc;
}
</style>
       
        <table class="fixed_header" id="bangNhanVien">
            <thead>
                <tr>
                    <th style="text-align: left">Mã</th>
                    <th style="text-align: left">Tên</th>
                    <th style="text-align: left">Nhóm</th>
                    <th style="text-align: left" >Xưởng</th>
                    <th style="text-align: left">Ngày đăng ký</th>
                    <th style="text-align: left">Giờ đăng ký</th>
                    <th style="text-align: left">Khung giờ</th>
                    <th style="text-align: left">Ngày nhận</th>
                    <th style="text-align: left">Giờ nhận</th>
                    <th style="text-align: left">Trạng thái</th>
                    <th style="text-align: left">Máy đăng ký</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $data)
                        @php                        
                            $c=0;
                            
                            for($i=0; $i< count($nvn); $i++){
                                if($nvn[$i] == $data->manhanvien && $ngaydk == $data->ngaydk)
                                {
                                    $c++;
                                    break;
                                }
                            }
                        @endphp
                     @if($c == 0)
                     <tr style="font-size: 15px">
                       
                        <td style="text-align: left">{{ $data->manhanvien }}</td>
                       
                        <td style="text-align: left">{{ $data->tennhanvien }}</td>
                        <td style="text-align: left">{{ $data->tennhom }}</td>
                        @php                                                
                        if($data->ip =="30.30.30.32")
                        {
                            $tenmay = "VT1";
                        } else{
                            $tenmay = "VT2";
                        }
                        @endphp           
                        <td style="text-align: left">{{$tenmay}}</td>
                        <td style="text-align: left">{{ substr($data->created_at, 0, 10 )}}</td>
                        <td style="text-align: left">{{  substr($data->created_at, 10, 6 )}}</td>
                        {{-- @php
                        
                        $k = substr($data->created_at, 14, 2 );
                        $thoiGian = \Carbon\Carbon::parse(substr($data->created_at, 10, 6 ));
                        if($k<30)
                        {
                            $thoiGianLamTron = $thoiGian->minute(0);

                        }else{
                            $thoiGianLamTron = $thoiGian->minute(30);
                        }
                        
                        @endphp
                        <td style="text-align: left">{{  substr($thoiGianLamTron, 10, 6 )}}</td> --}}
                        <td style="text-align: left">{{ $data->khunggio }}</td>
                        <td style="text-align: left">{{ $data->ngaydk }}</td>
                        @php
                          if($data->tt == "dn")  {
                        @endphp
                        <td style="text-align: left">{{ substr($data->updated_at, 10, 6 )}}</td>
                        <td style="text-align: left">Đã nhận</td>                        
                        @php
                          } else{
                        @endphp
                        <td></td>
                        <td></td>
                       
                        @php
                          } 
                        @endphp
                         <td></td>
                    </tr>
                     @else
                     <tr style="font-size: 15px; color: red">
                       
                        <td style="text-align: left">{{ $data->manhanvien }}</td>
                       
                        <td style="text-align: left">{{ $data->tennhanvien }}</td>
                        <td style="text-align: left">{{ $data->tennhom }}</td>
                        @php                                                
                        if($data->ip =="30.30.30.32")
                        {
                            $tenmay = "VT1";
                        } else{
                            $tenmay = "VT2";
                        }
                        @endphp           
                        <td style="text-align: left">{{$tenmay}}</td>
                        <td style="text-align: left">{{ substr($data->created_at, 0, 10 )}}</td>
                        <td style="text-align: left">{{  substr($data->created_at, 10, 6 )}}</td>
                        {{-- @php
                        
                        $k = substr($data->created_at, 14, 2 );
                        $thoiGian = \Carbon\Carbon::parse(substr($data->created_at, 10, 6 ));
                        if($k<30)
                        {
                            $thoiGianLamTron = $thoiGian->minute(0);

                        }else{
                            $thoiGianLamTron = $thoiGian->minute(30);
                        }
                        
                        @endphp
                        <td style="text-align: left">{{  substr($thoiGianLamTron, 10, 6 )}}</td> --}}
                        <td style="text-align: left">{{ $data->khunggio }}</td>
                        <td style="text-align: left">{{ $data->ngaydk }}</td>
                        @php
                          if($data->tt == "dn")  {
                        @endphp
                        <td style="text-align: left">{{ substr($data->updated_at, 10, 6 )}}</td>
                        <td style="text-align: left">Đã nhận</td>                        
                        @php
                          } else{
                        @endphp
                        <td></td>
                        <td></td>
                       
                        @php
                          } 
                        @endphp
                         <td></td>
                    </tr>
                    @endif
                   
                @endforeach

            </tbody>
        </table>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        var input = document.getElementById("manhanvienInput");
        input.addEventListener("input", timKiem);
        var input1 = document.getElementById("manhanvienInput1");
        function timKiem() {
            var filter1 = input.value.toUpperCase();
            var filter2 = input1.value.toUpperCase();
            var filter = filter1.substring(8);            
            var table = document.getElementById("bangNhanVien");
            var tr = table.getElementsByTagName("tr");
            var count = 0; // Biến đếm tổng số dòng tìm thấy

            for (var i = 0; i < tr.length; i++) {
                var td3 = tr[i].getElementsByTagName("td")[3];
                var td = tr[i].getElementsByTagName("td")[7];
                if (td3 && td) {
                    var txtValue = td.textContent || td.innerText;
                    var txtValue3 = td3.textContent || td3.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1 && txtValue3.toUpperCase().indexOf(filter2) > -1) {
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
        var input1 = document.getElementById("manhanvienInput1");
        input1.addEventListener("input", timKiem1);

        function timKiem1() {
            var filter1 = input.value.toUpperCase();
            var filter2 = input1.value.toUpperCase();
            var filter = filter1.substring(8);            
            var table = document.getElementById("bangNhanVien");
            var tr = table.getElementsByTagName("tr");
            var count = 0; // Biến đếm tổng số dòng tìm thấy

            for (var i = 0; i < tr.length; i++) {
                var td3 = tr[i].getElementsByTagName("td")[3];
                var td = tr[i].getElementsByTagName("td")[7];
                if (td3 && td) {
                    var txtValue = td.textContent || td.innerText;
                    var txtValue3 = td3.textContent || td3.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1 && txtValue3.toUpperCase().indexOf(filter2) > -1) {
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
