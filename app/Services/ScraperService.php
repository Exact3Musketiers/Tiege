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
    public function scrap($url)
    {
        $client  = new Client(HttpClient::create(['timeout' => 100000000]));
        $crawler = $client->request('GET', $url);

        $lyrics = $crawler->filter('.lyrics')->each(function ($node) {
            return $node->text();
        });
        return compact('lyrics');
    }
}
