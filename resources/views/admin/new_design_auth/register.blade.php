@extends('design_index.layout.layout')

@section('meta-tags')

    <title>ulybka.kz</title>
    <meta name="description"
          content="«ulybka.kz»"/>
    <meta name="keywords" content="ulybka.kz"/>

@endsection

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>


@section('content')
    <div class="mt-search-popup">
        <div class="mt-holder">
            <a href="#" class="search-close"><span></span><span></span></a>
            <div class="mt-frame">
                <form action="#">
                    <input type="text" placeholder="Search...">
                    <span class="icon-microphone"></span>
                    <button class="icon-magnifier" type="submit"></button>
                </form>
            </div>
        </div>
    </div>
    <main id="mt-main">
        <section class="mt-contact-banner"
                 {{--                 style="background-image: url('/new_design/images/sign_in.png'); background-size: contain; background-repeat: no-repeat;"--}}
                 style="background-color: lightgrey" ;
        >
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h1>Регистрация</h1>
                        <nav class="breadcrumbs">
                            <ul class="list-unstyled">
{{--                                <li><a href="index.html">home <i class="fa fa-angle-right"></i></a></li>--}}
{{--                                <li>register</li>--}}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <br>
        <section class="mt-detail-sec toppadding-zero">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-sm-push-1">
                        <div class="holder" style="margin: 0;">
                            <div class="mt-side-widget">
                                <div style="">
                                    <header class="text-center">
                                        <h1>Регистрация</h1>
                                        <p>Еще нету аккаунта?</p>
                                    </header>
                                    @if(isset($error))
                                        <div class="alert alert-danger">
                                            <p style="color:red">{{$error}}</p>
                                        </div>
                                    @endif
                                    <form method="post" action="/register">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6 form-group">
                                                <input required type="text" name="name" value="{{$row->name}}"
                                                       class="form-control input" placeholder="Имя"/>
                                                <input type="text" name="last_name" value="{{$row->last_name}}"
                                                       class="form-control input" placeholder="Фамилия"/>
                                                <input type="text" name="login" value="{{$row->login}}"
                                                       class="form-control input" placeholder="Логин"/>
                                                <div>
                                                    <select required name="recommend_user_id"
                                                            data-placeholder="Выберите пригласителя"
                                                            class="form-control selectpicker input"
                                                            data-live-search="true">
                                                        <option value="">Выберите пригласителя</option>
                                                        @foreach($recommend_row as $item)
                                                            <option @if($row->recommend_user_id == $item->user_id || (isset($_GET['id']) && $_GET['id'] == $item->user_id) ) {{'selected'}} @endif value="{{$item->user_id}}">
                                                                {{sprintf('%s (%s)',$item['login'], $item['last_name'])}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 form-group">
                                                <input required type="email" name="email" class="form-control input"
                                                       value="{{$row->email}}" placeholder="Email"/>
                                                <input required type="tel" name="phone" class="form-control input"
                                                       value="{{$row->phone}}" placeholder="Номер телефона"/>
                                                <input required type="password" value="{{$row->password}}"
                                                       name="password" class="form-control input"
                                                       placeholder="Пароль"/>
                                                <input required type="password" value="{{$row->confirm_password}}"
                                                       name="confirm_password" class="form-control input"
                                                       placeholder="Повторите пароль"/>                                                
                                            </div>                                            
                                        </div>
                                        <br>
                                        <button type="submit" class="btn btn-danger btn-type1">Зарегистрироваться
                                        </button>
                                    </form>
                                    <header>
                                        <div class="form-group text-center already-registered-div">
                                            Если Вы уже зарегистрированы на нашем сайте, нажмите <a
                                                    style="font-weight: bold; text-decoration: underline; color: black;"
                                                    href="/login">«Войти»</a>
                                        </div>
                                        {{-- <div class="form-group main-page-div" style="text-align: center">
                                            <a style="font-weight: bold; text-decoration: underline; color: black;"
                                               href="/">Главная страница</a>
                                        </div> --}}
                                    </header>
                                    {{-- <ul class="mt-socialicons">
                                        <li class="mt-facebook"><a href="#"><i class="fa fa-facebook-f"></i></a></li>
                                        <li style="background-color: lightgreen;"><a href="#"><i
                                                        class="fa fa-whatsapp"></i></a></li>
                                        <li class="mt-youtube"><a href="#"><i class="fa fa-youtube-play"></i></a></li>
                                    </ul> --}}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection