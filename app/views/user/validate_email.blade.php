@extends('templates.for_content')
@section('title','تایید پست الکترونیک')
@section('content')
    <div class="cp-container-content d-flex justify-content-center">
        <div class="w-50 m-5">
            <div class="card">
                <?php
                if (!authUser())
                    redirect(route(''));
                if (authUser()['email_confrimed'] == 1):
                    redirect(route(''));
                else:
                $user_adapter = new \App\database\adapter\UserTableAdapter();
                ?>
                <div class="card-header">تایید پست الکترونیک</div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <?php
                        echo $user_adapter->SEND_EMAIL_VALIDATION();
                        ?>
                    </div>
                    <p>لینک تایید حساب به پست الکترونیک شما فرستاده شده</p>
                </div>
                <?php
                endif;
                ?>
            </div>
        </div>
    </div>
@endsection