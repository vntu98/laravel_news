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
                <th class="column-title">Name</th>
                <th class="column-title">Trạng thái</th>
                <th class="column-title">Hiển thị Home</th>
                <th class="column-title">Kiểu hiển thị</th>
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
                            $status = Template::showItemStatus($controllerName, $val->status, $val->id);
                            $isHome = Template::showItemIsHome($controllerName, $val->is_home, $val->id);
                            $display = Template::showItemSelect($controllerName, $val->display, $val->id, 'display');
                            $createHistory = Template::showItemHistory($val->created_by, $val->created);
                            $modifiedHistory = Template::showItemHistory($val->modified_by, $val->modified);
                            $listBtnAction = Template::showButtonAction($controllerName, $val->id, $index);
                        @endphp
                        <tr class="{{ $class }} pointer" id="div-{{$val['id']}}">
                            <td class="index" data-index="{{ $index }}">{{ $index }}</td>
                            <td width="20%">
                                <p><strong>Name:</strong> {!! $name !!}</p>
                            </td>
                            <td>{!! $status !!}</td>
                            <td>{!! $isHome !!}</td>
                            <td>{!! $display !!}</td>
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