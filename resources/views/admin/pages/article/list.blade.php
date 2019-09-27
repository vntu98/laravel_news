@php
    use App\Helpers\Template as Template;
    use App\Helpers\Highlight;
@endphp
<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
            <tr class="headings">
                <th class="column-title">#</th>
                <th class="column-title">Article info</th>
                <th class="column-title">Thumb</th>
                <th class="column-title">Category</th>
                <th class="column-title">Kiểu bài viết</th>
                <th class="column-title">Trạng thái</th>
                {{-- <th class="column-title">Tạo mới</th>
                <th class="column-title">Chỉnh sửa</th> --}}
                <th class="column-title">Hành động</th>
            </tr>
            </thead>
            <tbody>
                @if (count($items) > 0)
                    @foreach($items as $key => $val)
                        @php
                            $index = $key + 1;
                            $class = ($index % 2 == 0) ? "even" : "odd";
                            $name = HighLight::show($val['name'], $params['search'], 'name');
                            $content = HighLight::show($val['content'], $params['search'], 'content');
                            $categoryName = App\Models\ArticleModel::find($val['id'])->category->name;
                            $thumb =  Template::showItemThumb($controllerName, $val->thumb, $name);
                            $status = Template::showItemStatus($controllerName, $val->status, $val->id);
                            $type = Template::showItemSelect($controllerName, $val->type, $val->id, 'type');
                            // $createHistory = Template::showItemHistory($val->created_by, $val->created);
                            // $modifiedHistory = Template::showItemHistory($val->modified_by, $val->modified);
                            $listBtnAction = Template::showButtonAction($controllerName, $val->id, $index);
                        @endphp
                        <tr class="{{ $class }} pointer" id="div-{{$val['id']}}">
                            <td class="index" data-index="{{ $index }}">{{ $index }}</td>
                            <td width="30%">
                                <p><strong>Name:</strong> {!! $name !!}</p>
                                <p><strong>Content:</strong> {!! $content !!}</p>
                            </td>
                            <td width="14%">{!! $thumb !!}</td>
                            <td>{!! $categoryName !!}</td>
                            <td>{!! $type !!}</td>
                            <td>{!! $status !!}</td>
                            {{-- <td>{!! $createHistory !!}</td>
                            <td>{!! $modifiedHistory !!}</td> --}}
                            <td class="last">{!! $listBtnAction !!}</td>
                        </tr>
                    @endforeach
                @else
                    @include('admin.templates.list_empty', ['colspan' => 8])
                @endif
            </tbody>
        </table>
    </div>
</div>