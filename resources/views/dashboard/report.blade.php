@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard / {{ $push->id }}  -  <span><a href="{{ url('/dashboard') }}">回上層</a></span> </div>

                <div class="panel-body">
                    <div id="container">
                        <div id="push">
                            <img id="push-icon" src="<?= ($push->icon)? $push->icon: '/images/push.png';?>">
                            <p id="x">x</p>
                            <p id="push-title">{{ $push->title }}</p>
                            <p id="push-message">{{ $push->body }}</p>
                            <p id="push-url">https://www.mtv.com.tw</p>
                        </div>
                    </div>
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>GCM success</th>
                                <th>GCM fail</th>
                                <th>露出</th>
                                <th>點擊</th>
                                <th>點擊率</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>#</th>
                                <th>GCM success</th>
                                <th>GCM fail</th>
                                <th>露出</th>
                                <th>點擊</th>
                                <th>點擊率</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
$(document).ready( function () {
    $('#datatable').DataTable('bSort': false);
} );
</script>
@endsection