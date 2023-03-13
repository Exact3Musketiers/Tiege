<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Wiki
{
    // Get the end of a random wikipedia page url
    public static function getRandomPage()
    {
        return str_replace(
            'https://nl.wikipedia.org/wiki/',
            '',
            Http::get(
                'https://nl.wikipedia.org/wiki/Special:Random'
            )->handlerStats()['url']
        );
    }

    public static function wikiURL($page) {
        return str_replace(' ', '_', $page);
    }

    public static function getWikiPage($page = 'https://en.wikipedia.org/wiki/Special:Random', $pageId = null)
    {
        // Get all wanted data from page
        $wiki = Http::get('https://nl.wikipedia.org/w/api.php', [
            'format' => 'json',
            'action' => 'parse',
            'page' => $page,
            'prop' => 'wikitext|images',
            'iiprop' => 'url',
            'formatversion' => '2'
        ]);

        // Check if the api throws an error
        if (array_key_exists('error', $wiki->json())) {
            return '<h1>Oeps, daar ging iets mis</h1><p><a href="'.url()->previous().'">Ga weer terug naar waar je was.</a></p>';
        }

        // Get title and body of the page
        $title = $wiki->json()['parse']['title'];
        $wiki = $wiki->json()['parse']['wikitext'];

        // Add title
        $wiki = '<h1>'.$title.'</h1><hr>'.$wiki;
        // Make links
        $wiki = preg_replace_callback(
            '/\[\[(.*?)\]\]/',
            function ($matches) use ($pageId) {
                $exploded = explode('|', $matches[1]);
                return '<a href="'.route('wiki.show', ['wiki' => $pageId]).'?pg='.str_replace(' ', '_', $exploded[0]).'">'.$exploded[0].'</a>';
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
        // $wiki = preg_replace('/{{(.*?)}}/', '', $wiki);
        // $wiki = preg_replace('/{{Infobox/', '', $wiki);

        return $wiki;
    }
}
