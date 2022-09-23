<?php
$bot_id = '5671597162:AAEnt_14yVkVc3_DooMLOwRUf2MhKqnPq98';
include 'sendMessage.php';

$json_out = json_decode(file_get_contents('php://input'), true);
$chat_id = $json_out['message']['chat']['id'];
$first_name = trim(str_replace('?', '', preg_replace('/[^A-Za-z0-9 ]/', '', $json_out['message']['chat']['first_name'])));
$type = $json_out['message']['chat']['type'];
$message = $json_out['message']['text'];
$message_id = $json_out['message']['message_id'];

sendMessage($bot_id,$chat_id,false,'Hi '.$first_name.'! Wie kann ich dir helfen?');

if(stripos($message, '/start') === 0 && $type == 'private')
{
    $sent = true;
    sendMessage($bot_id,$chat_id,false,'Hi '.$first_name.'! Wie kann ich dir helfen?');
}

if(stripos($message, '/befehl') === 0 && !isset($sent))
{
    $sent = true;
    sendMessage($bot_id,$chat_id,false,'Du hast <b>/befehl</b> verwendet. Das wäre die Antwort auf diesen Befehl. Ach übrigens, kannst du ganz einfach HTML-Tags verwenden, um beispielsweise den Text <b>fett</b> oder <i>kursiv</i> zu schreiben.');
}

if(stripos($message, '/würfel') === 0 || stripos($message, '/wuerfel') === 0 && !isset($sent))
{
    $sent = true;
    file_get_contents('https://api.telegram.org/bot'.$bot_id.'/senddice?chat_id='.$chat_id);
}

if(strpos(strtolower($message), 'whatsapp') !== false && !isset($sent))
{
    $sent = true;
    sendMessage($bot_id,$chat_id,false,'Habe ich da etwa WhatsApp gehört? Telegram > WhatsApp.');
}

if(strpos(strtolower($message), 'chatid') !== false && !isset($sent))
{
    $sent = true;
    sendMessage($bot_id,$chat_id,false,'Deine Chat-ID lautet: <b>'.$chat_id.'</b>');
}

$array = array('eins','zwei','drei');
if(in_array(strtolower($message), $array) AND !isset($sent))
{
    $sent = true;
    sendMessage($bot_id,$chat_id,false,'Wenn eines dieser Wörter in der Nachricht an den Bot vorkommt, erscheint diese Antwort.');
}

if(!isset($sent) && $type == 'private')
{
    sendMessage($bot_id,$chat_id,false,'Sorry, aber das habe ich nicht ganz verstanden.');
}

