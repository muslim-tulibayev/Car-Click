<?php

return [

    'cancelled' => '✅ Barcha operatsiyalar bekor qilindi',
    'empty_action' => "⚠️ Bekor qilish uchun hech narsa yo'q",
    'ask_contact' => "Kontakt: (Quyida \":btn\" tugmasini bosing)",
    'invalid_contact' => "⚠️ Bizga kontaktingizni yuborishingiz kerak\n(Quyidagi \":btn\" tugmasini bosing)",
    'login_started' => "✅ Tizimga kirish jarayoni boshlandi.",
    'wrong_credentials' => "⚠️ Kontakt yoki parol noto'g'ri.\n♻️ Qayta urinib ko'rish uchun: /login",
    'welcome_msg' => "🎊 Xush kelibsiz :firstname :lastname",
    'registration_started' => "✅ Ro'yxatdan o'tish jarayoni boshlandi.",
    'ask_password' => "Parol:",
    'ask_new_password' => "Parol yarating: (minimal uzunlik 8 belgidan iborat bo'lishi kerak)",
    'request_registered_msg' => "📨 Sizning so'rovingiz muvaffaqiyatli ro'yxatdan o'tkazildi va Operatorlarga yuborildi.",
    'please_wait' => "⏳ Iltimos, kuting, biz sizga imkon qadar tezroq javob berishga harakat qilamiz.",
    'request_allowed' => "✅ Sizning so'rovingiz ruxsat etildi.",
    'request_denied' => "❌ Sizning so'rovingiz rad etildi.",
    'request_allowed_for_operator' => "✅ Siz muvaffaqiyatli so'rovga ruxsat berdingiz.",
    'request_denied_for_operator' => "✅ Siz so'rovni muvaffaqiyatli rad etdingiz.",
    'new_operator_confirmation' => "🪪 <b>Yangi operator</b>\n"
        . "Ism: :firstname\n"
        . "Familiya: :lastname\n"
        . "Kontakt: :contact\n",
    'new_dealer_confirmation' => "👨‍💼 <b>Yangi diler</b>\n"
        . "Ism: :firstname\n"
        . "Familiya: :lastname\n"
        . "Kontakt: :contact\n",
    'registered' => "✅ Siz muvaffaqiyatli ro'yxatdan o'tdingiz.",
    'empty_cars' => "❌ Sizda hech qanday Avtomobil yo'q",
    'car_added_info' => "🆔 ID: :id\n"
        . "🅰 Kompaniya: :company\n"
        . "Ⓜ Model: :model\n"
        . "🔢 Yil: :year\n"
        . "🔷 Rang: :color\n"
        . "🆕 Holati: :condition\n"
        . "💬 Qo'shimcha: :additional\n",
    'car_info' => "🆔 ID: :id\n"
        . "📊 Status: :status\n"
        . "🅰 Kompaniya: :company\n"
        . "Ⓜ Model: :model\n"
        . "🔢 Yil: :year\n"
        . "🔷 Rang: :color\n"
        . "🆕 Holati: :condition\n"
        . "💬 Qo'shimcha: :additional\n"
        . "🙍‍♂️ Egasi: :owner_fname :owner_lname\n"
        . "👨‍💼 G'olib: :winner_fname :winner_lname\n",
    'auction_created_info' => "<b>Auksion belgilandi</b>\n"
        . "🆔 Avtomobil ID: :car_id\n"
        . "🅰 Kompaniya: :company\n"
        . "Ⓜ Model: :model\n"
        . "🙍‍♂️ Egasi: :owner\n"
        . "📅 Boshlash: :start\n"
        . "🏁 Tugatish: :finish\n"
        . "💵 Boshlang'ich narxi: :starting_price\$\n",
    'broadcast_message' => "Auksionda yangi Avtomobil\n"
        . "🅰 Kompaniya: :company\n"
        . "Ⓜ Model: :model\n"
        . "🔢 Yil: :year\n"
        . "🔷 Rang: :color\n"
        . "🆕 Holati: :condition\n"
        . "💬 Qo'shimcha: :additional\n"
        . "📅 Boshlash: :start\n"
        . "🏁 Tugatish: :finish\n"
        . "💵 Boshlang'ich narxi: :starting_price\$\n",
    'ask_start' => "<b>Auksion boshlanish vaqtini yuboring</b>\n"
        . "Vaqt quyidagi formatlardan birida bo'lishi kerak:\n"
        . "1⃣ Quyidagi tugmalardan birini bosing\n"
        . "2⃣ soat:daqiqa (masalan, 20:02)\n"
        . "3⃣ yil-oy-kun soat:daqiqa (masalan, 2023-10-15 14:30)\n",
    'invalid_start' => "⚠️ Siz kiritgan ma'lumotlar hech qaysi formatga mos kelmadi.\n"
        . "Ma'lumotni quyidagi formatlardan birida kiritib ko'ring.\n"
        . "1⃣ Quyidagi tugmalardan birini bosing\n"
        . "2⃣ soat:daqiqa (masalan, 20:02)\n"
        . "3⃣ yil-oy-kun soat:daqiqa (masalan, 2023-10-15 14:30)\n",
    'logged_out' => "✅ Siz tizimdan muvaffaqiyatli chiqdingiz.",
    'already_logged_in' => "‼️ Siz hozir tizimga kirgansiz.\nAgar hisobni o'zgartirmoqchi bo'lsangiz: /logout",
    'not_logged_in' => "‼️ Siz hali tizimga kirmagansiz",
    'ask_firstname' => "Ism: (masalan, Jon)",
    'ask_lastname' => "Familiya: (masalan, Doe)",
    'add_car_btn' => "➕ Avtomobilingizni qo'shing",
    'contact_btn' => "📲 Mening kontaktimni baham ko'rish",
    'channel_link_for_dealer' => "Siz ushbu kanalda yangi auktsionlar haqidagi bildirishnomalarni kuzatishingiz mumkin.\n"
        . env('BROADCASTING_CHANNEL_LINK'),
    'new_task' => "☑️ Yangi vazifa",
    'ask_car_company' => "Kompaniya: (masalan, Daewoo)",
    'ask_car_model' => "Model: (masalan, Epica)",
    'ask_car_year' => "Yil: (masalan, 2010)",
    'ask_car_color' => "Rang: (masalan, oq)",
    'ask_car_condition' => "Avtomobilingizning holati:",
    'bad' => "Yomon",
    'good' => "Yaxshi",
    'new' => "Yangi",
    'join_btn' => "Qo'shilish",
    'left_btn' => "🚪 Auktsionni tark etish",
    'auction_inactive' => "‼️ Kechirasiz! Auktsion faol emas.",
    'auction_info' => "📈 Eng yuqori narx: :highest_price\$\n"
        . "💵 Boshlang'ich narxi: :starting_price\$\n"
        . "👁 Ishtirokchilar: :participants\n"
        . "🏁 Tugatish: :finish\n",
    'write_price' => "Siz bu yerda o'zingizga mos narxni osongina yozishingiz mumkin:\n"
        . "(masalan, 10000|10 000|10 000|10 000$|10 000$)",
    'cant_left' => "‼️ Kechirasiz! Auktsionni tark eta olmaysiz, chunki hozir eng yuqori narx egasi sizsiz.",
    'left' => "✅ Siz auksionni muvaffaqiyatli tark etdingiz.",
    'price_not_higher_enough' => "⚠️ Narx kamida :enough_money\$ dan yuqori bo'lishi kerak.",
    'owner_confirm_message' => "Sizning :color :company :model avtomobilingiz kimoshdi savdosida :highest_price\$ narxda edi. Siz Avtomobilingizni shu narxga sotishga rozimisiz?",
    'car_sold_message_for_dealers' => "<b>Avtomobil sotildi</b>\n"
        . "👨‍💼 G'olib: :lastname :lastname\n"
        . "🚘 Avtomobil: :color :company :model\n"
        . "💵 Narxi: :highest_price\$\n",
    'car_sold_message_for_operator' => "<b>Avtomobil sotildi</b>\n"
        . "🆔 Avtomobil ID: :car_id\n"
        . "🚘 Avtomobil: :color :company :model\n"
        . "💵 Narxi: :highest_price\$\n"
        . "👨‍💼 G'olib: :winner_fname :winner_lname\n"
        . "📲 Telefon: :winner_phone\n"
        . "🙍‍♂️ Egasi: :owner_fname :owner_lname\n"
        . "📲 Telefon: :owner_phone\n",
    'car_sold_message_for_winner' => "🎉<b>Tabriklaymiz!</b>🎉\n"
        . "Hurmatli :firstname :lastname\n"
        . "Auksionda g'olib chiqdingiz.\n\n"
        . "🆔 Avtomobil ID: :car_id\n"
        . "🚘 Avtomobil: :color :company :model\n"
        . "💵 Narxi: :highest_price\$\n",
    'car_sold_message_for_owner' => "🎉<b>Tabriklaymiz!</b>🎉\n"
        . "Hurmatli :firstname :lastname\n"
        . "Avtomobilingiz sotildi!\n\n"
        . "🆔 Avtomobil ID: :car_id\n"
        . "🚘 Avtomobil: :color :company :model\n"
        . "💵 Narxi: :highest_price\$\n"
        . "👨‍💼 G'olib: :winner_fname :winner_lname\n",
    'car_not_sold_message_for_dealers' => "<b>Avtomobil sotilmadi</b>\n"
        . "🚘 Avtomobil: :color :company :model\n"
        . "💵 Narxi: :starting_price\$\n",
    'car_not_sold_message_for_owner' => "<b>Avtomobil sotilmadi</b>\n"
        . "Hurmatli :firstname :lastnamesi Avtomobilingiz sotilmadi\n\n"
        . "🚘 Avtomobil: :color :company :model\n"
        . "💵 Narxi: :starting_price\$\n",
    'car_not_sold_message_for_operator' => "<b>Avtomobil sotilmadi</b>\n"
        . "🆔 Avtomobil ID: :car_id\n"
        . "🚘 Avtomobil: :color :company :model\n"
        . "🙍‍♂️ Egasi: :owner_fname :owner_lname\n"
        . "📲 Telefon: :owner_phone\n",
    'didnt_sell_message_for_dealers' => "<b>Avtomobil sotilmadi</b>\n"
        . "Avtomobilning egasi sotishga rozi bo'lmadi.\n\n"
        . "🚘 Avtomobil: :color :company :model\n"
        . "💵 Narxi: :highest_price\$\n",
    'didnt_sell_message_for_operator' => "<b>Avtomobil sotilmadi</b>\n"
        . "Avtomobilning egasi sotishga rozi bo'lmadi.\n\n"
        . "🆔 Avtomobil ID: :car_id\n"
        . "🚘 Avtomobil: :color :company :model\n"
        . "💵 Narxi: :highest_price\$\n"
        . "🙍‍♂️ Egasi: :owner_fname :owner_lname\n"
        . "📲 Telefon: :owner_phone\n",
    'didnt_sell_message_for_winner' => "<b>Avtomobil sotilmadi</b>\n"
        . "Hurmatli :firstname :lastname auktsion so'rovingiz avtomobil egasi tomonidan rad etildi.\n\n"
        . "🚘 Avtomobil: :color :company :model\n"
        . "💵 Narxi: :highest_price\$\n",
    'didnt_sell_message_for_owner' => "<b>Avtomobil sotilmadi</b>\n"
        . "Hurmatli :firstname :lastname siz sotishga rozi bo'lmadingiz.\n\n"
        . "🆔 Avtomobil ID: :car_id\n"
        . "🚘 Avtomobil: :color :company :model\n"
        . "💵 Narxi: :highest_price\$\n",
    'my_cars_btn' => "🚘 Mening Avtomobillarim",
    'yes' => "Ha",
    'no' => "Yo'q",
    'auction_finished' => "🏁 Kim oshdi savdosi yakunlandi.",
    'pending_reply_from_the_owner' => "⏳ Avtomobil egasidan javob kutilmoqda...",
    'start_new_auction_btn' => '➕ Yangi auktsionni boshlash',
    'settings_btn' => '⚙ Sozlamalar',
    'auction_duration_btn' => '🕗 Auktsion muddati',
    'ask_car_id' => 'Avtomobil identifikatori: (masalan, 4231)',
    'ask_auction_duration' => 'Auksion davomiyligini daqiqalarda yuboring: (masalan, 30)',
    'settings_updated' => "✅ O'zgartirishlaringiz muvaffaqiyatli yangilandi.",
    'cancel_btn' => '🆑 Bekor qilish',
    'on_sale' => "Sotuvda",
    'sold_out' => "Sotilgan",
    'not_sold' => "Sotilmagan",
    'didnt_sell' => "Sotmadi",
    'choose_one_car' => "Qo'shimcha ma'lumot olish uchun ulardan birini tanlashingiz mumkin:",
    'your_cars' => "Avtomobillaringiz:",
    'get_info_a_car' => "ℹ Avtomobil haqida ma'lumot oling",
    'ask_car_additional' => "Agar siz qo'shimcha ma'lumot qo'shmoqchi bo'lsangiz, bu haqda yozing \n"
        . "Yoki keyingi bosqichga o'tish uchun quyidagi \":next\" tugmasini bosing.",
    'next_btn' => "➡ Keyingi",
    'allow' => "Ruxsat berish",
    'deny' => "Rad qilish",
    'ignore' => "E'tibor bermaslik",
    'choose_section' => "Bo'limni tanlang 👇",
    'unexpected_callback_query' => "⚠️ Avtomobillar ro'yxatidan bitta bo'limni tanlashingiz kerak.",
    'exist_contact' => "⚠️ Bu kontakt allaqachon ro'yxatdan o'tgan.",
    'ask_starting_price' => "Avtomobilning boshlang'ich narxini yuboring (AQSh dollarida): (masalan, 10 000$)",
    'back_btn' => "⬅ Orqaga",
    'ask_validate_car_msg' => "Avtomobilni tasdiqlang:",
    'join_to_auction_msg' => "Auksionga qo'shilish uchun ushbu tugmani bosing 👇",
    'already_joined_this_auction' => "✅ Siz allaqachon ushbu auktsionga qo'shilgansiz, Diler bot chatini tekshiring.",
    'already_joined_another_auction' => "⚠️ Siz allaqachon boshqa auktsionga qo'shilgansiz, bu auktsionga qo'shilish uchun avval qo'shilgan auktsionni tark eting.",
    'joined_the_auction' => "✅ Siz auktsionga muvaffaqiyatli qo'shildingiz, qo'shimcha ma'lumot olish uchun Diler bot chatini tekshiring.",
    'auction_started_for_owner' => "<b>Auksion boshlandi</b>\n"
        . "🆔 Avtomobil ID: :car_id\n"
        . "🚘 Avtomobil: :color :company :model\n"
        . "💵 Narxi: :starting_price\$\n",
    'auction_started_for_dealer' => "🏁 <b>Auksion boshlandi</b> 🏁",
    'price_lt_starting_price' => "⚠️ Narx boshlang'ich narx (:starting_price\$) dan kattaroq bo'lishi kerak.",
    'auction_hasnt_started_yet' => "⚠️ Auktsion hali boshlanmagan, shuning uchun siz hozir taklif qila olmaysiz.",
    'not_validated_account' => "⚠️ Hurmatli :firstname :lastname, Sizning so'rovingiz hali ko'rib chiqilmagan.",
    'unexpected_cancel_command_on_joined_auction' => "⚠️ Auktsionni tark etish uchun \"Bekor qilish\" buyrug'i ishlatilmaydi.\n"
        . "Agar siz kim oshdi savdosidan chiqmoqchi bo'lsangiz, uning o'rniga \":left_btn\" tugmasini bosing.",
    'unexpected_logout_command_on_joined_auction' => "Foydalanuvchi auktsionda bo'lgan vaqtda ⚠️ \"Chiqish\" buyrug'i qo'llab-quvvatlanmaydi."
        . "Agar siz hisobingizni tark etishni istasangiz, avval \":left_btn\" tugmasini bosing.",
    'now_btn' => "Hozir",
    'after_30_mins_btn' => "🕕 30 daqiqadan keyin",
    'after_1_h_btn' => "🕛 1 soatdan keyin",
    'after_2_hs_btn' => "🕛 2 soatdan keyin",
    'car_not_validated' => "⚠️ Avtomobil tasdiqlanmagan.",
    'car_is_already_in_auction' => "⚠️ Avtomobil allaqachon auksionda.\n"
        . "Auksion holati: :life_cycle",
    'waiting_start' => "Boshlanishi kutilmoqda",
    'playing' => "O'ynalmoqda",
    'waiting_confirmation' => "Tasdiqlash kutilmoqda",
    'finished' => "Tugatildi",
    'cannot_cancel_queue' => "‼️ Kechirasiz, siz operatsiyani bekor qila olmaysiz, chunki sizdan boshqa operator yo'q.",
    'empty_queue' => "☑️ Hech qanday vazifa yo'q",
    'done' => "Bajarildi",
    'cannot_logout_because_of_queue' => "‼️ Kechirasiz, siz tizimdan chiqa olmaysiz, chunki sizda vazifa bor va vazifani tayinlaydigan boshqa operator yo'q.",
    'waiting_validation' => "Tasdiqlash kutilmoqda",

    'help' => 'Bu yordam',
    'info' => "Bu ma'lumot",
    'more_images' => "Siz Avtomobilingizning boshqa rasmlarini qo'shishingiz mumkin, agar qo'shishni xohlamasangiz, quyidagi \":next_btn\" tugmasini bosing",
    'image_limit_msg' => "‼️ Siz maksimal rasmlar soniga yetdingiz",
    'invalid_image' => "⚠️ Bizga surat yuborishingiz kerak",
    'ask_car_image' => "Avtomobilingiz tasvirini yuboring:",

    'attributes' => [],

];
