@extends('layout')

@section('title')
    <title>دیتا راه</title>
@stop

@section('content')
    <!-- Page Header-->
    <header class="masthead" style="background-image: url({{ asset('images/home-bg.jpg') }})">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="page-heading">
                        <h1 class="eastern-blue-bg rounded-4 home-header">دیتاراه</h1>
                        <span class="subheading">راهی برای رسیدن به دیتا</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main Content-->
    <div class="container">
        <div class="row eastern-blue-bg text-light rounded-3 p-3 mb-5" id="explain">
            <div class="col-lg-6 mb-sm-3">
                <h3 class="mb-3 mt-4 fw-bolder">پلتفرم دیتاراه چیست؟</h3>
                ما در <span class="fw-bold">دیتاراه</span> برای دانش آموزان بستری ساخته‌ایم که بتوانند تمامی
                اشکالات درسی خود را از دیگران بپرسند، به اشکالات دیگر دانش آموزان پاسخ دهند و به سوالات و پاسخ های
                سایرین رأی دهند تا هیچ دانش آموز مستعدی در این عصر تکنولوژی، انرژی و زمان خود را صرف اشکالات درسی
                خود نکند بلکه با هم فکری دوستان و سایر دانش آموزان بهترین پاسخ را برای اشکالات خود بیابد.
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ asset('images/question.png') }}">
            </div>
        </div>

        <div class="scroll-horizontal pattens-blue-bg row mb-5 px-3 rounded-3">
            <div class="d-flex justify-content-between mt-3">
                <div>
                    <b>بهترین سوالات</b>
                    <img src="{{ asset('images/best_questions.png') }}" class="img-icon">
                </div>
            </div>
            <div class="mt-2 mb-3 items">
                <?php
                foreach ($best_questions as $best_question) {
                ?>
                <a href="{{ url('question/?title='.$best_question['question']->getTitle().'&created_at='.$best_question['question']->getCreatedAt()->format('Y-m-d H:i:s')) }}" class="item text-decoration-none eastern-blue-bg rounded-2 text-light text-center" target="_blank">
                    <div class="h4 px-2 py-3">
                        {{ $best_question['question']->getTitle() }}
                    </div>
                    <span class="pr-num">{{ getJDate($best_question['question']->getCreatedAt())->format('%A %d %B %Y ساعت %H:%M') }}</span><br>
                    <div class="my-2">
                        <?php
                        for ($i=0; $i<2; $i++) {
                        if ($best_question['question']->getTags()[$i] !== '') {
                        $tag = tagDetail($best_question['question']->getTags()[$i]);
                        ?>
                        <div class="btn btn-outline-light mx-1 tag">
                            <img src="{{ asset('images/'.$tag['image']) }}" class="img-icon">
                            {{ $tag['text'] }}
                        </div>
                        <?php }
                        }
                        ?>
                    </div>
                    <div>{{ $best_question['question']->getUser()->getDisplayName() }}</div>
                    <div class="pr-num mt-1">{{ $best_question['vote'] }} رأی</div>
                </a>
                <?php
                }
                ?>
            </div>
        </div>

        <div class="scroll-horizontal eastern-blue-bg row mb-5 px-3 rounded-3">
            <div class="d-flex justify-content-between mt-3">
                <div>
                    <b class="text-light">جدیدترین سوالات</b>
                    <img src="{{ asset('images/new_questions.png') }}" class="img-icon">
                </div>
            </div>
            <div class="mt-2 mb-3 items">
                <?php
                foreach ($questions as $question) {
                ?>
                <a href="{{ url('question/?title='.$question->getTitle().'&created_at='.$question->getCreatedAt()->format('Y-m-d H:i:s')) }}" class="item text-decoration-none pattens-blue-bg rounded-2 text-dark text-center" target="_blank">
                    <div class="h4 px-2 py-3">
                        {{ $question->getTitle() }}
                    </div>
                    <span class="pr-num">{{ getJDate($question->getCreatedAt())->format('%A %d %B %Y ساعت %H:%M') }}</span><br>
                    <div class="my-2">
                        <?php
                        for ($i=0; $i<2; $i++) {
                        if ($question->getTags()[$i] !== '') {
                        $tag = tagDetail($question->getTags()[$i]);
                        ?>
                        <div class="btn btn-outline-dark mx-1 tag">
                            <img src="{{ asset('images/'.$tag['image']) }}" class="img-icon">
                            {{ $tag['text'] }}
                        </div>
                        <?php }
                        }
                        ?>
                    </div>
                    <div>{{ $question->getUser()->getDisplayName() }}</div>
                </a>
                <?php
                }
                ?>
            </div>
        </div>

        <div class="row pattens-blue-bg mb-5 px-3 rounded-3" id="grouping">
            <div class="mt-3">
                <b>دسته بندی پایه‌ها</b>
                <img src="{{ asset('images/levels.png') }}" class="img-icon">
            </div>

            <div class="row mb-3 grouping">
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3">
                    <a href="{{ url('/questions?level=1') }}" class="btn btn-outline-dark">
                        <img src="{{ asset('images/level_first.png') }}" class="img-icon">
                        اول
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3">
                    <a href="{{ url('/questions?level=2') }}" class="btn btn-outline-dark">
                        <img src="{{ asset('images/level_first.png') }}" class="img-icon">
                        دوم
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3">
                    <a href="{{ url('/questions?level=3') }}" class="btn btn-outline-dark">
                        <img src="{{ asset('images/level_first.png') }}" class="img-icon">
                        سوم
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3">
                    <a href="{{ url('/questions?level=4') }}" class="btn btn-outline-dark">
                        <img src="{{ asset('images/level_first.png') }}" class="img-icon">
                        چهارم
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3">
                    <a href="{{ url('/questions?level=5') }}" class="btn btn-outline-dark">
                        <img src="{{ asset('images/level_first.png') }}" class="img-icon">
                        پنجم
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3">
                    <a href="{{ url('/questions?level=6') }}" class="btn btn-outline-dark">
                        <img src="{{ asset('images/level_first.png') }}" class="img-icon">
                        ششم
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3">
                    <a href="{{ url('/questions?level=7') }}" class="btn btn-outline-dark">
                        <img src="{{ asset('images/level_second.png') }}" class="img-icon">
                        هفتم
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3">
                    <a href="{{ url('/questions?level=8') }}" class="btn btn-outline-dark">
                        <img src="{{ asset('images/level_second.png') }}" class="img-icon">
                        هشتم
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3">
                    <a href="{{ url('/questions?level=9') }}" class="btn btn-outline-dark">
                        <img src="{{ asset('images/level_second.png') }}" class="img-icon">
                        نهم
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3">
                    <a href="{{ url('/questions?level=10') }}" class="btn btn-outline-dark">
                        <img src="{{ asset('images/level_third.png') }}" class="img-icon">
                        دهم
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3">
                    <a href="{{ url('/questions?level=11') }}" class="btn btn-outline-dark">
                        <img src="{{ asset('images/level_third.png') }}" class="img-icon">
                        یازدهم
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3">
                    <a href="{{ url('/questions?level=12') }}" class="btn btn-outline-dark">
                        <img src="{{ asset('images/level_third.png') }}" class="img-icon">
                        دوازدهم
                    </a>
                </div>
            </div>
        </div>

        <div class="row eastern-blue-bg text-light mb-5 px-3 rounded-3">
            <div class="mt-3">
                <b>دسته بندی دروس</b>
                <img src="{{ asset('images/lessons.png') }}" class="img-icon">
            </div>

            <div class="row mb-3 grouping">
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3">
                    <a href="{{ url('/questions?lesson=math') }}" class="btn btn-outline-light">
                        <img src="{{ asset('images/math.png') }}" class="img-icon">
                        ریاضی
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3">
                    <a href="{{ url('/questions?lesson=physics') }}" class="btn btn-outline-light">
                        <img src="{{ asset('images/physics.png') }}" class="img-icon">
                        فیزیک
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3">
                    <a href="{{ url('/questions?lesson=chemistry') }}" class="btn btn-outline-light">
                        <img src="{{ asset('images/chemistry.png') }}" class="img-icon">
                        شیمی
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3">
                    <a href="{{ url('/questions?lesson=biology') }}" class="btn btn-outline-light">
                        <img src="{{ asset('images/biology.png') }}" class="img-icon">
                        زیست
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3">
                    <a href="{{ url('/questions?lesson=earth') }}" class="btn btn-outline-light">
                        <img src="{{ asset('images/earth.png') }}" class="img-icon">
                        زمین
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3">
                    <a href="{{ url('/questions?lesson=poet') }}" class="btn btn-outline-light">
                        <img src="{{ asset('images/poet.png') }}" class="img-icon">
                        ادبیات
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3">
                    <a href="{{ url('/questions?lesson=arabic') }}" class="btn btn-outline-light">
                        <img src="{{ asset('images/arabic.png') }}" class="img-icon">
                        عربی
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3">
                    <a href="{{ url('/questions?lesson=english') }}" class="btn btn-outline-light">
                        <img src="{{ asset('images/english.png') }}" class="img-icon">
                        انگلیسی
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3">
                    <a href="{{ url('/questions?lesson=quran') }}" class="btn btn-outline-light">
                        <img src="{{ asset('images/quran.png') }}" class="img-icon">
                        دینی
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3">
                    <a href="{{ url('/questions?lesson=philosophy') }}" class="btn btn-outline-light">
                        <img src="{{ asset('images/philosophy.png') }}" class="img-icon">
                        فلسفه
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3">
                    <a href="{{ url('/questions?lesson=art') }}" class="btn btn-outline-light">
                        <img src="{{ asset('images/art.png') }}" class="img-icon">
                        هنر
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3">
                    <a href="{{ url('/questions?lesson=other') }}" class="btn btn-outline-light">
                        <img src="{{ asset('images/other.png') }}" class="img-icon">
                        سایر
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop
