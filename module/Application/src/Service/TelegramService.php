<?php

namespace Application\Service;

use Zend\Http\Request;
use Zend\Http\Response;

class TelegramService
{

    public function __construct()
    {
    }

    public function sendTelegramMessage($cId, $text, $webPreview = false)
    {
        $botToken = '';

        $requestData = [
            'chat_id' => $cId,
            'parse_mode' => 'Markdown',
            'text' => $text,
            'disable_notification' => true,
            'disable_web_page_preview' => $webPreview,
        ];

        $request = new Request();
        $request->setUri('https://api.telegram.org/bot' . $botToken . '/sendMessage');
        $request->setMethod('POST');
        $request->getPost()->fromArray($requestData);

        $client = new \Zend\Http\Client();
        $client->setOptions(['timeout' => 20]);
        $client->setEncType(\Zend\Http\Client::ENC_URLENCODED);

        /** @var $response Response */
        $response = $client->dispatch($request);

        echo $response->getStatusCode() . '<br>';
        echo $response->getBody() . '<br>';
        echo '<hr>';
    }
}