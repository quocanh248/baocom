@extends ('welcome')

@section('content')
<style>
    .search {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 18px;
    color: #fff;
    background-color: #1565c0;
    border: none;
    width: 80px;
    height: 40px;
    border-radius: 4px;
    margin-right: 30px;
    cursor: pointer;
}
</style>
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
            <form action="/timmodel1" method="POST">
                @csrf
                <input type="date" name="date" id="" placeholder="Nhập lot" required>
                <input type="text" name="lot" id="manhanvienInput" placeholder="Nhập lot" >
                <button type="submit" class="search" id="">Tìm</button>
            </form>
            <button type="" class="search" id="highlightButton">Chọn</button>
        </div>

    </div>
    <div class="container">

        <table class="fixed_header" id="bangNhanVien">
            <thead>
                <tr>
                    <th>Model</th>
                    <th>Lot</th>
                    <th>ID</th>
                    <th>status</th>
                    <th>Thời gian</th>                  
                </tr>
            </thead>
            <tbody>
                @php
               if(isset($data)){
                @endphp
                @foreach ($data as $item)
                <tr>
                    @php
                    $string = $item["id"];
                    $parts = explode("_", $string);
                    if (isset($parts[1])) {
                        $substring = substr($parts[2], 10, 4);
                        
                       
                    }
                    @endphp
                    <td>{{$item["definition"]}}</td>
                    <td>{{$item["lot"]}}</td>
                    <td>{{ $substring }}</td>                   
                    <td>{{$item["status"]}}</td>                   
                    <td>{{$item["updateAt"]}}</td>
                  
                    
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
