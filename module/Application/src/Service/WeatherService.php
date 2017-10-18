<?php

namespace Application\Service;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class WeatherService
{
    protected $goutteClient;
    protected $telegramService;
    protected $telegramCId = '';

    public function __construct(Client $goutteClient, TelegramService $telegramService)
    {
        $this->goutteClient = $goutteClient;
        $this->telegramService = $telegramService;
    }

    public function getWeather()
    {
        $crawler = $this->goutteClient->request('GET', 'http://www.dwd.de/DE/fachnutzer/luftfahrt/teaser/luftsportberichte/fbeu40_edze_node.html');

        $crawler->filter('div.body-text')->each(function (Crawler $node) {
            $text = $node->html();
            $resultText = preg_match('/Hinweise für Segelflieger:(.*?)(Zeiten|Luftfahrtberatungszentrale)/s', $text, $matchText);
            $resultTime = preg_match('/gültig vom(.*?)\n/s', $text, $matchTime);

            if ($resultText != 1 || $resultTime != 1) {
                return;
            }

            if (!isset($matchText[1]) || !isset($matchTime[1])) {
                return;
            }

            $this->sendWeather(trim($matchText[1]), trim($matchTime[1]));
        });
    }

    public function sendWeather($text, $time)
    {
        $text .= ' *gültig von ' . $time . '* ';
        $text .= '[DWD](http://www.dwd.de/DE/fachnutzer/luftfahrt/teaser/luftsportberichte/fbeu40_edze_node.html)';

        echo $text . '<br>';
        $this->telegramService->sendTelegramMessage($this->telegramCId, $text, true);
    }
}