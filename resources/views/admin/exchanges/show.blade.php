@extends('layouts.app')

@section('content')
    <h3 class="page-title">Exchange</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Riel (R)</th>
                            <td field-key='riels'>{{ $exchange->riels }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.organizations.fields.description')</th>
                            <td field-key='description'>{!! $exchange->description !!}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->


            {!! Form::open(array(
        'style' => '',
        'method' => 'PUT',
        'onsubmit' => "return confirm('Do you want to set this Exchange Rate?');",
        'route' => ['admin.exchanges.set_default', $exchange->id])) !!}

            {!! Form::submit('Apply Exchange Rate', ['class' => 'btn btn-success']) !!}
            {!! Form::close() !!}
            <br>


            <a href="{{ route('admin.exchanges.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop


