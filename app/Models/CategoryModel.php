<?php

namespace App\Models;

use App\Models\AdminModel;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class CategoryModel extends AdminModel
{
    public function __construct(){
        $this->table = 'category';
        $this->folderUpload = 'category';
        $this->fieldSearchAccepted = ['id', 'name'];
        $this->crudNotAccepted = ['_token'];
    }
    public function listItems($params = null, $options = null){ // lấy tất cả phần tử
        $result = null;
        if($options['task'] == 'admin-list-items'){
            $query = $this->select('id', 'name', 'status', 'is_home', 'display', 'created', 'created_by', 'modified', 'modified_by');
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
        }
        if($options['task'] == 'news-list-items'){
            $query = $this->select('id', 'name')
                        ->where('status', 'active')
                        ->limit(8);
            $result = $query->get()->toArray();
        }
        if($options['task'] == 'news-list-items-is-home'){
            $query = $this->select('id', 'name', 'display')
                        ->where('status', 'active')
                        ->where('is_home', 1);
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
        if($options['task'] == "change-is-home"){
            $is_home = ($params['currentIsHome'] == "yes") ? 0 : 1;
            $this::where('id', $params["id"])->update(['is_home' => $is_home]);
        }
        if($options['task'] == "add-item"){
            $params['created'] = date('Y-m-d');
            $params['created_by'] = 'Vu Tu';
            self::insert($this->prepareParams($params));
        }
        if($options['task'] == "edit-item"){
            $params['modified'] = date('Y-m-d');
            $params['modified_by'] = 'Vu Tu';
            self::where('id', $params['id'])->update($this->prepareParams($params));
        }
        if($options['task'] == "change-display"){
            $display = $params['currentDisplay'];
            self::where('id', $params['id'])->update(['display' => $display]);
        }
    }
    public function deleteItem($params = null, $options = null){
        if($options['task'] == "delete-item"){
            self::where('id', $params["id"])->delete();
        }
    }
    public function getItem($params = null, $options = null){
        $result = null;
        if($options['task'] == "get-item"){
            $result = self::select('id', 'name', 'status', 'is_home', 'display')->where('id', $params["id"])->first()->toArray();
        }
        return $result;
    }
}
