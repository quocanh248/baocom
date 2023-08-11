@extends ('welcome')

@section('content')
    <div class="header-right">
        <label class="title" for="">

            Tìm sợi
        </label>
        <label class="title" for="">
            @php
            if(isset($data)){
                @endphp
                
                Tổng: {{count($data)}}
                @php
            }
                @endphp
        </label>
        <div class="search-box">
            <form action="/timlot" method="POST">
                @csrf
                <input type="date" name="date" id="" placeholder="Nhập lot" required>
                <input type="text" name="lot" id="manhanvienInput" placeholder="Nhập lot" >
                <button type="submit" class="search" id="">Chọn</button>
            </form>
        </div>

    </div>
    <div class="container">

        <table class="fixed_header" id="bangNhanVien">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Công đoạn</th>
                    <th>Thời gian</th>
                    <th>Mã nhân viên</th>
                    <th>Họ tên</th>
                    <th>Model</th>
                    <th>Lot</th>
                </tr>
            </thead>
            <tbody>
                @php
               if(isset($data)){
                @endphp
                @foreach ($data as $item)
                <tr>
                    @php
                    $string = $item["id1"];
                    $parts = explode("_", $string);
                    if (isset($parts[1])) {
                        $substring = substr($parts[2], 10, 4);
                        
                       
                    }
                    @endphp
                    <td>{{ $substring }}</td>                   
                    <td>{{$item["workDirective"]}}</td>
                    <td>{{$item["startTimestamp"]}}</td>
                    <td>{{$item["id"]}}</td>
                    <td>{{$item["name"]}}</td>
                    <td>{{$item["definition"]}}</td>
                    <td>{{$item["lot"]}}</td>
                    
                </tr>
                    
                @endforeach
                @php
            }
                @endphp

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
                var td = tr[i].getElementsByTagName("td")[5];
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
