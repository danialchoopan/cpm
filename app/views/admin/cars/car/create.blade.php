@extends('admin.template.admin')
@section('title','افزودن خودرو')
@section('title_content','افزودن')
@section('content')
    <div class="row">
        <div class="col text-left">
            <a href="{{route('admin/dash/cars')}}" class="btn btn-warning">بازگشت به لیست خودرو ها </a>
        </div>
    </div>
    @if($can_create_car)
        <form method="post" action="{{route('admin/dash/cars')}}" enctype="multipart/form-data">
            <div class="form-group">
                <label for="input_title">نام:</label>
                <input type="text" class="form-control" id="input_title" name="name" required>
            </div>
            <div class="form-group">
                <label for="input_price">قیمت (تومان):</label>
                <input type="text" class="form-control" id="input_price" name="price" required>
            </div>

            <div class="form-group">
                <label for="input_img">عکس خودرو: </label>
                <input type="file" class="form-control" name="img_car" id="input_img" required>
            </div>

            <div class="form-group">
                <label for="input_select"> برند: </label>
                <select class="form-control" id="input_select" name="brand">
                    <?php
                    $first_option_foreach = true;
                    ?>
                    @foreach($brands as $brand)
                        @if($first_option_foreach)
                            <option value="{{$brand['id']}}" selected>{{$brand['name']}}</option>
                        @else
                            <option value="{{$brand['id']}}">{{$brand['name']}}</option>
                        @endif
                        <?php $first_option_foreach = false; ?>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <fieldset>
                    <legend>شرایط فروش</legend>
                    <?php
                    $first_option_foreach_2 = true;
                    ?>
                    @foreach($conditions as $condition)
                        @if($first_option_foreach_2)
                            <label class="m-2 form-check">
                                {{$condition['name']}}
                                <input type="checkbox" name="conditions[]" checked value="{{$condition['id']}}">
                            </label>
                        @else
                            <label class="m-2 form-check">
                                {{$condition['name']}}
                                <input type="checkbox" name="conditions[]" value="{{$condition['id']}}">
                            </label>
                        @endif
                        <?php $first_option_foreach_2 = false; ?>

                    @endforeach
                </fieldset>
            </div>

            <div class="form-group">
                <label for="input_body">توضیحات :</label>
                <textarea class="form-control" name="description" id="input_body" required></textarea>
            </div>

            <div class="form-group">
                <label for="is_for_sell_open">برای فروش باز است :</label>
                <input type="checkbox" value="1" name="is_for_sell_open" id="is_for_sell_open">
            </div>

            <input type="submit" class="btn btn-primary" value="افزودن"/>
        </form>
    @else
        <div class="row">
            <div class="col text-center">
                <h4>متاسفانه امکان افزودن خودرو وجود ندارد</h4>
                <h4>برای افزودن خودرو ابتدا برند و شرایط را اضافه کنید</h4>
                <h4><a href="{{route('admin/dash/brand')}}">برند ها</a></h4>
                <h4><a href="{{route('admin/dash/conditions')}}">شرایط ها</a></h4>
            </div>
        </div
    @endif

@endsection