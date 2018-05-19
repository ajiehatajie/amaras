@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Template {{ $template->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/template') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/template/' . $template->id . '/edit') }}" title="Edit Template"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['admin/template', $template->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-sm',
                                    'title' => 'Delete Template',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $template->id }}</td>
                                    </tr>
                                    <tr><th> Name </th><td> {{ $template->name }} </td></tr><tr><th> File </th><td> {{ $template->file }} </td></tr><tr><th> Notes </th><td> {{ $template->notes }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                            <iframe src='http://localhost:8000/file/1/response' 
                            width='1366px' height='623px' frameborder='0'>This is an embedded 
                            <a target='_blank' href='http://office.com'>Microsoft Office</a> document, powered by <a target='_blank' href='http://office.com/webapps'>Office Online</a>.</iframe>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
