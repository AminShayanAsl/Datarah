@extends('layout')

@section('title')
    <title>پروفایل</title>
@stop

@section('content')
    <!-- Page Header-->
    <header class="masthead" style="background-image: url({{ asset('images/profile-bg.jpg') }})">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="page-heading">
                        <h1>پروفایل</h1>
                        <span class="subheading">داده‌های مرتبط با شما در این قسمت قرار دارد.</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main Content-->
    <div class="container mb-5">
        <h4 class="fw-bold mb-4">اطلاعات شخصی</h4>
        <div class="user-info d-lg-flex d-block justify-content-between rounded-3 py-1 px-3">
            <?php
                if(!isset($_SESSION))
                {
                    session_start();
                }
            ?>
            <div class="mt-2 mb-2">
                <b>نام کاربری : </b>
                <span>{{ $_SESSION['auth']['display-name'] }}</span>
            </div>
            <div class="mt-2 mb-2">
                <b>ایمیل : </b>
                <span>{{ $_SESSION['auth']['email'] }}</span>
            </div>
            <div class="mt-2 mb-2" dir="ltr">
                <a href="{{ url('sign-out') }}" class="btn btn-danger">خروج</a>
            </div>
        </div>
        <hr>
        <h4 class="fw-bold mb-4 mt-5">
            سوالات ذخیره شده
            <i class="fa-solid fa-bookmark eastern-blue-text"></i>
        </h4>
        <?php if (!$bookmarks) { ?>
        <div class="alert alert-warning rounded-3 text-center py-3">
            <span class="h5">موردی یافت نشد.</span>
        </div>
        <?php } else {
        foreach ($bookmarks as $bookmark) { ?>
        <div class="item-box alert alert-secondary">
            <h5>{{ $bookmark->getQuestion()->getTitle() }}</h5>
            <span class="pr-num sub-label">{{ getJDate($bookmark->getQuestion()->getCreatedAt())->format('%A %d %B %Y ساعت %H:%M') }}</span><br>
            <hr>
            <a href="{{ url('question/?title='.$bookmark->getQuestion()->getTitle().'&created_at='.$bookmark->getQuestion()->getCreatedAt()->format('Y-m-d H:i:s')) }}" class="btn btn-outline-primary ms-2" target="_blank">صفحه سوال</a>
            <button class="show-more btn btn-outline-primary">نمایش بیشتر</button>
            <div class="more-box">
                <hr>
                <b>عنوان سوال</b>
                <p class="m-2 mb-3">
                {{ $bookmark->getQuestion()->getTitle() }}
                <div class="d-block mb-4">
                    <?php
                    for ($i=0; $i<2; $i++) {
                    if ($bookmark->getQuestion()->getTags()[$i] !== '') {
                    $tag = tagDetail($bookmark->getQuestion()->getTags()[$i]);
                    if (is_numeric($bookmark->getQuestion()->getTags()[$i])) {
                        $filter = 'level';
                    } else {
                        $filter = 'lesson';
                    }
                    ?>
                    <a href="{{ url('questions/?'.$filter.'='.$bookmark->getQuestion()->getTags()[$i]) }}" class="btn btn-outline-dark mx-1 tag">
                        <img src="{{ asset('images/'.$tag['image']) }}" class="img-icon">
                        {{ $tag['text'] }}
                    </a>
                    <?php }
                    }
                    ?>
                </div>
                </p>
                <b>توضیحات سوال</b>
                <p class="m-2">{!! $bookmark->getQuestion()->getContent() !!}</p>
            </div>
        </div>
        <?php }
        } ?>
        <hr>
        <h4 class="fw-bold mb-4 mt-5">
            سوالات در صف انتظار
            <i class="fa-regular fa-hourglass-half text-secondary"></i>
        </h4>
        <?php if (count($questions['waited']) == 0) { ?>
        <div class="alert alert-warning rounded-3 text-center py-3">
            <span class="h5">موردی یافت نشد.</span>
        </div>
        <?php } else {
            foreach ($questions['waited'] as $question) { ?>
            <div class="item-box alert alert-secondary">
                <h5>{{ $question->getTitle() }}</h5>
                <span class="pr-num sub-label">{{ getJDate($question->getCreatedAt())->format('%A %d %B %Y ساعت %H:%M') }}</span><br>
                <hr>
                <button class="show-more btn btn-outline-primary">نمایش بیشتر</button>
                <?php
                if ($_SESSION['auth']['user-type'] === 'admin') {
                ?>
                <a href="confirmation-question/?q-id={{ $question->getId() }}" class="btn btn-outline-success float-start mx-2">تایید</a>
                <a class="btn-reject btn btn-outline-danger float-start mx-2">عدم تایید</a>
                <div class="reject-box pb-5">
                    <hr>
                    <b>دلیل عدم تایید</b>
                    <form action="{{ url('comment-question/') }}" method="POST" class="mt-2">
                        {{ csrf_field() }}
                        <input class="d-none" name="q-id" type="text" value="{{ $question->getId() }}">
                        <textarea class="editor" name="comment"></textarea>
                        <button type="submit" class="btn btn-outline-danger float-start mt-3">ثبت</button>
                    </form>
                </div>
                <?php
                }
                ?>
                <div class="more-box">
                    <hr>
                    <b>عنوان سوال</b>
                    <p class="m-2 mb-3">
                        {{ $question->getTitle() }}
                        <div class="d-block mb-4">
                            <?php
                            for ($i=0; $i<2; $i++) {
                            if ($question->getTags()[$i] !== '') {
                            $tag = tagDetail($question->getTags()[$i]);
                            if (is_numeric($question->getTags()[$i])) {
                                $filter = 'level';
                            } else {
                                $filter = 'lesson';
                            }
                            ?>
                            <a href="{{ url('questions/?'.$filter.'='.$question->getTags()[$i]) }}" class="btn btn-outline-dark mx-1 tag">
                                <img src="{{ asset('images/'.$tag['image']) }}" class="img-icon">
                                {{ $tag['text'] }}
                            </a>
                            <?php }
                            }
                            ?>
                        </div>
                    </p>
                    <b>توضیحات سوال</b>
                    <p class="m-2">{!! $question->getContent() !!}</p>
                </div>
            </div>
        <?php }
        } ?>
        <h4 class="fw-bold mb-4 mt-5">
            سوالات تایید شده
            <i class="fa-regular fa-circle-check text-success"></i>
        </h4>
        <?php if (count($questions['confirmed']) == 0) { ?>
        <div class="alert alert-warning rounded-3 text-center py-3">
            <span class="h5">موردی یافت نشد.</span>
        </div>
        <?php } else {
        foreach ($questions['confirmed'] as $question) { ?>
        <div class="item-box alert alert-secondary">
            <h5>{{ $question->getTitle() }}</h5>
            <span class="pr-num sub-label">{{ getJDate($question->getCreatedAt())->format('%A %d %B %Y ساعت %H:%M') }}</span><br>
            <hr>
            <a href="{{ url('question/?title='.$question->getTitle().'&created_at='.$question->getCreatedAt()->format('Y-m-d H:i:s')) }}" class="btn btn-outline-primary ms-2" target="_blank">صفحه سوال</a>
            <button class="show-more btn btn-outline-primary">نمایش بیشتر</button>
            <div class="more-box">
                <hr>
                <b>عنوان سوال</b>
                <p class="m-2 mb-3">
                {{ $question->getTitle() }}
                <div class="d-block mb-4">
                    <?php
                    for ($i=0; $i<2; $i++) {
                    if ($question->getTags()[$i] !== '') {
                    $tag = tagDetail($question->getTags()[$i]);
                    if (is_numeric($question->getTags()[$i])) {
                        $filter = 'level';
                    } else {
                        $filter = 'lesson';
                    }
                    ?>
                    <a href="{{ url('questions/?'.$filter.'='.$question->getTags()[$i]) }}" class="btn btn-outline-dark mx-1 tag">
                        <img src="{{ asset('images/'.$tag['image']) }}" class="img-icon">
                        {{ $tag['text'] }}
                    </a>
                    <?php }
                    }
                    ?>
                </div>
                </p>
                <b>توضیحات سوال</b>
                <p class="m-2">{!! $question->getContent() !!}</p>
            </div>
        </div>
        <?php }
        } ?>
        <h4 class="fw-bold mb-4 mt-5">
            سوالات رد شده
            <i class="fa-regular fa-circle-xmark text-danger"></i>
        </h4>
        <?php if (count($questions['rejected']) == 0) { ?>
        <div class="alert alert-warning rounded-3 text-center py-3">
            <span class="h5">موردی یافت نشد.</span>
        </div>
        <?php } else {
        foreach ($questions['rejected'] as $question) { ?>
        <div class="item-box alert alert-secondary">
            <h5>{{ $question->getTitle() }}</h5>
            <span class="pr-num sub-label">{{ getJDate($question->getCreatedAt())->format('%A %d %B %Y ساعت %H:%M') }}</span><br>
            <hr>
            <button class="show-more btn btn-outline-primary ms-2">نمایش بیشتر</button>
            <button class="reject-reason btn btn-outline-danger">دلیل عدم تایید</button>
            <div class="more-box">
                <hr>
                <b>عنوان سوال</b>
                <p class="m-2 mb-3">
                {{ $question->getTitle() }}
                <div class="d-block mb-4">
                    <?php
                    for ($i=0; $i<2; $i++) {
                    if ($question->getTags()[$i] !== '') {
                    $tag = tagDetail($question->getTags()[$i]);
                    if (is_numeric($question->getTags()[$i])) {
                        $filter = 'level';
                    } else {
                        $filter = 'lesson';
                    }
                    ?>
                    <a href="{{ url('questions/?'.$filter.'='.$question->getTags()[$i]) }}" class="btn btn-outline-dark mx-1 tag">
                        <img src="{{ asset('images/'.$tag['image']) }}" class="img-icon">
                        {{ $tag['text'] }}
                    </a>
                    <?php }
                    }
                    ?>
                </div>
                </p>
                <b>توضیحات سوال</b>
                <p class="m-2">{!! $question->getContent() !!}</p>
            </div>
            <div class="reject-reason-box">
                <hr>
                <b>دلیل عدم تایید</b>
                <p class="m-2">
                    {!! $question->getComment() !!}
                </p>
            </div>
        </div>
        <?php }
        } ?>
        <hr>
        <h4 class="fw-bold mb-4 mt-5">
            پاسخ‌های در صف انتظار
            <i class="fa-regular fa-hourglass-half text-secondary"></i>
        </h4>
        <?php if (count($answers['waited']) == 0) { ?>
        <div class="alert alert-warning rounded-3 text-center py-3">
            <span class="h5">موردی یافت نشد.</span>
        </div>
        <?php } else {
        foreach ($answers['waited'] as $answer) { ?>
        <div class="item-box alert alert-secondary">
            <h5>{!! $answer->getContent() !!}</h5>
            <span class="pr-num sub-label">{{ getJDate($answer->getCreatedAt())->format('%A %d %B %Y ساعت %H:%M') }}</span><br>
            <hr>
            <button class="show-more btn btn-outline-primary">نمایش بیشتر</button>
            <?php
            if ($_SESSION['auth']['user-type'] === 'admin') {
            ?>
            <a href="confirmation-answer/?a-id={{ $answer->getId() }}" class="btn btn-outline-success float-start mx-2">تایید</a>
            <a class="btn-reject btn btn-outline-danger float-start mx-2">عدم تایید</a>
            <div class="reject-box pb-5">
                <hr>
                <b>دلیل عدم تایید</b>
                <form action="{{ url('comment-answer/') }}" method="POST" class="mt-2">
                    {{ csrf_field() }}
                    <input class="d-none" name="a-id" type="text" value="{{ $answer->getId() }}">
                    <textarea class="editor" name="comment"></textarea>
                    <button type="submit" class="btn btn-outline-danger float-start mt-3">ثبت</button>
                </form>
            </div>
            <?php
            }
            ?>
            <div class="more-box">
                <hr>
                <b>عنوان سوال</b>
                <p class="m-2 mb-3">
                {{ $answer->getQuestion()->getTitle() }}
                <div class="d-block mb-4">
                    <?php
                    for ($i=0; $i<2; $i++) {
                    if ($answer->getQuestion()->getTags()[$i] !== '') {
                    $tag = tagDetail($answer->getQuestion()->getTags()[$i]);
                    if (is_numeric($answer->getQuestion()->getTags()[$i])) {
                        $filter = 'level';
                    } else {
                        $filter = 'lesson';
                    }
                    ?>
                    <a href="{{ url('questions/?'.$filter.'='.$answer->getQuestion()->getTags()[$i]) }}" class="btn btn-outline-dark mx-1 tag">
                        <img src="{{ asset('images/'.$tag['image']) }}" class="img-icon">
                        {{ $tag['text'] }}
                    </a>
                    <?php }
                    }
                    ?>
                </div>
                </p>
                <b>توضیحات سوال</b>
                <p class="m-2 mb-3">{!! $answer->getQuestion()->getContent() !!}</p>
                <b>پاسخ سوال</b>
                <p class="m-2">{!! $answer->getContent() !!}</p>
            </div>
        </div>
        <?php }
        } ?>
        <h4 class="fw-bold mb-4 mt-5">
            پاسخ‌های تایید شده
            <i class="fa-regular fa-circle-check text-success"></i>
        </h4>
        <?php if (count($answers['confirmed']) == 0) { ?>
        <div class="alert alert-warning rounded-3 text-center py-3">
            <span class="h5">موردی یافت نشد.</span>
        </div>
        <?php } else {
        foreach ($answers['confirmed'] as $answer) { ?>
        <div class="item-box alert alert-secondary">
            <h5>{!! $answer->getContent() !!}</h5>
            <span class="pr-num sub-label">{{ getJDate($answer->getCreatedAt())->format('%A %d %B %Y ساعت %H:%M') }}</span><br>
            <hr>
            <a href="{{ url('question/?title='.$answer->getQuestion()->getTitle().'&created_at='.$answer->getQuestion()->getCreatedAt()->format('Y-m-d H:i:s')) }}" class="btn btn-outline-primary ms-2" target="_blank">صفحه سوال</a>
            <button class="show-more btn btn-outline-primary">نمایش بیشتر</button>
            <div class="more-box">
                <hr>
                <b>عنوان سوال</b>
                <p class="m-2 mb-3">
                {{ $answer->getQuestion()->getTitle() }}
                <div class="d-block mb-4">
                    <?php
                    for ($i=0; $i<2; $i++) {
                    if ($answer->getQuestion()->getTags()[$i] !== '') {
                    $tag = tagDetail($answer->getQuestion()->getTags()[$i]);
                    if (is_numeric($answer->getQuestion()->getTags()[$i])) {
                        $filter = 'level';
                    } else {
                        $filter = 'lesson';
                    }
                    ?>
                    <a href="{{ url('questions/?'.$filter.'='.$answer->getQuestion()->getTags()[$i]) }}" class="btn btn-outline-dark mx-1 tag">
                        <img src="{{ asset('images/'.$tag['image']) }}" class="img-icon">
                        {{ $tag['text'] }}
                    </a>
                    <?php }
                    }
                    ?>
                </div>
                </p>
                <b>توضیحات سوال</b>
                <p class="m-2 mb-3">{!! $answer->getQuestion()->getContent() !!}</p>
                <b>پاسخ سوال</b>
                <p class="m-2">{!! $answer->getContent() !!}</p>
            </div>
        </div>
        <?php }
        } ?>
        <h4 class="fw-bold mb-4 mt-5">
            پاسخ‌های رد شده
            <i class="fa-regular fa-circle-xmark text-danger"></i>
        </h4>
        <?php if (count($answers['rejected']) == 0) { ?>
        <div class="alert alert-warning rounded-3 text-center py-3">
            <span class="h5">موردی یافت نشد.</span>
        </div>
        <?php } else {
        foreach ($answers['rejected'] as $answer) { ?>
        <div class="item-box alert alert-secondary">
            <h5>{!! $answer->getContent() !!}</h5>
            <span class="pr-num sub-label">{{ getJDate($answer->getCreatedAt())->format('%A %d %B %Y ساعت %H:%M') }}</span><br>
            <hr>
            <button class="show-more btn btn-outline-primary ms-2">نمایش بیشتر</button>
            <button class="reject-reason btn btn-outline-danger">دلیل عدم تایید</button>
            <div class="more-box">
                <hr>
                <b>عنوان سوال</b>
                <p class="m-2 mb-3">
                {{ $answer->getQuestion()->getTitle() }}
                <div class="d-block mb-4">
                    <?php
                    for ($i=0; $i<2; $i++) {
                    if ($answer->getQuestion()->getTags()[$i] !== '') {
                    $tag = tagDetail($answer->getQuestion()->getTags()[$i]);
                    if (is_numeric($answer->getQuestion()->getTags()[$i])) {
                        $filter = 'level';
                    } else {
                        $filter = 'lesson';
                    }
                    ?>
                    <a href="{{ url('questions/?'.$filter.'='.$answer->getQuestion()->getTags()[$i]) }}" class="btn btn-outline-dark mx-1 tag">
                        <img src="{{ asset('images/'.$tag['image']) }}" class="img-icon">
                        {{ $tag['text'] }}
                    </a>
                    <?php }
                    }
                    ?>
                </div>
                </p>
                <b>توضیحات سوال</b>
                <p class="m-2 mb-3">{!! $answer->getQuestion()->getContent() !!}</p>
                <b>پاسخ سوال</b>
                <p class="m-2">{!! $answer->getContent() !!}</p>
            </div>
            <div class="reject-reason-box">
                <hr>
                <b>دلیل عدم تایید</b>
                <p class="m-2">
                    {!! $answer->getComment() !!}
                </p>
            </div>
        </div>
        <?php }
        } ?>
    </div>
    <script>
        while (document.querySelector( '.editor' )) {
            ClassicEditor
                .create( document.querySelector( '.editor' ), {
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
            document.querySelector( '.editor' ).classList.remove('editor');
        }

        $('.reject-box button').click(function () {
            var comment = $('.reject-box .ck-editor__editable').html();
            if ($.trim(comment) !== '<p><br data-cke-filler="true"></p>') {
                $('.reject-box textarea[name="comment"]').html(comment);
            }
        });
    </script>
@stop

