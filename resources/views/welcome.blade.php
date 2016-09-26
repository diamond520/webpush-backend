@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Guide</div>
                <div class="panel-body">
                @if (Auth::guest())
                    <div class="col-md-10 col-md-offset-1">
                        請由右上角登入，其他問題請洽詢<a href="mailto:sanlih.ec@gmail.com">管理員</a>。
                    </div>
                @else
                    <div class="col-md-2 col-md-offset-1">新增推播</div>
                    <div class="col-md-8">
                        <img src="{{URL::asset('/images/intro-1.png')}}" style="width:100%;" alt="intro: add new push">
                    </div>
                    <div class="col-md-12">
                    <!-- <hr style="height:3px;border:none;border-top:3px double #CCC;"> -->
                    <!-- <hr style="height: 6px; background: url({{URL::asset('/images/hr.png')}}) repeat-x 0 0; border: 0;"> -->
                    <hr style="border: 0; height: 1px; background-image: -webkit-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0); background-image: -moz-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0); background-image: -ms-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0); background-image: -o-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0); ">
                    </div>
                    <div class="col-md-2 col-md-offset-1">查看歷史紀錄</div>
                    <div class="col-md-8">
                        <img src="{{URL::asset('/images/intro-2.png')}}" style="width:100%;" alt="intro: check push histroy">
                    </div>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
