<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Vedmant\FeedReader\Facades\FeedReader;

class News
{
    public static function getNews()
    {
        $news = FeedReader::read('https://nu.nl/rss/Wetenschap');
        $news_array = [];
        $items = $news->get_items();

        foreach ($items as $news) {
            $news_array[] = [
                'title' => $news->get_title(),
                'description' => $news->get_description(),
                'image' => $news->get_enclosure(),
                'url' => $news->get_link()
            ];
        }

        return $news_array;
    }

    public static function updateNews()
    {
        $news = self::getNews();
        Storage::put('json/news.json', json_encode($news));

    }

    public static function readNews($limit = 8)
    {
        if (Storage::exists('json/news.json') && !is_null($news = json_decode(Storage::get('json/news.json')))) {
            $articles = array_slice($news, 0, $limit);
            $news = [
                'articles' => $articles,
            ];
        } else {
            $news = ['error' => 'Er is niets nieuws gebeurd'];
        }

        return $news;
    }
}
