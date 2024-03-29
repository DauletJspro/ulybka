<!DOCTYPE html>
<html class="bg-black">
<head>
    <meta charset="UTF-8">
    <title>ulybka.kz</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->
    <link href="/admin/auth/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/admin/auth/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="/admin/auth/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <link href="/admin/css/admin.css?v=2" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="/favicon.png?v=4" />
</head>
<body class="bg-black admin-background">
<div class="form-box" id="login-box">
    <div style="text-align: center">
        <a href="/">
            <img class="logo_svg" src="/logo_main.png?v=3" style="max-width: 220px; margin-bottom: 20px" />
        </a>
    </div>
    <div class="header">Забыли пароль</div>
    <form method="post" action="/reset-password">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="body bg-gray">
            <p style="color:red">@if(isset($error)){{$error}}@endif</p>
            <div class="form-group">
                <input required type="text" name="email" value="@if(isset($email)){{$email}}@endif" class="form-control" placeholder="Email"/>
            </div>
        </div>
        <div class="footer">
            <button type="submit" class="btn bg-olive btn-block" style="font-size: 17px">{{Lang::get('app.reset_password')}}</button>
            <div class="form-group" style="text-align: center">
                <div class="col-md-6">
                    <a style="font-weight: bold; text-decoration: underline" href="/login">Войти</a>
                </div>
                <div class="col-md-6">
                    <a style="font-weight: bold; text-decoration: underline" href="/">главная страница</a>
                </div>
                <div style="clear:both"></div>
            </div>
        </div>
    </form>
</div>


</body>
</html>