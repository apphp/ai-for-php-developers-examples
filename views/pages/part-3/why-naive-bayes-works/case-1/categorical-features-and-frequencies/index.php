<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Почему наивный Байес работает</h1>
</div>

<h4>Кейс 1. Категориальные признаки и частоты</h4>
<br>

<?= create_run_code_button(__t('common.implementation_in_pure_php'), 'part-3/why-naive-bayes-works/case-1/categorical-features-and-frequencies/code-run'); ?>

<div>
    <p>
        В этом кейсе мы посмотрим на самый простой наивный Байес с категориальными признаками.
        Мы явно посчитаем частоты по классам, превратим их в вероятности и классифицируем нового пользователя.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/code.php', opened: false, copyButtonId: 1, expandButtonId: 1); ?>
</div>

<hr>

<?= create_run_code_button(__t('linear_regression.case1.rubix_impl_title'), 'part-3/why-naive-bayes-works/case-1/categorical-features-and-frequencies/rubix-code-run'); ?>

<div>
    <p>
        Затем реализуем тот же самый пример через RubixML и увидим, как та же логика выражается на уровне библиотеки.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/rubix-code.php', opened: false, copyButtonId: 2, expandButtonId: 2); ?>
</div>
<br><br>

