<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Config;
use App\Models\SliderModel as MainModel;
use App\Http\Requests\SliderRequest as MainRequest;

class SliderController extends Controller
{
    private $pathViewController = 'admin.pages.slider.';
    private $controllerName = 'slider';
    private $params = [];
    private $model;
    public function __construct(){
        $this->params['pagination']['totalItemsPerPage'] = 5;
        $this->model = new MainModel();
        view()->share('controllerName', $this->controllerName);
    }
    public function index(Request $request){
        $this->params['filter']['status'] = $request->input('filter_status', 'all');
        $this->params['search']['field'] = $request->input('search_field', '');
        $this->params['search']['value'] = $request->input('search_value', '');
        $items = $this->model->listItems($this->params, ['task' => 'admin-list-items']);
        $itemsStatusCount = $this->model->countItems($this->params, ['task' => 'admin-count-items-group-by-status']);
        return view($this->pathViewController . 'index', [
            'items' => $items,
            'itemsStatusCount' => $itemsStatusCount,
            'params' => $this->params
        ]);
    }
    
    public function form(Request $request){
        $item = null;
        if($request->id !== null){
            $params['id'] = $request->id;
            $item = $this->model->getItem($params, ['task' => 'get-item']);
        }
        return view($this->pathViewController . 'form', [
            'item' => $item
        ]);
    }

    public function save(MainRequest $request){
        if($request->method() == 'POST'){
            $params = $request->all();
            $task = 'add-item';
            $notify = 'Thêm mới phần tử thành công!';
            if($params['id'] !== null){
                $task = 'edit-item';
                $notify = 'Cập nhật phần tử thành công!';
            }
        }
        $this->model->saveItem($params, ['task' => $task]);
        return redirect()->route($this->controllerName)->with('zvn_notify', $notify);
    }

    public function delete(Request $request){
        $params['id'] = $request->id;
        $this->model->deleteItem($params, ['task' => 'delete-item']);
        return response()->json([
            'message' => "Xóa thành công!"
        ]);
    }

    public function status(Request $request){
        $params['id'] = $request->id;
        $params['currentStatus'] =  $this->model->getItem($params, ['task' => 'get-current-status'])['status'];
        $tmplStatus = Config::get('zvn.template.status');
        $changeStatus = ($params['currentStatus'] == 'active') ? 'inactive' : 'active';
        $this->model->saveItem($params, ['task' => 'change-status']);
        return response()->json([
            'message' => 'Cập nhật trạng thái thành công!',
            'status' => $tmplStatus[$changeStatus],
            'value' => $changeStatus
        ]);
        // return redirect()->route($this->controllerName)->with('zvn_notify', 'Cập nhật trạng thái thành công!');
    }

}
