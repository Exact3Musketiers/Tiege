<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Wiki
{
    // Get the end of a random wikipedia page url
    public static function getRandomPage()
    {
        $wiki = json_decode(file_get_contents('files/wikipedia.json'), true);
        $random = rand(0, count($wiki) - 1);
        return $wiki[$random]['article'];
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
// dd($wiki);
        // Add title
        $wiki = '<h1>'.$title.'</h1><hr />'.$wiki;

        // Make links
        $wiki = preg_replace_callback(
            '/(?:\[\[Bestand:)(.*?)(?:\|.*?\]\]\n)/',
            function ($matches) {
                return '<div><img src="https://en.wikipedia.org/wiki/Special:Filepath/'.self::wikiURL($matches[1]).'" class="rounded float-end ms-3" width="260px" /></div>';
            },
            $wiki
        );

        // Make links
        $wiki = preg_replace_callback(
            '/\[\[(.*?)\]\]/',
            function ($matches) use ($pageId) {
                $exploded = explode('|', $matches[1]);
                return '<a href="'.route('wiki.show', ['wiki' => $pageId]).'?pg='.self::wikiURL($exploded[0]).'">'.$exploded[0].'</a>';
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
                return '<h2 class="pt-3">'.$matches[1].'</h2><hr />';
            },
            $wiki
        );

        $wiki = preg_replace_callback(
            '/(?:{{Zie hoofdartikel\|)(.*?)(?:}})/s',
            function ($matches) use($pageId) {
                return '<span>Zie hoofdartikel: </span><a href="'.route('wiki.show', ['wiki' => $pageId]).'?pg='.self::wikiURL($matches[1]).'">'.$matches[1].'</a>';
            },
            $wiki
        );
        
        $wiki = preg_replace('/(?:{{Zie ook\|)(.*?)(?:}})/s', '$1', $wiki);
        
        $wiki = preg_replace_callback(
            '/(?:{{Kolommen lijst.*?inhoud=\n\* )(.*?)(?:}})/s',
            function ($matches) {
                $items = explode('* ',$matches[1]);
                return '<div class="row row-cols-2 row-cols-md-3"><div class="col">'.implode("</div>\n<div class=\"col\">", $items).'</div></div>';
            },
            $wiki
        );
        
        $wiki = str_replace([
                    '{|', 
                    "\n|-\n|", 
                    "\n| style=\"padding-left: 1em;\" |", 
                    "\n|}\n"
                ], [
                    '<div class="row row-cols-2"><div class="col"><ul', 
                    '><li class="ps-3 py-0">', 
                    '</div><div class="col">', 
                    '</ul></div></div>'
                ], $wiki
            );

        $wiki = preg_replace_callback(
            '/(\*\*)(.*?)(?:\n)/s',
            function ($matches) {
                return '</li><ul><li class="ps-3 py-0">'.$matches[2].'</ul></li>';
            },
            $wiki
        );

        $wiki = preg_replace_callback(
            '/(\* )(.*?)(?:\n)/s',
            function ($matches) {
                return '</li><li>'.$matches[2].'</li>';
            },
            $wiki
        );

        // dd($wiki);


        $wiki = preg_replace('/({{Bron\?.*?}})/s', '', $wiki);
        // dd($match);
        
        $wiki = str_replace(["'''", "''"], '', $wiki);

        // Remove quotes around title
        // $wiki = preg_replace('/\'\'\'\'\'/', '', $wiki);
        // $wiki = preg_replace('/\'\'\'/', '', $wiki);
        // Remove info boxes
        // $wiki = preg_replace('/\|(.*?)\n/', '', $wiki);
        // $wiki = preg_replace('/{{(.*?)\n}}/', '', $wiki);
        // $wiki = preg_replace('/{{(.*?)}}/', '', $wiki);
        // $wiki = preg_replace('/{{(.*?)}}/', '', $wiki);
        // $wiki = preg_replace('/{{Infobox/', '', $wiki);
        // $wiki = preg_replace('/{{Zie hoofdartikel/', '', $wiki);
        // $wiki = preg_replace('/{{Zie ook/', '', $wiki);

        return $wiki;
    }
}
