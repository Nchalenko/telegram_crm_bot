<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Longman;

use Telegram\Bot\Api;


class TelegramController extends BaseController
{
    private $botName;
    private $apiKey;
    private $commandsPath;
    private $hookUrl;

    public function __construct()
    {
        $this->botName = env('BOT_NAME');
        $this->apiKey  = env('BOT_API_KEY');
        $this->commandsPath = env('COMMANDS_PATH');
        $this->hookUrl = 'https://telegram-crm-bot.gq/ololo-tele-hook';
    }
    

    public function test_new_api()
    {
        error_log(print_r(__FUNCTION__,1));
        $telegram = new Api($this->apiKey);



        $response = $telegram->getMe();
        error_log(print_r(1,1));
        error_log(print_r($response,1));

        $response = $telegram->setWebhook(['url' => $this->hookUrl]);
        error_log(print_r(2,1));
        error_log(print_r($response,1));

        $updates = $telegram->getWebhookUpdates();
        
        error_log(print_r(3,1));
        error_log(print_r($updates,1));

    }

    public function index()
    {
        try {
            // Create Telegram API object
            $telegram = new Longman\TelegramBot\Telegram($this->apiKey, $this->botName);

            // Enable MySQL
//            $telegram->enableMySql($mysql_credentials);
            $telegram->useGetUpdatesWithoutDatabase();

//            TelegramBot\Request::send('help', [
//                'text' => 'Hello'
//            ]);

            if (false) {
                $keyboard = new Longman\TelegramBot\Entities\Keyboard([
                    ['text' => 'test'],
                    ['text' => 'test2'],
                    ['text' => 'https://core.telegram.org'],
                ]);

                //Return a random keyboard.
                $keyboard = $keyboard
                    ->setResizeKeyboard(true)
                    ->setOneTimeKeyboard(true)
                    ->setSelective(false);

                $result = Longman\TelegramBot\Request::sendMessage([
                    'chat_id' => 371302071,
                    'text' => 'Your utf8 text 😜 ...',
                    'reply_markup' => $keyboard,
                    'parse_mode' => 'HTML'
                ]);
            }

            Longman\TelegramBot\Request::sendMessage([
                'chat_id' => 371302071,

                'text' => 'https://core.telegram.org',
                'parse_mode' => 'HTML'
            ]);

//            $telegram->addCommandsPaths([__DIR__ . $this->commandsPath]);
//            $c = $telegram->getCommandsList();
//            error_log(print_r($c,1));
            $admin_users = [];
            $telegram->enableAdmins($admin_users);
            $telegram->enableLimiter();
//            // Handle telegram getUpdates request

            $server_response = $telegram->handleGetUpdates();
//
////            $server_response = TelegramBot\Request::getUpdates();
//
//            $server_response = Longman\TelegramBot\Request::send('getUpdates', ['limit' => 5]);
//
//            if ($server_response->isOk()) {
//                $results = $server_response->getResult();
//
//                echo "<pre>";
//                //Process all updates
//                /** @var Update $result */
//                foreach ($results as $result) {
//                    error_log(print_r($result,1));
//                    var_dump($result);
//                    $telegram->processUpdate($result);
//                }
//
//            }

        } catch (Longman\TelegramBot\Exception\TelegramException $e) {
            print_r($e->getMessage());
            // log telegram errors
            //
        }

    }

    public function hook()
    {
        error_log(print_r(__FUNCTION__,1));
        try {
            // Create Telegram API object
            $telegram = new Longman\TelegramBot\Telegram($this->apiKey, $this->botName);
            $result = $telegram->setWebhook($this->hookUrl);
            error_log(print_r($result,1));

            // Handle telegram webhook request
            $telegram->handle();

            $a = $telegram->handleGetUpdates();
            error_log(print_r($a,1));
        } catch (Longman\TelegramBot\Exception\TelegramException $e) {
            // Silence is golden!
            // log telegram errors
            // echo $e->getMessage();
        }
    }

    public function set()
    {
        error_log(print_r(__FUNCTION__,1));

	try {
            // Create Telegram API object
            $telegram = new Longman\TelegramBot\Telegram($this->apiKey, $this->botName);

            // Set webhook
            $result = $telegram->setWebhook($this->hookUrl);
            if ($result->isOk()) {
                echo $result->getDescription();
            }
        } catch (Longman\TelegramBot\Exception\TelegramException $e) {
            // log telegram errors
            // echo $e->getMessage();
        }
    }
}
