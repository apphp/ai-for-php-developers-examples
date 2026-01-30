<?php

use app\classes\Chart;

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('decision_trees_space_partitioning.index.case1'); ?></h1>
</div>

<?= create_show_code_button(__t('common.implementation_in_pure_php'), 'part-4/decision-trees-and-space-partitioning/case-1/tutorial-decision-tree'); ?>

<div>
    <p>
        <?= __t('decision_trees_space_partitioning.case1.intro'); ?>
    </p>
</div>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-4">
            <p><b><?= __t('decision_trees_space_partitioning.case1.diagram_graph_label'); ?>:</b></p>

            <?php
                $allData = __t('decision_trees_space_partitioning.case1.diagram_all_data');
                $leftBranch = __t('decision_trees_space_partitioning.case1.diagram_left_branch');
                $rightBranch = __t('decision_trees_space_partitioning.case1.diagram_right_branch');
                $yes = __t('decision_trees_space_partitioning.case1.diagram_yes');
                $no = __t('decision_trees_space_partitioning.case1.diagram_no');
                $classLabel = __t('decision_trees_space_partitioning.case1.diagram_class_label');

                $graph = '
                    flowchart TD
                        A[' . $allData . '] --> B{visits ≤ 5?}

                        B -->|' . $yes . '| C["' . $leftBranch . '<br/>Entropy = 0<br/><br/>[1,2, passive]<br/>[2,3, passive]<br/>[3,4, passive]<br/><br/>' . $classLabel . ': passive"]
                        B -->|' . $no . '| D["' . $rightBranch . '<br/>Entropy = 0<br/><br/>[5,10, active]<br/>[7,15, active]<br/>[6,8, active]<br/><br/>' . $classLabel . ': active"]

                        A:::root
                        C:::leaf
                        D:::leaf
                    ';

                $style = '
                    classDef root fill:#e3f2fd,stroke:#1565c0,stroke-width:2px;
                    classDef leaf fill:#e8f5e9,stroke:#2e7d32,stroke-width:2px;
                ';

                echo Chart::drawTreeDiagram(
                    graph: $graph,
                    defaultMessage: __t('decision_trees_space_partitioning.case1.diagram_default'),
                    style: $style,
                    containerClass: 'px-4'
                );
            ?>

        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
        </div>
    </div>
</div>

<br><br>
