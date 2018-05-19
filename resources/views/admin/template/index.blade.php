@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Template</div>
                    <div class="card-body">
                        <a href="{{ url('/admin/template/create') }}" class="btn btn-success btn-sm" title="Add New Template">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => '/admin/template', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                            <span class="input-group-append">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Name</th><th>File</th><th>Notes</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($template as $item)
                                    <tr>
                                        <td>{{ $loop->iteration or $item->id }}</td>
                                        <td>{{ $item->name }}</td><td>{{ $item->file }}</td><td>{{ $item->notes }}</td>
                                        <td>

                                         <a href="{{  url('/admin/template/read/' . $item->id ) }}" title="View file {{ $item->name }}">
                                                        <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('file.response', $item->id) }}" title="Show or download file {{ $item->name }}">
                                                        <i class="fa fa-expand fa-fw"></i>
                                                    </a>
                                        <a href="{{ route('file.download', $item->id) }}" title="Download file {{ $item->name }}">
                                                        <i class="fa fa-download fa-fw"></i>
                                        </a>

                                            <a href="{{ url('/admin/template/' . $item->id . '/edit') }}" title="Edit Template"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                           
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/admin/template', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'title' => 'Delete Template',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $template->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
