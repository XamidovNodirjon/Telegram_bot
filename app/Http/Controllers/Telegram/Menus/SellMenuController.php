<?php

namespace App\Http\Controllers\Telegram\Menus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class SellMenuController extends Controller
{
public function show($chatId)
{
    Telegram::sendMessage([
        'chat_id' => $chatId,
        'text'    => "🛍 Sotaman bo‘limi - kategoriyani tanlang:",
        'reply_markup' => json_encode([
            'keyboard' => [
                [['text' => "🚗 Avto mashina"], ['text' => "🏡 Uy oldi sotdi"]],
                [['text' => "🏢 Vacancy"], ['text' => "🧦 Bolalar kiyimlari"]],
                [['text' => "🛌 Choyshablar"], ['text' => "⬅️ Orqaga"]],
                []
            ],
            'resize_keyboard' => true
        ])
    ]);
}
}
