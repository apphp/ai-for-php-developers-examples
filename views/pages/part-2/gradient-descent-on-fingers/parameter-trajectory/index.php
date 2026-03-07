<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('gradient_descent.sample1_title'); ?></h1>
</div>

<?= create_run_code_button(__t('gradient_descent.sample1_title'), 'part-2/gradient-descent-on-fingers/sample-1/parameter-trajectory/code-run'); ?>

<div>
    <p>
        <?= __t('gradient_descent.minimal_example_intro'); ?>
    </p>

    <p>
        <?= __t('gradient_descent.sample1.goal'); ?>
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
        <?= __t('gradient_descent.sample1.update_label'); ?>
        <br>
        $$w = w - \eta \cdot \frac{dL}{dw}$$
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/code.php', opened: true); ?>
</div>

<br><br>
