<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request): array
    {
        $articles = Article::query()
            ->with(['source', 'theme'])
            ->filter($request)
            ->get()
            ->when($request->group, function ($collection, $value) {
                return $collection->groupBy($value);
            });

        return $articles->toArray();
    }
}
