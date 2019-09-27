<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryModel as MainModel;
use App\Http\Requests\CategoryRequest as MainRequest;
use Config;

class CategoryController extends Controller
{
    private $pathViewController = 'admin.pages.category.';
    private $controllerName = 'category';
    private $params = [];
    private $model;
    public function __construct(){
        $this->params['pagination']['totalItemsPerPage'] = 10;
        $this->model = new MainModel();
        view()->share('controllerName', $this->controllerName);
    }
    public function index(Request $request){
        $this->params['filter']['status'] = $request->input('filter_status', 'all');
        $this->params['filter']['isHome'] = $request->input('filter_isHome', 'all');
        $this->params['filter']['display'] = $request->input('filter_display', 'all');
        if($this->params['filter']['isHome'] !== 'all' || $this->params['filter']['display'] !== 'all'){
            $this->params['filter']['status'] = '';
        }
        $this->params['search']['field'] = $request->input('search_field', '');
        $this->params['search']['value'] = $request->input('search_value', '');
        $items = $this->model->listItems($this->params, ['task' => 'admin-list-items']);
        $itemsStatusCount = $this->model->countItems($this->params, ['task' => 'admin-count-items-group-by-status']);
        $itemsIsHomeCount = $this->model->countItems($this->params, ['task' => 'admin-count-items-group-by-is-home']);
        $itemsDisplayCount = $this->model->countItems($this->params, ['task' => 'admin-count-items-group-by-display']);
        return view($this->pathViewController . 'index', [
            'items' => $items,
            'itemsStatusCount' => $itemsStatusCount,
            'itemsIsHomeCount' => $itemsIsHomeCount,
            'itemsDisplayCount' => $itemsDisplayCount,
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
    }

    public function isHome(Request $request){
        $params['id'] = $request->id;
        $params['currentIsHome'] =  $this->model->getItem($params, ['task' => 'get-current-ishome'])['is_home'];
        $params['currentIsHome'] = ($params['currentIsHome'] == 1) ? 'yes' : 'no';
        $tmplIsHome = Config::get('zvn.template.is_home');
        $this->model->saveItem($params, ['task' => 'change-is-home']);
        $changeIsHome = ($params['currentIsHome'] == 'yes') ? 'no' : 'yes';
        return response()->json([
            'message' => 'Cập nhật trạng thái hiển thị trang chủ thành công!',
            'ishome' => $tmplIsHome[$changeIsHome],
        ]);
    }

    public function display(Request $request){
        $params['currentDisplay'] = $request->display;
        $params['id'] = $request->id;
        $this->model->saveItem($params, ['task' => 'change-display']);
        return response()->json([
            'message' => 'Cập nhật kiểu hiển thị trang chủ thành công!',
        ]);
    }

}
