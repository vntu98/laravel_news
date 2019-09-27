<?php

namespace App\Models;

use App\Models\AdminModel;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class SliderModel extends AdminModel
{
    public function __construct(){
        $this->table = 'slider';
        $this->folderUpload = 'slider';
        $this->fieldSearchAccepted = ['id', 'name', 'description', 'link'];
        $this->crudNotAccepted = ['_token', 'thumb_current'];
    }
    public function listItems($params = null, $options = null){ // lấy tất cả phần tử
        $result = null;
        if($options['task'] == 'admin-list-items'){
            $query = $this->select('id', 'name', 'description', 'status', 'link', 'thumb', 'created', 'created_by', 'modified', 'modified_by');
            if($params['filter']['status'] !== 'all'){
                $query->where('status', $params['filter']['status']);
            }
            if($params['search']['value'] !== ''){
                if($params['search']['field'] == 'all'){
                    $query->where(function ($query) use ($params){
                        foreach($this->fieldSearchAccepted as $field){
                            $query->orWhere($field, 'LIKE', "%{$params['search']['value']}%");
                        }
                    });
                }else if(in_array($params['search']['field'], $this->fieldSearchAccepted)){
                    // $query->where($params['search']['field'], 'LIKE', '%' . $params['search']['value'] . '%');
                    $query->where($params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
                }
            }
            $result = $query->orderBy('id', 'desc')
                    ->paginate($params['pagination']['totalItemsPerPage']);
        }else if($options['task'] == 'news-list-items'){
            $query = $this->select('id', 'name', 'description', 'link', 'thumb')
                        ->where('status', 'active')
                        ->limit(5);
            $result = $query->get()->toArray();
        }
        return $result;
    }
    public function countItems($params = null, $options = null){ // lấy tất cả phần tử
        $result = null;
        if($options['task'] == 'admin-count-items-group-by-status'){
            $query = self::select(DB::raw('status, count(id) as count'));
            if($params['search']['value'] !== ''){
                if($params['search']['field'] == 'all'){
                    $query->where(function ($query) use ($params){
                        foreach($this->fieldSearchAccepted as $field){
                            $query->orWhere($field, 'LIKE', "%{$params['search']['value']}%");
                        }
                    });
                }else if(in_array($params['search']['field'], $this->fieldSearchAccepted)){
                    $query->where($params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
                }
            }
        }
        $result = $query->groupBy('status')->get()->toArray();
        return $result;
    }
    public function saveItem($params = null, $options = null){
        if($options['task'] == "change-status"){
            $status = ($params['currentStatus'] == "active") ? "inactive" : "active";
            $this::where('id', $params["id"])->update(['status' => $status]);
        }
        if($options['task'] == "add-item"){
            $params['thumb'] = $this->uploadThumb($params['thumb']);
            $params['created'] = date('Y-m-d');
            $params['created_by'] = (session('userInfo')) ? session('userInfo')['fullname'] : 'admin';
            self::insert($this->prepareParams($params));
        }
        if($options['task'] == "edit-item"){
            if(!empty($params['thumb'])){
                $this->deleteThumb($params['thumb_current']);
                $params['thumb'] = $this->uploadThumb($params['thumb']);
            }
            $params['modified'] = date('Y-m-d');
            $params['modified_by'] = (session('userInfo')) ? session('userInfo')['fullname'] : 'admin';
            self::where('id', $params['id'])->update($this->prepareParams($params));
        }
    }
    public function deleteItem($params = null, $options = null){
        if($options['task'] == "delete-item"){
            $item = self::getItem($params, ['task' => 'get-item']);
            $this->deleteThumb($item['thumb']);
            self::where('id', $params["id"])->delete();
        }
    }
    public function getItem($params = null, $options = null){
        $result = null;
        if($options['task'] == "get-item"){
            $result = self::select('id', 'name', 'description', 'status', 'link', 'thumb')->where('id', $params["id"])->first()->toArray();
        }
        if($options['task'] == "get-current-status"){
            $result = self::select('status')->where('id', $params["id"])->first()->toArray();
        }
        return $result;
    }
}
