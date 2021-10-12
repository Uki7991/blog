<?php

namespace App\Services;

use jcobhams\NewsApi\NewsApi;

class ArticleService
{
    private $client;

    public function __construct(NewsApi $client)
    {
        $this->client = $client;
    }

    public function getArticles($q = null, $category = null, $pageSize = null): object
    {
        try {
            return $this->client->getTopHeadLines($q, null, null, $category, $pageSize);
        } catch (\Exception $exception) {
            \Log::critical($exception->getMessage());

            return new \stdClass();
        }
    }
}
