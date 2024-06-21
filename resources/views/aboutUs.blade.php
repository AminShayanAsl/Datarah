@extends('base')

@section('title')
    <title>امین شایان اصل</title>
@stop

@section('body')
    <div class="content-wrapper h-100 overflow-y-scroll">
        <div class="position-fixed w-100" dir="ltr">
            <div class="menu-btn d-none eastern-blue-bg mx-sm-5 my-sm-4 m-3 rounded-circle shadow text-center text-light">
                <i class="fa-solid fa-bars h3 mt-2"></i>
                <i class="fa-solid fa-xmark h3 mt-2"></i>
            </div>
        </div>
        <div class="menu-wrapper">
            <div class="menu card position-fixed h-100 eastern-blue-bg rounded-0 z-1 shadow">
                <div class="text-center mt-2 mb-3">
                    <img class="rounded-circle border border-3 border-secondary" src="{{ asset('images/amin-sm.jpg') }}">
                    <span class="text-light mt-1">امین شایان اصل</span>
                </div>
                <hr>
                <a href="#introduce" class="w-100 text-decoration-none text-light px-4 py-2">معرفی</a>
                <a href="#education" class="w-100 text-decoration-none text-light px-4 py-2">تحصیلات</a>
                <a href="#job" class="w-100 text-decoration-none text-light px-4 py-2">سوابق شغلی</a>
                <a href="#skill" class="w-100 text-decoration-none text-light px-4 py-2">مهارت‌ها</a>
            </div>
        </div>
        <div class="container content px-5 lh-lg">
            <section id="introduce" class="py-3">
                <h4 class="mt-3">معرفی</h4>
                <div class="text-center my-3 px-2">
                    <img class="col-sm-9 col-12 rounded-3" src="{{ asset('images/amin-lg.jpg') }}">
                </div>
                <b>سلام</b>
                <p>من امین شایان اصل، طراح سایت <b>دیتاراه</b> هستم. در این صفحه قصد دارم به معرفی خودم بپردازم:</p>
                <ul class="row list-unstyled">
                    <li class="col-lg-6 col-12">نام و نام خانوادگی : <br class="d-md-none">امین شایان اصل</li>
                    <li class="col-lg-6 col-12">مدرک تحصیلی : <br class="d-md-none">کارشناسی مهندسی کامپیوتر</li>
                    <li class="col-lg-6 col-12">سال تولد : <br class="d-md-none">۱۳۷۹</li>
                    <li class="col-lg-6 col-12">محل تولد : <br class="d-md-none">آذربایجان شرقی، مراغه</li>
                    <li class="col-lg-6 col-12">شغل‌ها : <br class="d-md-none">طراح سایت، هنرآموز کامپیوتر</li>
                    <li class="col-lg-6 col-12">وضعیت تأهل : <br class="d-md-none">متأهل</li>
                </ul>
            </section>
            <hr>
            <section id="education" class="py-3">
                <h4 class="mt-3">تحصیلات</h4>
                <p class="my-4">
                    من دوره‌های ابتدایی، دوره اول متوسطه و دوره دوم متوسطه را در شهرستان مراغه واقع در استان آذربایجان شرقی مشغول به تحصیل بودم.
                    دوره ابتدایی را در مدرسه دولتی شمس تبریزی گذراندم و دوره‌های اول و دوم متوسطه را هم در مدرسه استعدادهای درخشان تحصیل کردم.
                    در دوره دوم رشته تحصیلی ام ریاضی بود.  در سال ۱۳۹۷ در کنکور سراسری ریاضی شرکت کردم که با رتبه ۱۱۵۸ منطقه دو در رشته
                    مهندسی کامپیوتر دانشگاه شهید رجایی تهران پذیرفته و پس از ۴ سال موفق به اخذ مدرک کارشناسی مهندسی کامپیوتر از این دانشگاه شدم.
                </p>
                <div class="text-center">
                    <img src="{{ asset('images/student.png') }}" class="col-9 col-sm-8 col-md-7 col-lg-5 col-xl-3 rounded-3">
                </div>
            </section>
            <hr>
            <section id="job" class="py-3">
                <h4 class="mt-3">سوابق شغلی</h4>
                <p class="my-4">
                    من به عنوان طراح سایت تا به حال در دو شرکت مشغول به کار بودم.  در شرکت تدوین مصرف تِم واقع در تبریز به مدت سه ماه و در شرکت marketmap که
                    یکی از استارتاپ‌های  دانشگاه علم و صنعت تهران است به مدت دو سال  مشغول بودم.  و همچنین از سال ۱۴۰۱ در یکی از هنرستان‌های استان آذربایجان شرقی،
                    هنرآموز کامپیوتر هستم.
                </p>
                <div class="text-center">
                    <img src="{{ asset('images/programmer.png') }}" class="col-11 col-sm-10 col-md-8 col-lg-7 col-xl-5 rounded-3">
                </div>
            </section>
            <hr>
            <section id="skill" class="py-3 mb-4">
                <h4 class="mt-3">مهارت‌ها</h4>
                <p class="my-4">
                    تجربه کار با هر کدام از موارد زیر را دارا می‌باشم:
                </p>
                <ul class="row list-unstyled">
                    <li class="col-lg-4 col-sm-6 col-12">HTML</li>
                    <li class="col-lg-4 col-sm-6 col-12">CSS</li>
                    <li class="col-lg-4 col-sm-6 col-12">Java Script</li>
                    <li class="col-lg-4 col-sm-6 col-12">Bootstrap</li>
                    <li class="col-lg-4 col-sm-6 col-12">jQuery</li>
                    <li class="col-lg-4 col-sm-6 col-12">Php</li>
                    <li class="col-lg-4 col-sm-6 col-12">Laravel</li>
                    <li class="col-lg-4 col-sm-6 col-12">Python</li>
                    <li class="col-lg-4 col-sm-6 col-12">Django</li>
                    <li class="col-lg-4 col-sm-6 col-12">SQL</li>
                    <li class="col-lg-4 col-sm-6 col-12">Doctrine</li>
                    <li class="col-lg-4 col-sm-6 col-12">Web Scraping (Crawl)</li>
                    <li class="col-lg-4 col-sm-6 col-12">Git</li>
                    <li class="col-lg-4 col-sm-6 col-12">Linux (Ubuntu)</li>
                </ul>
                <div class="text-center py-5 mb-5">
                    <img src="{{ asset('images/skills.png') }}" class="col-11 col-sm-10 col-md-8 col-lg-7 col-xl-5 rounded-3">
                </div>
            </section>
        </div>
    </div>
    <script>
        $('.content-wrapper').scrollSpy({
            target: $('.menu a')
        }).scroll();

        $(document).ready(function() {
            $('.menu-btn').click(function () {
                if ($('.menu').css('margin-right') == '-200px') {
                    $('.menu').animate({
                        marginRight: '0px'
                    });
                } else {
                    $('.menu').animate({
                        marginRight: '-200px'
                    });
                }
                $('.fa-bars').toggle();
                $('.fa-xmark').toggle();
            });
        });
    </script>
@stop
