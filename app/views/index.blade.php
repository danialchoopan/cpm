@include('templates.header')
<section class="cp-header-slider">
    @include('include.msg')
</section>
<section class="cp-dialog-header">
    <div>
        <p>فرصت بی نظیر برای خرید خودرو دلخواه با شرایط پرداخت آسان</p>
        <p>خودرو مورد علاقه خود را اقساطی بخرید ، فروش اقساطی خودرو از شرکت معتبر</p>
    </div>
    <div class="cp-btn-holder-header">
        <a href="" class="cp-btn">تلفن های تماس</a>
        <a href="" class="cp-btn cp-btn-white">درباره شرکت دانیال خودرو فروشی</a>
    </div>
</section>
</header>
<section class="cp-section-index-page">
    <article class="cp-row cp-introduction">
        <h1>فروش اقساطی خودرو</h1>
        <p>{{get_setting()['site_description']}}</p>
    </article>

    <article class="cp-article-terms">
        <section>

        </section>
        <section>
            <h1>
                فروش اقساطی خودرو با شرایط آسان و تحویل فوری
            </h1>

            <p class="rtl">
                در حال حاضر با توجه به تولید انواع مختلف خودروهای داخلی و خارجی با مدل‌ها و قیمت‌های متنوع، نیاز به
                خرید و یا تعویض خودرو بیش از پیش احساس می‌شود و بسیاری از مردم درصدد خرید خودروی دلخواه خود هستند.
                اگر به خرید خوردرو فکر می‌کنید اما بودجه‌ی لازم برای خرید خودروی مورد علاقه‌تان را در اختیار ندارید،
                این مژده را به شما می‌دهیم که نیازی نیست نگران پرداخت تمام هزینه‌ی لازم برای خرید خودروی مورد نظرتان
                باشید. شرکت سپند خودرو آریا با طرح فروش اقساطی خودرو با تحویل فوری این امکان را برای شما فراهم کرده
                است تا بتوانید پس از خرید خودرو، هزینه‌ی خودروی مورد نظرتان را به صورت اقساط بلند مدت تا 36 ماه
                پرداخت کنید.
            </p>

            <p class="rtl">
                لازم به ذکر است که فروش اقساطی خودرو در شرکت سپند خودرو آریا صرفا به صورت تحویل فوری انجام شده و
                هیچگونه پیش فروش خودرو و یا فروش اقساطی خودرو با تحویل مدت دار در این مجموعه صورت نمی‌پذیرد. کافیست
                خودروی مورد نظرتان را انتخاب کرده و پس از پرداخت بخشی از قیمت خودرو به عنوان پیش پرداخت، مابقی هزینه
                را به صورت اقساط بلند مدت 24 تا 36 ماهه به صورت هر 2 ماه 1 فقره چک پرداخت نمایید. شرکت سپند خودرو
                آریا با شماره ثبت 446306 دارای جواز فعالیت از اتحادیه اتومبیل فروشان با درجه کیفی 1 و از اعضا رسمی
                انجمن صنفی واردکنندگان خودرو به شماره عضویت 1020، شرکتی قابل اعتماد جهت خرید خودرو می‌باشد. جهت
                اطلاع از جزئیات شرایط خرید اقساطی خودرو کافیست با کارشناسان شرکت سپند خودرو آریا تماس بگیرید و
                مشاوره رایگان دریافت کنید.
            </p>
        </section>
    </article>
    <article class="cp-row ">
        <h1>فروش اقساطی و نقدی خودرو های</h1>
        <section class="cp-brand cp-d-flex">
            @foreach($brands as $brand)
                <?php
                $photo_adapter = new \App\database\adapter\PhotoAdapter();
                ?>
                <a href="{{route("car/brand/$brand[id]")}}" style="text-decoration: none">
                    <div class="cp-card rtl">
                        <img src="{{show_img_user($photo_adapter->find($brand['photo_id'])['name'])}}" alt=""
                             width="100%">
                        <p class="cp-card-title">{{$brand['name']}}</p>
                        <p class="cp-card-description">{{$brand['description']}}</p>
                    </div>
                </a>
            @endforeach
        </section>
    </article>


    <article class="cp-row ">
        <h1>آخرین پست های بلاگ</h1>
        <section class="cp-brand cp-d-flex">
            @foreach($latest_posts as $post)
                <?php
                $photo_adapter = new \App\database\adapter\PhotoAdapter();
                ?>
                <a href="{{route("blog/show/$post[id]")}}" style="text-decoration: none">
                    <div class="cp-card rtl">
                        <img src="{{show_img_user($photo_adapter->find($post['photo_id'])['name'])}}" alt=""
                             width="100%">
                        <p class="cp-card-title">{{$post['title']}}</p>
                        <p class="cp-card-description">{{substr($post['body'],0,200)}}</p>
                    </div>
                </a>
            @endforeach
        </section>
    </article>
</section>

@if(authUser() && !authUser()['phone_confrimed'])
    <div class="modal" tabindex="-1" id="Modal_show_msg_user">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="alert alert-warning text-center">
                        لطفا شماره همرا خود را تایید کنید برای در خواست خرید خودرو ابتدا باید شماره همراه خود را تایید
                        کنید
                    </div>
                    <button type="button" class="btn btn-primary btn-block" data-dismiss="modal">باشه</button>
                </div>
            </div>
        </div>
    </div>
@endif


@include('templates.footer')