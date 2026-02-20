<?php

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
            $graph = null;
            $style = null;
            $decisionPathSteps = [];

            $featureNames = [
                0 => 'visits',
                1 => 'time',
            ];

            $normalizeFeatureName = static function ($feature) use ($featureNames): string {
                if (is_int($feature)) {
                    return $featureNames[$feature] ?? (string) $feature;
                }

                if (is_float($feature) && is_finite($feature)) {
                    $int = (int) $feature;

                    return $featureNames[$int] ?? (string) $int;
                }

                if (is_string($feature)) {
                    $trim = trim($feature);

                    if ($trim !== '' && ctype_digit($trim)) {
                        $int = (int) $trim;

                        return $featureNames[$int] ?? (string) $int;
                    }

                    $lower = strtolower($trim);
                    if ($lower === 'time' || $lower === 'times') {
                        return 'time';
                    }

                    if ($lower === 'visit' || $lower === 'visits') {
                        return 'visits';
                    }

                    return $trim;
                }

                if (is_object($feature) && method_exists($feature, '__toString')) {
                    return $normalizeFeatureName((string) $feature);
                }

                return get_debug_type($feature);
            };

            $getValue = static function (object $object, array $names) {
                $ref = new ReflectionObject($object);

                foreach ($names as $name) {
                    if ($ref->hasProperty($name)) {
                        $prop = $ref->getProperty($name);
                        $prop->setAccessible(true);

                        return $prop->getValue($object);
                    }

                    if ($ref->hasMethod($name)) {
                        $method = $ref->getMethod($name);
                        if ($method->getNumberOfRequiredParameters() === 0) {
                            $method->setAccessible(true);

                            return $method->invoke($object);
                        }
                    }

                    $getter = 'get' . ucfirst($name);
                    if ($ref->hasMethod($getter)) {
                        $method = $ref->getMethod($getter);
                        if ($method->getNumberOfRequiredParameters() === 0) {
                            $method->setAccessible(true);

                            return $method->invoke($object);
                        }
                    }
                }

                return null;
            };

            $stringify = static function ($value): string {
                if (is_scalar($value) || $value === null) {
                    return (string) $value;
                }

                if (is_array($value)) {
                    return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                }

                if (is_object($value) && method_exists($value, '__toString')) {
                    return (string) $value;
                }

                return get_debug_type($value);
            };

            $buildMermaid = null;
            $buildMermaid = static function (object $node, array &$lines, int &$counter, array &$nodeIdMap) use (&$buildMermaid, $getValue, $stringify, $normalizeFeatureName): string {
                $counter++;
                $id = 'N' . $counter;

                $nodeIdMap[spl_object_id($node)] = $id;

                $left = $getValue($node, ['left', 'l', 'true', 't']);
                $right = $getValue($node, ['right', 'r', 'false', 'f']);

                $isSplit = is_object($left) && is_object($right);

                if ($isSplit) {
                    $feature = $getValue($node, ['feature', 'column', 'featureIndex', 'index']);
                    $value = $getValue($node, ['value', 'threshold', 'split', 'cutoff', 'splitValue']);

                    $featureStr = $normalizeFeatureName($feature);
                    $valueStr = $stringify($value);

                    $lines[] = $id . '{' . $featureStr . ' ≤ ' . round($valueStr, 2) . '?}';

                    $leftId = $buildMermaid($left, $lines, $counter, $nodeIdMap);
                    $rightId = $buildMermaid($right, $lines, $counter, $nodeIdMap);

                    $lines[] = "$id -->|yes| $leftId";
                    $lines[] = "$id -->|no| $rightId";

                    return $id;
                }

                $prediction = $getValue($node, ['prediction', 'class', 'label', 'value', 'outcome']);
                $predictionStr = $stringify($prediction);
                $lines[] = $id . '["class: ' . $predictionStr . '"]';

                return $id;
            };

            $walkDecisionPath = static function (object $node, array $sample) use ($getValue): array {
                $steps = [];

                while (true) {
                    $left = $getValue($node, ['left', 'l', 'true', 't']);
                    $right = $getValue($node, ['right', 'r', 'false', 'f']);

                    $isSplit = is_object($left) && is_object($right);
                    if (!$isSplit) {
                        $prediction = $getValue($node, ['prediction', 'class', 'label', 'value', 'outcome']);
                        $steps[] = [
                            'type' => 'leaf',
                            'node' => $node,
                            'prediction' => $prediction,
                        ];
                        break;
                    }

                    $feature = $getValue($node, ['feature', 'column', 'featureIndex', 'index']);
                    $value = $getValue($node, ['value', 'threshold', 'split', 'cutoff', 'splitValue']);

                    $featureIndex = is_int($feature) ? $feature : null;
                    $featureValue = ($featureIndex !== null && array_key_exists($featureIndex, $sample)) ? $sample[$featureIndex] : null;

                    $goLeft = ($featureValue !== null && is_numeric($value)) ? ($featureValue <= $value) : null;

                    $steps[] = [
                        'type' => 'split',
                        'node' => $node,
                        'feature' => $feature,
                        'threshold' => $value,
                        'sampleValue' => $featureValue,
                        'branch' => $goLeft === null ? null : ($goLeft ? 'yes' : 'no'),
                    ];

                    if ($goLeft === null) {
                        break;
                    }

                    $node = $goLeft ? $left : $right;
                }

                return $steps;
            };

            try {
                $root = null;

                $root = $getValue($estimator, ['root', 'tree', 'model', 'node', 'head']);

                if (is_object($root)) {
                    $lines = [];
                    $counter = 0;
                    $nodeIdMap = [];

                    $lines[] = 'flowchart TD';
                    $rootId = $buildMermaid($root, $lines, $counter, $nodeIdMap);
                    $lines[] = $rootId . ':::root';

                    $graph = "\n    " . implode("\n    ", $lines) . "\n";

                    $decisionPathSteps = $walkDecisionPath($root, $sample);

                    $pathNodeIds = [];
                    foreach ($decisionPathSteps as $step) {
                        if (!isset($step['node']) || !is_object($step['node'])) {
                            continue;
                        }

                        $oid = spl_object_id($step['node']);
                        if (isset($nodeIdMap[$oid])) {
                            $pathNodeIds[] = $nodeIdMap[$oid];
                        }
                    }

                    foreach ($pathNodeIds as $pathNodeId) {
                        $graph .= "    class $pathNodeId path;\n";
                    }

                    $style = '
                        classDef root fill:#e3f2fd,stroke:#1565c0,stroke-width:2px;
                        classDef path fill:#fff3e0,stroke:#ef6c00,stroke-width:3px;
                    ';
                }
            } catch (Throwable) {
                $graph = null;
                $style = null;
                $decisionPathSteps = [];
            }

            echo Chart::drawTreeDiagram(
                    graph: $graph,
                    defaultMessage: __t('decision_trees_space_partitioning.case1.diagram_default'),
                    style: $style ?? '',
                    containerClass: 'px-4'
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
