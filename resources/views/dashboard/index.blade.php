@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <table id="datatable" class="table display">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>標題</th>
                                <th>內容</th>
                                <th>露出</th>
                                <th>點擊</th>
                                <th>點擊率(%)</th>
                                <th>時間</th>
                                <th>查看</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; ?>
                            @foreach ($pushes as $push)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $push->title }}</td>
                                <td>{{ $push->body }}</td>
                                <th>0</th>
                                <th>0</th>
                                <th>0.0</th>
                                <td>{{ $push->created_at }}</td>
                                <td><a href="{{ url('/dashboard/'.$push->id) }}">detail</a></td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach
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
    $('#datatable').DataTable();
} );
</script>
@endsection