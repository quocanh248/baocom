
<!DOCTYPE html>
<html>

<head>
    {{-- <link rel="stylesheet" type="text/css" href="style.css"> --}}
    <link rel="stylesheet" href="/dist/css/admincss.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
    @php

    @endphp
    <div class="admin-menu">
        <ul>
            <li>
                <a href="">Nhân sự</a>
                <ul class="submenu">
                    <li><a href="/dsnhansu">DS nhân sự</a></li>
                    <!-- <li><a href="/dsdiemdanh">Điểm danh</a></li> -->
                    <li><a href="/dslichlamviec">Lịch làm việc</a></li>
                    @php
                    if(count(Session::get('q' )) > 0)
                    {
                    $q = Session::get('q' );  
                   
                    if($q[0]->maquyen==1 || $q[0]->maquyen==2){           
                    @endphp
                    <li><a href="/viewcaptaikhoan">Quản lý tài khoản</a></li>
                    @php
                    }
                    @endphp
                    
                    @if($q[0]->maquyen == 1 || $q[0]->maquyen == 30)
                    <li><a href="/sodo">Cập nhật sơ đồ</a></li> 
                    @endif
                    @php
                    }
                    @endphp
                    <li><a href="/xemsodo">xem sơ đồ</a></li> 
                    {{-- <li><a href="/viewcaptaikhoan">DS tài khoản</a></li> --}}
                </ul>
            </li>
            
            @if(count(Session::get('q' )) > 0)
           
            @php $q = Session::get('q' ); @endphp  
            
            @foreach($q as $data)
            @if($data->maquyen==1 || $data->maquyen==2) 
                   
            <li>
                <a href="">Báo cơm</a>
                <ul class="submenu">
                    <li><a href="/dscomchay">DS ĐK cơm chay</a></li>                   
                    <li><a href="/dscomman">DS ĐK cơm mặn</a></li>
                    <li><a href="/tkcomtheongay">TK cơm ngày</a></li>
                    <li><a href="/thongkecomthang">TK cơm tháng</a></li>
                    <li><a href="/dkcomchay">Đăng ký cơm chay</a></li>
                    <li><a href="/ktrcomchay">Kiểm tra cơm chay</a></li>
                    <li><a href="/convert">Đăng ký cơm mặn</a></li>
                    
                </ul>
            </li>
            @break   
            @endif
            @endforeach
            @endif
            <li>
                <a href="">Công việc</a>
                <ul class="submenu">
                    @if(count(Session::get('q' )) > 0)           
                    @php $q = Session::get('q' ); @endphp 
                    
                    @foreach($q as $data)
                    @if($data->maquyen==1 || $data->maquyen==10 || $data->maquyen==20)                         
                    <li><a href="/viewpccv">DS các bộ phận</a></li>    
                    @break   
                    @endif
                    @endforeach
                    @endif                    
                    <li><a href="/viewpccvcc">Xem cv cá nhân</a></li>     
                    {{-- <li><a href="/xemlscvcc">Lịch sử cv cá nhân</a></li>               --}}
                    
                    
                </ul>
            </li>
            @php
            $userid = Session::get('userid' );
            $username = Session::get('username' );
                  if(!empty($userid)) {
            @endphp


            <li class="login-button">
                <a href="">User: {{$username}}</a>
                <ul class="submenu">
                <li class="">
                <a onclick="dangxuat()">Đăng xuất</a>
                </li>
                </ul>
            </li>
            @php
                  }
            @endphp
              </ul>

            </div>
            @yield('content')
           
            <script type="text/javascript">
                function dangxuat() {
                    if (confirm('Bạn có chắc muốn đăng xuất?')) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        sessionStorage.clear();
                        localStorage.clear();
                        $.ajax({
                            processData: false,
                            contentType: false,
                            type: 'GET',
                            dataType: 'JSON',
                            url: '/dangxuat',
                            success: function(res) {
                                //window.location.href = window.location.href;
                                sessionStorage.clear();
                                localStorage.clear();
                            }
                        });
                    }
                    window.location.reload();
                }
            </script>
        </body>
        
        </html>