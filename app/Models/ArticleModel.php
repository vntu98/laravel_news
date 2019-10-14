<?php

namespace App\Models;

use App\Models\AdminModel;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class ArticleModel extends AdminModel
{
    public function __construct(){
        $this->table = 'article';
        $this->folderUpload = 'article';
        $this->fieldSearchAccepted = ['name', 'content'];
        $this->crudNotAccepted = ['_token', 'thumb_current'];
    }
    public function listItems($params = null, $options = null){ // lấy tất cả phần tử
        $result = null;
        if($options['task'] == 'admin-list-items'){
            $query = $this->select('id', 'name', 'content', 'status', 'thumb', 'type');
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
            $query = $this->select('id', 'name', 'description', 'thumb')
                        ->where('status', 'active')
                        ->limit(5);
            $result = $query->get()->toArray();
        }
        if($options['task'] == 'news-list-items-featured'){
            $query = $this->select('id', 'name', 'content', 'status', 'thumb', 'type', 'created', 'created_by')
                    ->where('status', 'active')
                    ->where('type', 'featured')
                    ->orderBy('id', 'desc')
                    ->take(3);
            $result = $query->get()->toArray();
        }
        if($options['task'] == 'news-list-items-latest'){
            $query = $this->select('id', 'name', 'content', 'status', 'thumb', 'type', 'created', 'created_by')
                    ->where('status', 'active')
                    ->orderBy('id', 'desc')
                    ->take(4);
            $result = $query->get()->toArray();
        }
        if($options['task'] == 'news-list-items-most-viewed'){
            $query = $this->select('id', 'name', 'content', 'status', 'thumb', 'type', 'views', 'created', 'created_by')
                    ->where('status', 'active')
                    ->orderBy('views', 'desc')
                    ->take(3);
            $result = $query->get()->toArray();
        }
        if($options['task'] == 'news-list-items-in-category'){
            $query = $this->select('id', 'name', 'content', 'thumb', 'created', 'created_by')
                    ->where('status', 'active')
                    ->where('category_id', $params['category_id'])
                    ->take(4);
            $result = $query->get()->toArray();
        }
        if($options['task'] == 'news-list-items-related-in-category'){
            $query = $this->select('id', 'name', 'content', 'thumb', 'created', 'created_by')
                    ->where('status', 'active')
                    ->where('category_id', $params['category_id'])
                    ->where('id', '!=', $params['article_id'])
                    ->take(4);
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
        if($options['task'] == "change-type"){
            $type = ($params['currentType'] == "featured") ? "featured" : "normal";
            $this::where('id', $params["id"])->update(['type' => $type]);
        }
        if($options['task'] == "news-access-view"){
            $views = $this->getItem($params, ['task' => 'get-views-item'])['views'];
            $this::where('id', $params["article_id"])->update(['views' => ($views + 1)]);
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
            $result = self::select('id', 'category_id', 'name', 'content', 'status', 'thumb')->where('id', $params["id"])->first()->toArray();
        }
        if($options['task'] == "get-views-item"){
            $result = self::select('views')->where('id', $params["article_id"])->first()->toArray();
        }
        if($options['task'] == "get-current-status"){
            $result = self::select('status')->where('id', $params["id"])->first()->toArray();
        }
        if($options['task'] == "news-get-item"){
            $result = self::select('id', 'category_id', 'name', 'content', 'status', 'thumb', 'created', 'created_by')->where('id', $params["article_id"])->first();
            if($result) $result = $result->toArray();
        }
        return $result;
    }
    public function category()
    {
        return $this->belongsTo('App\Models\CategoryModel');
    }
}
