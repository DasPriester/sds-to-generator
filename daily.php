<?php
// runs daily

// load the Bot/chats.json
$chats = json_decode(file_get_contents('Bot/chats.json'), true);

// for every group check if it is the day after the groups weekday (monday, tuesday, wednesday, thursday, friday, saturday, sunday)
foreach ($chats["groups"] as $chat) {
    if (date('Y-m-d', strtotime('yesterday')) == date('Y-m-d', strtotime('last ' . $chat['weekday']))) {
        // if it is, send the message
        $message = 'Resetting the group for the next week.';
        $url = 'https://api.telegram.org/bot' . $token . '/sendMessage?chat_id=' . $chat['id'] . '&text=' . urlencode($message);
        file_get_contents($url);

        // reset the group
        // load TOs/group/Plenum_to.json
        $plenum = json_decode(file_get_contents('TOs/' . $chat['name'] . '/Plenum_to.json'), true);

        // save file to TOs/group/Plenum_<date>_to.json
        $date = $plenum['date'];
        file_put_contents('TOs/' . $chat['name'] . '/Plenum_' . $date . '_to.json', json_encode($plenum, JSON_PRETTY_PRINT));

        // reset the plenum
        // set date to next weekday
        $date = date('Y-m-d', strtotime('next ' . $chat['weekday']));
        // reset the TO
        $plenum = [
            'name' => 'Plenum',
            'date' => $date,
            'tops' => [],
        ];

        // save the file
        file_put_contents('TOs/' . $chat['name'] . '/Plenum_to.json', json_encode($plenum, JSON_PRETTY_PRINT));
    }
}