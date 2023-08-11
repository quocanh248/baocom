@extends ('welcome')

@section('content')
    <div class="header-right">
        <label class="title" for="">
            Thống kê tháng: {{substr($thang, 5, 2). "-". substr($thang, 0, 4) }}
        </label>
        <label class="title" for="" id="totalCount">

        </label>
        <div class="search-box">
            <input type="text" id="manhanvienInput" name="ngay" placeholder="Nhập ngày để tìm kiếm" >
            <form action="/tkthang" method="POST">
                @csrf
                <input type="month" id="" name="ngay" value="{{$thang}}" placeholder="Chọn tháng để thống kê" >
                <button class="search" type="submit" id="highlightButton">Thống kê</button>
            </form>
        </div>

    </div>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 18px;
            text-align: center;
            top: 0;
           
        }

        th {
            text-align: left;
            height: 35px;
            border: 1px solid #ccc;
            text-align: center;


        }

        td {
            text-align: left;
            padding: 6px;
            height: 25px;
            border: 1px solid #ccc;
            text-align: center;


        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }

        th {
            background-color: #04AA6D;
            color: white;
            text-align: center;
        }
        .container {
            position: fixed;
            top: 0;
            left: 0;
            width: 98%;
            margin-top: 125px;
            margin-left: 20px;
            margin-right: 20px;
            padding: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            height: 85%;
            background-color: #fff;
            overflow-y: auto;
            margin-bottom: 0px;
        }
        .fixed_header1 thead {
            position: sticky;
            top: 0;
            background-color: #ffffff;
        }

        .container {
            padding-bottom: 0;
            margin-bottom: 0;
        }

        .container table {
            margin: 0;
            width: 100%;
        }

        .fixed_header1 tbody {
            overflow-y: scroll;
           
        }
    </style>
    <div class="container">
        <br>
        <table class="fixed_header1" id="bangNhanVien">
            <thead>
                <tr>
                    <th rowspan="2" style="background-color: #ffa500">Ngày</th>
                    <th colspan="5">VT1</th>
                    <th colspan="5" style="background-color: #ffa500">VT2</th>
                    <th rowspan="2">Chấm công</th>
                    <th rowspan="2" style="background-color: #ffa500">HS báo</th>
                    <th rowspan="2">Lệch</th>
                </tr>
                <tr>
                    <th>Báo mặn</th>
                    <th>Nhận mặn</th>
                    <th>Báo chay</th>
                    <th>Nhận chay</th>
                    <th>ĐK chay</th>
                    <th style="background-color: #ffa500">Báo mặn</th>
                    <th style="background-color: #ffa500">Nhận mặn</th>
                    <th style="background-color: #ffa500">Báo chay</th>
                    <th style="background-color: #ffa500">Nhận chay</th>
                    <th style="background-color: #ffa500">ĐK chay</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $date => $values)              
                <tr style="color: #2f2929">
                    <td>{{ $date }}</td>
                    <td style="color: red">{{$values['man1']}}</td>
                    <td>{{$values['commandst'] - $values['total_commands']}}</td>
                    <td style="color: red">{{$values['chay1']}}</td>
                    <td>{{$values['total_comchayds1']}}</td>
                    <td>{{$values['dkchay1']}}</td>
                    <td style="color: red">{{$values['man2']}}</td>
                    <td>{{$values['total_commands']}}</td>
                    <td style="color: red">{{$values['chay2']}}</td>
                    <td>{{$values['total_comchayds2']}}</td>
                    <td>{{$values['dkchay2']}}</td>
                    <td>{{$values['diemdanh']}}</td>
                    <td style="color: red; "><b> {{$values['man1']+ $values['man2'] + $values['chay1']+ $values['chay2']}} </b></td>                   
                    <td style="color: rgb(242, 10, 10)"><b>{{$values['diemdanh'] - ($values['man1']+ $values['man2'] + $values['chay1']+ $values['chay2'])}}</b></td>
                   
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        // Lấy ngày hiện tại
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
