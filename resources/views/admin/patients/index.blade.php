@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.patients.title')</h3>
    @can('patient_create')
        <p>
            <a href="{{ route('admin.patients.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>

        </p>
    @endcan

    @can('patient_delete')
        @if(\Illuminate\Support\Facades\Auth::user()->role->id == 1)
            <p>
            <ul class="list-inline">
                <li><a href="{{ route('admin.patients.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('quickadmin.qa_all')</a></li> |
                <li><a href="{{ route('admin.patients.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('quickadmin.qa_trash')</a></li>
            </ul>
            </p>
        @endif
    @endcan


    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped" id="table-patients">
                <thead>
                <tr>
                    <th width="15%">@lang('quickadmin.patients.fields.name')</th>
                    <th width="10%">@lang('quickadmin.patients.fields.gender')</th>
                    <th width="10%">@lang('quickadmin.patients.fields.age')</th>
                    <th width="15%">@lang('quickadmin.patients.fields.oranization')</th>
                    <th width="15%">@lang('quickadmin.patients.fields.diagnostic')</th>
                    <th width="10%">Creator</th>
                    <th width="10%">Date</th>
                    <th width="15%">Action</th>
                </tr>
                </thead>
            </table>

            <!-- Modal Delete-->
            <div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="" id="deleteForm" method="post">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Delete Patient</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                Are you sure delete this Patient?
                                You won't be able to revert this!
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger" onclick="formSubmit()"><i class="fa fa-trash"></i> Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
@stop

@section('javascript')
    <script>

        {{--@can('patient_delete')--}}
            {{--window.route_mass_crud_entries_destroy = '{{ route('admin.patients.mass_destroy') }}';--}}
        {{--@endcan--}}
        {{--$(document).ready(function () {--}}
            {{--window.dtDefaultOptions.ajax = '{!! route('admin.patients.index') !!}';--}}
            {{--window.dtDefaultOptions.columns = [@can('patient_delete')--}}
            {{--{data: 'massDelete', name: 'id', searchable: false, sortable: false},@endcan--}}
                {{--{data: 'name', name: 'name'},--}}
                {{--{data: 'gedner', name: 'gender'},--}}
                {{--{data: 'age', name: 'age'},--}}
                {{--{data: 'oranization', name: 'oranization'},--}}
                {{--{data: 'diagnostic', name: 'diagnostic'},--}}
                {{--{data: 'creator', name: 'creator'},--}}
                {{--{data: 'invoice.created_at', name: 'invoice.created_at'},--}}

                {{--{data: 'actions', name: 'actions', searchable: false, sortable: false}--}}
            {{--];--}}
            {{--processAjaxTables();--}}
        {{--});--}}




        $(function() {
            $('#table-patients').DataTable({
                processing: true,
                serverSide: true,
                // searchable:true,
                // sortable: true,
                ajax: '{!! route('admin.get.patients') !!}',

                columns: [

                    { data: 'name', name: 'name'},
                    { data: 'gender'},
                    { data: 'age', name: 'age', },
                    { data: 'oranization.name_kh', name: 'oranization.name_kh', },
                    { data: 'diagnostic', name: 'diagnostic' },
                    { data: 'creator', name: 'creator' },
                    // { data: 'date', name: 'date'},
                    { data: 'date', name: 'date'},
                    { data: 'action', name: 'action', searchable: false, sortable: false },
                    // { data: 'invoices.created_at', name: 'invoice_date' }
                ]
            });
        });


        function deleteData(id)
        {
            var id = id;
            var url = '{{ route("admin.patients.destroy", ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
        }

        function formSubmit()
        {
            $("#deleteForm").submit();
        }

    </script>
@endsection