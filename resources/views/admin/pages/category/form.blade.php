@php
    use App\Helpers\Template;
    use App\Helpers\Form as FormTemplate;
    $formInputAttr = config('zvn.template.form_input');
    $formLabelAttr = config('zvn.template.form_label');
    $statusValue = ['default' => 'Chọn trạng thái', 'active' => config('zvn.template.status.active.name'), 'inactive' => config('zvn.template.status.inactive.name')];
    $isHomeValue = ['default' => 'Chọn hiển thị', 1 => config('zvn.template.is_home.yes.name'), 0 => config('zvn.template.is_home.no.name')];
    $displayValue = ['default' => 'Chọn kiểu hiển thị', 'list' => config('zvn.template.display.list.name'), 'grid' => config('zvn.template.display.grid.name')];
    $inputHiddenID = Form::hidden('id', $item['id']);
    $elements = [
        [
            'label' => Form::label('name', 'Name: ', $formLabelAttr),
            'element' => Form::text('name', $item['name'], $formInputAttr)
        ],
        [
            'label' => Form::label('status', 'Status: ', $formLabelAttr),
            'element' => Form::select('status', $statusValue, $item['status'], ['class' => 'form-control col-md-6 col-xs-12'])
        ],
        [
            'label' => Form::label('is_home', 'Hiển thị: ', $formLabelAttr),
            'element' => Form::select('is_home', $isHomeValue, $item['is_home'], ['class' => 'form-control col-md-6 col-xs-12'])
        ],
        [
            'label' => Form::label('display', 'Kiểu hiển thị: ', $formLabelAttr),
            'element' => Form::select('display', $displayValue, $item['display'], ['class' => 'form-control col-md-6 col-xs-12'])
        ],
        [
            'element' => $inputHiddenID . Form::submit('Save', ['class' => 'btn btn-success']),
            'type' => "btn-submit"
        ],
    ];
@endphp
@extends('admin.main')
@section('content')
@include('admin.templates.page_header', ['pageIndex' => false])
<!--box-lists-->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title', ['title' => 'Form'])
            @include('admin.templates.error')
            <div class="x_content">
                {{ Form::open([
                    'method' => 'post',
                    'url' => route("$controllerName/save"),
                    'accept-charset' => 'UTF-8',
                    'enctype' => 'multipart/form-data',
                    'class' => 'form-horizontal form-label-left',
                    'id' => 'main-form' ]) }}
                    {!! FormTemplate::show($elements) !!}
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
<!--end-box-lists-->
@endsection


