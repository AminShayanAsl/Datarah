@extends('layout')

@section('title')
    <title>افزودن&thinsp;سوال</title>
@stop

@section('content')
    <!-- Page Header-->
    <header class="masthead" style="background-image: url({{ asset('images/question-bg.png') }})">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="page-heading">
                        <h1>افزودن سوال</h1>
                        <span class="subheading">سوال خود را در فرم زیر بیان کنید.</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main Content-->
    <div class="container">
        <h4 class="fw-bold mb-4">افزودن سوال</h4>
        <?php
        if(!isset($_SESSION))
        {
            session_start();
        }
        if (!isset($_SESSION['auth'])) {
        ?>
        <div class="warning-box alert alert-warning mb-3 rounded-3">
            <div class="m-auto py-3 px-3">
                <b>برای افزودن سوال، ابتدا باید وارد شوید.</b>
            </div>
        </div>
        <?php
        }
        ?>
        <div class="advice-box mb-3 rounded-3">
            <div class="m-auto py-3 px-3">
                <h6 class="fw-bold">
                    نوشتن یک سوال خوب
                </h6>
                <p class="h6 mt-3 lh-lg">
                    فرم زیر به شما کمک می‌کند که سوالتان را مطرح کنید.
                </p>
                <h6 class="fw-bold mt-4">
                    مراحل
                </h6>
                <ul class="h6 lh-lg">
                    <li>سوال خود را داخل قسمت عنوان در یک خط خلاصه کنید.</li>
                    <li>سوال خود را با جزئیات کامل بیان کنید.</li>
                    <li>آنچه را که تلاش کردید و انتظار داشتید اتفاق بیافتد را مطرح کنید.</li>
                    <li>از قسمت دسته‌بندی، تگ‌هایی را انتخاب کنید که به نمایان شدن سوالتان برای اعضای سایت کمک می‌کند.</li>
                    <li>قبل از ثبت سوال، قسمت های مختلف سوال را بررسی نمایید.</li>
                </ul>
            </div>
        </div>
        <div class="add-question-box rounded-3 mb-5 px-3 pb-4" <?php if (!isset($_SESSION['auth'])) { echo "disabled"; } ?>>
            <form action="{{ url('save-question') }}" method="post" class="m-auto mt-3 pb-5">
                {{ csrf_field() }}
                <label class="fw-bold">عنوان</label>
                <p class="sub-label mt-1">تصور کنید که از یک شخص سوال می‌پرسید.</p>
                <input class="form-control" type="text" name="title" placeholder="عنوان سوال">
                <label class="fw-bold mt-4">توضیحات</label>
                <p class="sub-label mt-1">سوال را معرفی کنید و آنچه را که در عنوان نوشته‌اید را شرح دهید.</p>
                <textarea id="editor" name="explain"></textarea>
                <input type="text" name="level" class="d-none">
                <input type="text" name="lesson" class="d-none">


                <div class="row my-3">
                    <div class="mt-3">
                        <b>دسته بندی پایه‌ها (اختیاری)</b>
                    </div>

                    <div class="row mb-3 grouping-tags">
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                            <a class="btn btn-outline-dark" data-level-num="1">
                                <img src="{{ asset('images/level_first.png') }}" class="img-icon">
                                اول
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                            <a class="btn btn-outline-dark" data-level-num="2">
                                <img src="{{ asset('images/level_first.png') }}" class="img-icon">
                                دوم
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                            <a class="btn btn-outline-dark" data-level-num="3">
                                <img src="{{ asset('images/level_first.png') }}" class="img-icon">
                                سوم
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                            <a class="btn btn-outline-dark" data-level-num="4">
                                <img src="{{ asset('images/level_first.png') }}" class="img-icon">
                                چهارم
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                            <a class="btn btn-outline-dark" data-level-num="5">
                                <img src="{{ asset('images/level_first.png') }}" class="img-icon">
                                پنجم
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                            <a class="btn btn-outline-dark" data-level-num="6">
                                <img src="{{ asset('images/level_first.png') }}" class="img-icon">
                                ششم
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                            <a class="btn btn-outline-dark" data-level-num="7">
                                <img src="{{ asset('images/level_second.png') }}" class="img-icon">
                                هفتم
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                            <a class="btn btn-outline-dark" data-level-num="8">
                                <img src="{{ asset('images/level_second.png') }}" class="img-icon">
                                هشتم
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                            <a class="btn btn-outline-dark" data-level-num="9">
                                <img src="{{ asset('images/level_second.png') }}" class="img-icon">
                                نهم
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                            <a class="btn btn-outline-dark" data-level-num="10">
                                <img src="{{ asset('images/level_third.png') }}" class="img-icon">
                                دهم
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                            <a class="btn btn-outline-dark" data-level-num="11">
                                <img src="{{ asset('images/level_third.png') }}" class="img-icon">
                                یازدهم
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                            <a class="btn btn-outline-dark" data-level-num="12">
                                <img src="{{ asset('images/level_third.png') }}" class="img-icon">
                                دوازدهم
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class=" mt-3">
                        <b>دسته بندی دروس (اختیاری)</b>
                    </div>

                    <div class="row mb-3 grouping-tags">
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                            <a class="btn btn-outline-dark" data-lesson-name="math">
                                <img src="{{ asset('images/math.png') }}" class="img-icon">
                                ریاضی
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                            <a class="btn btn-outline-dark" data-lesson-name="physics">
                                <img src="{{ asset('images/physics.png') }}" class="img-icon">
                                فیزیک
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                            <a class="btn btn-outline-dark" data-lesson-name="chemistry">
                                <img src="{{ asset('images/chemistry.png') }}" class="img-icon">
                                شیمی
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                            <a class="btn btn-outline-dark" data-lesson-name="biology">
                                <img src="{{ asset('images/biology.png') }}" class="img-icon">
                                زیست
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                            <a class="btn btn-outline-dark" data-lesson-name="earth">
                                <img src="{{ asset('images/earth.png') }}" class="img-icon">
                                زمین
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                            <a class="btn btn-outline-dark" data-lesson-name="poet">
                                <img src="{{ asset('images/poet.png') }}" class="img-icon">
                                ادبیات
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                            <a class="btn btn-outline-dark" data-lesson-name="arabic">
                                <img src="{{ asset('images/arabic.png') }}" class="img-icon">
                                عربی
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                            <a class="btn btn-outline-dark" data-lesson-name="english">
                                <img src="{{ asset('images/english.png') }}" class="img-icon">
                                انگلیسی
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                            <a class="btn btn-outline-dark" data-lesson-name="quran">
                                <img src="{{ asset('images/quran.png') }}" class="img-icon">
                                دینی
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                            <a class="btn btn-outline-dark" data-lesson-name="philosophy">
                                <img src="{{ asset('images/philosophy.png') }}" class="img-icon">
                                فلسفه
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                            <a class="btn btn-outline-dark" data-lesson-name="art">
                                <img src="{{ asset('images/art.png') }}" class="img-icon">
                                هنر
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                            <a class="btn btn-outline-dark" data-lesson-name="other">
                                <img src="{{ asset('images/other.png') }}" class="img-icon">
                                سایر
                            </a>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success py-2 float-start">ثبت سوال</button>
            </form>
        </div>
    </div>

    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ), {
                toolbar: [
                    'undo', 'redo',
                    '|', 'heading',
                    '|', 'bold', 'italic', 'link',
                    '|', 'bulletedList', 'numberedList'
                ],
                language: {
                    // The UI will be English.
                    ui: 'en',

                    // But the content will be edited in Arabic.
                    content: 'ar'
                }
            } )
            .then( editor => {
                window.editor = editor;
            } )
            .catch( err => {
                console.error( err.stack );
            } );

        $('.add-question-box button').click(function (e) {
            var title = $('.add-question-box input[name="title"]').val();
            var explain = $('.add-question-box .ck-editor__editable').html();

            if($.trim(title) === '') {
                e.preventDefault();
                $.sweetModal({
                    content: '<h4 class="f-iranSans">عنوان سوال نباید خالی باشد.</h4>',
                    icon: $.sweetModal.ICON_WARNING
                });
            } else if ($.trim(explain) === '<p><br data-cke-filler="true"></p>') {
                e.preventDefault();
                $.sweetModal({
                    content: '<h4 class="f-iranSans">توضیحات سوال نباید خالی باشد.</h4>',
                    icon: $.sweetModal.ICON_WARNING
                });
            } else {
                $('.add-question-box textarea[name="explain"]').html(explain);
            }
        });

        <?php if (isset($message)) { ?>
        $.sweetModal({
            content: '<h4 class="f-iranSans">{{ $message }}</h4>',
            icon: $.sweetModal.ICON_WARNING
        });
        <?php } else if (isset($message_success)) { ?>
        $.sweetModal({
            content: '<h4 class="f-iranSans">{{ $message_success }}</h4>',
            icon: $.sweetModal.ICON_SUCCESS,
            buttons: [
                {
                    label: '<span class="f-iranSans">متوجه شدم</span>',
                    classes: 'greenB'
                }
            ]
        });
        <?php } ?>
    </script>
@stop
