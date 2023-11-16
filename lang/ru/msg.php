<?php

return [
    'cancelled' => ' ✅ Все операции отменены',
    'empty_action' => "⚠️ Отменять нечего",
    'ask_contact' => "Контакт: (Нажмите кнопку \":btn\" ниже)",
    'invalid_contact' => "‼️ Вы должны отправить нам свой контакт\n(Просто нажмите кнопку \":btn\" ниже)",
    'login_started' => " ✅ Процесс входа в систему начат.",
    'wrong_credentials' => "⚠️ Неверный контакт или пароль.\n♻️ Чтобы повторить попытку: /login",
    'welcome_msg' => "🎊 Добро пожаловать :firstname :lastname",
    'registration_started' => " ✅ Процесс регистрации начался.",
    'ask_password' => "Пароль:",
    'ask_new_password' => "Создайте пароль: (минимальная длина должна составлять 8 символов)",
    'request_registered_msg' => "📨 Ваш запрос успешно зарегистрирован и отправлен Операторам.",
    'please_wait' => "⏳ Пожалуйста, подождите, мы постараемся ответить вам как можно скорее.",
    'request_allowed' => "✅ Ваш запрос разрешен.",
    'request_denied' => "❌ Ваш запрос отклонен.",
    'request_allowed_for_operator' => "🚀 Вы успешно разрешили запрос.",
    'request_denied_for_operator' => "🚀 Вы успешно отклонили запрос.",
    'task_done_msg' => "🚀 Вы успешно выполнили свою задачу",
    'new_operator_confirmation' => "🪪 <b>Новый оператор</b>\n"
        . "Имя: :firstname\n"
        . "Фамилия: :lastname\n"
        . "Контакт: :contact\n",
    'new_dealer_confirmation' => "👨‍💼 <b>Новый дилер</b>\n"
        . "Имя: :firstname\n"
        . "Фамилия: :lastname\n"
        . "Контакт: :contact\n",
    'registered' => "Вы успешно зарегистрированы.",
    'empty_cars' => "❌ У вас нет машин",
    'car_added_info' => "🆔 ID: :id\n"
        . "🅰 Компания: :company\n"
        . "Ⓜ Модель: :model\n"
        . "🔢 Год: :year\n"
        . "🔷 Цвет: :color\n"
        . "🆕 Состояние: :condition\n"
        . "💬 Дополнительно: :additional\n",
    'car_info' => "🆔 ID: :id\n"
        . "📊 Статус: :status\n"
        . "🅰 Компания: :company\n"
        . "Ⓜ Модель: :model\n"
        . "🔢 Год: :year\n"
        . "🔷 Цвет: :color\n"
        . "🆕 Состояние: :condition\n"
        . "💬 Дополнительно: :additional\n"
        . "👤 Владелец: :owner_fname :owner_lname\n"
        . "🏆 Победитель: :winner_fname :winner_lname\n",
    'auction_created_info' => "<b>Аукцион назначен</b>\n"
        . "🆔 Идентификатор автомобиля: :car_id\n"
        . "🅰 Компания: :company\n"
        . "Ⓜ Модель: :model\n"
        . "👤 Владелец: :owner\n"
        . "📅 Начало: :start\n"
        . "🏁 Финиш: :finish\n"
        . "💵 Начальная цена: :starting_price\$\n",
    'broadcast_message' => "Новая машина на аукционе\n"
        . "🅰 Компания: :company\n"
        . "Ⓜ Модель: :model\n"
        . "🔢 Год: :year\n"
        . "🔷 Цвет: :color\n"
        . "🆕 Состояние: :condition\n"
        . "💬 Дополнительно: :additional\n"
        . "📅 Начало: :start\n"
        . "🏁 Финиш: :finish\n"
        . "💵 Начальная цена: :starting_price\$\n",
    'ask_start' => "<b>Укажите время начала аукциона</b>\n"
        . "Время должно быть в одном из этих форматов:\n"
        . "1⃣ Просто нажмите одну из кнопок ниже\n"
        . "2⃣ час:минута (например, 20:02)\n"
        . "3⃣ год-месяц-день час:минута (например, 2023-10-15 14:30)\n",
    'invalid_start' => "⚠️ Введенная вами информация не соответствует ни одному из форматов.\n"
        . "Пожалуйста, попробуйте ввести информацию в одном из следующих форматов.\n"
        . "1⃣ Просто нажмите одну из кнопок ниже\n"
        . "2⃣ час:минута (например, 20:02)\n"
        . "3⃣ год-месяц-день час:минута (например, 2023-10-15 14:30)\n",
    'logged_out' => "✅ Вы успешно вышли из системы.",
    'already_logged_in' => "‼️ Вы вошли в систему.\nЕсли вы хотите сменить учетную запись: /logout",
    'not_logged_in' => "‼️ Вы еще не вошли в систему",
    'ask_firstname' => "Имя: (например, Джон)",
    'ask_lastname' => "Фамилия: (например, Доу)",
    'add_car_btn' => "➕ Добавьте свою машину",
    'contact_btn' => "📲 Поделиться контактом",
    'channel_link_for_dealer' => "Вы должны подписаться на этот канал, чтобы получать уведомления о новых аукционах.\n",
    'new_task' => "☑️ Новая задача",
    'ask_car_company' => "Компания: (например, Daewoo)",
    'ask_car_model' => "Модель: (например, Epica)",
    'ask_car_year' => "Год: (например, 2010)",
    'ask_car_color' => "Цвет: (например, белый)",
    'ask_car_condition' => "Состояние вашего автомобиля:",
    'bad' => "Плохо",
    'good' => "Хорошо",
    'new' => "Новый",
    'join_btn' => "Присоединиться",
    'left_btn' => "🚪 Покинуть аукцион",
    'auction_inactive' => "‼️ Извините! Аукцион не активен.",
    'write_price' => "Вы можете легко написать здесь подходящую вам цену:\n"
        . "(например, 10000|10 000|10,000|10 000$|$10 000)",
    'cant_left' => "‼️ Извините! Вы не можете покинуть аукцион, поскольку сейчас вы являетесь владельцем самой высокой цены.",
    'left' => "✅ Вы успешно покинули аукцион.",
    'price_not_higher_enough' => "⚠️ Цена должна быть как минимум выше :enough_price\$.",
    'owner_confirm_message' => "Ваш автомобиль :color :company :model был оценен на аукционе по цене :highest_price\$. Вы готовы продать свой автомобиль по этой цене?",
    'car_sold_message_for_dealers' => "<b>Машина распродана.</b>\n"
        . "🏆 Победитель: :firstname :lastname\n"
        . "🚘 Автомобиль: :color :company :model\n"
        . "💵 Цена: :highest_price\$\n",
    'car_sold_message_for_winner' => "🎉<b>Поздравляем!</b>🎉\n"
        . "Дорогой :firstname :lastname\n"
        . "Вы выиграли аукцион.\n\n"
        . "🆔 Идентификатор автомобиля: :car_id\n"
        . "🚘 Автомобиль: :color :company :model\n"
        . "💵 Цена: :highest_price\$\n",
    'car_sold_message_for_owner' => "🎉<b>Поздравляем!</b>🎉\n"
        . "Дорогой :firstname :lastname\n"
        . "Ваша машина распродана!\n\n"
        . "🆔 Идентификатор автомобиля: :car_id\n"
        . "🚘 Автомобиль: :color :company :model\n"
        . "💵 Цена: :highest_price\$\n"
        . "🏆 Победитель: :winner_fname :winner_lname\n",
    'car_not_sold_message_for_dealers' => "<b>Автомобиль не продан.</b>\n"
        . "🚘 Автомобиль: :color :company :model\n"
        . "💵 Цена: :starting_price\$\n",
    'car_not_sold_message_for_owner' => "<b>Машина не продана.</b>\n"
        . "Уважаемый :firstname :lastname, ваша машина не продана.\n\n"
        . "🚘 Автомобиль: :color :company :model\n"
        . "💵 Цена: :starting_price\$\n",
    'car_not_sold_message_for_operator' => "<b>Машина не продана.</b>\n"
        . "🆔 Идентификатор автомобиля: :car_id\n"
        . "🚘 Автомобиль: :color :company :model\n"
        . "👤 Владелец: :owner_fname :owner_lname\n"
        . "📲 Телефон: :owner_phone\n",
    'didnt_sell_message_for_dealers' => "<b>Автомобиль не продан.</b>\n"
        . "Владелец автомобиля не согласился продавать.\n\n"
        . "🚘 Автомобиль: :color :company :model\n"
        . "💵 Цена: :highest_price\$\n",
    'didnt_sell_message_for_operator' => "<b>Машина не продана.</b>\n"
        . "Владелец автомобиля не согласился продавать.\n\n"
        . "🆔 Идентификатор автомобиля: :car_id\n"
        . "🚘 Автомобиль: :color :company :model\n"
        . "💵 Цена: :highest_price\$\n"
        . "👤 Владелец: :owner_fname :owner_lname\n"
        . "📲 Телефон: :owner_phone\n",
    'didnt_sell_message_for_winner' => "<b>Машина не продана.</b>\n"
        . "Дорогой :firstname :lastname, ваша заявка на аукцион была отклонена владельцем автомобиля.\n\n"
        . "🚘 Автомобиль: :color :company :model\n"
        . "💵 Цена: :highest_price\$\n",
    'didnt_sell_message_for_owner' => "<b>Машина не продана.</b>\n"
        . "Уважаемый :firstname :lastname, вы не соглашались продавать.\n\n"
        . "🆔 Идентификатор автомобиля: :car_id\n"
        . "🚘 Автомобиль: :color :company :model\n"
        . "💵 Цена: :highest_price\$\n",
    'my_cars_btn' => "🚘 Мои машины",
    'yes' => "Да",
    'no' => "Нет",
    'auction_finished' => "🏁 Аукцион завершен.",
    'pending_reply_from_the_owner' => "⏳ Ожидается ответ от владельца автомобиля...",
    'start_new_auction_btn' => '➕ Начать новый аукцион',
    'settings_btn' => '⚙ Настройки',
    'auction_duration_btn' => '🕗 Продолжительность аукциона',
    'ask_car_id' => 'Идентификатор автомобиля: (например, 4231)',
    'ask_auction_duration' => 'Продолжительность аукциона в минутах: (например, 30)',
    'settings_updated' => ' ✅ Ваши изменения успешно обновлены.',
    'cancel_btn' => '🆑 Отмена',
    'on_sale' => "Распродажа",
    'sold_out' => "Распродано",
    'not_sold' => "Не продано",
    'didnt_sell' => "Не продано",
    'choose_one_car' => "Вы можете выбрать один из них для получения дополнительной информации:",
    'your_cars' => "Ваши машины:",
    'get_info_a_car' => "ℹ Получить информацию об автомобиле",
    'ask_car_additional' => "Если вы хотите добавить дополнительную информацию, напишите об этом \n"
        . "Или нажмите кнопку \":next\" ниже, чтобы перейти к следующему шагу.",
    'next_btn' => "➡ Далее",
    'allow' => "Разрешить",
    'deny' => "Отрицать",
    'choose_section' => "Выберите раздел 👇",
    'unexpected_callback_query' => "⚠️ Вам следует выбрать один раздел из списка автомобилей.",
    'exist_contact' => "⚠️ Этот контакт уже зарегистрирован.",
    'ask_starting_price' => "Укажите стартовую цену автомобиля (в долларах США): (например, 10 000$)",
    'back_btn' => "⬅ Назад",
    'ask_validate_car_msg' => "Подтвердить этот автомобиль:",
    'join_to_auction_msg' => "Чтобы присоединиться к аукциону, нажмите эту кнопку 👇",
    'already_joined_this_auction' => "✅ Вы уже присоединились к этому аукциону. Пожалуйста, проверьте чат бота дилера.",
    'already_joined_another_auction' => "⚠️ Вы уже присоединились к другому аукциону. Чтобы присоединиться к этому аукциону, покиньте аукцион, в котором вы ранее участвовали.",
    'joined_the_auction' => "✅ Вы успешно присоединились к аукциону. Дополнительную информацию можно получить в чате бота дилера.",
    'auction_started_for_owner' => "<b>Аукцион начался</b>\n"
        . "🆔 Идентификатор автомобиля: :car_id\n"
        . "🚘 Автомобиль: :color :company :model\n"
        . "💵 Цена: :starting_price\$\n",
    'auction_started_for_dealer' => "🏁 <b>Аукцион начался</b> 🏁",
    'price_lt_starting_price' => "⚠️ Цена должна быть больше начальной цены (:starting_price\$).",
    'auction_hasnt_started_yet' => "⚠️ Аукцион еще не начался, поэтому вы не можете сделать ставку сейчас.",
    'not_validated_account' => "⚠️ Уважаемый :firstname :lastname, Ваш запрос еще не обработан.",
    'unexpected_cancel_command_on_joined_auction' => "⚠️ Команда \"Отмена\" не используется для выхода из аукциона.\n"
        . "Если вы хотите выйти из аукциона, вместо этого нажмите кнопку \":left_btn\".",
    'unexpected_logout_command_on_joined_auction' => "⚠️ Команда \"Выйти\" не поддерживается, пока пользователь участвует в аукционе."
        . "Если вы хотите выйти из своей учетной записи, сначала нажмите кнопку \":left_btn\".",
    'now_btn' => "Сейчас",
    'after_30_mins_btn' => "🕕 Через 30 минут",
    'after_1_h_btn' => "🕛 Через 1 час",
    'after_2_hs_btn' => "🕛 Через 2 часа",
    'car_not_validated' => "⚠️ Автомобиль не проверен.",
    'car_is_already_in_auction' => "⚠️ Автомобиль уже выставлен на аукцион.\n"
        . "Статус аукциона: :life_cycle",
    'waiting_start' => "Ожидание начала",
    'playing' => "Играет",
    'waiting_confirmation' => "Ожидание подтверждения",
    'finished' => "Финиш",
    'cannot_cancel_task' => "‼️ Извините, взятую задачу нельзя отменить.",
    'empty_task' => "☑️ Нет доступных задач",
    'done' => "Финиш",
    'cannot_logout_because_of_task' => "‼️ Извините, вы не можете выйти, потому что у вас есть задача",
    'waiting_validation' => "Ожидание проверки",
    'help' => "📎 Здесь должно быть сообщение \"Помощь\"",
    'info' => "📎 Здесь должно быть сообщение \"Информация\"",
    'more_images' => "Вы можете добавить больше изображений вашего автомобиля. Если вы не хотите добавлять, нажмите кнопку \":next_btn\" ниже",
    'image_limit_msg' => "‼️ Вы достигли максимального количества изображений",
    'invalid_image' => "⚠️ Вы должны прислать нам фотографию",
    'ask_car_image' => "Отправьте изображение вашего автомобиля:",
    'visit_channel' => "🌐 Посетить канал",
    'auction_info_msg_for_current_winner' => "📈 Самая высокая цена: :highest_price\$\n"
        . "👀 Участники: :participants\n"
        . "🏁 Финиш: :finish\n\n"
        . "<b> 👑 Дорогой :fname :lname, теперь ты предложишь самую высокую цену </b>",
    'auction_info_msg_for_dealers' => "📈 Самая высокая цена: :highest_price\n"
        . "👀 Участники: :participants\n"
        . "🏁 Финиш: :finish\n\n"
        . "✳ Теперь вы можете предложить :enough_price\$, чтобы выиграть аукцион",
    'auction_info_msg_for_owner' => "📈 Самая высокая цена: :highest_price\$\n"
        . "👀 Участники: :participants\n"
        . "🏁 Финиш: :finish\n",
    'get_info_dealers' => "👨‍💼 Дилеры",
    'dealers_info_msg' => "👨‍💼 Дилеры:\n"
        . "🔢 Номер: :number\n",
    'not_bid_yet' => 'Еще не сделана ставка',
    'dealer_list_title' => "<b>👨‍💼 Дилеры :first_num - :last_num из :all_num </b>\n\n",
    'dealer_info' => "<b>👨‍💼 Дилер </b>\n\n"
        . "Имя: :fname\n"
        . "Фамилия: :lname\n"
        . "Контакт: :contact\n"
        . "Количество автомобилей: :num_of_cars",
    'bids_list' => "<b>🤝 Ставки :first_num - :last_num из :all_num </b>\n\n"
        . ":slot\n"
        . "👤 Владелец: :owner_fname :owner_lname\n"
        . "📲 Телефон: :owner_phone\n",
    'car_sold_message_for_operator' => "<b>Машина распродана.</b>\n"
        . "🆔 Идентификатор автомобиля: :car_id\n"
        . "🚘 Автомобиль: :color :company :model\n"
        . "💵 Цена: :highest_price\$\n"
        . "🏆 Победитель: :winner_fname :winner_lname\n"
        . "📲 Телефон: :winner_phone\n"
        . "👤 Владелец: :owner_fname :owner_lname\n"
        . "📲 Телефон: :owner_phone\n",
    'bidder' => "<b>:number - :price\$</b>\n"
        . "👨‍💼 Дилер: :fname :lname\n"
        . "📲 Телефон: :phone\n",
    'take' => "📥 Взять",
    'remove' => "🗑 Удалить",
    'cant_take_task_msg' => "⚠️ Вы не можете выполнить задачу, поскольку у вас сейчас есть операция. Вам следует завершить текущую операцию",
    'task_not_found_msg' => "⚠️ Задача не найдена",
    'mute_btn' => "🔕 Отключить звук",
    'unmute_btn' => "🔔 Включить звук",
    'prev' => '⬅ Предыдущая',
    'next' => 'Далее ➡',
    'task_taken_msg' => "✳ Задача получена",
    'start_cmd' => "♻ Перезапустить бота",
    'help_cmd' => "🆘 Помощь",
    'info_cmd' => "ℹ Информация",
    'login_cmd' => "➡ Войти",
    'registration_cmd' => "➡ Регистрация в системе",
    'logout_cmd' => "⬅ Выйти",
    'cancel_cmd' => "❌ Отменить операцию",
    'task_cmd' => "🧩 Получить доступные задачи",

    'fnshd_auction_msg_for_chnl' => "💸 <b>АВТОМОБИЛЬ РАСПРОДАН</b>",

    'attributes' => [],

];
