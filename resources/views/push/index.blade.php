@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">+Push</a></span> </div>
                @if (count($errors) > 0)
                <div class="panel-body">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
                <div class="panel-body">
                    <div id="container">
                        <div id="push">
                            <img id="push-icon" src="/images/push.png" placeholder="/images/push.png">
                            <p id="x">x</p>
                            <p id="push-title" alt="title" placeholder="標題">標題</p>
                            <p id="push-message" alt="body" placeholder="內文">內文</p>
                            <p id="push-url">https://www.mtv.com.tw</p>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <form class="input_row" action="/push/add" method="post">
                        <div>
                            <span>
                                <input class="balloon" id="title" name="title" type="text" placeholder="推播的標題" value="{{ old('title') }}" /><label for="title">標題</label>
                            </span>
                            <span>
                                <input class="balloon" id="body" name="body" type="text" placeholder="推播的內文" value="{{ old('body') }}" /><label for="body">內文</label>
                            </span>
                        </div>
                        <div>
                            <span>
                                <input class="balloon" id="icon" name="icon" type="text" placeholder="外部連結必須使用 http://" style="width:400px;" value="{{ old('icon') }}" /><label for="icon">icon</label>
                            </span>
                            <span>(選填)</span>
                        <div>
                        </div> 
                            <span>
                                <input class="balloon" id="url" name="url" type="text" placeholder="推播的連結" style="width:400px;" value="{{ old('url') }}" /><label for="url">連結</label>
                            </span>
                            <span>(選填)</span>
                            <span><a id="test_url" href="#" target="_blank">測試連結</a></span>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div><span><button type="submit" class="btn btn-primary">送出</button></span></div>
                        
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $('#title, #body').change(function(){
        var id = $(this).attr('id');
        var input = $(this).val() || $("p[alt="+id+"]").attr('placeholder');
        $("p[alt="+id+"]").html(input);
    });
    $('#icon').change(function(){
        var url = $(this).val() || '/images/push.png';
        $("#push-icon").attr('src', url);
    });
    $('#url').change(function(){
        var url = $(this).val();
        $("#test_url").attr('href', url);
    });
</script>
@endsection