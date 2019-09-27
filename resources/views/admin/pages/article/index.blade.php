@php
    use App\Helpers\Template;
    $xhtmlButtonFilter = Template::showButtonFilter($params['filter']['status'], $controllerName, $itemsStatusCount, $params['search']);
    $xhtmlAreaSearch = Template::showAreaSearch($controllerName, $params['search']);
@endphp
@extends('admin.main')
@section('content')
    @include('admin.templates.page_header', ['pageIndex' => true])
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
                @include('admin.templates.x_title', ['title' => 'Bộ lọc'])
            <div class="x_content">
                <div class="row">
                    <div class="col-md-6"> {!! $xhtmlButtonFilter !!} </div>
                    <div class="col-md-6"> {!! $xhtmlAreaSearch !!} </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--box-lists-->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title', ['title' => 'Danh sách'])
            @include('admin.pages.article.list')
        </div>
    </div>
</div>
<!--end-box-lists-->
<!--box-pagination-->
@if(count($items) > 0)
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title', ['title' => 'Phân trang'])
            @include('admin.templates.pagination')
        </div>
    </div>
</div>
@endif
<!--end-box-pagination-->
@endsection


