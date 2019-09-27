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
                <th class="column-title">Slider info</th>
                <th class="column-title">Trạng thái</th>
                <th class="column-title">Tạo mới</th>
                <th class="column-title">Chỉnh sửa</th>
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
                            $description = HighLight::show($val['description'], $params['search'], 'description');
                            $link = HighLight::show($val['link'], $params['search'], 'link');
                            $thumb =  Template::showItemThumb($controllerName, $val->thumb, $name);
                            $status = Template::showItemStatus($controllerName, $val->status, $val->id);
                            $createHistory = Template::showItemHistory($val->created_by, $val->created);
                            $modifiedHistory = Template::showItemHistory($val->modified_by, $val->modified);
                            $listBtnAction = Template::showButtonAction($controllerName, $val->id, $index);
                        @endphp
                        <tr class="{{ $class }} pointer" id="div-{{$val['id']}}">
                            <td class="index" data-index="{{ $index }}">{{ $index }}</td>
                            <td width="40%">
                                <p><strong>Name:</strong> {!! $name !!}</p>
                                <p><strong>Description:</strong> {!! $description !!}</p>
                                <p><strong>Link:</strong> {!! $link !!}</p>
                                <p>{!! $thumb !!}</p>
                            </td>
                            <td>{!! $status !!}</td>
                            <td>{!! $createHistory !!}</td>
                            <td>{!! $modifiedHistory !!}</td>
                            <td class="last">{!! $listBtnAction !!}</td>
                        </tr>
                    @endforeach
                @else
                    @include('admin.templates.list_empty', ['colspan' => 6])
                @endif
            </tbody>
        </table>
    </div>
</div>