<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class News
{

    public static function getNews()
    {
        return Http::get('https://newsapi.org/v2/top-headlines', [
            'country' => 'nl',
            'pageSize' => '20',
            'apiKey' => config('services.news.key'),
        ]);
    }

    public static function writeNews()
    {
        if (!file_exists('news.json')) {
            $newsResponse = self::getNews();
            file_put_contents('news.json', $newsResponse);
        }

        self::refreshNews();
    }

    public static function readNews($limit, $retry = false)
    {
        self::writeNews();

        if (file_exists('news.json')) {
            $updatedAt = date('H:m:s', filemtime('news.json'));
            $news = json_decode(file_get_contents('news.json'));
            $articles = array_slice($news->articles, 0, $limit);
            $news = [
                'articles' => $articles,
                'updatedAt' => $updatedAt,
            ];
        } else {
            $news = ['error' => 'Er is niets nieuws gebeurd'];
        }

        return $news;
    }

    public static function refreshNews(): void
    {
        $currentTime = time();
        $age = filemtime('news.json');
        $timeDifference = $currentTime - $age;

        if ($timeDifference >= 3600) {
            // Call NewsAPI
            $newsResponse = self::getNews();
            file_put_contents('news.json', $newsResponse);
        }
    }
}
