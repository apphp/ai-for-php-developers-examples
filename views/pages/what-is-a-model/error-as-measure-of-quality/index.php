<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('what_is_model.heading'); ?></h1>
</div>

<?= create_run_code_button(__t('what_is_model.error_as_measure_of_quality'), 'part-1/what-is-a-model/error-as-measure-of-quality/code-run'); ?>

<div>
    <p>
        <?= __t('what_is_model.error_measure.intro1'); ?>
    </p>

    <p>
        <?= __t('what_is_model.error_measure.intro2'); ?>
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/code.php', opened: true); ?>
</div>
