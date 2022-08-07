<?php

namespace App\Http\Controllers\Telegram;

use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotController
{
    public function index()
    {


        dd(json_decode('{"update_id":303377195,"message":{"message_id":22,"from":{"id":315065368,"is_bot":false,"first_name":"\u0421\u0435\u0440\u0433\u0435\u0439","last_name":"\u0418\u0432\u0430\u043d\u043e\u0432","username":"HooLS18","language_code":"ru"},"chat":{"id":315065368,"first_name":"\u0421\u0435\u0440\u0433\u0435\u0439","last_name":"\u0418\u0432\u0430\u043d\u043e\u0432","username":"HooLS18","type":"private"},"date":1659864404,"reply_to_message":{"message_id":21,"from":{"id":5344868950,"is_bot":true,"first_name":"TeleframContestBot","username":"HooLS18ContestBot"},"chat":{"id":315065368,"first_name":"\u0421\u0435\u0440\u0433\u0435\u0439","last_name":"\u0418\u0432\u0430\u043d\u043e\u0432","username":"HooLS18","type":"private"},"date":1659864402,"text":"\u0412\u044b\u0431\u0435\u0440\u0438\u0442\u0435 \u043a\u043e\u043d\u043a\u0443\u0440\u0441"},"contact":{"phone_number":"+79623261990","first_name":"\u0421\u0435\u0440\u0433\u0435\u0439","last_name":"\u0418\u0432\u0430\u043d\u043e\u0432","user_id":315065368}}}'));


        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $updates =  $telegram->getWebhookUpdates();

        Log::info('Chat_id = ' . $updates);

        if(isset($updates["message"])){
            $text = $updates["message"]["text"] ?? '';
            $chat_id = $updates["message"]["chat"]["id"];

            if ($text) {
                switch ($text) {
                    case '/start':
//                        $keyboard = array(
//                            array(array('request_contact' => true, 'request_location' => true,  'text' => 'Конкурс 1')),
//                            array(array('request_contact' => true, 'request_location' => true,  'text' => 'Конкурс 2')),
//                        );
//                        $reply_markup = Keyboard::make([
//                            'keyboard' => $keyboard,
//                            'resize_keyboard' => true,
//                            'one_time_keyboard' => true
//                        ]);
//                        $response = Telegram::sendMessage([
//                            'chat_id' => $chat_id,
//                            'text' => 'Выберите конкурс',
//                            'reply_markup' => $reply_markup
//                        ]);
                        $keyboard = Keyboard::make()
                            ->inline()
                            ->row(
                                Keyboard::inlineButton(['text' => 'Выберите конкурс', 'callback_data' => '/select_konkurs']),
                            );
                        $response = Telegram::sendMessage([
                            'chat_id' => $chat_id,
                            'text' => 'Выберите конкурс',
                            'reply_markup' => $keyboard
                        ]);

//                        $reply_markup = Keyboard::remove();
//
//                        $response = $telegram->sendMessage([
//                            'chat_id' => $chat_id,
//                            'text' => 'Hello World',
//                            'reply_markup' => $reply_markup
//                        ]);
                        break;
//                    case '/select_konkurs':
//                        $keyboard = array(
//                            array(array('callback_data' => '/select_konkurs_one', 'text' => 'Конкурс 1')),
//                            array(array('callback_data' => '/select_konkurs_two', 'text' => 'Конкурс 2')),
//                            array(array('callback_data' => '/start', 'text' => 'Назад')),
//                        );
//                        $reply_markup = Keyboard::make([
//                            'keyboard' => $keyboard,
//                            'resize_keyboard' => true,
//                            'one_time_keyboard' => true
//                        ]);
//                        $response = Telegram::sendMessage([
//                            'chat_id' => $chat_id,
//                            'text' => 'Выберите конкурс',
//                            'reply_markup' => $reply_markup
//                        ]);
//                        break;
                    case '/select_konkurs_one':
                        $response = Telegram::sendMessage([
                            'chat_id' => $chat_id,
                            'text' => 'Вы зарегистрировались на участие в конкурсе номер 1',
                        ]);
                    case '/select_konkurs_two':
                        $response = Telegram::sendMessage([
                            'chat_id' => $chat_id,
                            'text' => 'Вы зарегистрировались на участие в конкурсе номер 2',
                        ]);
                        break;
                    default:
                        $response = Telegram::sendMessage([
                            'chat_id' => $chat_id,
                            'text' => 'Неверная команда',
                        ]);
                }
            }
        }

        if(isset($updates["callback_query"])){
            $chat_id = $updates["callback_query"]['from']['id'];
            $keyboard = Keyboard::make()
                ->inline()
                ->row(
                    Keyboard::inlineButton(['text' => 'Нож - Рысь', 'callback_data' => '/konkurs_1']),
                )->row(
                    Keyboard::inlineButton(['text' => 'Шампура - Енот', 'callback_data' => '/konkurs_2']),
                )->row(
                    Keyboard::inlineButton(['text' => 'Топор - Тигр', 'callback_data' => '/konkurs_3']),
                );
            $response = Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => 'Список текущих конкурсов',
                'reply_markup' => $keyboard
            ]);
        }
    }
}
