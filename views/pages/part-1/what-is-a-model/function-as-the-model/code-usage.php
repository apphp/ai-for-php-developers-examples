<?php

require_once __DIR__ . '/code.php';

$model = new SimpleLinearModel(2.0, 0.0);
echo $model->predict(3.0);
