<tr data-index="{{ $index }}">
    <td>{!! Form::number('invoices['.$index.'][invstate_id]', old('invoices['.$index.'][invstate_id]', isset($field) ? $field->invstate_id: ''), ['class' => 'form-control']) !!}</td>

    <td>
        <a href="#" class="remove btn btn-xs btn-danger">@lang('quickadmin.qa_delete')</a>
    </td>
</tr>