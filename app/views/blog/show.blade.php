@extends('templates.for_content')
@section('title','بلاگ')
@section('content')
    <div class="row justify-content-center">
        <div class="card w-75 m-4">
            <div class="row">
                <div class="col">
                    <div class="card-body">
                        <p class="card-text rtl"><small class="text-muted">{{$category['name']}}</small></p>
                        <h4 class="rtl">{{$blog['title']}}</h4>
                        <p class="card-text rtl">{{$blog['body']}}</p>
                    </div>
                </div>

                <div class="col">
                    <img src="{{show_by_photo_id($blog['photo_id'])}}" class="card-img-top" alt="...">
                </div>
            </div>

            <hr>
            <div class="row m-2">
                <div class="col-12">
                    <h3>
                        نظرات
                    </h3>
                    @include('include.msg')
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @if(authUser())
                                <form method="post" action="{{route("blog/show/$blog[id]/comment")}}">
                                    <p class="text-muted">ثبت نظر</p>
                                    <div class="form-group">
                                    <textarea
                                            name="content"
                                            placeholder="نظری بنویسید ..."
                                            class="form-control" required></textarea>
                                    </div>
                                    <input type="submit" class="btn btn-primary" value="ارسال"/>
                                </form>
                            @else
                                <div class="alert alert-warning">
                                    برای ثبت نظر ابتدا باید وارد شوید
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if(count($comments)!=0)
                    @foreach($comments as $comment)
                        <div class="col-12 mt-3">
                            <div class="card">
                                <div class="card-body">
                                    {{user_auth_id($comment['user_id'])['full_name']}}
                                    :
                                    {{$comment['content']}}
                                    <hr>
                                    نوشته شده در :
                                    {{show_date_php($comment['created_at'])}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 mt-2">
                        <div class="alert alert-warning">
                            متاسفانه نظری برای نمایش وجود ندارد
                        </div>
                    </div>
                @endif
            </div>

        </div>


    </div>
@endsection