@extends('admin.template.admin')
@section('title','بروزسانی خودرو')
@section('title_content','بروزسانی')
@section('content')
    <div class="row">
        <div class="col text-left">
            <a href="{{route('admin/dash/cars')}}" class="btn btn-warning">بازگشت به لیست خودرو ها </a>
        </div>
    </div>
    <?php
    $conditions_id = unserialize($car['condition_id']);
    ?>
    @if($can_create_car)
        <form method="post" action="{{route("admin/dash/cars/$car[id]/update")}}" enctype="multipart/form-data">
            <div class="form-group">
                <label for="input_title">نام:</label>
                <input type="text" class="form-control" id="input_title" name="name"
                       value="{{$car['name']}}"
                       required>
            </div>
            <div class="form-group">
                <label for="input_price">قیمت (تومان):</label>
                <input type="text" class="form-control" id="input_price" name="price"
                       value="{{$car['price']}}"
                       required>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="input_img">عکس خودرو: </label>
                        <input type="file" class="form-control" name="img_car" id="input_img">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <img src="{{$car_photo_path}}" width="100%" alt="عکسی موجود نیست">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="input_select"> برند: </label>
                <select class="form-control" id="input_select" name="brand">
                    @foreach($brands as $brand)
                        <option value="{{$brand['id']}}"
                                @if($brand['id']==$car['brand_id'])
                                selected
                                @endif
                        >{{$brand['name']}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <fieldset>
                    <legend>شرایط فروش</legend>
                    @foreach($conditions as $condition)
                        <label class="m-2 form-check">
                            {{$condition['name']}}
                            <input type="checkbox" name="conditions[]"
                                   @foreach($conditions_id as $ci)
                                   @if($condition['id']==$ci)
                                   checked
                                   @endif
                                   @endforeach
                                   value="{{$condition['id']}}">
                        </label>
                    @endforeach
                </fieldset>
            </div>

            <div class="form-group">
                <label for="input_body">توضیحات :</label>
                <textarea class="form-control" name="description" id="input_body"
                          required>{{$car['description']}}</textarea>
            </div>

            <div class="form-group">
                <label for="is_for_sell_open">برای فروش باز است :</label>
                <input type="checkbox" value="1" name="is_for_sell_open"
                       @if($car['is_car_open_for_sell'])
                       checked
                       @endif
                       id="is_for_sell_open">
            </div>

            <input type="submit" class="btn btn-primary" value="بروزسانی"/>
        </form>

        <form action="{{route('admin/dash/cars/destroy')}}" method="post">
            <input type="hidden" name="car_id" value="{{$car['id']}}}">
            <input type="submit" class="btn btn-danger m-2" value="حذف خودرو">
        </form>
    @else
        <div class="row">
            <div class="col text-center">
                <h4>متاسفانه امکان برورسانی خودرو وجود ندارد</h4>
                <h4>برای بروزسانی خودرو ابتدا برند و شرایط را اضافه کنید</h4>
                <h4><a href="{{route('admin/dash/brand')}}">برند ها</a></h4>
                <h4><a href="{{route('admin/dash/conditions')}}">شرایط ها</a></h4>
            </div>
        </div
    @endif

@endsection