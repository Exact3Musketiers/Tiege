<?php

namespace App\Services;

use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

class ScraperService
{
    /**
     * Make a call to to specified url and return formatted data
     *
     * @param string $url
     *
     * @return array
     */
    public function scrape(string $url)
    {
        $client = new Client(HttpClient::create(['timeout' => 10, 'max_redirects' => 1]));

        $crawler = $client->request('GET', $url);
//        while ($crawler->getBaseHref() !== 'https://genius.com/') {
//            redirect()->route('lyrics');
//        }
        sleep(0.5);
        $unavailable = $crawler->filter('.mxm-lyrics-not-available')->each(function ($node) {
            return $node->text();
        });
        if ($unavailable != null)
            $lyrics[0] = preg_split('/(?=[A-Z])/', $unavailable[0])[1];
        else
            $lyrics = $crawler->filter('.lyrics__content__error,.lyrics__content__ok,.lyrics__content__warning')->each(function ($node) {
                return $node->text();
            });
        if($lyrics == null)
            $lyrics[0] = 'No lyrics available ' . $url;

//        dd($url, $lyrics, $unavailable, $unavailable == null);

        return compact('lyrics');
    }


}
