<?php

namespace App\Http\Controllers\Telegram;

use App\Models\Contest;
use App\Models\ContestMember;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotController
{
    public function index()
    {
        if (request()->header('X-Telegram-Bot-Api-Secret-Token') !== env('TELEGRAM_BOT_WEB_HOOK_SECRET')) {
            abort(403);
        }

        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $updates = $telegram->getWebhookUpdates();

        Log::info(json_encode($updates));

        if (isset($updates["message"])) {
            $text = $updates["message"]["text"] ?? '';
            $chat_id = $updates["message"]["chat"]["id"];
            $user_name = $updates["message"]["chat"]["first_name"];

            if ($text) {
                switch ($text) {
                    case '/start':
                        $keyboard = Keyboard::make()
                            ->inline()
                            ->row(
                                Keyboard::inlineButton(['text' => 'Выберите конкурс', 'callback_data' => '/select_konkurs']),
                            );
                        $telegram->sendMessage([
                            'chat_id' => $chat_id,
                            'text' => view('telegram.hello', ['user_name' => $user_name])->render(),
                            'parse_mode' => 'HTML',
                            'reply_markup' => $keyboard
                        ]);
                        break;
                }
            }
        }

        if (isset($updates["callback_query"])) {
            $chat_id = $updates["callback_query"]['from']['id'];
            $user_name = $updates["callback_query"]['from']['first_name'];
            $date_now = Carbon::now();
            $contests = Contest::where('start_date', '<', $date_now)
                ->where('end_date', '>', $date_now)->get();

            if ($updates["callback_query"]['data'] == '/select_konkurs') {
                if ($contests->isEmpty()) {
                    $telegram->sendMessage([
                        'chat_id' => $chat_id,
                        'text' => 'К сожалению на данный момент нет активных розыгрышей',
                    ]);
                } else {
                    $telegram->sendMessage([
                        'chat_id' => $chat_id,
                        'text' => 'Список активных конкурсов',
                    ]);
                    foreach ($contests as $key => $contest) {
                        $telegram->sendPhoto([
                            'chat_id' => $chat_id,
                            'photo' => InputFile::create($contest->getContestImage(), 'contest_image'),
                            'caption' => '<b>Конкурс №' . ($key + 1) . '</b>' . PHP_EOL . '<b>' . $contest->name . '</b>' . PHP_EOL . $contest->description,
                            'parse_mode' => 'HTML',
                        ]);
                    }

                    $keyboard = Keyboard::make()
                        ->inline();

                    foreach ($contests as $contest) {
                        $keyboard->row(
                            Keyboard::inlineButton(['text' => $contest->short_name, 'callback_data' => '/konkurs_id_' . $contest->id]),
                        );
                    }
                    $telegram->sendMessage([
                        'chat_id' => $chat_id,
                        'text' => 'Для участия в конкурсе нажмите кнопку ниже',
                        'reply_markup' => $keyboard
                    ]);
                }
            }

            foreach ($contests as $contest) {
                if ($updates["callback_query"]['data'] == '/konkurs_id_' . $contest->id) {
                    $contest_member = ContestMember::where(['chat_id' => $chat_id, 'first_name' => $user_name, 'contest_id' => $contest->id])->first();
                    if (!empty($contest_member)) {
                        $telegram->sendMessage([
                            'chat_id' => $chat_id,
                            'text' => '<b>' . $user_name . '</b> - Вы уже зарегистрированы на участие в конкурсе - <b>' . $contest->short_name . '</b>' . PHP_EOL . 'Ваш номер для участия - <b>' . $contest_member->number_member . '</b>',
                            'parse_mode' => 'HTML',
                        ]);
                    } else {
                        $last_number = ContestMember::where(['contest_id' => $contest->id])->orderByDesc('number_member')->first()->number_member ?? 0;
                        $contest_member = ContestMember::create([
                            'chat_id' => $chat_id,
                            'first_name' => $user_name,
                            'username' => ' - ',
                            'contest_id' => $contest->id,
                            'number_member' => $last_number + 1,
                        ]);
                        $telegram->sendMessage([
                            'chat_id' => $chat_id,
                            'text' => '<b>' . $user_name . '</b> - Вы успешно зарегистировались на участие в конкурсе - <b>' . $contest->short_name . '</b>' . PHP_EOL . 'Ваш номер для участия - <b>' . $contest_member->number_member . '</b>',
                            'parse_mode' => 'HTML',
                        ]);
                    }
                }
            }
        }
    }
}

