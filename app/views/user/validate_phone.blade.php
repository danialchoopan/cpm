@extends('templates.for_content')
@section('title','نام نویسی')
@section('content')
    <div class="cp-container-content d-flex justify-content-center">
        <div class="w-50 m-5">
            <div class="card">
                <?php
                if (!authUser())
                    redirect(route(''));

                if (authUser()['phone_confrimed'] == 1):
                    redirect(route(''));
                else:
                $user_adapter = new \App\database\adapter\UserTableAdapter();
                ?>
                <div class="card-header">تایید شماره همراه</div>
                <div class="card-body">
                    <div class="alert alert-info " role="alert">
                        <?php echo
                        $user_adapter->SEND_SMS_VALIDATION()
                        ?>
                    </div>
                    <form method="post" action="{{route('user/validate/phone/number')}}">
                        @include('include.msg')
                        <div class="form-group">
                            <label>کد تایید</label>
                            <input type="text" class="form-control" name="validate_code"
                                   placeholder="XXX-XXX-XXX"
                                   required>
                            <small class="form-text text-muted">ارسال کد ممکن است 2 تا 5 دقیقه طول بکشد لطفا
                                صبور باشید</small>
                        </div>
                        <input type="submit" class="btn btn-primary btn-block" value="تایید"/>
                        <a href="{{route('user/validate/phone')}}" class="btn btn-info btn-block">ارسال دوباره کد
                            تایید</a>
                        <small class="text-muted">اگر بعد 5 دقیقه کد به دست شما نرسید دوباره در خواست کنید </small>
                    </form>
                </div>
                <?php
                endif;
                ?>
            </div>
        </div>
    </div>
@endsection