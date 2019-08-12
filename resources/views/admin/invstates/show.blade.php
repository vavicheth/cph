@extends('layouts.app')

@section('content')
    <h3 class="page-title">Invoice States</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>State</th>
                            <td field-key='state'>{{ $invstate->state }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.organizations.fields.description')</th>
                            <td field-key='description'>{!! $invstate->description !!}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->

            <a href="{{ route('admin.invstates.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop


