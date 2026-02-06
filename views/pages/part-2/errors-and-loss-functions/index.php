<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('errors_loss.heading'); ?></h1>
</div>

<div>
    <p>
        <?= __t('errors_loss.intro'); ?>
    </p>

    <p>
        <?= __t('errors_loss.intro2'); ?>
    </p>

    <ul>
        <li>
            <?= create_link('part-2/errors-and-loss-functions/case-1/mse-and-cost-of-a-big-miss', __t('errors_loss.case1_title')) ?>
        </li>
        <li>
            <?= create_link('part-2/errors-and-loss-functions/case-2/model-selection-using-a-loss-function', __t('errors_loss.case2_title')) ?>
        </li>
        <li>
            <?= create_link('part-2/errors-and-loss-functions/case-3/log-loss-and-classifier-confidence', __t('errors_loss.case3_title')) ?>
        </li>
        <li>
            <?= create_link('part-2/errors-and-loss-functions/case-4/same-accuracy-different-log-loss', __t('errors_loss.case4_title')) ?>
        </li>
        <li>
            <?= create_link('part-2/errors-and-loss-functions/case-5/...', __t('errors_loss.case5_title'), true) ?>
        </li>
    </ul>
</div>
