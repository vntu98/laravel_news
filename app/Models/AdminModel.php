<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class AdminModel extends Model
{
    protected $table = ''; // tương tác với table
    protected $folderUpload = '';
    public $timestamps = false; // tự cập nhật thời gian created_at, updated_at = tắt
    const CREATED_AT = 'created'; // cấu hình lại created_at
    const UPDATED_AT = 'modified'; // cấu hình lại updated_at
    protected $fieldSearchAccepted = [
        'id',
        'name'  
    ];
    protected $crudNotAccepted = [
        '_token',
        'thumb_current',
    ];
    public function deleteThumb($thumbName){
        Storage::disk('storage_image')->delete($this->folderUpload . '/' .$thumbName);
    }
    public function uploadThumb($thumbObj){ // $thumObj: UploadFile
        $thumbName = Str::random(10) . '.' . $thumbObj->clientExtension();
        $thumbObj->storeAs($this->folderUpload, $thumbName, 'storage_image');
        return $thumbName;
    }
    public function prepareParams($params){
        return array_diff_key($params, array_flip($this->crudNotAccepted));
    }
}
