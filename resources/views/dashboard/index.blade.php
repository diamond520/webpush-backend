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
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; ?>
                            @foreach ($pushes as $push)
                            <tr data-href="{{ url('/dashboard/'.$push->id) }}" class="clickable">
                                <td>{{ $i }}</td>
                                <td>{{ $push->title }}</td>
                                <td>{{ $push->body }}</td>
                                <th>{{ $push->impression }}</th>
                                <th>{{ $push->click }}</th>
                                <th>{{ ($push->impression) ? number_format(($push->click/$push->impression)*100, 2) : 0 }}</th>
                                <td>{{ $push->created_at }}</td>
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
    $('#datatable tbody tr').on('click', function(){
        window.document.location = $(this).data("href");
    });
} );
</script>
@endsection