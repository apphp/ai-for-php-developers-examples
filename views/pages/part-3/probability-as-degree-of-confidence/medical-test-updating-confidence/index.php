<?php

?><div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('nav.part3_probability_confidence'); ?></h1>
</div>

<?= create_run_code_button(__t('probability_confidence.case2_title'), 'part-3/probability-as-degree-of-confidence/case-2/medical-test-updating-confidence/code-run'); ?>

<div>
    <p>
        <?= __t('probability_confidence.intro'); ?>
    </p>
</div>

<div>
    <b><?= __t('probability_confidence.case2.scenario_title'); ?></b>
    <p>
        <?= __t('probability_confidence.case2.scenario_intro'); ?>
    </p>
    <ul>
        <li><?= __t('probability_confidence.case2.scenario_item1'); ?></li>
        <li><?= __t('probability_confidence.case2.scenario_item2'); ?></li>
        <li><?= __t('probability_confidence.case2.scenario_item3'); ?></li>
    </ul>
    <p>
        <?= __t('probability_confidence.case2.scenario_question'); ?>
    </p>
    <p>
        <?= __t('probability_confidence.case2.scenario_note'); ?>
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/code.php', opened: true); ?>
</div>
<br><br>
