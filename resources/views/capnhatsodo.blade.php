@extends ('welcome')

@section('content')
    <div class="header-right">
        <label class="title" for="">
          Thêm sơ đồ

        </label>

        <div class="search-box">
            {{-- <input type="text" id="manhanvienInput" placeholder="Nhập mã nhân viên">
            <button class="search-mini" style="margin-right: 50px;" id="taotaikhoan">Tạo mới +</button> --}}
        </div>

    </div>
    <style>
        .fixed_header1 {
            border-collapse: collapse;
            width: 100%;
            font-size: 18px;
            text-align: center;
            top: 0;

        }

        .fixed_header1 th {
            text-align: left;
            height: 35px;
            border: 1px solid #ccc;
            text-align: center;


        }

        .fixed_header1 td {
            text-align: left;
            padding: 6px;
            height: 25px;
            border: 1px solid #ccc;
            text-align: center;


        }

        .fixed_header1 tr:nth-child(even) {
            background-color: #f2f2f2
        }

        .fixed_header1 th {
            background-color: #04AA6D;
            color: white;
            text-align: center;
        }

        .fixed_header1 thead {
            position: sticky;
            top: 0;
            background-color: #ffffff;
        }

        .fixed_header1 tbody {
            overflow-y: scroll;

        }

        .checkbox-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            /* Số lượng cột tại đây (3 cột trong ví dụ) */
            gap: 10px;
            /* Khoảng cách giữa các checkbox */
        }

        label {
            margin-left: 30px;
            margin-right: 30px;
        }

        /* Tạo kiểu dáng cho checkbox tùy chỉnh */
        .custom-checkbox {
            display: inline-block;
            width: 25px;
            height: 25px;
            border: 2px solid #ccc;
            border-radius: 3px;
            background-color: #fff;
            cursor: pointer;
            margin-right: 15px;
        }

        /* Tạo kiểu dáng khi checkbox được chọn */
        .custom-checkbox.checked {
            background-color: #00a0e9;
            border-color: #00a0e9;
        }

        /* Tạo kiểu dáng cho tick */
        .custom-checkbox.checked::before {
            content: '\2713';
            display: block;
            text-align: center;
            color: #fff;
            font-size: 14px;
            line-height: 16px;
        }

        /* Thêm hiệu ứng khi hover */
        .custom-checkbox:hover {
            border-color: #00a0e9;
        }

        /* Thêm hiệu ứng khi focus */
        .custom-checkbox:focus {
            outline: none;
            box-shadow: 0 0 5px #00a0e9;
        }
    </style>

    <div class="container">
        <form action="/capnhatsodochucdanh" method="POST">
            @csrf
            <div class="form-group">

                <div class="row">
                    <div class="col-6">
                        <label for="input1">Nhập tên nhân viên:</label>
                        <datalist id="cities">
                            @foreach ($dsnhansu as $data)
                                <option value="{{ $data->tennhanvien }}"></option>
                            @endforeach

                        </datalist>
                        <input type="text" name="manhanvien" id="manhanvien" class="form-control" autocomplete="off"
                            required list="cities">

                    </div>
                    <div class="col-6">
                        <label for="input1">Nhập chức danh</label>
                        <datalist id="cities1">
                            @foreach ($dschucdanh as $data)
                                <option value="{{ $data->machucdanh }}">{{ $data->tenchucdanh }}</option>
                            @endforeach

                        </datalist>
                        <input type="text" name="chucdanh1" id="chucdanh1" class="form-control" autocomplete="off"
                            required list="cities1">

                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="input1">Chức danh quản lý:</label>
                        <datalist id="cities2">
                            @foreach ($dschucdanh as $data)
                                <option value="{{ $data->machucdanh }}">{{ $data->tenchucdanh }}</option>
                            @endforeach

                        </datalist>
                        <input type="text" name="chucdanh2" id="chucdanh2" class="form-control" autocomplete="off"
                             list="cities2">

                    </div>
                    <div class="col-6">
                        <label for="input1">Mô tả</label>
                       
                        <input type="text" name="mota" id="mota" class="form-control" autocomplete="off"
                            required list="">

                    </div>

                </div>
                <div class="row">
                    <div class="col-10">
                    </div>
                    <div class="col-2">
                        <button class="search" id="taotaikhoan12" style="margin-left: 80px">Tạo </button>
                    </div>
                </div>

            </div>
        </form>

    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@endsection
