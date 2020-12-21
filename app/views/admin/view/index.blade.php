@extends('admin.template.admin')
@section('title','نمایش بازدید ها')
@section('title_content','بازدید  ها')
@section('content')
    @include('include.msg')
    @if(count($views)!=0)
        <table class="table table-hover">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">ip</th>
                <th scope="col">تعداد بازدید</th>
                <th scope="col">ساخته شده در</th>
            </tr>
            </thead>
            <tbody>
            @foreach($views as $view)
                <tr>
                    <th scope="row">
                        {{$view['id']}}
                    </th>
                    <td>
                        {{$view['ip']}}
                    </td>
                    <td>
                        {{$view['count_of_visit']}}
                    </td>
                    <td>
                        {{show_date_php($view['created_at'])}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="row m-1">
            <div class="col text-center">
                <h4>متاسفانه بازدیدی برای نمایش وجود ندارد</h4>
            </div>
        </div>
    @endif
@endsection
