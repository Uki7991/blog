<?php

namespace App\Jobs;

use App\Models\Article;
use App\Models\Source;
use App\Services\ArticleService;
use Carbon\Carbon;

class ParseArticleJob extends Job
{
    public function __construct()
    {

    }

    public function handle(ArticleService $articleService)
    {
        foreach (Article::$themes as $theme) {
            $response = $articleService->getArticles($theme, 'technology', 1);

            if ($response->status === 'ok') {
                $article = $response->articles && isset($response->articles[0]) ? $response->articles[0] : null;

                if ($article) {
                    $source = Source::query()->firstOrCreate([
                        'source_id' => $article->source->id,
                        'title' => $article->source->name,
                    ]);

                    \Log::info('Source created: ' . $source->id);

                    $article = $source->articles()->updateOrCreate(
                        [
                            'title' => $article->title,
                        ],
                        [
                            'author' => $article->author,
                            'description' => $article->description,
                            'url' => $article->url,
                            'url_to_image' => $article->urlToImage,
                            'published_at' => Carbon::parse($article->publishedAt),
                            'content' => $article->content,
                        ]
                    );

                    \Log::info('Article created: ' . $article->id);
                }
            }
        }
    }
}
