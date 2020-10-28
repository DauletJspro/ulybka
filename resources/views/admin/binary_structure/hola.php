<?php

$user = new \App\Models\Users();
$parent_user = $user::get_user($tree[0]) ?: null;
$user_left_second_line = $user::get_user($tree[1]) ?: null;
$user_right_second_line = $user::get_user($tree[2]) ?: null;
$user_fourth = $user::get_user($tree[3]) ?: null;
$user_fifth = $user::get_user($tree[4]) ?: null;
$user_sixth = $user::get_user($tree[5]) ?: null;
$user_seventh = $user::get_user($tree[6]) ?: null;
$structure_id = (app('request')->input('structure_id')) != "" ? (app('request')->input('structure_id')) : null;
?>
@extends('admin.layout.layout')

@section('content')
<section class="content-header">
  <h1>
    Матричная структура
  </h1>
  <h4 class="visible-lg  visible-sm visible-md visible-xs">
    <div class="alert  alert-success">Вы можете двигать структуру для полного просмотра <i
          class="fa fa-arrow-right"></i></div>
  </h4>
</section>
<div class="row card" style="margin-top: 20px;">
  <div class="parent_class col-xs-12 col-sm-12  col-md-12  col-lg-9 col-xl-9 text-center card-body text-center">
    <div style="width: 100%;" class="text-center">
      <div class="tree text-center" >
        <ul class="text-center">
          <li>
            <a href="#">
              <div class="row" id="first_line">
                <div class="col-md-12 text-center">
                  <div class="thumbnail">
                    <img src="{{asset($parent_user ? $parent_user->avatar : '/media/default.png')}}"
                         alt="">
                    @if($parent_user)
                    <div class="caption text-left">
                      <span><span class="left_text">Ф.И.O:</span> {{sprintf('%s %s', $parent_user->name, $parent_user->last_name)}}</span>
                      <br>
                      <span><span class="left_text">Логин:</span> {{$parent_user->login}}</span>
                      <br>
                      {{--                                                <span><span class="left_text">Дата:</span> {{\Carbon\Carbon::parse($parent_user->created_at)->toDateString()}}</span>--}}
                    </div>
                    @else
                    <div class="text-center">
                      <div>Не указано</div>
                      <br>
                      <br>
                      <br>
                      <div class="col-md-12">
                        <button onclick="toPacketShop()"
                                style="background-color: transparent; border: 0;">
                          Купить место (7000тг)
                        </button>
                      </div>

                    </div>
                    @endif

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
                        <img src="{{asset($user_left_second_line ? $user_left_second_line->avatar : '/media/default.png')}}"
                             alt="">
                        @if($user_left_second_line)
                        <div class="caption text-left">
                          <span><span class="left_text">Ф.И.O:</span> {{sprintf('%s %s', $user_left_second_line->name, $user_left_second_line->last_name)}}</span>
                          <br>
                          <span><span class="left_text">Логин:</span> {{$user_left_second_line->login}}</span>
                          <br>
                          {{--                                                        <span><span class="left_text">Дата:</span> {{\Carbon\Carbon::parse($user_left_second_line->created_at)->toDateString()}}</span>--}}
                        </div>
                        @else
                        <div class="text-center">
                          <div>Не указано</div>
                          <br>
                          <br>
                          <br>
                          <div class="col-md-12">
                            <button onclick="toPacketShop()"
                                    style="background-color: transparent; border: 0;">
                              Купить место (7000тг)
                            </button>
                          </div>
                        </div>
                        @endif

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
                            <img src="{{asset($user_fourth ? $user_fourth->avatar : '/media/default.png')}}"
                                 alt="">
                            @if($user_fourth)
                            <div class="caption text-left">
                              <span><span class="left_text">Ф.И.O:</span> {{sprintf('%s %s', $user_fourth->name, $user_fourth->last_name)}}</span>
                              <br>
                              <span><span class="left_text">Логин:</span> {{$user_fourth->login}}</span>
                              <br>
                              {{--                                                                <span><span class="left_text">Дата:</span> {{\Carbon\Carbon::parse($user_fourth->created_at)->toDateString()}}</span>--}}
                            </div>
                            @else
                            <div class="text-center">
                              <div>Не указано</div>
                              <br>
                              <br>
                              <br>
                              <div class="col-md-12">
                                <button onclick="toPacketShop()"
                                        style="background-color: transparent; border: 0;">
                                  Купить место (7000тг)
                                </button>
                              </div>

                            </div>
                            @endif

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
                            <img src="{{asset($user_fifth ? $user_fifth->avatar : '/media/default.png')}}"
                                 alt="">
                            @if($user_fifth)
                            <div class="caption text-left">
                              <span><span class="left_text">Ф.И.O:</span> {{sprintf('%s %s', $user_fifth->name, $user_fifth->last_name)}}</span>
                              <br>
                              <span><span class="left_text">Логин:</span> {{$user_fifth->login}}</span>
                              <br>
                              {{--                                                                <span><span class="left_text">Дата:</span> {{\Carbon\Carbon::parse($user_fifth->created_at)->toDateString()}}</span>--}}
                            </div>
                            @else
                            <div class="text-center">
                              <div>Не указано</div>
                              <br>
                              <br>
                              <br>
                              <div class="col-md-12">
                                <button onclick="toPacketShop()"
                                        style="background-color: transparent; border: 0;">
                                  Купить место (7000тг)
                                </button>
                              </div>

                            </div>
                            @endif

                          </div>
                        </div>
                      </div>
                    </a>
                  </li>
                </ul>
              </li>
              <li>
                <a href="#">
                  <div class="row" id="first_line">
                    <div class="col-md-12 text-center">
                      <div class="thumbnail">
                        <img src="{{asset($user_right_second_line ? $user_right_second_line->avatar : '/media/default.png')}}"
                             alt="">
                        @if($user_right_second_line)
                        <div class="caption text-left">
                          <span><span class="left_text">Ф.И.O:</span> {{sprintf('%s %s', $user_right_second_line->name, $user_right_second_line->last_name)}}</span>
                          <br>
                          <span><span class="left_text">Логин:</span> {{$user_right_second_line->login}}</span>
                          <br>
                          {{--                                                        <span><span class="left_text">Дата:</span> {{\Carbon\Carbon::parse($user_right_second_line->created_at)->toDateString()}}</span>--}}

                        </div>
                        @else
                        <div class="text-center">
                          <div>Не указано</div>
                          <br>
                          <br>
                          <br>

                          <div class="col-md-12">
                            <button onclick="toPacketShop()"
                                    style="background-color: transparent; border: 0;">
                              Купить место (7000тг)
                            </button>
                          </div>

                        </div>
                        @endif

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
                            <img src="{{asset($user_sixth ? $user_sixth->avatar : '/media/default.png')}}"
                                 alt="">
                            @if($user_sixth)
                            <div class="caption text-left">
                              <span><span class="left_text">Ф.И.O:</span> {{sprintf('%s %s', $user_sixth->name, $user_sixth->last_name)}}</span>
                              <br>
                              <span><span class="left_text">Логин:</span> {{$user_sixth->login}}</span>
                              <br>
                              {{--                                                                <span><span class="left_text">Дата:</span> {{\Carbon\Carbon::parse($user_sixth->created_at)->toDateString()}}</span>--}}
                            </div>
                            @else
                            <div class="text-center">
                              <div>Не указано</div>
                              <br>
                              <br>
                              <br>
                              <div class="col-md-12">
                                <button onclick="toPacketShop()"
                                        style="background-color: transparent; border: 0;">
                                  Купить место (7000тг)
                                </button>
                              </div>
                            </div>
                            @endif
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
                            <img src="{{asset($user_seventh ? $user_seventh->avatar : '/media/default.png')}}"
                                 alt="">
                            @if($user_seventh)
                            <div class="caption text-left">
                              <span><span class="left_text">Ф.И.O:</span> {{sprintf('%s %s', $user_seventh->name, $user_seventh->last_name)}}</span>
                              <br>
                              <span><span class="left_text">Логин:</span> {{$user_seventh->login}}</span>
                              <br>
                              {{--                                                                <span><span class="left_text">Дата:</span> {{\Carbon\Carbon::parse($user_seventh->created_at)->toDateString()}}</span>--}}
                            </div>
                            @else
                            <div class="text-center">
                              <div>Не указано</div>
                              <br>
                              <br>
                              <br>
                              <div class="col-md-12">
                                <button onclick="toPacketShop()"
                                        style="background-color: transparent; border: 0;">
                                  Купить место (7000тг)
                                </button>
                              </div>

                            </div>
                            @endif

                          </div>
                        </div>
                      </div>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="parent_class_2 col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 card-body"
       style="background-color: white;height: 100%;">
    <div class="box-body">
      <div class="form-group">
        <label>Структура</label>
        <select name="structure_id" id="structure_id" class="form-control">
          <option {{$structure_id == 1 ? 'selected' : ''}} value="1">Стол 1</option>
          <option {{$structure_id == 2 ? 'selected' : ''}} value="2">Стол 2</option>
          <option {{$structure_id == 3 ? 'selected' : ''}} value="3">Стол 3</option>
          <option {{$structure_id == 4 ? 'selected' : ''}} value="4">Стол 4</option>
          <option {{$structure_id == 5 ? 'selected' : ''}} value="5">Стол 5</option>
          <option {{$structure_id == 6 ? 'selected' : ''}} value="6">Стол 6</option>
          <option {{$structure_id == 7 ? 'selected' : ''}} value="7">Стол 7</option>
        </select>
      </div>
      <div class="form-group">
        <label>Поиск по логину</label>

        <form method="POST" action="{{route('binary_structure.get_by_user_id')}}"
              style="border: 1px solid lightgrey; padding: 10px;">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input name="login" value="{{ $row->email }}" type="text" class="form-control"
                 placeholder="Введите">
          <input type="hidden" name="structure_id" value="{{$structure_id ?: null}}">
          <br>
          <button class="btn btn-success">Найти</button>
        </form>
      </div>
      <div class="form-group">
        <button class="btn btn-warning">Купить место (7000 тг)</button>
        <br>
        <br>
        <button class="btn btn-success" onclick="toPacketShop()">Следующее место</button>
      </div>
    </div>
  </div>
</div>

@endsection

<style>
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
        font-size: 1rem;
        font-weight: 300;
    }

    .thumbnail img {
        width: 90%;
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
        .parent_class {
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

    @media only screen and (max-width: 600px) {
        .parent_class {
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

    /* Small devices (portrait tablets and large phones, 600px and up) */
    @media only screen and (min-width: 600px) {
        .parent_class {
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
            width: 800px;
        }
    }

    /* Medium devices (landscape tablets, 768px and up) */
    @media only screen and (min-width: 768px) {
        .parent_class {
            overflow: auto;
            white-space: nowrap !important;
            border: 1px solid grey;
            padding: 10px;
            margin-top: 20px;
        }
        .parent_class_2{
            padding: 10px;
        }
        .tree {
            width: 1000px;
        }
    }

    /* Large devices (laptops/desktops, 992px and up) */
    @media only screen and (min-width: 992px) {
        .parent_class {
            overflow: auto;
            white-space: nowrap !important;
            border: 2px solid #f39c12;
            border-radius: 5px;
            padding: 10px;
            margin-top: 0;
        }
        .parent_class_2{
            padding: 10px;
        }
        .tree {
            padding-left: 50px;
        }
    }

    /* Extra large devices (large laptops and desktops, 1200px and up) */
    @media only screen and (min-width: 1200px) {
        .parent_class {
            overflow: auto;
            white-space: nowrap !important;
            border: 2px solid #f39c12;
            border-radius: 5px;
            padding: 10px;
            margin-top: 0;
        }
        .parent_class_2{
            padding: 10px;
        }
        .tree {
            padding-left: 50px;
        }
    }

    @media only screen and (min-width: 1200px) {
        .tree {
            padding-left: 150px;
        }
    }
</style>

@section('js')
<script>

    var dynamic = $('.parent_class');
    var static = $('.parent_class_2');

    static.height(dynamic.height());


    $("#structure_id").bind('change', function () {
        location.href = "/admin/binary_structure/show?structure_id=" + $(this).val();
    });

    function toPacketShop() {
        location.href = "{{route('shop.index')}}"
    }
</script>
@endsection
