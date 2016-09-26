@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ url('/dashboard') }}">Dashboard</a> / {{ $push->id }}</div>

                <div class="panel-body">
                    <div id="container">
                        <div id="push">
                            <img id="push-icon" src="{{ $push->icon or '/images/push.png' }}">
                            <p id="x">x</p>
                            <p id="push-title">{{ $push->title }}</p>
                            <p id="push-message">{{ $push->body }}</p>
                            <p id="push-url">https://www.setddg.com</p>
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
                                <th>點擊率(%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>#</th>
                                <th>{{ $push->success }}</th>
                                <th>{{ $push->failure }}</th>
                                <th>{{ $push->impression }}</th>
                                <th>{{ $push->click }}</th>
                                <th>{{ ($push->impression) ? number_format(($push->click/$push->impression)*100, 2) : 0 }}</th>
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
    $('#datatable').DataTable({'bSort': false, bFilter: false});
} );
</script>
@endsection
