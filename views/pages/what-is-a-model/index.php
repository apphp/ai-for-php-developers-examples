<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">What is a model in the mathematical sense</h1>
</div>

<?= create_run_code_button('Function as the basis of the model', '/part-1/what-is-a-model/code-run'); ?>

<div>
    <p>
        Linear model. This is a fully-fledged model. It says, "Price ($ŷ$) is approximately equal to area ($x$) multiplied by some coefficient ($w$), plus some shift ($b$)."
        If you rewrite this in PHP, you get almost trivial code:
        $ŷ = w x + b$
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/code.php', opened: true); ?>
</div>
