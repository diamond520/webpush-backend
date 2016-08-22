@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>標題</th>
                                <th>內容</th>
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
