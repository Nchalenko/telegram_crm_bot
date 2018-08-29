<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Longman\TelegramBot;

class Controller extends BaseController
{
    private $botName;
    private $apiKey;

    public function __construct()
    {
        $this->botName = env('BOT_NAME');
        $this->apiKey  = env('BOT_API_KEY');
    }

    public function index()
    {
        try {
            // Create Telegram API object
            $telegram = new TelegramBot\Telegram($this->apiKey, $this->botName);

            // Enable MySQL
//            $telegram->enableMySql($mysql_credentials);
            $telegram->useGetUpdatesWithoutDatabase();

            if (false) {
                $keyboard = new TelegramBot\Entities\Keyboard([
                    ['text' => 'test'],
                    ['text' => 'test2'],
                    ['text' => 'https://core.telegram.org'],
                ]);

                //Return a random keyboard.
                $keyboard = $keyboard
                    ->setResizeKeyboard(true)
                    ->setOneTimeKeyboard(true)
                    ->setSelective(false);

                $result = TelegramBot\Request::sendMessage([
                    'chat_id' => 371302071,
                    'text' => 'Your utf8 text 😜 ...',
                    'reply_markup' => $keyboard,
                    'parse_mode' => 'HTML'
                ]);
            }

            TelegramBot\Request::sendMessage([
                'chat_id' => 371302071,
                'text' => 'https://core.telegram.org',
                'parse_mode' => 'HTML'
            ]);

            $q = TelegramBot\Request::getMe();
            error_log(print_r($q,1));

            // Handle telegram getUpdates request
            $a = $telegram->handleGetUpdates();

            error_log(print_r($a,1));


        } catch (TelegramBot\Exception\TelegramException $e) {
            print_r($e->getMessage());
            // log telegram errors
            //
        }
    }
}
