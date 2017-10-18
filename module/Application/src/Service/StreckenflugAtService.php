<?php

namespace Application\Service;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class StreckenflugAtService extends TableGateway
{
    protected $adapter;
    protected $goutteClient;
    protected $telegramService;
    protected $telegramCId = '';

    public function __construct(Adapter $adapter, Client $goutteClient, TelegramService $telegramService)
    {
        $this->adapter = $adapter;
        $this->goutteClient = $goutteClient;
        $this->telegramService = $telegramService;

        parent::__construct('sat_news', $adapter);
    }

    public function getNews()
    {
        $crawler = $this->goutteClient->request('GET', 'http://streckenflug.at/');

        $crawler->filter('div[id*=\'NEWS_\']')->each(function (Crawler $node) {
            $newsId = str_replace('NEWS_news_', '', $node->attr('id'));
            $date = $this->getDate($node);
            $title = $this->getTitle($node);
            $text = $this->getText($node);

            if (!isset($title) || substr($title, 0, 5) == 'Shop:') {
                return;
            }

            if (!isset($text)) {
                return;
            }

            if ($text == $title) {
                $text = '';
            }

            echo $newsId . '<br>';
            echo $date . '<br>';
            echo $title . '<br>';
            echo $text . '<br>';

            $result = $this->insertNews($newsId, $title, $text);

            echo $result ? 'OK' : 'vorhanden' . '<br>';
            echo '<hr>';
        });
    }

    private function getDate(Crawler $node)
    {
        $newsItem = $node->filter('td.ynewv');
        foreach ($newsItem as $key => $content) {
            $crawler = new Crawler($content);
            $text = trim($crawler->text());

            if ($key == 0 && strlen($text) == 10) {
                return $text;
            }
        }

        return null;
    }

    private function getTitle(Crawler $node)
    {
        $newsItem = $node->filter('td.ynewv');
        foreach ($newsItem as $key => $content) {
            $crawler = new Crawler($content);
            $text = trim($crawler->text());

            if ($key == 1 && strlen($text) != 0) {
                return $text;
            }
        }

        return null;
    }

    private function getText(Crawler $node)
    {
        $pNews = $node->filter('p.news');
        foreach ($pNews as $pNewsItem) {
            $crawler = new Crawler($pNewsItem);
            $text = trim($crawler->text());

            if (strlen($text) != 0) {
                return $text;
            }
        }

        return null;
    }

    private function insertNews($newsId, $title, $text)
    {
        $news = $this->select(['news_id' => $newsId])->current();

        if ($news) {
            return false;
        }

        $news = [
            'time' => date('Y-m-d H:i:s'),
            'news_id' => $newsId,
            'title' => $title,
            'text' => $text,
        ];
        $this->insert($news);

        return true;
    }

    public function sendNews()
    {
        $rowset = $this->select(function(Select $select)  {
            $select->where(['sent' => 0]);
            $select->limit(1);
        });

        foreach ($rowset as $news) {
            $this->update(['sent' => 1], ['id' => $news['id']]);

            $text = '*' . $news['title'] . '* ';
            //$text .= $news['text'] . ' ';
            $text .= '[streckenflug.at](http://streckenflug.at/index.php?IB=' . $news['news_id'] . ')';

            echo $text . '<br>';
            $this->telegramService->sendTelegramMessage($this->telegramCId, $text);
        }
    }
}