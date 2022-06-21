<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class Wiki
{
    public static function getWikiPage($page = 'https://en.wikipedia.org/wiki/Special:Random')
    {
        $page = str_replace(
            'https://nl.wikipedia.org/wiki/',
            '',
            Http::get(
                'https://nl.wikipedia.org/wiki/Special:Random'
            )->handlerStats()['url']
        );
        // $page = str_replace(
        //     'https://nl.wikipedia.org/wiki/',
        //     '',
        //     Http::get(
        //         'https://nl.wikipedia.org/wiki/Parallelia abnegans'
        //     )->handlerStats()['url']
        // );
        // $page = str_replace(
        //     'https://nl.wikipedia.org/wiki/',
        //     '',
        //     Http::get(
        //         'https://nl.wikipedia.org/wiki/Ginny_Wemel'
        //     )->handlerStats()['url']
        // );

        $wiki = Http::get('https://nl.wikipedia.org/w/api.php', [
            'format' => 'json',
            'action' => 'parse',
            'page' => $page,
            'prop' => 'wikitext|images',
            'iiprop' => 'url',
            'formatversion' => '2'
        ]);

        // $wiki = $wiki->json();
        // dd($wiki->json());
        $title = $wiki->json()['parse']['title'];
        $wiki = $wiki->json()['parse']['wikitext'];


            // Add title
            $wiki = '<h1>'.$title.'</h1><hr>'.$wiki;
            // Make links
            $wiki = preg_replace_callback(
                '/\[\[(.*?)\]\]/',
                function ($matches) {
                    $exploded = explode('|', $matches[1]);
                    return '<a href="https://nl.wikipedia.org/wiki/'.str_replace(' ', '_', $exploded[0]).'">'.$exploded[0].'</a>';
                },
                $wiki
            );
            // Create H3s
            $wiki = preg_replace_callback(
                '/===(.*?)===/',
                function ($matches) {
                    return '<h3 class="pt-3">'.$matches[1].'</h3>';
                },
                $wiki
            );
            // Create heading 2s
            $wiki = preg_replace_callback(
                '/==(.*?)==/',
                function ($matches) {
                    return '<h2 class="pt-3">'.$matches[1].'</h2><hr>';
                },
                $wiki
            );
            // Remove quotes around title
            $wiki = preg_replace('/\'\'\'\'\'/', '', $wiki);
            $wiki = preg_replace('/\'\'\'/', '', $wiki);
            // Remove info boxes
            $wiki = preg_replace('/\|(.*?)\n/', '', $wiki);
            $wiki = preg_replace('/{{(.*?)\n}}/', '', $wiki);
            $wiki = preg_replace('/{{(.*?)}}/', '', $wiki);
            $wiki = preg_replace('/{{(.*?)}}/', '', $wiki);
            // $wiki = preg_replace('/{{Infobox/', '', $wiki);

            return $wiki;
    }
}
