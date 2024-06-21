@extends('base')

@section('body')
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img id="header-logo" src="{{ asset('images/logo.png') }}">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
                منو
            </button>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto py-4 py-lg-0">
                    <li class="nav-item"><a class="nav-link px-lg-2 px-xl-3 py-3 py-lg-4" href="{{ url('add-question/') }}">افزودن&thinsp;سوال</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-2 px-xl-3 py-3 py-lg-4" href="{{ url('questions/') }}">سوالات</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-2 px-xl-3 py-3 py-lg-4" href="{{ url('/#grouping') }}">دسته‌بندی</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-2 px-xl-3 py-3 py-lg-4" href="{{ url('users-rank/') }}">رتبه‌بندی&thinsp;کاربران</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-2 px-xl-3 py-3 py-lg-4" href="{{ url('help/') }}">راهنما</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-2 px-xl-3 py-3 py-lg-4" href="{{ url('sign-in/') }}">حساب&thinsp;کاربری</a></li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="main-footer text-white">
        <div class="container p-4 pb-0">
            <section>
                <div class="row">
                    <div class="col-lg-8 col-md-8 mb-4 mb-md-0">
                        <h5 class="text-uppercase text-center text-md-end"><span class="pb-2">سخن بزرگان</span></h5>

                        <p class="mt-4 px-3 fst-italic lh-lg">
                            {!! $content !!}
                        </p>
                    </div>


                    <div class="col-lg-4 col-md-4 mb-4 mb-md-0">
                        <h5 class="text-uppercase text-center text-md-end"><span class="pb-2">لینک‌های مفید</span></h5>

                        <ul class="list-unstyled mt-4 mb-0 lh-lg text-center text-md-end">
                            <li>
                                <a href="{{ url('amin-shayan-asl/') }}" class="light_link text-decoration-none">درباره‌ما</a>
                            </li>
                            <li>
                                <a href="{{ url('help/') }}" class="light_link text-decoration-none">راهنما</a>
                            </li>
                            <li>
                                <a href="{{ url('support/') }}" class="light_link text-decoration-none">پشتیبانی</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <hr class="mb-4" />

            <!-- Social media -->
            <section class="mb-4 text-center">
                <!-- Google -->
                <a class="btn btn-outline-light btn-floating m-1" href="https://mail.google.com/mail/?view=cm&fs=1&to=datarah2024@gmail.com" role="button" target="_blank"><i class="fab fa-google"></i></a>

                <!-- telegram -->
                <a class="btn btn-outline-light btn-floating m-1" href="https://t.me/datarah2024" role="button" target="_blank"><i class="fa-brands fa-telegram"></i></a>

                <!-- Instagram -->
                <a class="btn btn-outline-light btn-floating m-1" href="https://instagram.com/datarah2024" role="button" target="_blank"><i class="fab fa-instagram"></i></a>
            </section>
        </div>

        <!-- Copyright -->
        <div id="copyright" class="text-center p-3" dir="ltr" style="">
            © 2024 Copyright:
            <a class="text-white" href="{{ url('amin-shayan-asl/') }}">Amin Shayan asl</a>
        </div>
    </footer>
@stop
