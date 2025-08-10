<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Telegram\Menus\AccountMenuController;
use App\Http\Controllers\Telegram\Menus\BuyMenuController;
use App\Http\Controllers\Telegram\Menus\CarMenuController;
use App\Http\Controllers\Telegram\Menus\MyAdsMenuController;
use App\Http\Controllers\Telegram\Menus\SellMenuController;
use App\Http\Controllers\Telegram\Menus\ServiceMenuController;
use App\Http\Controllers\Telegram\Menus\SettingsMenuController;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\User;

class TelegramBotController extends Controller
{
    public function handle(Request $request)
    {
        $update = Telegram::getWebhookUpdate();

        if ($update->has('message')) {
            $message = $update->getMessage();
            $chat = $message->getChat();
            $chatId = $chat->getId();
            $text = $message->getText();

            $existingUser = User::where('chat_id', $chatId)->first();

            if ($text === '/start') {
                if ($existingUser) {
                    $name = $existingUser->username ? '@' . $existingUser->username : $existingUser->first_name;
                    return app(\App\Http\Controllers\Telegram\Menus\MainMenuController::class)
                        ->show($chatId, $name);
                } else {
                    $name = $chat->getUsername() ? '@' . $chat->getUsername() : $chat->getFirstName();

                    Telegram::sendMessage([
                        'chat_id' => $chatId,
                        'text' => "Salom {$name}! 📱 Iltimos, telefon raqamingizni yuboring:",
                        'reply_markup' => json_encode([
                            'keyboard' => [
                                [['text' => "📞 Raqamni yuborish", 'request_contact' => true]]
                            ],
                            'resize_keyboard' => true,
                            'one_time_keyboard' => true
                        ])
                    ]);
                    return;
                }
            }

            if ($message->has('contact')) {
                $contact = $message->getContact();

                User::updateOrCreate(
                    ['chat_id' => $chatId],
                    [
                        'first_name' => $chat->getFirstName(),
                        'username' => $chat->getUsername(),
                        'telegram_id' => $contact->getUserId(),
                        'phone_number' => $contact->getPhoneNumber(),
                    ]
                );

                $name = $chat->getUsername() ? '@' . $chat->getUsername() : $chat->getFirstName();

                return app(\App\Http\Controllers\Telegram\Menus\MainMenuController::class)
                    ->show($chatId, $name);
            }

            switch ($text) {
                case "🛍 Sotaman":
                    return app(SellMenuController::class)
                        ->show($chatId);
                case "📦 Sotib olaman":
                    return app(BuyMenuController::class)
                        ->show($chatId);
                case "🔍 Xizmat taklif qilaman":
                    return app(ServiceMenuController::class)
                        ->show($chatId);
                case "📄 Mening e'lonlarim":
                    return app(MyAdsMenuController::class)
                        ->show($chatId);
                case "💰 Hisobim":
                    return app(AccountMenuController::class)
                        ->show($chatId);
                case "⚙️ Sozlamalar":
                    return app(SettingsMenuController::class)
                        ->show($chatId);
                case "🚗 Avto mashina":
                    return app(CarMenuController::class)->show($chatId);
            }
        }

        return response('ok', 200);
    }
}
