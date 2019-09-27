@php
    use App\Helpers\Template;
    use App\Helpers\Form as FormTemplate;
    $formInputAttr = config('zvn.template.form_input');
    $formLabelAttr = config('zvn.template.form_label');
    $statusValue = ['default' => 'Select status', 'active' => config('zvn.template.status.active.name'), 'inactive' => config('zvn.template.status.inactive.name')];
    $levelValue = ['default' => 'Select level', 'admin' => config('zvn.template.level.admin.name'), 'member' => config('zvn.template.level.member.name')];
    $inputHiddenID = Form::hidden('id', $item['id']);
    $inputHiddenAvatar = Form::hidden('avatar_current', $item['avatar']);
    $inputHiddenTask = Form::hidden('task', 'add');
    $elements = [
        [
            'label' => Form::label('username', 'UserName: ', $formLabelAttr),
            'element' => Form::text('username', $item['username'], $formInputAttr)
        ],
        [
            'label' => Form::label('email', 'Email: ', $formLabelAttr),
            'element' => Form::text('email', $item['email'], $formInputAttr)
        ],
        [
            'label' => Form::label('fullname', 'FullName: ', $formLabelAttr),
            'element' => Form::text('fullname', $item['fullname'], $formInputAttr)
        ],
        [
            'label' => Form::label('password', 'Password: ', $formLabelAttr),
            'element' => Form::password('password', $formInputAttr)
        ],
        [
            'label' => Form::label('password_confirmation', 'Password Confirmation: ', $formLabelAttr),
            'element' => Form::password('password_confirmation', $formInputAttr)
        ],
        [
            'label' => Form::label('level', 'Level: ', $formLabelAttr),
            'element' => Form::select('level', $levelValue, $item['level'], ['class' => 'form-control col-md-6 col-xs-12'])
        ],
        [
            'label' => Form::label('status', 'Status: ', $formLabelAttr),
            'element' => Form::select('status', $statusValue, $item['status'], ['class' => 'form-control col-md-6 col-xs-12'])
        ],
        [
            'label' => Form::label('avatar', 'Avatar: ', $formLabelAttr),
            'element' => Form::file('avatar', $formInputAttr),
            'avatar' => (!empty($item['id'])) ? Template::showItemThumb($controllerName, $item['avatar'], $item['username']) : null,
            'type' => 'avatar'
        ],
        [
            'element' => $inputHiddenID . $inputHiddenAvatar . $inputHiddenTask . Form::submit('Save', ['class' => 'btn btn-success']),
            'type' => "btn-submit"
        ],
    ];
@endphp
<!--box-lists-->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title', ['title' => 'Form'])
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


