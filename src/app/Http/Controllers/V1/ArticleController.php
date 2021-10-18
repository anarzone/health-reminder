<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArticleController extends Controller
{
    public function __construct(private ArticleService $articleService)
    {
        $this->middleware('auth:sanctum');
    }

    public function index(){
        return Response::success($this->articleService->getAll());
    }

    public function show($id){
        return Response::success($this->articleService->getSingle($id));
    }
}
