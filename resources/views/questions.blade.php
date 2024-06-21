@extends('layout')

@section('title')
    <title>سوالات</title>
@stop

@section('content')
    <!-- Page Header-->
    <header class="masthead" style="background-image: url({{ asset('images/questions-bg.jpg') }})">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="page-heading">
                        <h1>سوالات</h1>
                        <span class="subheading">لیست تمامی سوالات را در قسمت پایین مشاهده می‌کنید.</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main Content-->
    <div class="container mb-5">
        <div class="filter-box border border-secondary rounded-3 p-3 mb-4">
            <form action="{{ url('questions/') }}" method="get" class="d-xl-flex justify-content-xl-between d-block text-center">
                <select class="form-select mx-xl-2 my-lx-0 my-3 m-auto" name="level">
                    <option value="all" selected>دسته بندی پایه‌ها</option>
                    <option value="1">اول</option>
                    <option value="2">دوم</option>
                    <option value="3">سوم</option>
                    <option value="4">چهارم</option>
                    <option value="5">پنجم</option>
                    <option value="6">ششم</option>
                    <option value="7">هفتم</option>
                    <option value="8">هشتم</option>
                    <option value="9">نهم</option>
                    <option value="10">دهم</option>
                    <option value="11">یازدهم</option>
                    <option value="12">دوازدهم</option>
                </select>
                <select class="form-select mx-xl-2 my-lx-0 my-3 m-auto" name="lesson">
                    <option value="all" selected>دسته بندی دروس</option>
                    <option value="math">ریاضی</option>
                    <option value="physics">فیزیک</option>
                    <option value="chemistry">شیمی</option>
                    <option value="biology">زیست</option>
                    <option value="earth">زمین</option>
                    <option value="poet">ادبیات</option>
                    <option value="arabic">عربی</option>
                    <option value="english">انگلیسی</option>
                    <option value="quran">دینی</option>
                    <option value="philosophy">فلسفه</option>
                    <option value="art">هنر</option>
                    <option value="other">سایر</option>
                </select>
                <select class="form-select mx-xl-2 my-lx-0 my-3 m-auto" name="sort">
                    <option value="default" selected>مرتب سازی</option>
                    <option value="new">جدیدترین</option>
                    <option value="old">قدیمی‌ترین</option>
                </select>
                <button type="submit" class="btn btn-success mx-lx-2 my-lx-0 my-2">اعمال فیلتر</button>
            </form>
        </div>
        <div class="row d-flex mb-3">
            <div class="not-found text-secondary text-center h5 mt-4 d-none">هیچ موردی یافت نشد.</div>
            <?php
            foreach ($questions as $question) {
            ?>
            <div class="question col-12 col-xl-4 col-md-6 px-2">
                <a href="{{ url('question/?title='.$question->getTitle().'&created_at='.$question->getCreatedAt()->format('Y-m-d H:i:s')) }}" class="text-decoration-none" target="_blank">
                    <div class="item-box alert alert-secondary text-center">
                        <h5 class="text-dark mb-2">{{ $question->getTitle() }}</h5>
                        <span class="pr-num sub-label">{{ getJDate($question->getCreatedAt())->format('%A %d %B %Y ساعت %H:%M') }}</span><br>
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
                        <div class="sub-label">{{ $question->getUser()->getDisplayName() }}</div>
                    </div>
                </a>
            </div>
            <?php } ?>
        </div>
        <nav aria-label="page navigation" dir="ltr">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if ($pages_info['current_page'] == 1) { ?>disabled<?php } ?>">
                    <a class="page-link <?php if ($pages_info['current_page'] == 1) { ?>disabled<?php } ?>"  href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PATH_INFO'].'?level='.$data['level'].'&lesson='.$data['lesson'].'&sort='.$data['sort'].'&page='.(string)($pages_info['current_page']-1) ?>" tabindex="-1">&laquo;</a>
                </li>
                <?php
                for ($i=1; $i<=$pages_info['pages_count']; $i++) {
                ?>
                <li class="page-item <?php if ($pages_info['current_page'] == $i) { ?>active<?php } ?>">
                    <a class="page-link pr-num" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PATH_INFO'].'?level='.$data['level'].'&lesson='.$data['lesson'].'&sort='.$data['sort'].'&page='.(string)($i) ?>">
                        {{ $i }}
                    </a>
                </li>
                <?php
                }
                ?>
                <li class="page-item">
                    <a class="page-link <?php if ($pages_info['current_page'] == $pages_info['pages_count']) { ?>disabled<?php } ?>" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PATH_INFO'].'?level='.$data['level'].'&lesson='.$data['lesson'].'&sort='.$data['sort'].'&page='.(string)($pages_info['current_page']+1) ?>">&raquo;</a>
                </li>
            </ul>
        </nav>
    </div>
    <script>
        <?php
        if ($data['level'] !== 'default') {
        ?>
            $('option[value=<?php echo $data['level']; ?>]').attr("selected","selected");
        <?php
        }
        if ($data['lesson'] !== 'all') {
        ?>
        $('option[value=<?php echo $data['lesson']; ?>]').attr("selected","selected");
        <?php
        }
        if ($data['sort'] !== 'all') {
        ?>
        $('option[value=<?php echo $data['sort']; ?>]').attr("selected","selected");
        <?php
        }
        ?>

        if ($('.question').length === 0) {
            $('.not-found').removeClass('d-none');
            $('.pagination').addClass('d-none');
        }
    </script>
@stop
