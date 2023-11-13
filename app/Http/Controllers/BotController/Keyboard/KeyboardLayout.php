<?php

namespace App\Http\Controllers\BotController\Keyboard;

use App\Models\Operator;
use App\Models\Task;
use Telegram\Bot\Keyboard\Button;
use Telegram\Bot\Keyboard\Keyboard;

class KeyboardLayout
{
    public static function empty()
    {
        return Keyboard::make()
            ->remove();
    }




    public static function emptyInline()
    {
        return Keyboard::make()
            ->inline()
            ->row([]);
    }




    public static function home($user_type)
    {
        if ($user_type === 'operator')
            return Keyboard::make()
                ->setOneTimeKeyboard(true)
                ->setResizeKeyboard(true)
                ->row([Button::make(['text' => trans('msg.start_new_auction_btn')])])
                ->row([Button::make(['text' => trans('msg.get_info_a_car')])])
                ->row([Button::make(['text' => trans('msg.get_info_dealers')])])
                ->row([Button::make(['text' => trans('msg.settings_btn')])]);

        elseif ($user_type === 'dealer')
            return Keyboard::make()
                ->setOneTimeKeyboard(true)
                ->setResizeKeyboard(true)
                ->row([Button::make(['text' => trans('msg.my_cars_btn')])]);

        elseif ($user_type === 'user')
            return Keyboard::make()
                ->setOneTimeKeyboard(true)
                ->setResizeKeyboard(true)
                ->row([Button::make(['text' => trans('msg.my_cars_btn')])])
                ->row([Button::make(['text' => trans('msg.add_car_btn')])]);
    }




    public static function contact()
    {
        return Keyboard::make()
            ->setOneTimeKeyboard(true)
            ->setResizeKeyboard(true)
            ->row([
                Button::make([
                    'text' => trans('msg.contact_btn'),
                    'request_contact' => true,
                ]),
            ])
            ->row([
                Button::make([
                    'text' => trans('msg.cancel_btn')
                ]),
            ]);
    }




    public static function auctionJoin($auction_id)
    {
        return Keyboard::make()
            ->inline()
            ->row([
                Button::make([
                    'text' => trans('msg.join_btn'),
                    'callback_data' => 'auction_join:' . $auction_id
                ])
            ]);
    }




    public static function auctionLeft()
    {
        return Keyboard::make()
            ->setOneTimeKeyboard(true)
            ->setResizeKeyboard(true)
            ->row([
                Button::make([
                    'text' => trans('msg.left_btn'),
                ]),
            ]);
    }




    public static function chooseLang()
    {
        return Keyboard::make()
            ->inline()
            ->row([Button::make(['text' => "🇺🇸 English", 'callback_data' => 'en'])])
            ->row([Button::make(['text' => "🇺🇿 O'zbekcha", 'callback_data' => 'uz'])])
            ->row([Button::make(['text' => "🇷🇺 Русский", 'callback_data' => 'ru'])]);
    }



    public static function chooseCarCondition()
    {
        return Keyboard::make()
            ->inline()
            ->row([Button::make(['text' => trans('msg.bad'), 'callback_data' => 'bad'])])
            ->row([Button::make(['text' => trans('msg.good'), 'callback_data' => 'good'])])
            ->row([Button::make(['text' => trans('msg.new'), 'callback_data' => 'new'])]);
    }



    public static function ownerConfirm($auction_id)
    {
        return Keyboard::make()
            ->inline()
            ->row([
                Button::make([
                    'text' => trans('msg.yes'),
                    'callback_data' => 'owner_confirm|yes|auction_id:' . $auction_id
                ]),
                Button::make([
                    'text' => trans('msg.no'),
                    'callback_data' => 'owner_confirm|no|auction_id:' . $auction_id
                ]),
            ]);
    }




    public static function settingItems(Operator $operator)
    {
        $keyboard = Keyboard::make()
            ->setOneTimeKeyboard(true)
            ->setResizeKeyboard(true)
            ->row([Button::make(['text' => trans('msg.auction_duration_btn')])]);

        if ($operator->is_muted)
            $keyboard->row([Button::make(['text' => trans('msg.unmute_btn')])]);
        else
            $keyboard->row([Button::make(['text' => trans('msg.mute_btn')])]);

        return $keyboard->row([Button::make(['text' => trans('msg.back_btn')])]);
    }




    public static function cancel()
    {
        return Keyboard::make()
            ->setOneTimeKeyboard(true)
            ->setResizeKeyboard(true)
            ->row([Button::make(['text' => trans('msg.cancel_btn')])]);
    }




    public static function next()
    {
        return Keyboard::make()
            ->setOneTimeKeyboard(true)
            ->setResizeKeyboard(true)
            ->row([Button::make(['text' => trans('msg.next_btn')])])
            ->row([Button::make(['text' => trans('msg.cancel_btn')])]);
    }





    public static function taskValidationBtns(Task $task)
    {
        return Keyboard::make()
            ->inline()
            ->row([
                Button::make([
                    'text' => trans('msg.allow'),
                    'callback_data' => 'task|' . $task->id . '|allow'
                ]),
                Button::make([
                    'text' => trans('msg.deny'),
                    'callback_data' => 'task|' . $task->id . '|deny'
                ]),
            ]);
    }





    public static function taskDoneBtns(Task $task)
    {
        return Keyboard::make()
            ->inline()
            ->row([
                Button::make([
                    'text' => trans('msg.done'),
                    'callback_data' => 'task|' . $task->id . '|done',
                ])
            ]);
    }





    public static function askStart()
    {
        return Keyboard::make()
            ->setOneTimeKeyboard(true)
            ->setResizeKeyboard(true)
            ->row([Button::make(['text' => trans('msg.now_btn')])])
            ->row([Button::make(['text' => trans('msg.after_30_mins_btn')])])
            ->row([Button::make(['text' => trans('msg.after_1_h_btn')])])
            ->row([Button::make(['text' => trans('msg.after_2_hs_btn')])]);
        // ->row([Button::make(['text' => trans('msg.cancel_btn')])]);
    }






    public static function channelLink()
    {
        return Keyboard::make()
            ->inline()
            ->row([
                Button::make([
                    'text' => trans('msg.visit_channel'),
                    'url' => env('BROADCASTING_CHANNEL_LINK'),
                ])
            ]);
    }






    public static function dealersList($dealers, int $current_page = 1, bool $prev = false, bool $next = false)
    {
        $keyboard = Keyboard::make()->inline();
        $i = 0;
        $count_dealers = count($dealers);
        while ($i < $count_dealers) {
            $row = [];
            for ($j = 0; $j < 5; $j++) {
                $index = $i + $j;
                if ($index === $count_dealers) break;
                $row[] = Button::make([
                    'text' => $index + 1,
                    'callback_data' => 'dealer|info|' . $dealers[$index]->id,
                ]);
            }
            $keyboard->row($row);
            if ($i + 5 > $count_dealers)
                $i = $count_dealers;
            else
                $i += 5;
        }
        $row = [];
        if ($prev)
            $row[] = Button::make([
                'text' => '⬅ Prev',
                'callback_data' => 'dealer|prev|' . $current_page
            ]);
        $row[] = Button::make([
            'text' => '🆑 Cancel',
            'callback_data' => 'dealer|cancel|' . $current_page
        ]);
        if ($next)
            $row[] = Button::make([
                'text' => 'Next ➡',
                'callback_data' => 'dealer|next|' . $current_page
            ]);
        $keyboard->row($row);
        return $keyboard;
    }






    public static function bidsList(Task $task, int $current_page = 1, bool $prev = false, bool $next = false)
    {
        $keyboard = Keyboard::make()->inline();
        $row = [];
        if ($prev)
            $row[] = Button::make([
                'text' => '⬅ Prev',
                'callback_data' => 'bids-list|prev|' . $current_page
            ]);
        if ($next)
            $row[] = Button::make([
                'text' => 'Next ➡',
                'callback_data' => 'bids-list|next|' . $current_page
            ]);
        $keyboard->row($row);
        $keyboard->row([
            Button::make([
                'text' => '✅ Done',
                'callback_data' => 'task|' . $task->id . '|done'
            ])
        ]);
        return $keyboard;
    }





    public static function taskNtfyBtns(Task $task)
    {
        return Keyboard::make()
            ->inline()
            ->row([
                Button::make([
                    'text' => trans('msg.take'),
                    'callback_data' => 'task-ntfy|' . $task->id . '|take'
                ])
            ])
            ->row([
                Button::make([
                    'text' => trans('msg.remove'),
                    'callback_data' => 'task-ntfy|' . $task->id . '|remove'
                ])
            ]);
    }
}
