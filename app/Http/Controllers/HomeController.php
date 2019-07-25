<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\SliderModel;
use App\Models\CategoryModel;

class HomeController extends Controller
{
    private $pathViewController = 'news.pages.home.';
    private $controllerName = 'home';
    private $params = [];
    private $model;
    public function __construct(){
        view()->share('controllerName', $this->controllerName);
    }
    public function index(Request $request){
        $sliderModel = new SliderModel();
        $categoryModel = new CategoryModel();
        $itemsSlider = $sliderModel->listItems(null, ['task' => 'news-list-items']);
        $itemsCategory = $categoryModel->listItems(null, ['task' => 'news-list-items-is-home']);
        return view($this->pathViewController . 'index', [
            'params' => $this->params,
            'itemsSlider' => $itemsSlider,
            'itemsCategory' => $itemsCategory
        ]);
    }
}
