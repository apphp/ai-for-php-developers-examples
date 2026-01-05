<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('linear_regression.heading'); ?></h1>
</div>

<?= create_run_code_button(__t('linear_regression.case1_title') . ' (PHP)', 'part-2/linear-regression-as-basic-model/case-1/apartment-valuation-based-on-parameters/code-run'); ?>

<div>
    <h5>Реализация на чистом PHP</h5>

    <p>
        Начнём с варианта без библиотек. Это полезно не для продакшена, а для понимания.
        Мы будем использовать градиентный спуск, матрицу признаков $X$ размером $N$ x $4$ и вектор весов $w$ длины $4$.
        Bias добавим как дополнительный признак со значением 1.
    </p>

</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/code.php', opened: !true); ?>
</div>
