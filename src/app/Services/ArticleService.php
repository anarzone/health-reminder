<?php

namespace App\Services;

use App\Http\Resources\ArticleResource;
use App\Models\Article;

class ArticleService
{
    public function __construct(private Article $articleModel)
    {
    }

    public function getAll(){
        return ArticleResource::collection($this->articleModel->latest()->get());
    }

    public function getSingle($id){
        return new ArticleResource($this->articleModel->where('id',$id)->first());
    }
}
