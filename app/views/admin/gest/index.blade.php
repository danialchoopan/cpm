@extends('admin.template.admin')
@section('title','نمایش اقساط')
@section('title_content','اقساط  ها')
@section('content')
    @include('admin.msg')
    @if(count($gests)!=0)
        <table class="table table-hover">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">کاربر</th>
                <th scope="col">شرایط</th>
            </tr>
            </thead>
            <tbody>
            @foreach($gests as $gest)
                <?php
                $car_adapter = new \App\database\adapter\CarAdapter();
                $apply_adapter = new \App\database\adapter\ApplyCarAdapter();
                ?>
                <tr>
                    <th scope="row">{{$gest['id'].""}}</th>
                    <td>{{user_auth_id($gest['user_id'])['full_name']}}</td>
                    <td>{{show_condition_by_id(
    $apply_adapter->find($gest['apply_id'])['condition_id'])['name']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="row m-1">
            <div class="col text-center">
                <h4>متاسفانه اقساطی برای نمایش وجود ندارد</h4>
            </div>
        </div>
    @endif
@endsection
