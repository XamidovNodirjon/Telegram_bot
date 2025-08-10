<?php

namespace App\Http\Controllers\Telegram\Menus;

use App\Http\Controllers\Controller;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\CarAd;
use App\Models\User;

class CarMenuController extends Controller
{
    public function show($chatId)
    {
        $user = User::where('chat_id', $chatId)->first();

        $ad = CarAd::create([
            'user_id' => $user->id,
            'step' => 'waiting_photos'
        ]);

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => "🚗 Mashina e’lonini joylashdan oldin iltimos, quyidagilarga e’tibor bering:\n\n"
                . "1️⃣ Avval mashinaning rasmlarini yuboring.\n"
                . "2️⃣ Barcha rasmlarni yuborib bo‘lgach, 'Next' tugmasini bosing.",
            'reply_markup' => json_encode([
                'keyboard' => [
                    [['text' => "⏭ Next"], ['text' => "⏮ Prev"]],
                ],
                'resize_keyboard' => true
            ])
        ]);
    }
}
