<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);

// Handle parameters
// ----------------------------------
$gradientDebugOptions = [__t('common.show_debug') => '1'];
$gradientDebug = isset($_GET['gradientDebug']) && is_string($_GET['gradientDebug']) ? $_GET['gradientDebug'] : '';
verify_fields($gradientDebug, array_values($gradientDebugOptions), '');

$learningRateOptions = ['0.01' => '0.01', '0.001' => '0.001', '0.0001' => '0.0001', '0.00001' => '0.00001', '0.000001' => '0.000001'];
$learningRateValue = isset($_GET['learningRate']) && is_string($_GET['learningRate']) ? $_GET['learningRate'] : '0.0001';
verify_fields($learningRateValue, array_values($learningRateOptions), reset($learningRateOptions));

$epochsOptions = [100 => 100, 1000 => 1000, 5000 => 5000, 10000 => 10000, 20000 => 20000];
$epochsValue = isset($_GET['epochs']) && is_string($_GET['epochs']) ? $_GET['epochs'] : 5000;
verify_fields($epochsValue, array_values($epochsOptions), reset($epochsOptions));

$debugResult = '--';
$w = 0;
$b = 0;
// ----------------------------------

ob_start();
//////////////////////////////

include('vectors-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('gradient_descent.heading'); ?></h1>
</div>

<h4><?= __t('gradient_descent.implementation'); ?></h4>
<br>

<?= create_show_code_button(__t('gradient_descent.impl_php_vector_version'), 'part-2/gradient-descent-on-fingers/implementation'); ?>

<div>
    <p>
        <?= __t('gradient_descent.more_features_vectors_hint'); ?>
    </p>
</div>

<?= create_example_of_use_block(dirname(__FILE__) . '/vectors-code-usage.php'); ?>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-6 pe-5">
            <?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>

            <p>
                <?= __t('gradient_descent.result_hint'); ?>
                $y = <?= (stripos((string)$w[0], 'e') !== false) ? $w[0] : number_format((float)$w[0], 3, '.', '') ?>x
                + <?= (stripos((string)$w[1], 'e') !== false) ? $w[1] : number_format((float)$w[1], 3, '.', '') ?>$
            </p>
        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <div>
                <div>
                    <b><?= __t('gradient_descent.debug_title'); ?>:</b>
                </div>
                <form class="mt-2" action="<?= APP_URL ?>part-2/gradient-descent-on-fingers/implementation/vectors-code-run" type="GET">
                    <?= create_form_features($gradientDebugOptions, [$gradientDebug], fieldName: 'gradientDebug', type: 'single-checkbox', class: 'mb-2'); ?>
                    <br>
                    <div>
                        <b><?= __t('gradient_descent.learning_rate') ?>:</b>
                    </div>
                    <?= create_form_features($learningRateOptions, [$learningRateValue], fieldName: 'learningRate', type: 'select', class: 'w-50 me-4'); ?>
                    <br><br>
                    <div>
                        <b><?= __t('gradient_descent.epochs') ?>:</b>
                    </div>
                    <?= create_form_features($epochsOptions, [$epochsValue], fieldName: 'epochs', type: 'select', class: 'w-50 me-4'); ?>

                    <div class="form-check form-check-inline float-end p-0 m-0 me-1">
                        <button type="submit" class="btn btn-sm btn-outline-primary"><?= __t('common.regenerate'); ?></button>
                    </div>
                    <div class=" clearfix "></div>
                </form>
            </div>
            <hr>

            <?php if ($gradientDebug): ?>
                <div class="mb-1">
                    <b><?=__t('common.debug_traceback')?>:</b>
                </div>
                <code class="code-result" id="expandable-div">
                    <!-- Expand button -->
                    <?php if ($debugResult !== '--'): ?>
                        <div class="bd-fullscreen cursor-pointer">
                            <i id="expandable-div-icon" class="fas fa-expand fa-inverse" title="<?= __t('common.open_in_full_screen'); ?>"></i>
                        </div>
                    <?php endif; ?>
                    <pre class="pre-wrap"><?= $debugResult; ?></pre>
                </code>
            <?php endif; ?>
        </div>
    </div>
</div>
