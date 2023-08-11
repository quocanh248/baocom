<!DOCTYPE html>
<html>
<head>
	<title>Menu</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Font: Source Sans Pro -->   
    <!-- Ionicons -->

    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/color.css">
	<style>
		nav {
			background-color: #5F9EA0;
			overflow: hidden;
		}

		nav ul {
			list-style-type: none;
			margin: 0;
			padding: 0;
			overflow: hidden;
		}

		nav li {
			float: left;
		}

		nav li a {
			display: block;
			color: white;
			text-align: center;
			padding: 14px 16px;
			text-decoration: none;
		}

		nav li a:hover {
			background-color: #ccc;
			color: #000;
		}
		.login {
			float: right;
			
			text-align: center;
			text-decoration: none;
			color: white;
			
		}
	</style>
</head>
<body>
	
	@yield('content')
	
</body>
</html>
