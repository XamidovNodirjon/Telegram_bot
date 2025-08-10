<?php

namespace App\Http\Controllers\Telegram\Menus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class MainMenuController extends Controller
{
    public function show($chatId, $name)
    {
        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => "✅ Xush kelibsiz, {$name}! Quyidagi xizmatlardan birini tanlang:",
            'reply_markup' => json_encode([
                'keyboard' => [
                    [['text' => "🛍 Sotaman"], ['text' => "📦 Sotib olaman"]],
                    [['text' => "🔍 Xizmat taklif qilaman"], ['text' => "📄 Mening e'lonlarim"]],
                    [['text' => "💰 Hisobim"], ['text' => "⚙️ Sozlamalar"]]
                ],
                'resize_keyboard' => true
            ])
        ]);
    }
}
