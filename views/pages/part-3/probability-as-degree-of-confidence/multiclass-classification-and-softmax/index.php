<?php

?><div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('nav.part3_probability_confidence'); ?></h1>
</div>

<?= create_run_code_button(__t('probability_confidence.case3_title'), 'part-3/probability-as-degree-of-confidence/case-3/multiclass-classification-and-softmax/code-run'); ?>

<div>
    <p>
        <?= __t('probability_confidence.intro'); ?>
    </p>
</div>

<div>
    <b><?= __t('probability_confidence.case3.scenario_title'); ?></b>
    <p>
        <?= __t('probability_confidence.case3.scenario_intro'); ?>
    </p>
    <p>
        <?= __t('probability_confidence.case3.scenario_note'); ?>
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/code.php', opened: true); ?>
</div>
<br><br>
