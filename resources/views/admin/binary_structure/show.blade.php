<?php
/** @var \App\Models\Users $user_id */
/** @var \App\Models\BinaryStructure $structure_id */

$user = new \App\Models\Users();

$structure = \App\Models\BinaryStructure::where(['id' => $structure_id])->first();
$users = \App\Models\BinaryStructure::get_binary_tree_by_user($user_id, $structure, $number);

$packet = \App\Models\Packet::where(['packet_id' => $structure->id])->first();
$packet_price = $packet->packet_price * \App\Models\Currency::usdToKzt();
$is_show_last_4 = true;
$padding_left = 0;
$padding_left_2 = 0;
if ($structure_id == 2) {
    $is_show_last_4 = false;
    $padding_left = 150;
    $padding_left_2 = 100;
}
if ($structure_id == 4) {
    $padding_left = 150;
    $padding_left_2 = 100;
    $is_show_last_4 = false;
}

?>
@extends('admin.layout.layout')


@section('content')
    <div class="row card" style="margin-top: 20px;background-color: {{$structure->css_color}}">
        <div class="header search_header col-12"
             style="background-color: #fffaf1;height:auto;border-radius: 4px; border: 1px solid lightgrey;">
            <div class="box-body row ">
                <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12">
                    <label>Структура</label>
                    <select name="structure_id" id="structure_id" class="form-control">
                        <option {{$structure_id == 1 ? 'selected' : ''}} value="1">Первый стол</option>
                        <option {{$structure_id == 2 ? 'selected' : ''}} value="2">Второй стол</option>
                        <option {{$structure_id == 3 ? 'selected' : ''}} value="3">Третий стол</option>
                        <option {{$structure_id == 4 ? 'selected' : ''}} value="4">Четвертый стол</option>
                        <option {{$structure_id == 5 ? 'selected' : ''}} value="5">Пятый стол</option>
                    </select>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2">
                    <label>Номер стола</label>
                    <select name="number_id" id="number_id" class="form-control">
                        <option {{$number == 1 ? 'selected' : ''}} value="1">1</option>
                        <option {{$number == 2 ? 'selected' : ''}} value="2">2</option>
                        <option {{$number == 3 ? 'selected' : ''}} value="3">3</option>
                        <option {{$number == 4 ? 'selected' : ''}} value="4">4</option>
                        <option {{$number == 5 ? 'selected' : ''}} value="5">5</option>
                        <option {{$number == 6 ? 'selected' : ''}} value="5">6</option>
                        <option {{$number == 7 ? 'selected' : ''}} value="5">7</option>
                        <option {{$number == 8 ? 'selected' : ''}} value="5">8</option>
                    </select>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 search_form">
                    <label>Поиск по логину</label>
                    <form method="POST" action="{{route('binary_structure.get_by_user_id')}}">
                        <div class="col-xl-8 col-lg-8 col-md-11 col-sm-9 col-xs-9 search_field"
                             style="padding: 0 !important;">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input name="login" value="{{ $row->email }}" type="text" class="form-control"
                                   placeholder="Введите">
                            <input type="hidden" name="structure_id" value="{{$structure_id ?: null}}">
                            <input type="hidden" name="number" value="{{$number ?: null}}">
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-1 col-sm-1 col-xs-1  search_button">
                            <button class="btn btn-success">Найти</button>
                        </div>
                    </form>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 button_form">
                    <div class="col-md-5 col-sm-5 col-xs-5 button_1_div">
                        <label class="label_button_1" for="button1" style="color: transparent;">hola</label>
                        <button id="button1" class="btn btn-warning">Купить место (10000 тг)</button>
                    </div>
                    <div class="col-xl-1col-lg-1 hidden-md hidden-sm hidden-xs"></div>
                    <div class=" col-md-5 col-sm-5 col-xs-5  button_2_div">
                        <label class="label_button_2" for="button2" style="color: transparent;">hola</label>
                        <button id="button2" class="btn btn-success" onclick="toPacketShop()">Следующее место
                        </button>
                    </div>
                </div>
{{--                <div class=" col-md-5 col-sm-5 col-xs-5">--}}
{{--                    <a href="{{route('binary_structure.replace_form')}}" style="margin-top: 10px;"--}}
{{--                       class="btn btn-success">--}}
{{--                        Переместить пользователя--}}
{{--                    </a>--}}
{{--                </div>--}}
            </div>
        </div>
        <h1 style="float: left;padding-left: 2rem;padding-top: 1rem;">
            {{$structure->name_ru}}. <span style="font-size: 80%;">Номер стола: {{$number}}</span>
        </h1>
        {{--        <h3 style="float:left; padding-top: 6rem;padding-left: -3rem;"></h3>--}}
        <div class="col-12 tree" style="margin-top:100px;height: auto;">
            <ul>
                <li class="tree_li" style="padding-left: 120px;">
                    <a href="#">
                        <div class="row" id="first_line">
                            <div class="col-md-12 text-center">
                                <div class="thumbnail">
                                    <img src="{{asset(isset($users[0]) && $users[0]->avatar ? $users[0]->avatar : '/media/default.png')}}"
                                         alt="">
                                    <div class="caption text-center">
                                        <br>
                                        <span>{{isset($users[0]) ? $users[0]->login: 'Не указано' }}</span>
                                        <br>
                                    </div>
                                    <div class="text-center">
                                        <div class="col-md-12 buy_button"
                                             style="background-color: #f39c12; padding: 5px;">
                                            <button onclick="toPacketShop()"
                                                    style="background-color:#f39c12; border: 0;">
                                                @if(!isset($users[0]))
                                                    Купить место <span
                                                            class="visible-lg visible-xl visible-md hidden-sm hidden-xs"></span>
                                                @else
                                                    Куплено
                                                @endif
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </a>
                    <ul>
                        <li>
                            <a href="#">
                                <div class="row" id="first_line">
                                    <div class="col-md-12 text-center">
                                        <div class="thumbnail">
                                            <img src="{{asset(isset($users[1]) && $users[1]->avatar ? $users[1]->avatar : '/media/default.png')}}"
                                                 alt="">
                                            <div class="caption text-center">
                                                <br>
                                                <span>{{isset($users[1]) ? $users[1]->login: 'Не указано' }}</span>
                                                <br>
                                            </div>
                                            <div class="text-center">
                                                <div class="col-md-12 buy_button"
                                                     style="background-color: #f39c12; padding: 5px;">
                                                    <button onclick="toPacketShop()"
                                                            style="background-color:#f39c12; border: 0;">
                                                        @if(!isset($users[1]))
                                                            Купить место <span
                                                                    class="visible-lg visible-xl visible-md hidden-sm hidden-xs"></span>
                                                        @else
                                                            Куплено
                                                        @endif
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </a>
                            <ul>
                                @if($is_show_last_4)
                                    <li>
                                        <a href="#">
                                            <div class="row" id="first_line">
                                                <div class="col-md-12 text-center">
                                                    <div class="thumbnail">
                                                        <img src="{{asset(isset($users[3]) && $users[3]->avatar ? $users[3]->avatar : '/media/default.png')}}"
                                                             alt="">
                                                        <div class="caption text-center">
                                                            <br>
                                                            <span>{{isset($users[3]) ? $users[3]->login: 'Не указано' }}</span>
                                                            <br>
                                                        </div>
                                                        <div class="text-center">
                                                            <div class="col-md-12 buy_button"
                                                                 style="background-color: #f39c12; padding: 5px;">
                                                                <button onclick="toPacketShop()"
                                                                        style="background-color:#f39c12; border: 0;">
                                                                    @if(!isset($users[3]))
                                                                        Купить место <span
                                                                                class="visible-lg visible-xl visible-md hidden-sm hidden-xs"></span>
                                                                    @else
                                                                        Куплено
                                                                    @endif
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="row" id="first_line">
                                                <div class="col-md-12 text-center">
                                                    <div class="thumbnail">
                                                        <img src="{{asset(isset($users[4]) && $users[4]->avatar ? $users[4]->avatar : '/media/default.png')}}"
                                                             alt="">
                                                        <div class="caption text-center">
                                                            <br>
                                                            <span>{{isset($users[4]) ? $users[4]->login: 'Не указано' }}</span>
                                                            <br>
                                                        </div>
                                                        <div class="text-center">
                                                            <div class="col-md-12 buy_button"
                                                                 style="background-color: #f39c12; padding: 5px;">
                                                                <button onclick="toPacketShop()"
                                                                        style="background-color:#f39c12; border: 0;">
                                                                    @if(!isset($users[4]))
                                                                        Купить место <span
                                                                                class="visible-lg visible-xl visible-md hidden-sm hidden-xs"></span>
                                                                    @else
                                                                        Куплено
                                                                    @endif
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                        <li>
                            <a href="#">
                                <div class="row" id="first_line">
                                    <div class="col-md-12 text-center">
                                        <div class="thumbnail">
                                            <img src="{{asset(isset($users[2]) && $users[2]->avatar ? $users[2]->avatar : '/media/default.png')}}"
                                                 alt="">
                                            <div class="caption text-center">
                                                <br>
                                                <span>{{isset($users[2]) ? $users[2]->login: 'Не указано' }}</span>
                                                <br>
                                            </div>
                                            <div class="text-center">
                                                <div class="col-md-12 buy_button"
                                                     style="background-color: #f39c12; padding: 5px;">
                                                    <button onclick="toPacketShop()"
                                                            style="background-color:#f39c12; border: 0;">
                                                        @if(!isset($users[2]))
                                                            Купить место <span
                                                                    class="visible-lg visible-xl visible-md hidden-sm hidden-xs"></span>
                                                        @else
                                                            Куплено
                                                        @endif
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </a>
                            <ul>
                                @if($is_show_last_4)
                                    <li>
                                        <a href="#">
                                            <div class="row" id="first_line">
                                                <div class="col-md-12 text-center">
                                                    <div class="thumbnail">
                                                        <img src="{{asset(isset($users[5]) && $users[5]->avatar ? $users[5]->avatar : '/media/default.png')}}"
                                                             alt="">
                                                        <div class="caption text-center">
                                                            <br>
                                                            <span>{{isset($users[5]) ? $users[5]->login: 'Не указано' }}</span>
                                                            <br>
                                                        </div>
                                                        <div class="text-center">
                                                            <div class="col-md-12 buy_button"
                                                                 style="background-color: #f39c12; padding: 5px;">
                                                                <button onclick="toPacketShop()"
                                                                        style="background-color:#f39c12; border: 0;">
                                                                    @if(!isset($users[5]))
                                                                        Купить место <span
                                                                                class="visible-lg visible-xl visible-md hidden-sm hidden-xs"></span>
                                                                    @else
                                                                        Куплено
                                                                    @endif
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="row" id="first_line">
                                                <div class="col-md-12 text-center">
                                                    <div class="thumbnail">
                                                        <img src="{{asset(isset($users[6]) && $users[6]->avatar ? $users[6]->avatar : '/media/default.png')}}"
                                                             alt="">
                                                        <div class="caption text-center">
                                                            <br>
                                                            <span>{{isset($users[6]) ? $users[6]->login: 'Не указано' }}</span>
                                                            <br>
                                                        </div>
                                                        <div class="text-center">
                                                            <div class="col-md-12 buy_button"
                                                                 style="background-color: #f39c12; padding: 5px;">
                                                                <button onclick="toPacketShop()"
                                                                        style="background-color:#f39c12; border: 0;">
                                                                    @if(!isset($users[6]))
                                                                        Купить место <span
                                                                                class="visible-lg visible-xl visible-md hidden-sm hidden-xs"></span>
                                                                    @else
                                                                        Куплено
                                                                    @endif
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </div>

@endsection

<style>
    .buy_button button {
        font-size: 120%;
        color: white;
    }

    .thumbnail {
        width: 150px;
        padding: 0 !important;
        margin-bottom: 0 !important;
    }

    .thumbnail .caption {
        padding-top: 0 !important;
        font-size: 1rem;
    }

    .thumbnail .caption h3 {
        font-size: 2rem;
    }

    .thumbnail .caption span {
        margin-top: 1rem;
        font-size: 1.7rem;
        font-weight: 600;
    }

    .thumbnail img {
        margin-top: 10px;
        width: 75%;
        border: 2px solid lightgrey;
        border-radius: 50%;
        max-height: 110px;
    }

    .thumbnail .caption p {
        font-size: 1.4rem;
    }

    /*Now the CSS*/
    * {
        margin: 0;
        padding: 0;
    }

    .tree ul {

        position: relative;

        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }

    .tree li {
        float: left;
        text-align: center;
        list-style-type: none;
        position: relative;
        padding: 20px 5px 0 5px;

        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }

    /*We will use ::before and ::after to draw the connectors*/

    .tree li::before, .tree li::after {
        content: '';
        position: absolute;
        top: 0;
        right: 50%;
        border-top: 1px solid #ccc;
        width: 50%;
        height: 20px;
    }

    .tree li::after {
        right: auto;
        left: 50%;
        border-left: 1px solid #ccc;
    }

    /*We need to remove left-right connectors from elements without
    any siblings*/
    .tree li:only-child::after, .tree li:only-child::before {
        display: none;
    }

    /*Remove space from the top of single children*/
    .tree li:only-child {
        padding-top: 0;
    }

    /*Remove left connector from first child and
    right connector from last child*/
    .tree li:first-child::before, .tree li:last-child::after {
        border: 0 none;
    }

    /*Adding back the vertical connector to the last nodes*/
    .tree li:last-child::before {
        border-right: 1px solid #ccc;
        border-radius: 0 5px 0 0;
        -webkit-border-radius: 0 5px 0 0;
        -moz-border-radius: 0 5px 0 0;
    }

    .tree li:first-child::after {
        border-radius: 5px 0 0 0;
        -webkit-border-radius: 5px 0 0 0;
        -moz-border-radius: 5px 0 0 0;
    }

    /*Time to add downward connectors from parents*/
    .tree ul ul::before {
        content: '';
        position: absolute;
        top: -20;
        left: 50%;
        border-left: 1px solid #ccc;
        width: 0;
        height: 20px;
    }

    .tree li a {
        border: 1px solid #ccc;
        text-decoration: none;
        color: #666;
        font-family: arial, verdana, tahoma;
        font-size: 11px;
        display: inline-block;
        margin-bottom: 20px !important;
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;

        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }

    /*Time for some hover effects*/
    /*We will apply the hover effect the the lineage of the element also*/
    .tree li a:hover, .tree li a:hover + ul li a {
        background: #c8e4f8;
        color: #000;
        border: 1px solid #94a0b4;
    }

    /*Connector styles on hover*/
    .tree li a:hover + ul li::after,
    .tree li a:hover + ul li::before,
    .tree li a:hover + ul::before,
    .tree li a:hover + ul ul::before {
        border-color: #94a0b4;
    }
</style>

<style>
    @media only screen and (max-width: 400px) {
        .tree_li {
            padding-left: 0px !important;
        }

        .thumbnail .caption span {
            font-size: 1.1rem !important;
        }

        .thumbnail {
            width: 65px;
        }

        .buy_button button {
            font-size: 80%;
        }

        .button_form {
            margin-top: 10px;
        }

        .label_button_1 {
            display: none !important;
        }

        .label_button_2 {
            display: none !important;
        }

        .button_1_div {
            padding-left: 0 !important;
            width: auto !important;
        }

        .button_2_div {
            padding-left: 0 !important;
        }

        .tree {
            width: 700px;
        }
    }


    @media only screen and (max-width: 425px) {
        .thumbnail {
            width: 60px;
        }
    }


    @media only screen and (max-width: 538px) {
        .thumbnail {
            width: 80px;
        }

    }


    @media only screen and (max-width: 600px) {

        .tree_li {
            padding-left: {{60+$padding_left}}px !important;
        }

        .thumbnail .caption span {
            font-size: 1.1rem !important;
        }

        .thumbnail {
            width: 100px;
        }

        .buy_button button {
            font-size: 80%;
        }

        .button_form {
            margin-top: 10px;
        }

        .label_button_1 {
            display: none !important;
        }

        .label_button_2 {
            display: none !important;
        }

        .button_1_div {
            padding-left: 0 !important;
            width: auto !important;
        }

        .button_2_div {
            padding-left: 0 !important;
        }


        .tree {
            overflow: auto;
            white-space: nowrap !important;
            border: 1px solid grey;
            padding: 10px;
            margin-top: 20px;
        }

        .parent_class_2 {
            padding: 10px;
        }

        .tree {
            width: 700px;
        }
    }

    @media only screen and (max-width: 452px) {
        .tree_li {
            padding-left: {{0 + $padding_left_2}}             !important;
        }

        .thumbnail {
            width: 80px;
        }

    }

    @media only screen and (max-width: 393px) {
        .thumbnail {
            width: 70px;
        }
    }


    /* Small devices (portrait tablets and large phones, 600px and up) */
    @media only screen and (min-width: 600px) {
        .tree_li {
            padding-left: {{60+$padding_left}}px !important;
        }

        .thumbnail .caption span {
            font-size: 1.1rem !important;
        }

        .thumbnail {
            width: 120px;
        }

        .buy_button button {
            font-size: 80%;
        }


        .button_form {
            margin-top: 20px;
        }

        .label_button_1 {
            display: none !important;
        }

        .label_button_2 {
            display: none !important;
        }

        .button_1_div {
            padding-left: 0 !important;
            width: auto !important;
        }

        .button_2_div {
            padding-left: 0 !important;
        }


        .tree {
            width: 800px;
        }
    }

    /* Medium devices (landscape tablets, 768px and up) */
    @media only screen and (min-width: 768px) {

        .tree_li {
            padding-left: {{90+$padding_left}}px !important;
        }

        .thumbnail .caption span {
            font-size: 1.1rem !important;
        }

        .thumbnail {
            width: 100px !important;
        }

        .buy_button button {
            font-size: 80%;
        }


        .thumbnail {
            width: 120px;
        }

        .search_header {
            padding: 0 40px 0 40px;
        }

        .search_form {
            margin-top: 15px;
        }

        .button_form {
            margin-top: 20px;
        }

        .label_button_1 {
            display: none !important;
        }

        .label_button_2 {
            display: none !important;
        }

        .button_1_div {
            padding-left: 0 !important;
            width: auto !important;
        }

        .button_2_div {
            padding-left: 0 !important;
        }


        .tree {
            width: 1000px;
        }
    }

    /* Large devices (laptops/desktops, 992px and up) */
    @media only screen and (min-width: 992px) {

        .tree_li {
            padding-left: {{120+$padding_left}}px !important;
        }

        .thumbnail .caption span {
            font-size: 1.7rem !important;
        }

        .thumbnail {
            width: 150px !important;
        }

        .buy_button button {
            font-size: 120%;
        }

        .search_header {
            padding: 0 40px 0 40px;
        }

        .search_form {
            margin-top: 0px;
        }

        .button_form {
            margin-top: 0px;
        }

        .label_button_1 {
            display: block !important;
        }

        .label_button_2 {
            display: block !important;
        }


        .tree {
            /*padding-left: 50px;*/
            margin: auto;
        }
    }

    /* Extra large devices (large laptops and desktops, 1200px and up) */
    @media only screen and (min-width: 1200px) {
        .tree {
            /*padding-left: 50px;*/
        }
    }

    @media only screen and (min-width: 1200px) {
        .tree {
            /*padding-left: 150px;*/
            margin: auto;
        }
    }
</style>

@section('js')
    <script>

        var dynamic = $('.parent_class');
        var static = $('.parent_class_2');

        static.height(dynamic.height());


        $("#structure_id").bind('change', function () {
            location.href = "/admin/binary_structure/show?structure_id=" + $(this).val() + "&number=" + $("#number_id").val();
        });
        $("#number_id").bind('change', function () {
            location.href = "/admin/binary_structure/show?number=" + $(this).val() + "&structure_id=" + $("#structure_id").val();
        });

        function toPacketShop() {
            location.href = "{{route('shop.index')}}"
        }
    </script>
@endsection
