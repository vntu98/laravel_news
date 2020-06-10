<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Config;
use App\Models\UserModel as MainModel;
use App\Http\Requests\UserRequest as MainRequest;
use App\Repositories\User\UserRepositoryInterface;

class UserController extends Controller
{
    private $pathViewController = 'admin.pages.user.';
    private $controllerName = 'user';
    private $params = [];
    private $model;
    private $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    ){
        $this->userRepository = $userRepository;
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
            // $item = $this->model->getItem($params, ['task' => 'get-item']);
            $item = $this->userRepository->findById($params['id']);
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

    public function changePassword(MainRequest $request){
        if($request->method() == 'POST'){
            $params = $request->all();
            $this->model->saveItem($params, ['task' => 'change-password']);

        }
        return redirect()->route($this->controllerName)->with('zvn_notify', 'Thay đổi mật khẩu thành công!');
    }

    public function changeLevel(MainRequest $request){
        if($request->method() == 'POST'){
            $params = $request->all();
            $this->model->saveItem($params, ['task' => 'change-level-post']);

        }
        return redirect()->route($this->controllerName)->with('zvn_notify', 'Thay đổi level thành công!');
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

    public function level(Request $request){
        $params['currentLevel'] = $request->level;
        $params['id'] = $request->id;
        $this->model->saveItem($params, ['task' => 'change-level']);
        return response()->json([
            'message' => 'Cập nhật level thành công!!',
        ]);
    }

}
