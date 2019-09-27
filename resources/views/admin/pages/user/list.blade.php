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
                <th class="column-title">Username</th>
                <th class="column-title">Email</th>
                <th class="column-title">Fullname</th>
                <th class="column-title">Level</th>
                <th class="column-title">Avatar</th>
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
                            $username = HighLight::show($val['username'], $params['search'], 'username');
                            $fullname = HighLight::show($val['fullname'], $params['search'], 'fullname');
                            $email = HighLight::show($val['email'], $params['search'], 'email');
                            $level = Template::showItemSelect($controllerName, $val->level, $val->id, 'level');
                            $avatar =  Template::showItemThumb($controllerName, $val->avatar, $username);
                            $status = Template::showItemStatus($controllerName, $val->status, $val->id);
                            $createHistory = Template::showItemHistory($val->created_by, $val->created);
                            $modifiedHistory = Template::showItemHistory($val->modified_by, $val->modified);
                            $listBtnAction = Template::showButtonAction($controllerName, $val->id, $index);
                        @endphp
                        <tr class="{{ $class }} pointer">
                            <td class="index" data-index="{{ $index }}">{{ $index }}</td>
                            <td width="10%">{!! $username !!}</td>
                            <td width="10%">{!! $email !!}</td>
                            <td width="10%">{!! $fullname !!}</td>
                            <td width="15%">{!! $level !!}</td>
                            <td width="5%">{!! $avatar !!}</td>
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