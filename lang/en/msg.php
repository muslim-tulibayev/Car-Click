<?php

return [

    'choose_lang' => "Select language:\n\n"
        . "Muloqot uchun tilni tanlang:\n\n"
        . "Выберите язык для общения:",

    'cancelled' => '✅ All operations has been cancelled',
    'empty_action' => "⚠️ Nothing to cancel",
    'ask_contact' => "Contact: (Press the \":btn\" button below)",
    'invalid_contact' => "⚠️ You should send us your contact\n(Just press the \":btn\" button below)",
    'login_started' => "✅ Login process started",
    'wrong_credentials' => "⚠️ Contact or Password is wrong.\n♻️ To try again: /login",
    'welcome_msg' => "🎊 Welcome :firstname :lastname",
    'registration_started' => "✅ Registration process started",
    'ask_password' => "Password:",
    'ask_new_password' => "Create a password: (minimum length must be 8 characters)",
    'request_registered_msg' => "📨 Your request has been successfully registered and sent to the Operators",
    'please_wait' => "⏳ Please wait, we will try to answer you as soon as possible",
    'request_allowed' => "✅ Your request allowed",
    'request_denied' => "❌ Your request denied",
    'request_allowed_for_operator' => "✅ You successfully allowed the request",
    'request_denied_for_operator' => "✅ You successfully denied the request",
    'task_done_msg' => "✅ You have successfully completed your task",
    'new_operator_confirmation' => "🪪 <b>New Operator</b>\n"
        . "Firstname: :firstname\n"
        . "Lastname: :lastname\n"
        . "Contact: :contact\n",
    'new_dealer_confirmation' => "👨‍💼 <b>New Dealer</b>\n"
        . "Firstname: :firstname\n"
        . "Lastname: :lastname\n"
        . "Contact: :contact\n",
    'registered' => "✅ You are successfully resgistered",
    'empty_cars' => "❌ You do not have any cars",
    'car_added_info' => "🆔 ID: :id\n"
        . "🅰 Company: :company\n"
        . "Ⓜ Model: :model\n"
        . "🔢 Year: :year\n"
        . "🔷 Color: :color\n"
        . "🆕 Condition: :condition\n"
        . "💬 Additional: :additional\n",
    'car_info' => "🆔 ID: :id\n"
        . "📊 Status: :status\n"
        . "🅰 Company: :company\n"
        . "Ⓜ Model: :model\n"
        . "🔢 Year: :year\n"
        . "🔷 Color: :color\n"
        . "🆕 Condition: :condition\n"
        . "💬 Additional: :additional\n"
        . "� Owner: :owner_fname :owner_lname\n"
        . "🏆 Winner: :winner_fname :winner_lname\n",
    'auction_created_info' => "<b>The auction is set</b>\n"
        . "🆔 Car ID: :car_id\n"
        . "🅰 Company: :company\n"
        . "Ⓜ Model: :model\n"
        . "� Owner: :owner\n"
        . "📅 Start: :start\n"
        . "🏁 Finish: :finish\n"
        . "💵 Starting price: :starting_price\$\n",
    'broadcast_message' => "New car in Auction\n"
        . "🅰 Company: :company\n"
        . "Ⓜ Model: :model\n"
        . "🔢 Year: :year\n"
        . "🔷 Color: :color\n"
        . "🆕 Condition: :condition\n"
        . "💬 Additional: :additional\n"
        . "📅 Start: :start\n"
        . "🏁 Finish: :finish\n"
        . "💵 Starting price: :starting_price\$\n",
    'ask_start' => "<b>Submit the auction starting time</b>\n"
        . "The time should be in one of these formats:\n"
        . "1⃣ Just click one of the buttons below\n"
        . "2⃣ hour:minute (e.g. 20:02)\n"
        . "3⃣ year-month-day hour:minute (e.g. 2023-10-15 14:30)\n",
    'invalid_start' => "⚠️ The information you entered did not match any of the formats.\n"
        . "Please try entering information in one of the following formats.\n"
        . "1⃣ Just click one of the buttons below\n"
        . "2⃣ hour:minute (e.g. 20:02)\n"
        . "3⃣ year-month-day hour:minute (e.g. 2023-10-15 14:30)\n",
    'logged_out' => "✅ You have successfully logged out",
    'already_logged_in' => "‼️ You are currently logged in.\nIf you want to change account: /logout",
    'not_logged_in' => "‼️ You are not logged in yet",
    'ask_firstname' => "Firstname: (e.g. John)",
    'ask_lastname' => "Lastname: (e.g. Doe)",
    'add_car_btn' => "➕ Add your car",
    'contact_btn' => "📲 Share my contact",
    'channel_link_for_dealer' => "You must subscribe to this channel to be notified of new auctions\n",
    'new_task' => "☑️ New task",
    'ask_car_company' => "Company: (e.g. Daewoo)",
    'ask_car_model' => "Model: (e.g. Epica)",
    'ask_car_year' => "Year: (e.g. 2010)",
    'ask_car_color' => "Color: (e.g. White)",
    'ask_car_condition' => "Condition of your car:",
    'bad' => "Bad",
    'good' => "Good",
    'new' => "New",
    'join_btn' => "Join",
    'left_btn' => "🚪 Leave the Auction",
    'auction_inactive' => "‼️ Sorry! Auction is not active",
    'write_price' => "You can easily write the price that suits you here:\n"
        . "(e.g. 10000|10 000|10,000|10 000$|$10 000)",
    'cant_left' => "‼️ Sorry! You can't left the Auction becuase the highest price owner is you now",
    'left' => "✅ You successfully left the auction",
    'price_not_higher_enough' => "⚠️ The price must be at least higher than :enough_price\$",
    'owner_confirm_message' => "Your :color :company :model car was priced at :highest_price\$ at the auction. Are you willing to sell your car for this price?",
    'car_sold_message_for_dealers' => "<b>Car sold out.</b>\n"
        . "🏆 Winner: :firstname :lastname\n"
        . "🚘 Car: :color :company :model\n"
        . "💵 Price: :highest_price\$\n",
    'car_sold_message_for_winner' => "🎉<b>Congratulations!</b>🎉\n"
        . "Dear :firstname :lastname\n"
        . "You won the auction.\n\n"
        . "🆔 Car ID: :car_id\n"
        . "🚘 Car: :color :company :model\n"
        . "💵 Price: :highest_price\$\n",
    'car_sold_message_for_owner' => "🎉<b>Congratulations!</b>🎉\n"
        . "Dear :firstname :lastname\n"
        . "Your car sold out!\n\n"
        . "🆔 Car ID: :car_id\n"
        . "🚘 Car: :color :company :model\n"
        . "💵 Price: :highest_price\$\n"
        . "🏆 Winner: :winner_fname :winner_lname\n",
    'car_not_sold_message_for_dealers' => "<b>Car not sold.</b>\n"
        . "🚘 Car: :color :company :model\n"
        . "💵 Price: :starting_price\$\n",
    'car_not_sold_message_for_owner' => "<b>Car not sold.</b>\n"
        . "Dear :firstname :lastname your car not sold.\n\n"
        . "🚘 Car: :color :company :model\n"
        . "💵 Price: :starting_price\$\n",
    'car_not_sold_message_for_operator' => "<b>Car not sold.</b>\n"
        . "🆔 Car ID: :car_id\n"
        . "🚘 Car: :color :company :model\n"
        . "� Owner: :owner_fname :owner_lname\n"
        . "📲 Phone: :owner_phone\n",
    'didnt_sell_message_for_dealers' => "<b>Car not sold.</b>\n"
        . "The owner of the car did not agree to sell.\n\n"
        . "🚘 Car: :color :company :model\n"
        . "💵 Price: :highest_price\$\n",
    'didnt_sell_message_for_operator' => "<b>Car not sold.</b>\n"
        . "The owner of the car did not agree to sell.\n\n"
        . "🆔 Car ID: :car_id\n"
        . "🚘 Car: :color :company :model\n"
        . "💵 Price: :highest_price\$\n"
        . "👤 Owner: :owner_fname :owner_lname\n"
        . "📲 Phone: :owner_phone\n",
    'didnt_sell_message_for_winner' => "<b>Car not sold.</b>\n"
        . "Dear :firstname :lastname your auction request has been rejected by the owner of the car.\n\n"
        . "🚘 Car: :color :company :model\n"
        . "💵 Price: :highest_price\$\n",
    'didnt_sell_message_for_owner' => "<b>Car not sold.</b>\n"
        . "Dear :firstname :lastname you did not agree to sell.\n\n"
        . "🆔 Car ID: :car_id\n"
        . "🚘 Car: :color :company :model\n"
        . "💵 Price: :highest_price\$\n",
    'my_cars_btn' => "🚘 My cars",
    'yes' => "Yes",
    'no' => "No",
    'auction_finished' => "🏁 The auction has finished",
    'pending_reply_from_the_owner' => "⏳ Pending reply from the owner of the car..",
    'start_new_auction_btn' => '➕ Start new Auction',
    'settings_btn' => '⚙ Settings',
    'auction_duration_btn' => '🕗 Auction duration',
    'ask_car_id' => 'Car ID: (e.g. 4231)',
    'ask_auction_duration' => 'Submit Auction duration in minutes: (e.g. 30)',
    'settings_updated' => '✅ Your changes successfully updated.',
    'cancel_btn' => '🆑 Cancel',
    'on_sale' => "On sale",
    'sold_out' => "Sold out",
    'not_sold' => "Not sold",
    'didnt_sell' => "Did not sell",
    'choose_one_car' => "You can choose one of these for more information:",
    'your_cars' => "Your cars:",
    'get_info_a_car' => "ℹ Get info about a car",
    'ask_car_additional' => "If you want to add more information, write about it \n"
        . "Or click \":next\" button below to go to the next step",
    'next_btn' => "➡ Next",
    'allow' => "Allow",
    'deny' => "Deny",
    'ignore' => "Ignore",
    'choose_section' => "Choose section 👇",
    'unexpected_callback_query' => "⚠️ You should select one section from cars list",
    'exist_contact' => "⚠️ This contact already registered",
    'ask_starting_price' => "Submit the starting price of the car (in USD): (e.g. 10 000$)",
    'back_btn' => "⬅ Back",
    'ask_validate_car_msg' => "Validate this car:",
    'join_to_auction_msg' => "To join the auction click this button 👇",
    'already_joined_this_auction' => "✅ You have already joined this auction, Please check the Dealer bot chat",
    'already_joined_another_auction' => "⚠️ You have already joined another auction, to join this auction, please leave the auction you previously joined",
    'joined_the_auction' => "✅ You joined the auction successfully, Please check the Dealer bot chat for more information",
    'auction_started_for_owner' => "<b>Auction started</b>\n"
        . "🆔 Car ID: :car_id\n"
        . "🚘 Car: :color :company :model\n"
        . "💵 Price: :starting_price\$\n",
    'auction_started_for_dealer' => "🏁 <b>Auction started</b> 🏁",
    'price_lt_starting_price' => "⚠️ Price must be greater than the starting price (:starting_price\$)",
    'auction_hasnt_started_yet' => "⚠️ The auction hasn't started yet, so you can't bid now",
    'not_validated_account' => "⚠️ Dear :firstname :lastname, Your request has not been processed yet",
    'unexpected_cancel_command_on_joined_auction' => "⚠️ The \"Cancel\" command is not used to leave the auction.\n"
        . "If you want to exit the auction, click the \":left_btn\" button instead",
    'unexpected_logout_command_on_joined_auction' => "⚠️ \"Logout\" command is not supported while a user is in an auction."
        . "If you want to leave your account, please click \":left_btn\" button first",
    'now_btn' => "Now",
    'after_30_mins_btn' => "🕕 After 30 minutes",
    'after_1_h_btn' => "🕛 After 1 hour",
    'after_2_hs_btn' => "🕛 After 2 hours",
    'car_not_validated' => "⚠️  Car not validated",
    'car_is_already_in_auction' => "⚠️ Car is already in Auction.\n"
        . "Auction status: :life_cycle",
    'waiting_start' => "Waiting to start",
    'playing' => "Playing",
    'waiting_confirmation' => "Waiting confirmation",
    'finished' => "Finished",
    'cannot_cancel_queue' => "‼️ Sorry, You cannot cancel the operation beacuse there is no operator except you",
    'queue_ignored' => "✅ The task ignored successfully",
    'empty_queue' => "☑️ There is no task",
    'done' => "Done",
    'cannot_logout_because_of_queue' => "‼️ Sorry, you cannot log out because you have a task and there is no other operator to assign the task to",
    'waiting_validation' => "Waiting validation",
    'help' => 'This is help',
    'info' => "This is info",
    'more_images' => "You can add more images of your car, If you don't want to add, click \":next_btn\" button below",
    'image_limit_msg' => "‼️ You have reached the maximum number of images",
    'invalid_image' => "⚠️ You should send us a photo",
    'ask_car_image' => "Send an image of your car:",
    'visit_channel' => "🌐 Visit channel",
    'auction_info_msg_for_current_winner' => "📈 Highest price: :highest_price\$\n"
        . "👀 Participants: :participants\n"
        . "🏁 Finish: :finish\n\n"
        . "<b> 👑 Dear :fname :lname, the highest bidder is you now </b>",
    'auction_info_msg_for_dealers' => "📈 Highest price: :highest_price\n"
        . "👀 Participants: :participants\n"
        . "🏁 Finish: :finish\n\n"
        . "✳ Now you can bid :enough_price\$ to win the auction",
    'auction_info_msg_for_owner' => "📈 Highest price: :highest_price\$\n"
        . "👀 Participants: :participants\n"
        . "🏁 Finish: :finish\n",
    'get_info_dealers' => "👨‍💼 Dealers",
    'dealers_info_msg' => "👨‍💼 Dealers:\n"
        . "🔢 Number: :number\n",
    'not_bid_yet' => 'Not bid yet',
    'dealer_list_title' => "<b>👨‍💼 Dealers :first_num - :last_num of :all_num </b>\n\n",
    'dealer_info' => "<b>👨‍💼 Dealer </b>\n\n"
        . "Firstname: :fname\n"
        . "Lastname: :lname\n"
        . "Phone: :contact\n"
        . "Number of cars: :num_of_cars",

    'take' => "Take",
    'bids_list' => "<b>🤝 Bids :first_num - :last_num of :all_num </b>\n\n"
        . ":slot\n"
        . "👤 Owner: :owner_fname :owner_lname\n"
        . "📲 Phone: :owner_phone\n",
    'car_sold_message_for_operator' => "<b>Car sold out.</b>\n"
        . "🆔 Car ID: :car_id\n"
        . "🚘 Car: :color :company :model\n"
        . "💵 Price: :highest_price\$\n"
        . "🏆 Winner: :winner_fname :winner_lname\n"
        . "📲 Phone: :winner_phone\n"
        . "👤 Owner: :owner_fname :owner_lname\n"
        . "📲 Phone: :owner_phone\n",
    'bidder' => "<b>:number - :price\$</b>\n"
        . "👨‍💼 Dealer: :fname :lname\n"
        . "📲 Phone: :phone\n",

    'attributes' => [],

];
