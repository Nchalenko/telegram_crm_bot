<?php

include('.././vendor/autoload.php'); //Подключаем библиотеку
    use Telegram\Bot\Api; 

    $telegram = new Api('375466075:AAEARK0r2nXjB67JiB35JCXXhKEyT42Px8s'); //Устанавливаем токен, полученный у BotFather
    $result = $telegram -> getWebhookUpdates();

error_log($result);
