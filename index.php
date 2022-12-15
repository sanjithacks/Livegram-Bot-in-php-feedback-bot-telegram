<?php
#==================[By Sanjithacks]===============#



date_default_timezone_set("Asia/Kolkata");
define("BOT_TOKEN", "592998298:AAH4.."); //Your TOKEN here
define("API_URL", "https://api.telegram.org/bot" . BOT_TOKEN . "/");
$UID = 012333829; //ID of admin, only able to reply to message
$inbox_id = -10092829282; //ID where all message will forwarded
$input = file_get_contents("php://input");
$output = json_decode($input, true);
if (array_key_exists("message", $output)) {
    $update_id = $output["update_id"];
    $userid = $output["message"]["from"]["id"];
    $chat_type = $output["message"]["chat"]["type"];
    $firstname = $output["message"]["from"]["first_name"];
    $message_id = $output["message"]["message_id"];
    $caption = "";
    if (array_key_exists("caption", $output["message"])) {
        $caption = $output["message"]["caption"];
    }
    if (array_key_exists("text", $output["message"])) {
        if (
            $output["message"]["text"] == "/start" &&
            $userid != $UID &&
            $chat_type == "private"
        ) {
            $data = [
                "text" =>
                    "Hello\!\n\nYou can contact us using this bot\.\n\nThis bot was made by @Baetmon69",
                "parse_mode" => "MarkdownV2",
                "disable_web_page_preview" => true,
                "disable_notification" => false,
                "reply_to_message_id" => null,
                "chat_id" => $userid,
            ];
            $json_data = json_encode($data, JSON_NUMERIC_CHECK);
            return axios("sendMessage", $json_data);
        }
        if (
            $output["message"]["text"] == "/start" &&
            $userid == $UID &&
            $chat_type == "private"
        ) {
            $data = [
                "text" =>
                    "Hi I will forward all message to the group or channel you given me\.",
                "parse_mode" => "MarkdownV2",
                "disable_web_page_preview" => true,
                "disable_notification" => false,
                "reply_to_message_id" => null,
                "chat_id" => $userid,
            ];
            $json_data = json_encode($data, JSON_NUMERIC_CHECK);
            return axios("sendMessage", $json_data);
        }
    }
    if ($userid != $UID && $chat_type == "private") {
        $data = [
            "chat_id" => $inbox_id,
            "from_chat_id" => $userid,
            "message_id" => true,
            "disable_notification" => false,
            "message_id" => $message_id,
        ];
        $json_data = json_encode($data, JSON_NUMERIC_CHECK);
        return axios("forwardMessage", $json_data);
    } else {
        if ($userid == $UID) {
            if (array_key_exists("reply_to_message", $output["message"])) {
                if (
                    array_key_exists(
                        "forward_from",
                        $output["message"]["reply_to_message"]
                    )
                ) {
                    if (array_key_exists("text", $output["message"])) {
                        $data = [
                            "text" => $output["message"]["text"],
                            "chat_id" =>
                                $output["message"]["reply_to_message"][
                                    "forward_from"
                                ]["id"],
                        ];
                        $json_data = json_encode($data, JSON_NUMERIC_CHECK);
                        return axios("sendMessage", $json_data);
                    }
                    if (array_key_exists("animation", $output["message"])) {
                        $data = [
                            "animation" =>
                                $output["message"]["animation"]["file_id"],
                            "chat_id" =>
                                $output["message"]["reply_to_message"][
                                    "forward_from"
                                ]["id"],
                        ];
                        $json_data = json_encode($data, JSON_NUMERIC_CHECK);
                        return axios("sendAnimation", $json_data);
                    }
                    if (array_key_exists("audio", $output["message"])) {
                        $data = [
                            "audio" => $output["message"]["audio"]["file_id"],
                            "chat_id" =>
                                $output["message"]["reply_to_message"][
                                    "forward_from"
                                ]["id"],
                            "caption" => $caption,
                        ];
                        $json_data = json_encode($data, JSON_NUMERIC_CHECK);
                        return axios("sendAudio", $json_data);
                    }
                    if (array_key_exists("contact", $output["message"])) {
                        $data = [
                            "phone_number" =>
                                $output["message"]["contact"]["phone_number"],
                            "first_name" =>
                                $output["message"]["contact"]["first_name"],
                            "last_name" => $output["message"]["contact"][
                                "last_name"
                            ]
                                ? $output["message"]["contact"]["last_name"]
                                : "",
                            "vcard" => $output["message"]["contact"]["vcard"],
                            "chat_id" =>
                                $output["message"]["reply_to_message"][
                                    "forward_from"
                                ]["id"],
                        ];
                        $json_data = json_encode($data, JSON_NUMERIC_CHECK);
                        return axios("sendContact", $json_data);
                    }
                    if (array_key_exists("dice", $output["message"])) {
                        $data = [
                            "chat_id" =>
                                $output["message"]["reply_to_message"][
                                    "forward_from"
                                ]["id"],
                            "emoji" => $output["message"]["emoji"],
                        ];
                        $json_data = json_encode($data, JSON_NUMERIC_CHECK);
                        return axios("sendDice", $json_data);
                    }
                    if (array_key_exists("document", $output["message"])) {
                        $data = [
                            "document" =>
                                $output["message"]["document"]["file_id"],
                            "chat_id" =>
                                $output["message"]["reply_to_message"][
                                    "forward_from"
                                ]["id"],
                            "caption" => $caption,
                        ];
                        $json_data = json_encode($data, JSON_NUMERIC_CHECK);
                        return axios("sendDocument", $json_data);
                    }
                    if (array_key_exists("location", $output["message"])) {
                        $data = [
                            "longitude" => $output["message"]["location"][
                                "longitude"
                            ]
                                ? $output["message"]["location"]["longitude"]
                                : 0,
                            "latitude" => $output["message"]["location"][
                                "latitude"
                            ]
                                ? $output["message"]["location"]["latitude"]
                                : 0,
                            "horizontal_accuracy" => $output["message"][
                                "location"
                            ]["horizontal_accuracy"]
                                ? $output["message"]["location"][
                                    "horizontal_accuracy"
                                ]
                                : 0,
                            "live_period" => $output["message"]["location"][
                                "live_period"
                            ]
                                ? $output["message"]["location"]["live_period"]
                                : 0,
                            "heading" => $output["message"]["location"][
                                "heading"
                            ]
                                ? $output["message"]["location"]["heading"]
                                : 0,
                            "proximity_alert_radius" => $output["message"][
                                "location"
                            ]["proximity_alert_radius"]
                                ? $output["message"]["location"][
                                    "proximity_alert_radius"
                                ]
                                : 0,
                            "chat_id" =>
                                $output["message"]["reply_to_message"][
                                    "forward_from"
                                ]["id"],
                        ];
                        $json_data = json_encode($data, JSON_NUMERIC_CHECK);
                        return axios("sendLocation", $json_data);
                    }
                    if (array_key_exists("photo", $output["message"])) {
                        $data = [
                            "photo" => end($output["message"]["photo"])[
                                "file_id"
                            ],
                            "chat_id" =>
                                $output["message"]["reply_to_message"][
                                    "forward_from"
                                ]["id"],
                            "caption" => $caption,
                        ];
                        $json_data = json_encode($data, JSON_NUMERIC_CHECK);
                        return axios("sendPhoto", $json_data);
                    }
                    if (array_key_exists("sticker", $output["message"])) {
                        $data = [
                            "sticker" =>
                                $output["message"]["sticker"]["file_id"],
                            "chat_id" =>
                                $output["message"]["reply_to_message"][
                                    "forward_from"
                                ]["id"],
                        ];
                        $json_data = json_encode($data, JSON_NUMERIC_CHECK);
                        return axios("sendSticker", $json_data);
                    }
                    if (array_key_exists("venue", $output["message"])) {
                        $data = [
                            "longitude" => $output["message"]["venue"][
                                "location"
                            ]["longitude"]
                                ? $output["message"]["venue"]["location"][
                                    "longitude"
                                ]
                                : 0,
                            "latitude" => $output["message"]["venue"][
                                "location"
                            ]["latitude"]
                                ? $output["message"]["venue"]["location"][
                                    "latitude"
                                ]
                                : 0,
                            "titile" => $output["message"]["venue"]["title"]
                                ? $output["message"]["venue"]["title"]
                                : "",
                            "address" => $output["message"]["venue"]["address"]
                                ? $output["message"]["venue"]["address"]
                                : "",
                            "foursquare_id" => $output["message"]["venue"][
                                "foursquare_id"
                            ]
                                ? $output["message"]["venue"]["foursquare_id"]
                                : "",
                            "foursquare_type" => $output["message"]["venue"][
                                "foursquare_type"
                            ]
                                ? $output["message"]["venue"]["foursquare_type"]
                                : "",
                            "google_place_id" => $output["message"]["venue"][
                                "google_place_id"
                            ]
                                ? $output["message"]["venue"]["google_place_id"]
                                : "",
                            "google_place_type" => $output["message"]["venue"][
                                "google_place_type"
                            ]
                                ? $output["message"]["venue"][
                                    "google_place_type"
                                ]
                                : "",
                            "chat_id" =>
                                $output["message"]["reply_to_message"][
                                    "forward_from"
                                ]["id"],
                        ];
                        $json_data = json_encode($data, JSON_NUMERIC_CHECK);
                        return axios("sendVenue", $json_data);
                    }
                    if (array_key_exists("video", $output["message"])) {
                        $data = [
                            "video" => $output["message"]["video"]["file_id"],
                            "chat_id" =>
                                $output["message"]["reply_to_message"][
                                    "forward_from"
                                ]["id"],
                        ];
                        $json_data = json_encode($data, JSON_NUMERIC_CHECK);
                        return axios("sendVideo", $json_data);
                    }
                    if (array_key_exists("video_note", $output["message"])) {
                        $data = [
                            "video_note" =>
                                $output["message"]["video_note"]["file_id"],
                            "chat_id" =>
                                $output["message"]["reply_to_message"][
                                    "forward_from"
                                ]["id"],
                        ];
                        $json_data = json_encode($data, JSON_NUMERIC_CHECK);
                        return axios("sendVideoNote", $json_data);
                    }
                    if (array_key_exists("voice", $output["message"])) {
                        $data = [
                            "voice" => $output["message"]["voice"]["file_id"],
                            "chat_id" =>
                                $output["message"]["reply_to_message"][
                                    "forward_from"
                                ]["id"],
                            "caption" => $caption,
                        ];
                        $json_data = json_encode($data, JSON_NUMERIC_CHECK);
                        return axios("sendVideoNote", $json_data);
                    }
                }
            }
        }
    }
}
function axios($method, $parameters)
{
    if (!is_string($method)) {
        error_log("Method name must be a string\n");
        return false;
    }
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => API_URL . $method,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $parameters,
        CURLOPT_HTTPHEADER => [
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36",
            "accept: application/json",
            "content-type: application/json",
        ],
    ]);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        return "cURL Error #:" . $err;
    } else {
        return $response;
    }
}
?>
