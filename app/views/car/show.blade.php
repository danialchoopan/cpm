@extends('templates.for_content')
@section('title','خودرو')
@section('content')
    <?php
    $conditions = unserialize($car['condition_id']);
    ?>
    <div class="cp-container-content">
        <div class="card m-3">
            <div class="card-header">
                <h4>{{$car['name']}}</h4>
            </div>
            <div class="card-body">
                <div class="row ">
                    <div class="col m-3">
                        <h4>{{$car['name']}}</h4>
                        <p>{{$car['description']}}</p>
                    </div>
                    <div class="col m-3">
                        <img src="{{show_by_photo_id($car['photo_id'])}}" width="100%" alt="">
                        <p>شرایط فروش</p>
                        <ul>
                            @foreach($conditions as $condition)
                                <li>{{show_condition_by_id($condition)['name']}}</li>
                            @endforeach
                        </ul>

                        @if(authUser() && authUser()['phone_confrimed'])
                            <form method="post"
                                  action="{{route("car/show/$car[id]/complete/request")}}">
                                <div class="form-group m-3">
                                    <label>امتخاب شرایط: </label>
                                    <select class="form-control" name="condition_id">
                                        @foreach($conditions as $condition)
                                            <option value="{{show_condition_by_id($condition)['id']}}">
                                                {{show_condition_by_id($condition)['name']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group m-3">
                                    <input class="form-control btn btn-primary btn-block mt-2" type="submit"
                                           value="درخواست">
                                </div>
                            </form>
                        @endif

                        @if(!authUser())
                            <div class="alert alert-warning">
                                برای درخواست خودرو باید وارد شوید
                            </div>
                        @else
                            @if(!authUser()['phone_confrimed'])
                                <div class="alert alert-warning">
                                    <p>
                                        برای در خواست خودرو ابتدا باید شماره همراه خود را تایید کنید
                                    </p>
                                    <p>
                                        <a href="{{route('profile/user')}}">تایید شماره</a>
                                    </p>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection