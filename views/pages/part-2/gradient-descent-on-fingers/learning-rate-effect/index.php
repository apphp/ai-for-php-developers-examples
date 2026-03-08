<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('gradient_descent.heading'); ?></h1>
</div>

<?= create_run_code_button(__t('gradient_descent.sample2_title'), 'part-2/gradient-descent-on-fingers/sample-2/learning-rate-effect/code-run'); ?>

<div>
    <p>
        <?= __t('gradient_descent.sample2.intro'); ?>
    </p>

    <p>
        <?= __t('gradient_descent.sample2.goal'); ?>
    </p>

    <p>
        <?= __t('gradient_descent.sample1.data_label'); ?>
        <br>
        <code>
            x = [1, 2, 3, 4]<br>
            y = [2, 4, 6, 8]
        </code>
    </p>

    <p>
        <?= __t('gradient_descent.sample1.model_label'); ?>
        <br>
        $$\hat{y} = w \cdot x$$
    </p>

    <p>
        <?= __t('gradient_descent.sample2.compare_label'); ?>
        <br>
        <code>
            lr = 0.01<br>
            lr = 0.1<br>
            lr = 1.0
        </code>
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/code.php', opened: true); ?>
</div>

<br><br>
