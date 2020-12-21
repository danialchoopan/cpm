@extends('templates.for_content')
@section('title','ویرایش')
@section('content')
    <?php
    $auth_user = authUser();
    ?>
    <div class="cp-container-content d-flex justify-content-center">
        <div class="w-100 m-4">
            <div class="card">
                <div class="card-header">ویرایش پروفایل</div>
                <div class="card-body">
                    @include('include.msg')
                    <div class="row">
                        <div class="col">
                            <h3>آپلود پروفایل عکس مورد نظر خود را انتخاب کنید</h3>
                            <form action="{{route('profile/user/edit')}}" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>عکس پروفایل</label>
                                    <input type="file" class="form-control" name="photo_file"
                                           required>
                                    <small class="text-muted d-block m-1">نکته حداکثر فایل مجاز برای آپلود 512 کیلوبایت
                                        است </small>
                                    <small class="text-muted d-block m-1">نکته برای در خواست خودرو از عکس واقعی خود
                                        استفاده
                                        کنید</small>

                                </div>
                                <input class="btn btn-primary btn-block m-2" type="submit" value="بروزرسانی">
                            </form>
                        </div>
                        <div class="col text-center">
                            @if($auth_user['photo_id'])
                                <img src="{{show_by_photo_id($auth_user['photo_id'])}}" width="80%" alt="پروفایل">
                                <a class="btn btn-danger btn-block m-2"
                                   href="{{route('profile/user/edit/delete/profile')}}">حذف عکس پروفایل</a>
                            @else
                                <img src="" alt="بدون پروفایل">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection