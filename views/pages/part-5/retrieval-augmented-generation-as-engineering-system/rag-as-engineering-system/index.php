<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('rag_engineering_system.rag_as_engineering_system.title'); ?></h1>
</div>

<div>
    <p>
        <?= __t('rag_engineering_system.rag_as_engineering_system.intro'); ?>
    </p>
</div>

<?php

//use LLPhant\Chat\OpenAIChat;
//use LLPhant\Chat\Message;
//use LLPhant\Chat\Enums\ChatRole;
//
//$apiKey = config('OPENAI_API_KEY');
//
//if (!$apiKey) {
//    echo '<div class="alert alert-warning" role="alert">OPENAI_API_KEY is not set. Add it to your <code>.env</code> file to run this example.</div>';
//} else {
//    try {
//        $chat = new OpenAIChat();
//
//        $message = new Message();
//        $message->role = ChatRole::User;
//        $message->content = 'What is the capital of France?';
//
//        $response = $chat->generateText($message);
//
//        echo '<div class="card"><div class="card-body"><pre class="mb-0">' . htmlspecialchars((string)$response, ENT_QUOTES, 'UTF-8') . '</pre></div></div>';
//    } catch (\Throwable $e) {
//        echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</div>';
//    }
//}


?>


<br><br>
