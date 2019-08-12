@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">Reports</h3>



    <!-- Report By Medicines -->
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Report by Medicine</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            {!! Form::open(['method' => 'POST', 'route' => ['admin.reports.medicine']]) !!}
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('fromdate', 'From Date'.'*', ['class' => 'control-label']) !!}
                    {!! Form::text('fromdate', old('fromdate'), ['class' => 'form-control fromdate', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('fromdate'))
                        <p class="help-block">
                            {{ $errors->first('fromdate') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-6 form-group">
                    {!! Form::label('todate', 'To Date'.'*', ['class' => 'control-label']) !!}
                    {!! Form::text('todate', old('todate'), ['class' => 'form-control todate', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('todate'))
                        <p class="help-block">
                            {{ $errors->first('todate') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('invstate', 'Invoice States'.'', ['class' => 'control-label']) !!}
                    {!! Form::select('invstate[]', $invstates, old('invstate'), ['multiple'=>true,'class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('invstate'))
                        <p class="help-block">
                            {{ $errors->first('invstate') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-3 form-group">
                    {!! Form::submit('View', ['class' => 'btn btn-info']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer no-padding">

        </div>
        <!-- /.footer -->
    </div>
    <!-- /.box -->

    <!-- Report By Invoice State -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Report by Patient type</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            {!! Form::open(['method' => 'POST', 'route' => ['admin.reports.date_report']]) !!}
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('fromdate', 'From Date'.'*', ['class' => 'control-label']) !!}
                    {!! Form::text('fromdate', old('fromdate'), ['class' => 'form-control fromdate', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('fromdate'))
                        <p class="help-block">
                            {{ $errors->first('fromdate') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-6 form-group">
                    {!! Form::label('todate', 'To Date'.'*', ['class' => 'control-label']) !!}
                    {!! Form::text('todate', old('todate'), ['class' => 'form-control todate', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('todate'))
                        <p class="help-block">
                            {{ $errors->first('todate') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-3 form-group">
                    {!! Form::submit('View', ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer no-padding">

        </div>
        <!-- /.footer -->
    </div>
    <!-- /.box -->



    <!-- Report By Service -->
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Report by Department</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            {!! Form::open(['method' => 'POST', 'route' => ['admin.reports.department']]) !!}
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('fromdate', 'From Date'.'*', ['class' => 'control-label']) !!}
                    {!! Form::text('fromdate', old('fromdate'), ['class' => 'form-control fromdate', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('fromdate'))
                        <p class="help-block">
                            {{ $errors->first('fromdate') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-6 form-group">
                    {!! Form::label('todate', 'To Date'.'*', ['class' => 'control-label']) !!}
                    {!! Form::text('todate', old('todate'), ['class' => 'form-control todate', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('todate'))
                        <p class="help-block">
                            {{ $errors->first('todate') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-3 form-group">
                    {!! Form::submit('View', ['class' => 'btn btn-success']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer no-padding">

        </div>
        <!-- /.footer -->
    </div>
    <!-- /.box -->


    <!-- Report By Max and Min -->
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">Report by Minimum and Maximum invoice</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            {!! Form::open(['method' => 'POST', 'route' => ['admin.reports.max_min']]) !!}
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('fromdate', 'From Date'.'*', ['class' => 'control-label']) !!}
                    {!! Form::text('fromdate', old('fromdate'), ['class' => 'form-control fromdate', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('fromdate'))
                        <p class="help-block">
                            {{ $errors->first('fromdate') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-6 form-group">
                    {!! Form::label('todate', 'To Date'.'*', ['class' => 'control-label']) !!}
                    {!! Form::text('todate', old('todate'), ['class' => 'form-control todate', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('todate'))
                        <p class="help-block">
                            {{ $errors->first('todate') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('invstate', 'Invoice States'.'', ['class' => 'control-label']) !!}
                    {!! Form::select('invstate[]', $invstates, old('invstate'), ['multiple'=>true,'class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('invstate'))
                        <p class="help-block">
                            {{ $errors->first('invstate') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('type', 'Type'.'*', ['class' => 'control-label']) !!}

                    <div>
                        <label>
                            {!! Form::radio('type', 'min', false, ['required' => '']) !!}
                            Minimum
                        </label>

                        <label>
                            {!! Form::radio('type', 'max', false, ['required' => '']) !!}
                            Maximum
                        </label>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-xs-3 form-group">
                    {!! Form::submit('View', ['class' => 'btn btn-warning']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer no-padding">

        </div>
        <!-- /.footer -->
    </div>
    <!-- /.box -->


    <!-- Report By Medicine History -->
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Report by Drug History</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            {!! Form::open(['method' => 'POST', 'route' => ['admin.reports.medicine_history']]) !!}
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('fromdate', 'From Date'.'*', ['class' => 'control-label']) !!}
                    {!! Form::text('fromdate', old('fromdate'), ['class' => 'form-control fromdate', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('fromdate'))
                        <p class="help-block">
                            {{ $errors->first('fromdate') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-6 form-group">
                    {!! Form::label('todate', 'To Date'.'*', ['class' => 'control-label']) !!}
                    {!! Form::text('todate', old('todate'), ['class' => 'form-control todate', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('todate'))
                        <p class="help-block">
                            {{ $errors->first('todate') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('medicine', 'Medicine'.'*', ['class' => 'control-label']) !!}
                    {!! Form::select('medicine', $medicines, old('medicine'), ['class' => 'form-control select2', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('medicine'))
                        <p class="help-block">
                            {{ $errors->first('medicine') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-3 form-group">
                    {!! Form::submit('View', ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer no-padding">

        </div>
        <!-- /.footer -->
    </div>
    <!-- /.box -->



@stop

@section('javascript')
    @parent

    <script src="{{ url('adminlte/plugins/datetimepicker/moment-with-locales.min.js') }}"></script>
    <script src="{{ url('adminlte/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $(function(){
            moment.updateLocale('{{ App::getLocale() }}', {
                week: { dow: 1 } // Monday is the first day of the week
            });

            $('.fromdate').datetimepicker({
                format: "{{ config('app.date_format_moment') }}",
                locale: "{{ App::getLocale() }}",
            });

        });

        $(function(){
            moment.updateLocale('{{ App::getLocale() }}', {
                week: { dow: 1 } // Monday is the first day of the week
            });

            $('.todate').datetimepicker({
                format: "{{ config('app.date_format_moment') }}",
                locale: "{{ App::getLocale() }}",
            });

        });

    </script>
@stop