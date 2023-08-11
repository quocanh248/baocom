<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }


        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>

</head>

<body>
    <form method="POST" action="/themnhansu">
        @csrf
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tag</th>
                    <th>Name</th>
                    <th>Bộ phận</th>
                   
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $hit)
                    
                    <tr>
                        <td><input style="background-color: transparent; border: none; outline: none;"
                            type="text" name="manhanvien[]" value="{{ $hit['_id'] }}"></td>
                        <td ><input style="background-color: transparent; border: none; outline: none;"
                            type="text" name="tag[]" value="{{ isset($hit['_source']['tag']) ? $hit['_source']['tag'] : '' }}"></td>
                        <td ><input style="background-color: transparent; border: none; outline: none;"
                            type="text" name="name[]" value="{{ isset($hit['_source']['name']) ? $hit['_source']['name'] : '' }}"></td>
                        <td ><input style="background-color: transparent; border: none; outline: none;"
                            type="text" name="tennhom[]" value="{{ isset($hit['_source']['workgroup']) ? $hit['_source']['workgroup'] : '' }}"></td>                        
                    </tr>
                @endforeach


            </tbody>
        </table>
        <button type="submit" class="btn btn-sm btn-success">Thêm vào CSDL</button>
    </form>
</body>

</html>
