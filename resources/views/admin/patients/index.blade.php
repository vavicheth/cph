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
{{--        @if(\Illuminate\Support\Facades\Auth::user()->role->id == 1)--}}
            <p>
            <ul class="list-inline">
                <li><a href="{{ route('admin.patients.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('quickadmin.qa_all')</a></li> |
                <li><a href="{{ route('admin.patients.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('quickadmin.qa_trash')</a></li>
            </ul>
            </p>
{{--        @endif--}}
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

            <!-- Modal Delete Permanent-->
            <div class="modal fade" id="DeleteModalPerma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="" id="deleteFormPerma" method="post">
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
                                <button type="submit" class="btn btn-danger" onclick="formSubmitPerma()"><i class="fa fa-trash"></i> Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Restore-->
            <div class="modal fade" id="RestoreModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="" id="restoreForm" method="post">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Restore Patient</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                {{ csrf_field() }}
                                {{ method_field('POST') }}
                                Are you sure restore this Patient?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success" onclick="formSubmit()"><i class="fa fa-backward"></i> Restore</button>
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
        @can('patient_delete')
                @if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('admin.patients.mass_destroy') }}'; @endif
        @endcan
        $(function() {

            $('#table-patients').DataTable({
                processing: true,
                serverSide: true,
                searchable:true,
                ajax: '{!! route('admin.patients.index') !!}?show_deleted={{ request('show_deleted') }}',

                columns: [


                    { data: 'name', name: 'name',},
                    { data: 'gender',name:'gender'},
                    { data: 'age', name: 'age' },
                    { data: 'organization', name: 'organization',"defaultContent": "គ្មាន","targets": "_all",searchable: true},
                    { data: 'diagnostic', name: 'diagnostic' },
                    { data: 'usercreator', name: 'usercreator',"defaultContent": "គ្មាន","targets": "_all" },
                    { data: 'date', name: 'date',"defaultContent": "គ្មាន","targets": "_all" },
                    { data: 'action', name: 'action' },
                    // { data: 'invoices.created_at', name: 'invoice_date' }
                ],
                // order:[6,'desc']
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


        function deleteDataPerma(id)
        {
            var id = id;
            var url = '{{ route("admin.patients.perma_del", ":id") }}';
            url = url.replace(':id', id);
            $("#deleteFormPerma").attr('action', url);
        }
        function formSubmitPerma()
        {
            $("#deleteFormPerma").submit();
        }

        function restoreData(id)
        {
            var id = id;
            var url = '{{ route("admin.patients.restore", ":id") }}';
            url = url.replace(':id', id);
            $("#restoreForm").attr('action', url);
        }
        function formSubmitrestore()
        {
            $("#restoreForm").submit();
        }


    </script>
@endsection