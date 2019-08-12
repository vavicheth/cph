@extends('layouts.app')

@section('content')
    <h3 class="page-title">Extends</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Percentage (%)</th>
                            <td field-key='percentage'>{{ $extend->percentage }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.organizations.fields.description')</th>
                            <td field-key='description'>{!! $extend->description !!}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->


            {!! Form::open(array(
        'style' => '',
        'method' => 'PUT',
        'onsubmit' => "return confirm('Do you want to Extend this percentage to Medicine?');",
        'route' => ['admin.extends.set_default', $extend->id])) !!}


                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            {!! Form::label('manual','Including Manual'.'', ['class' => 'control-label']) !!}
                            {!! Form::hidden('manual', 0) !!}
                            {!! Form::checkbox('manual', 1, []) !!}
                        </div>
                    </div>
                </div>

            {!! Form::submit('Apply Extend', ['class' => 'btn btn-success']) !!}
            {!! Form::close() !!}
            <br>


            <a href="{{ route('admin.extends.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop


