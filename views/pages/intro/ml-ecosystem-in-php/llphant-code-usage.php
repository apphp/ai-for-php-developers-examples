<?php

use LLPhant\Chat\Enums\ChatRole;
use LLPhant\Chat\Message;
use LLPhant\Chat\OpenAIChat;

$chat = new OpenAIChat();

$message = new Message();
$message->role = ChatRole::User;
$message->content = 'What is the capital of France? ';

$response = $chat->generateText((string)$message);
echo $response;
