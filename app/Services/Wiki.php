<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

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
    
    public static function hashPage($page) {
        return md5(self::wikiURL($page.config('services.salt')));
    }

    public static function getWikiDescription($page) {
        // Get all wanted data from page
        $wiki = Http::get('https://nl.wikipedia.org/api/rest_v1/page/summary/'.$page);

        // Check if the api throws an error
        if (array_key_exists('error', $wiki->json())) {
            return '<h1>Oeps, daar ging iets mis</h1><p><a href="'.url()->previous().'">Ga weer terug naar waar je was.</a></p>';
        }

        return $wiki->json()['extract'];
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
            Session::put('toErrorPage', true);
            return '<h1>Oeps, daar ging iets mis</h1><p><a href="'.url()->previous().'">Ga weer terug naar waar je was.</a></p>';
        }


        // Get title and body of the page
        $title = $wiki->json()['parse']['title'];
        $wiki = $wiki->json()['parse']['wikitext'];

        if (strpos($wiki, '#REDIRECT') !== false || strpos($wiki, '#DOORVERWIJZING') !== false) {
            Session::put('throughRedirectPage', true);

            $explode = explode('[[', $wiki);
            $page = str_replace(']]', '', $explode[1]);

            return header("location: " . route('wiki.show', ['wiki' => $pageId , 'pg' => self::wikiURL($page), 'hash' => self::hashPage($page)]));
        }

        $wiki = preg_replace([
            '/(style=".*?;")/', 
            '/(colspan=".*?")/',
            '/(rowspan=".*?")/',
            '/(bgcolor=".*?")/',
        ], '', $wiki);


        // Add title
        $wiki = '<h1>'.$title.'</h1><hr />'.$wiki;

        // Make infobox images
        $wiki = preg_replace_callback(
            '/(?:afbeelding.*?= )(.*?\.jpg)/',
            function ($matches) {
                return 'Afbeelding</div><div class="col px-0"><img src="https://en.wikipedia.org/wiki/Special:Filepath/'.self::wikiURL($matches[1]).'" class="rounded img-fluid" />';
            },
            $wiki
        );
        
        // Make infobox images
        $wiki = preg_replace_callback(
            '/(?:handtekening.*?= )(.*?\.svg)/',
            function ($matches) {
                return 'Afbeelding</div><div class="col px-0"><img src="https://en.wikipedia.org/wiki/Special:Filepath/'.self::wikiURL($matches[1]).'" class="rounded img-fluid" />';
            },
            $wiki
        );

        // Make infobox
        $wiki = preg_replace_callback(
            '/(?:{{Infobox.*?\| )(.*?)(?:\n}}\n?)/s',
            function ($matches) {
                $matches = str_replace(["\n|", ' = ', ' =', '= '], '</div><div class="col px-0">', $matches);
                return '<div class="row row-cols-2 float-none float-lg-end border rounded ms-3 mb-3 px-2" style="width:300px; clear:right;"><div class="col px-0">'.$matches[1].'</div></div>';
            },
            $wiki
        );

        // Make images
        $wiki = preg_replace_callback(
            '/(?:\[\[Bestand:)(.*?)(?:\|.*?\]\]\n)/',
            function ($matches) {
                return '<div><img src="https://en.wikipedia.org/wiki/Special:Filepath/'.self::wikiURL($matches[1]).'" class="rounded float-end ms-3 img-fluid" width="260px" style="clear:right;" /></div>';
            },
            $wiki
        );

        // Make links
        $wiki = preg_replace_callback(
            '/\[\[(.*?)\]\]/',
            function ($matches) use ($pageId) {
                $exploded = explode('|', $matches[1]);
                return '<a href="'.route('wiki.show', ['wiki' => $pageId, 'pg' => self::wikiURL($exploded[0]), 'hash' => self::hashPage($exploded[0])]).'">'.$exploded[0].'</a>';
            },
            $wiki
        );

        // Create heading 3s
        $wiki = preg_replace_callback(
            '/====(.*?)====/',
            function ($matches) {
                return '<h4 class="pt-3">'.$matches[1].'</h4>';
            },
            $wiki
        );

        // Create heading 3s
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

        // Create parent article links
        $wiki = preg_replace_callback(
            '/(?:{{Zie hoofdartikel\|)(.*?)(?:}})/s',
            function ($matches) use($pageId) {
                return '<span>Zie hoofdartikel: </span><a href="'.route('wiki.show', ['wiki' => $pageId, 'pg' => self::wikiURL($matches[1]), 'hash' => self::hashPage($matches[1])]).'">'.$matches[1].'</a>';
            },
            $wiki
        );
        
        // Create see also links
        $wiki = preg_replace('/(?:{{Zie ook\|)(.*?)(?:}})/s', '$1', $wiki);
        
        
        // Create column list
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
                    "\n|- \n|", 
                    "\n|  |", 
                    "|}",
                    "",
                ], [
                    '<div class="row row-cols-2 w-100"><div class="col w-100"><ul', 
                    '><li class="ps-3 py-0">', 
                    '><li class="ps-3 py-0">', 
                    '</div><div class="col">', 
                    '</ul></div></div>',
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
            '/(\*)(.*?)(?:\n)/s',
            function ($matches) {
                return '</li><li>'.$matches[2].'</li>';
            },
            $wiki
        );

        // Remove tables, book links, bron
        $wiki = preg_replace_array(['/({{Tabel.*?\n\|.*?\n}}\n)/s', '/(<div style="overflow-x:auto;">.*?<\/div>)/s', '/(\[http:\/\/books.*?\])/s', '/({{Bron.*?}})/s', '/({{Citeer.*?}})/s'], [''], $wiki);
        
        // Remove a bunch of stuff
        $wiki = str_replace(["'''", "''", "<small>", "</small>", "]]"], '', $wiki);
        $wiki = str_replace('{{Zie dp}}', '<a href="https://nl.wikipedia.org/wiki/'.self::wikiURL($page).'_(doorverwijspagina)">Zie doorverwijspagina</a><br /><br />', $wiki);

        return $wiki;
    }
}
