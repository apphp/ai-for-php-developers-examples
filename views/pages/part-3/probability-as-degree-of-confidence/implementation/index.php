<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('nav.part3_probability_confidence'); ?></h1>
</div>

<?= create_run_code_button(__t('common.implementation_in_pure_php'), 'part-3/probability-as-degree-of-confidence/implementation/code-run'); ?>

<div>
    <p>
        <?= __t('probability_confidence.logits_paragraph'); ?>
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/code.php', opened: true, copyButtonId: 1, expandButtonId: 1); ?>
</div>

