@extends('templates.for_content')
@section('title','بلاگ')
@section('content')
    <div class="row">
        <div class="col-2 p-3">
            <h4 class="text-center p-2">دسته بندی ها</h4>
            <div class="row justify-content-around p-3">
                @if(count($categorys)!=0)
                    <ul>
                        @foreach($categorys as $category)
                            <li class="rtl"><a href="{{route("blog/category/$category[id]")}}">{{$category['name']}}</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <h4 class="text-center">متاسفانه دسته بندی جهت نمایش وجود ندارد</h4>
                @endif
            </div>
        </div>
        <div class="cp-container-content rtl col-10">
            <h4 class="text-center p-4">{{$category_blog['name']}}</h4>
            <div class="row p-2 justify-content-around">
                @if(count($blogs)!=0)
                    @foreach($blogs as $blog)
                        <?php
                        $photo_adapter = new \App\database\adapter\PhotoAdapter();
                        $photo_path = $photo_adapter->find($blog['photo_id'])['name'];
                        ?>
                        <div class="card col-3 m-2">
                            <img src="{{show_img_user($photo_path)}}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{$blog['title']}}</h5>
                                <p class="card-text">{{substr($blog['body'],0,200)}} ...</p>
                                <a href="{{route("blog/show/$blog[id]")}}" class="btn btn-primary">مشاهده</a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h4 class="text-center">متاسفانه پستی جهت نمایش وجود ندارد</h4>
                @endif
            </div>
        </div>
    </div>
@endsection