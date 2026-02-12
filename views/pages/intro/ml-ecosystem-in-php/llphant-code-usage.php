<?php

use LLPhant\Chat\OpenAIChat;
use LLPhant\Chat\Message;
use LLPhant\Chat\Enums\ChatRole;

$chat = new OpenAIChat();

$message = new Message();
$message->role = ChatRole::User;
$message->content = 'What is the capital of France? ';

$response = $chat->generateText($message);
echo $response;
