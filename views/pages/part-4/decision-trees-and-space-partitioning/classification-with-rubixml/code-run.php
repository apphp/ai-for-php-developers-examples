<?php

use app\classes\RubixTreeDiagram;
use app\classes\Chart;

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);

ob_start();

include __DIR__ . '/code-usage.php';

$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('decision_trees_space_partitioning.index.case2'); ?></h1>
</div>

<?= create_show_code_button(__t('linear_regression.case1.rubix_impl_title'), 'part-4/decision-trees-and-space-partitioning/case-2/classification-with-rubixml'); ?>

<div>
    <p>
        <?= __t('decision_trees_space_partitioning.case2.rubix_run_intro'); ?>
    </p>
</div>

<?= create_example_of_use_block(__DIR__ . '/code-usage.php'); ?>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-4">
            <p><b><?= __t('decision_trees_space_partitioning.case1.diagram_graph_label'); ?>:</b></p>

            <?php

            // Expose a Mermaid flowchart (best-effort) for the trained RubixML tree.
            // The template (code-run.php) will render it via Chart::drawTreeDiagram().
            $diagram = RubixTreeDiagram::build(
                estimator: $estimator,
                sample: $sample,
                featureNames: [
                    0 => 'visits',
                    1 => 'time',
                ]
            );

            $graph = $diagram['graph'];
            $style = $diagram['style'];
            $decisionPathSteps = $diagram['decisionPathSteps'];

            echo Chart::drawTreeDiagram(
                    graph: $graph,
                    defaultMessage: __t('decision_trees_space_partitioning.case1.diagram_default'),
                    style: $style ?? '',
                    containerClass: 'px-4 mb-4'
                );
            ?>
        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
        </div>
    </div>
</div>

<div class="mt-3">
    <p>
        <?= __t('decision_trees_space_partitioning.case2.rubix_result_explanation'); ?>
    </p>
</div>

<br><br>
