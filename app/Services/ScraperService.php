<?php

namespace App\Services;

use Goutte\Client;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

class ScraperService
{
    /**
     * Make a call to to specified url and return formatted data
     *
     * @param string $artist
     * @param string $song
     *
     * @return array
     */
    public function scrape(string $artist, string $song): array
    {
        $url = 'https://www.musixmatch.com/lyrics/' . $artist . '/' . $song;
        $service = 'MusixMatch';
        $client = new Client(HttpClient::create(['timeout' => 10, 'max_redirects' => 1]));

        $crawler = $client->request('GET', $url);

        sleep(0.5);

        //Gets unavailable messages
        $unavailable = $crawler->filter('.mxm-lyrics-not-available')->each(function ($node) {
            return $node->text();
        });

        if ($unavailable != null)
            //Formats unavailable message
            $lyrics[0] = preg_split('/(?=[A-Z])/', $unavailable[0])[1];
        else
            //Filters lyrics content
            $lyrics = $crawler->filter('.lyrics__content__error,.lyrics__content__ok,.lyrics__content__warning')->each(function ($node) {
                return $node->text();
            });

        //If no lyrics is available
        if ($lyrics == null)
            $lyrics[0] = 'No lyrics available';

        //If no lyrics is available try genius
        if ($unavailable != null || strpos($lyrics[0], "No lyrics available") === 0) {
            $service = 'Genius';
            $url = 'https://genius.com/' . $artist . '-' . $song . '-lyrics';
            $lyrics = $this->geniusFallback($url);
        }
//            dd($url, $lyrics, $unavailable, $unavailable == null, $unavailable != null || strpos($lyrics[0], "No lyrics available") === 0);

        return compact('lyrics', 'service');
    }

    //TODO: make genius a bit more stable, sometimes it just times out
    public function geniusFallback(string $url): array
    {
        $client = new Client(HttpClient::create(['timeout' => 10, 'max_redirects' => 1]));

        $crawler = $client->request('GET', $url);

        while ($crawler->getBaseHref() !== 'https://genius.com/') {
            $this->geniusFallback($url);
        }
        return $crawler->filter('.lyrics')->each(function ($node) {
            return $node->text();
        });
    }
}
