<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('nav.part3_probability_confidence'); ?></h1>
</div>

<div>
    <p>
        <?= __t('probability_confidence.intro'); ?>
    </p>

    <ul>
        <li>
            <?= create_link('part-3/probability-as-degree-of-confidence/implementation', __t('probability_confidence.link_softmax_example')) ?>
        </li>
        <li>
            <?= create_link('part-3/probability-as-degree-of-confidence/case-1/spam-filter-probability-vs-decision', __t('probability_confidence.case1_title')) ?>
        </li>
        <li>
            <?= create_link('part-3/probability-as-degree-of-confidence/case-2/medical-test-updating-confidence', __t('probability_confidence.case2_title')) ?>
        </li>
        <li>
            <?= create_link('part-3/errors-and-loss-functions/case-3/...', __t('probability_confidence.case3_title'), true) ?>
        </li>
        <li>
            <?= create_link('part-3/errors-and-loss-functions/case-4/...', __t('probability_confidence.case4_title'), true) ?>
        </li>
        <li>
            <?= create_link('part-3/errors-and-loss-functions/case-4/...', __t('probability_confidence.case5_title'), true) ?>
        </li>
    </ul>
</div>
