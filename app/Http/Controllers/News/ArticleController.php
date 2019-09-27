<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\ArticleModel;

class ArticleController extends Controller
{
    private $pathViewController = 'news.pages.article.';
    private $controllerName = 'article';
    private $params = [];
    private $model;
    public function __construct(){
        view()->share('controllerName', $this->controllerName);
    }
    public function index(Request $request){
        $params['article_id'] = $request->article_id;
        $articleModel = new ArticleModel();
        $categoryModel = new CategoryModel();
        $itemArticle = $articleModel->getItem($params, ['task' => 'news-get-item']);
        if(empty($itemArticle)) return redirect()->route('home');
        $itemsLatest= $articleModel->listItems(null, ['task' => 'news-list-items-latest']);
        $params['category_id'] = $articleModel::find($itemArticle['id'])->category['id'];
        $itemCategory = $categoryModel->getItem($params, ['task' => 'news-get-item']);
        $itemArticle['related_articles'] = $articleModel->listItems($params, ['task' => 'news-list-items-related-in-category']);
        
        return view($this->pathViewController . 'index', [
            'params' => $this->params,
            'itemsLatest' => $itemsLatest,
            'itemArticle' => $itemArticle
        ]);
    }
}
