@extends('templates.for_content')
@section('title','درباره ما')
@section('content')
    <div class="card m-5">
        <div class="card-header">درباره ما</div>
        <div class="card-body p-3">
            @include('include.msg')
            {{get_setting()['about_us']}}
        </div>
    </div>
@endsection