@extends('templates.for_content')
@section('title','برند')
@section('content')
    <div class="cp-container-content rtl">
        <h4 class="text-center m-3">{{$brand['name']}}</h4>
        <div class="row p-2 justify-content-around">
            @if(count($cars)!=0)
                @foreach($cars as $car)
                    <?php
                    $photo_adapter = new \App\database\adapter\PhotoAdapter();
                    $photo_path = $photo_adapter->find($car['photo_id'])['name'];
                    ?>
                    <div class="card col-3 m-2">
                        <img src="{{show_img_user($photo_path)}}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{$car['name']}}</h5>
                            <p class="card-text">{{substr($car['description'],0,200)}} ...</p>
                            <a href="{{route("car/show/$car[id]")}}" class="btn btn-primary">مشاهده</a>
                        </div>
                    </div>
                @endforeach
            @else
                <h4 class="text-center m-5">متاسفانه خودرویی در این برند برای نمایش وجود ندارد</h4>
            @endif
        </div>
    </div>
@endsection