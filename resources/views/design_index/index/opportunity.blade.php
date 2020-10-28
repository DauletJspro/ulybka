@extends('design_index.layout.layout')

@section('meta-tags')
    <link rel="stylesheet" href="/new_design/css/opportunity-responsive.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <title>ulybka.kz</title>
    {{-- <meta name="description"
          content="«Qpartners» - это уникальный медиа проект с широким набором возожностей для взаймодествия с участниками виртуального рынка"/>
    <meta name="keywords" content="Qpartners"/> --}}

@endsection
<div id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="height:700px; width:100%;padding-top: 50px;">
            <iframe id="myFrame" style="width: 100%; height: 100%;"
                    frameborder="0" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true">
            </iframe>
        </div>
    </div>
</div>
@section('content')

    <main id="mt-main" style="">
        <section class="mt-mainslider4 add" style="margin-top: 0;background-color: #ebebeb;">
            <div class="container" style="height: 60%; ">
                <div class="row">
                    <div class="col-sm-6">
                        <div style=" padding: 140px 38px 20px 41px;">
                            <div class="video_box" style="
                                            /*background-image: url('/new_design/images/video/qyran_partners.jpg');*/
                                            background-color: red;
                                            background-size: cover;
                                            background-repeat: no-repeat;
                                            background-position: center;

                                        ">
                                <div class="red_play_button" data-youtube-url="uhJikpNX-u8"
                                     onclick="openModal(this)" style="cursor: pointer;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div style=" padding: 140px 38px 20px 80px;">
                            <div class="logo_image" style="
                                            background-image: url('/new_design/images/logo/go_diamonds_logo.png');
                                            background-size: contain;
                                            background-repeat: no-repeat;
                                            background-position: center;
                                            width: 420px;
                                            height: 120px;

                                        ">
                            </div>
                            <div class="text-center" style="font-family: Sans-Serif; color: black; font-size: 22px;">
                                Первый в Казахстане МЛМ проект <br>
                                который объединяет 3 маркетинг программы <br>
                                в одной платформе
                            </div>

                            <div class="second-section-div-right text-center"
                                 style="width: 100%;float: none;margin-top: 40px;">
                                <a href="/presentation/marketing_plan.pdf"
                                   style="background-color: transparent;font-size:140%;"
                                   class="second-section-button hover-red" target="_blank">
                                    ПОДЕЛИТЬСЯ
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="mt-section-1">
            <div class="container" style="margin-top: 0;padding-top: 0;">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="banner-frame" style="padding-top: 0;">
                            <div class="banner-15 right wow"
                                 style="width: 580px;
                             height: 540px;
                             background: white;
                             margin:0;
                             margin-left: 19px;
                            ">
                                <div class="holder">
                                    <div class="second-section-title">
                                        <h3 class="second-section-title-h3 text-center">
                                            <span style="color: black;font-weight: bold;">Стань миллионером </span>
                                        </h3>
                                    </div>
                                    <div style="float: left; " class="second-section-text text-left">
                                    <span style="color: black;">
                                        В ЭТОМ ПОЛИКЕ ВЫ УЗНАЕТЕ, КАК С 12000 ТЕНГЕ СДЕЛАТЬ
                                        17 МИЛЛИОНОВ ЗА 5 МИНУТ
                                    </span>
                                        <div class="video_box" style="
                                            /*background-image: url('/new_design/images/video/qyran_partners.jpg');*/
                                            background-color: red;
                                            background-size: cover;
                                            background-repeat: no-repeat;
                                            background-position: center;
                                        ">
                                            <div class="red_play_button" data-youtube-url="uhJikpNX-u8"
                                                 onclick="openModal(this)" style="cursor: pointer;"></div>
                                        </div>
                                    </div>
                                    <div class="text-center video_buttons">
                                        <div class="second-section-div-left">
                                            <a href="/register" class="second-section-button hover-red">СТАТЬ
                                                ПАРТНЕРОМ
                                            </a>
                                        </div>
                                        <div class="second-section-div-right">
                                            <a href="/presentation/marketing_plan.pdf"
                                               class="second-section-button hover-red" target="_blank">
                                                СКАЧАТЬ ПРЕЗЕНТАЦИЮ
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="red_border_video">
                            </div>
                            <div class="banner-15 right wow"
                                 style="width: 580px; height: 540px;background: white;margin:0;">
                                <div class="holder">
                                    <div class="second-section-title">
                                        <h3 class="second-section-title-h3">
                                            <span style="color: black;">БУДЬ</span>
                                            <span style="color: #05c100;">ЗДОРОВЫМ</span>
                                        </h3>
                                    </div>
                                    <div style="float: left; " class="second-section-text text-left">
                                    <span style="color: black;">
                                       В ЭТОМ РОЛИКЕ ВЫ УЗНАЕТЕ, КАКУКРЕПИТЬ И УЛУЧШИТЬ СВОЕ ЗДОРОВЬЕ И САМОЧУВСТВИЕ
                                    </span>
                                        <div class="video_box" style="
                                            /*background-image: url('/new_design/images/video/natural_market.jpg');*/
                                            background-color: #00d300;
                                            background-size: cover;
                                            background-repeat: no-repeat;
                                            background-position: center;
                                            ">
                                            <div style="cursor: pointer;" class="green_play_button"
                                                 data-youtube-url="eKyZWdo8drM"
                                                 onclick="openModal(this)"></div>
                                        </div>
                                    </div>
                                    <div style="" class="text-center video_buttons">
                                        <div class="second-section-div-left">
                                            <a href="/presentation/normal_product.pdf" target="_blank"
                                               class="second-section-button br-green hover-green">
                                                СКАЧАТЬ КАТАЛОГ
                                            </a>
                                        </div>
                                        <div class="second-section-div-right">
                                            <a href="/shop" class="second-section-button br-green hover-green">
                                                ПЕРЕЙТИ В МАГАЗИН
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="mt-section-2" style="
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-image: url('/new_design/images/opportunity/image_section_3.png');
            margin-left: auto;
            margin-right: auto;
        ">
            <div class="container">
                <div class="section-2-title" style="padding-bottom: 80px;">
                    <h1 class="h1-title"><span style="color: black;">Щедрые</span> <span
                                style="color: #ff0000;">80%</span></h1>
                    <h3 class="h3-title"><span style="color:#ff0000; ">с уникальным маркетинг планом</span></h3>
                    <div style="width: 100%;height: 100px;">
                        <h3 class="h3-title-what-you-get">Что <span style="color: #ff0000;">Вы получаете</span>?</h3>
                    </div>

                    <p>
                        Став Партнером Вы получаете полноценный доступ к Маркетинг плану и ко всем его <br>
                        Инструментам и Возможностям.
                    </p>
                    <div class="row what_you_get_icons_div" style="margin-top: 50px;">
                        <div class="col-xs-12 col-md-12 col-xs-12">
                            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2  text-center">
                                <div class="icon_image_div" style="
                                background-image: url('/new_design/images/opportunity/book_icon.png');
                            "></div>
                                <h2>Каталог <br>
                                    натуральной <br>
                                    продукции
                                </h2>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2   text-center">
                                <div class="icon_image_div" style="
                                background-image: url('/new_design/images/opportunity/copy_book.png');
                                width: 50px;
                                height: 50px;
                            "></div>
                                <h2>Презентация <br>
                                    Маркетинг <br>
                                    плана
                                </h2>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2  text-center">
                                <div class="icon_image_div" style="
                                background-image: url('/new_design/images/opportunity/debat_card.png');
                            "></div>
                                <h2>Онлайн <br>
                                    клубная <br>
                                    карта
                                </h2>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2  text-center">
                                <div class="icon_image_div" style="
                                background-image: url('/new_design/images/opportunity/had.png');
                            "></div>
                                <h2>Обучение <br>
                                    Партнеров <br>
                                    компании
                                </h2>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2  text-center">
                                <div class="icon_image_div" style="
                                background-image: url('/new_design/images/opportunity/assistmant.png');
                            "></div>
                                <h2>
                                    Ассортимент <br>
                                    Натуральной <br>
                                    продукции
                                </h2>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2  text-center">
                                <div class="icon_image_div" style="
                                background-image: url('/new_design/images/opportunity/home_car.png');
                                width: 50px;
                                height: 50px;
                            "></div>
                                <h2>
                                    Участие в <br>
                                    Социальных <br>
                                    программах
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="mt-section-2" style="
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-image: url('/new_design/images/opportunity/image_section_3.png');
            margin-left: auto;
            margin-right: auto;
            margin-top: 2rem;
            padding-bottom: 60px;
        ">
            <div class="container">
                <div class="section-2-title">
                    <h3 class="what-we-offer-text"><span style="color: black;">Что мы</span> предлагаем Вам <span
                                style="color: black;">?</span></h3>
                    <p>
                       Мы предлагаем Вам уникальный маркетинг программу с высокими доходами. Войдя в один
                        из ниже приведенных столов Вы можете заработать более 17 000 000 тенге.
                        Также, Вы получите комплекс натуральной продукции для оздоровления здоровья.
                    </p>
                    <div class="row row-1">
                        <div class="col-sm-6 col-md-6  col-lg-4 col-xl-3 col-xs-6">
                            <div class="red-border">
                            </div>
                            <div class="packet-body">
                                <div class="stars-box text-center">
                                    <img src="/new_design/images/opportunity/star.png" alt="">
                                </div>
                                <div class="packet-name text-center">
                                    SILVER <br>
                                    12 000 ТГ.
                                </div>
                                <div class="bonus-text">
                                    <ul style="list-style: none;">
                                        <li>Получите: </li>
                                        <li>
                                            - 2 шт.
                                            &nbsp;натуральной
                                            &nbsp;продукции
                                        </li>
                                        <li>
                                            - инструмент <br>
                                            &nbsp; работы
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 col-xs-6">
                            <div class="red-border">
                            </div>
                            <div class="packet-body">
                                <div class="stars-box text-center">
                                    <img src="/new_design/images/opportunity/star.png" alt="">
                                    <img src="/new_design/images/opportunity/star.png" alt="">
                                </div>
                                <div class="packet-name text-center">
                                    GOLD <br>
                                    24 000 тг.
                                </div>
                                <div class="bonus-text">
                                    <ul style="list-style: none;">
                                        <li>Получите: </li>
                                        <li>
                                            - 4 шт.
                                            &nbsp;натуральной
                                            &nbsp;продукции
                                        </li>
                                        <li>
                                            - инструмент <br>
                                            &nbsp; работы
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 col-xs-6">
                            <div class="red-border">
                            </div>
                            <div class="packet-body">
                                <div class="stars-box text-center">
                                    <img src="/new_design/images/opportunity/star.png" alt="">
                                    <img src="/new_design/images/opportunity/star.png" alt="">
                                    <img src="/new_design/images/opportunity/star.png" alt="">
                                </div>
                                <div class="packet-name text-center">
                                    PLATINUM <br>
                                    76 000 тг.
                                </div>
                                <div class="bonus-text">
                                    <ul style="list-style: none;">
                                        <li>Получите: </li>
                                        <li>
                                            - 13 шт.
                                            &nbsp;натуральной
                                            &nbsp;продукции
                                        </li>
                                        <li>
                                            - инструмент <br>
                                            &nbsp; работы
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 110px;">
                        <div class="download-marketing-div">
                            <a class="download-marketing" href="/presentation/marketing_plan.pdf" target="_blank">
                                СКАЧАТЬ МАРКЕТИНГ
                                <span>PDF</span>
                            </a>
                        </div>
                        <div class="download-marketing-div center-div">
                            <a href="{{route('coming-soon', ['id' => 9 ])}}" class="download-marketing" target="_blank">
                                СМОТРЕТЬ ПРЕЗЕНТАЦИЮ
                                <span>MP4</span>
                            </a>
                        </div>
                        <div class="download-marketing-div">
                            <a class="download-marketing"
                               style="padding-right: 20px;cursor: pointer;"
                               href="/register">
                                СТАТЬ ПАРТНЕРОМ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="row" style="padding-bottom: 150px;">
            <div class="container" style="height: 400px;">
                <div class="why-we-are-text">
                    <h3>Почему вы должны <span style="color: #ff0000;"> работать с нами </span>?</h3>
                </div>
                <div class="row">
                    <div class="col-sm-4 text-center">
                        <div class="red-border">
                        </div>
                        <div class="img-text-box">
                            <div class="benefit-img"
                                 style="
                            background-size: cover;
                            background-position: center;
                            background-repeat: no-repeat;
                            background-image: url('/new_design/images/opportunity/exclusive.png');
                            margin-left: auto;
                            margin-right: auto;
                            width: 150px;
                            height: 150px;
                        ">
                            </div>
                            <div class="benefit-text">
                                <p>высокодоходный <br>
                                    и УНИкальный <br>
                                    маркетинг-план
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 text-center">
                        <div class="red-border">
                        </div>
                        <div class="img-text-box">
                            <div class="benefit-img"
                                 style="
                            background-size: cover;
                            background-position: center;
                            background-repeat: no-repeat;
                            background-image: url('/new_design/images/opportunity/natural.png');
                            margin-left: auto;
                            margin-right: auto;
                            width: 150px;
                            height: 150px;
                        ">
                            </div>
                            <div class="benefit-text">
                                <p>постоянная поддержка <br>
                                    со стороны администрации <br>
                                    и лидеров
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 text-center">
                        <div class="img-text-box">
                            <div class="benefit-img"
                                 style="
                            background-size: cover;
                            background-position: center;
                            background-repeat: no-repeat;
                            background-image: url('/new_design/images/opportunity/24-7-hours.png');
                            margin-left: auto;
                            margin-right: auto;
                            width: 150px;
                            height: 150px;
                        ">
                            </div>
                            <div class="benefit-text">
                                <p>натуральная продукция <br>
                                    отечественного <br>
                                    производства
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="want-to-be-partner-box text-center">
                    <a href="/register" class="want-to-be-partner-box-a">
                        ХОЧУ СТАТЬ ПАРТНЕРОМ
                    </a>
                </div>
                <div class="share-button-box text-center">
                    <a href="#" class="share-button" data-toggle="modal" data-target="#share_modal">
                        поделиться
                    </a>
                </div>
            </div>
        </section>
        <section class="" style="background: rgba(232, 232, 232, 0.5); padding-top: 50px; padding-bottom: 50px;">
            <div class="container">
                <div class="col-xs-12" style="padding-bottom: 30px;">
                    <h2 class="have-a-question">Остались вопросы?</h2>
                    <span class="have-a-question-span">Напишите в любое время! </span>
                    {{Form::open(['action' => ['Index\FaqController@opportunityFaqStore'], 'method' => 'POST', 'class'=> 'contact-form' ])}}
                    {{Form::token()}}
                    <fieldset class="have-a-question-fieldset">
                        <input type="text" required name="user_name" class="form-control" placeholder="Имя">
                        <input type="email" required name="user_email" class="form-control" placeholder="E-Mail">
                        <input type="text" required name="user_phone" class="form-control" placeholder="Номер телефона">
                        <textarea rows="10" class="form-control" name="question"
                                  placeholder="Текст ..."></textarea>
                        <button type="submit" class="have-a-question-button">
                            Отправить
                        </button>
                    </fieldset>
                    {{Form::close()}}
                </div>
            </div>
        </section>

        <div class="modal fade bs-example-modal-lg" id="share_modal" tabindex="-1" role="dialog"
             aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <div class="title-group"
                             style="margin-left: 20px; font-size: 120%; color: black; font-weight: 400;">
                            <h4 class="modal-title">Пригласить друга</h4>
                            <h5 class="modal-title">Вы можете поделиться со своими друзьями в социальной сети</h5>
                            <h5 class="modal-title">http://local.qpartners.club/1/admin</h5>
                        </div>
                    </div>
                    <div class="modal-body">
                        <ul style="list-style: none;">
                            <li>
                                <a href="https://api.whatsapp.com/send?text={{$url}}" style="
                                padding:5px 10px 5px 10px;
                                border: 2px solid lightgreen;
                                border-radius: 3px;
                                font-size: 130%;
                                ">
                                    <i style="font-weight: 500;color: lightgreen;" class="fa fa-whatsapp"></i>
                                    <span style="font-weight: 500;color: black;margin-left: 1rem;">Поделиться через Whatsapp</span>
                                </a>

                            </li>
                            <li style="margin-top: 15px;">
                                <a href="https://telegram.me/share/url?url={{$url}}" style="
                                padding:5px 10px 5px 10px;
                                border: 2px solid dodgerblue;
                                border-radius: 3px;
                                font-size: 130%;
                                ">
                                    <i style="
                                    background-image: url('https://bitnovosti.com/wp-content/uploads/2017/02/telegram-icon-7.png');
                                    background-position: center;
                                    background-size: cover;
                                    width: 18px;height: 18px;
                                    bottom: -5px;
                                    "
                                       class="fa fa-telegram"
                                    >

                                    </i>
                                    <span style="font-weight: 500;color: black;margin-left: 1rem;">Поделиться через Telegram</span>
                                </a>

                            </li>
                            <li style="margin-top: 15px;">
                                <a href="https://www.facebook.com/sharer.php?u={{$url}}" style="
                                padding:5px 10px 5px 10px;
                                border: 2px solid dodgerblue;
                                border-radius: 3px;
                                font-size: 130%;
                                ">
                                    <i style="font-weight: 500;color: dodgerblue;" class="fa fa-facebook"></i>
                                    <span style="font-weight: 500;color: black;margin-left: 1rem;">Поделиться через Facebook</span>
                                </a>

                            </li>
                            <li style="margin-top: 15px;">
                                <a href="http://vk.com/share.php?url={{$url}}" style="
                                padding:5px 10px 5px 10px;
                                border: 2px solid dodgerblue;
                                border-radius: 3px;
                                font-size: 130%;
                                ">
                                    <i style="font-weight: 500;color: dodgerblue;" class="fa fa-vk"></i>
                                    <span style="font-weight: 500;color: black;margin-left: 1rem;">Поделиться через VK</span>
                                </a>

                            </li>
                            <li style="margin-top: 15px;">
                                <a href="https://twitter.com/share?url={{$url}}" style="
                                padding:5px 10px 5px 10px;
                                border: 2px solid dodgerblue;
                                border-radius: 3px;
                                font-size: 130%;
                                ">
                                    <i style="font-weight: 500;color: dodgerblue;" class="fa fa-twitter"></i>
                                    <span style="font-weight: 500;color: black;margin-left: 1rem;">Поделиться через Twiiter</span>
                                </a>

                            </li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

<style>
    #mCSB_1_dragger_horizontal {
        background: #ff0000 !important;
    }
</style>
@section('js')
    <script>
        function openModal(tag_object) {
            var videoIdInYouTube = $(tag_object).data('youtube-url');
            var url = ('https://www.youtube.com/embed/' + videoIdInYouTube);
            document.getElementById("myFrame").src = url;
            $('#myModal').modal('toggle');
        }
    </script>
@endsection

