@extends('templates.for_content')
@section('title','تماس با ما')
@section('content')


    <div class="card m-5">
        <div class="card-header">ارتباط با ما</div>
        <div class="card-body p-3">
            @include('include.msg')
            {{get_setting()['contact_us']}}
            <div class="m-1 text-primary">
                شماره تماس
                :
                {{get_setting()['phone_number']}}
            </div>
            <div class="m-1 text-primary">
                پست الکترونیک
                :
                {{get_setting()['email']}}
            </div>
        </div>
    </div>
@endsection