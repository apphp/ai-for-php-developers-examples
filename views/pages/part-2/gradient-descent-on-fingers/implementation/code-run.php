<?php

use app\classes\Chart;

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);

// Handle parameters
$gradientDebugOptions = [__t('common.show_debug') => '1'];
$gradientDebug = isset($_GET['gradientDebug']) && is_string($_GET['gradientDebug']) ? $_GET['gradientDebug'] : '';
verify_fields($gradientDebug, array_values($gradientDebugOptions), '');


ob_start();
//////////////////////////////

include('code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?php echo __t('gradient_descent.heading'); ?></h1>
</div>

<h4><?php echo __t('gradient_descent.implementation'); ?></h4>
<br>

<?= create_show_code_button(__t('common.implementation_in_pure_php'), 'part-2/gradient-descent-on-fingers/implementation'); ?>

<div>
    <p>
        <?php echo __t('gradient_descent.minimal_example_intro'); ?>
    </p>
</div>

<?= create_example_of_use_block(dirname(__FILE__) . '/code.php'); ?>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-6 pe-5">
            <?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>

            <p>
                <?php echo __t('gradient_descent.result_hint'); ?>
            </p>
        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <div>
                <div>
                    <b><?php echo __t('gradient_descent.debug_title'); ?>:</b>
                </div>
                <form class="mt-2" action="<?= APP_URL ?>part-2/gradient-descent-on-fingers/implementation/code-run" type="GET">
                    <?= create_form_features($gradientDebugOptions, [$gradientDebug], fieldName: 'gradientDebug', type: 'single-checkbox', class: 'ms-3'); ?>
                    <div class="form-check form-check-inline float-end p-0 m-0 me-1">
                        <button type="submit" class="btn btn-sm btn-outline-primary"><?= __t('common.regenerate'); ?></button>
                    </div>
                    <div class=" clearfix "></div>
                </form>
            </div>
            <hr>

            <?php if($gradientDebug): ?>
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
