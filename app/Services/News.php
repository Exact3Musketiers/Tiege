<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Vedmant\FeedReader\Facades\FeedReader;

class News
{
    public static function getNews()
    {
        $topics = [
            'https://nu.nl/rss/Wetenschap',
            'https://nu.nl/rss/film',
            'https://nu.nl/rss/cultuur-overig',
            'https://nu.nl/rss/Tech',
            'https://nu.nl/rss/Opmerkelijk',
        ];
        $news_array = [];
        $lengths = [];

        foreach ($topics as $key => $topic) {
            $news = FeedReader::read($topic);
            $items = $news->get_items();

            foreach ($items as $news) {
                $news_array[$key][] = [
                    'title' => $news->get_title(),
                    'description' => $news->get_description(),
                    'image' => $news->get_enclosure(),
                    'url' => $news->get_link()
                ];
            }

            $lengths[] = count($news_array[$key]);
        }

        $merged_news = [];
        $length = max($lengths);

        for ($i = 0; $i < $length; $i++) {
            for ($j = 0; $j <= count($topics); $j++) {
                if (isset($news_array[$j][$i])) {
                    $merged_news[] = $news_array[$j][$i];
                }
            }
        }

        return array_unique($merged_news, SORT_REGULAR);
    }

    public static function updateNews()
    {
        $news = self::getNews();
        Storage::put('json/news.json', json_encode($news));

    }

    public static function readNews($limit = 8)
    {
        if (Storage::exists('json/news.json') && !is_null($news = json_decode(Storage::get('json/news.json')))) {
            $articles = array_slice((array)$news, 0, $limit);
            $news = [
                'articles' => $articles,
            ];
        } else {
            $news = ['error' => 'Er is niets nieuws gebeurd'];
        }

        return $news;
    }
}
