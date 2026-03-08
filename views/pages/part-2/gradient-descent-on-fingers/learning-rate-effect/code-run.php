<?php

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
    <h1 class="h2"><?= __t('gradient_descent.heading'); ?></h1>
</div>

<?= create_show_code_button(__t('gradient_descent.sample2_title'), 'part-2/gradient-descent-on-fingers/sample-2/learning-rate-effect'); ?>

<div>
    <p>
        <?= __t('gradient_descent.sample2.run_intro'); ?>
    </p>
</div>

<?= create_example_of_use_block(dirname(__FILE__) . '/code-usage.php'); ?>

<div class="row">
    <div class="col-md-12 col-lg-7 mb">
        <div class="card card-body mt-2 mt-lg-0 mb-3 ">
            <p class="mb-2"><b>0.01</b> – <?= __t('gradient_descent.sample2.lr_slow'); ?></p>
            <p class="mb-2"><b>0.1</b> – <?= __t('gradient_descent.sample2.lr_good'); ?></p>
            <p class="mb-0"><b>1.0</b> – <?= __t('gradient_descent.sample2.lr_diverge'); ?></p>
        </div>

        <div class="card card-body">
            <div>
                <canvas id="gd-lr-chart" height="140"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-lg-5">
        <div class="mb-3 col-md-3">
            <label class="form-label" for="gd-lr-select"><b>Learning rate</b></label>
            <select class="form-select" id="gd-lr-select">
                <option value="0.01">0.01</option>
                <option value="0.1" selected>0.1</option>
                <option value="1.0">1.0</option>
            </select>
        </div>
        <hr>

        <?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
    </div>
</div>

<style>
    [data-theme="dark"] .card.card-body {
        background-color: #1c1c1c;
        color: #ccc;
        border-color: #343434;
    }

    [data-theme="dark"] #gd-lr-chart {
        background-color: #232323;
        border-radius: 10px;
    }
</style>

<script>
    (function () {
        const trajectories = <?= json_encode($trajectories, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
        const learningRateMeta = {
            '0.01': {
                label: 'learning rate = 0.01',
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13,110,253,0.1)'
            },
            '0.1': {
                label: 'learning rate = 0.1',
                borderColor: '#198754',
                backgroundColor: 'rgba(25,135,84,0.1)'
            },
            '1.0': {
                label: 'learning rate = 1.0',
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220,53,69,0.1)'
            }
        };

        if (typeof Chart === 'undefined') {
            return;
        }

        function isDarkMode() {
            return document.body.getAttribute('data-theme') === 'dark'
                || document.documentElement.getAttribute('data-theme') === 'dark';
        }

        function chartColors() {
            return isDarkMode()
                ? {
                    text: '#cccccc',
                    grid: 'rgba(169, 169, 169, 0.18)'
                }
                : {
                    text: '#212529',
                    grid: 'rgba(0, 0, 0, 0.1)'
                };
        }

        function buildDataset(learningRate) {
            const trajectory = trajectories[learningRate] || [];
            const meta = learningRateMeta[learningRate] || learningRateMeta['0.1'];

            return {
                labels: trajectory.map(item => item.epoch),
                dataset: {
                    label: meta.label,
                    data: trajectory.map(item => item.w),
                    borderColor: meta.borderColor,
                    backgroundColor: meta.backgroundColor,
                    tension: 0.2
                }
            };
        }

        const select = document.getElementById('gd-lr-select');
        const initialLearningRate = select ? select.value : '0.1';
        const initialDataset = buildDataset(initialLearningRate);
        const colors = chartColors();
        const ctx = document.getElementById('gd-lr-chart');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: initialDataset.labels,
                datasets: [initialDataset.dataset]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: { color: colors.text }
                    }
                },
                scales: {
                    x: {
                        title: { display: true, text: '<?= __t('gradient_descent.sample1.ui.epoch') ?>', color: colors.text },
                        ticks: { color: colors.text },
                        grid: { color: colors.grid }
                    },
                    y: {
                        title: { display: true, text: 'w', color: colors.text },
                        ticks: { color: colors.text },
                        grid: { color: colors.grid }
                    }
                }
            }
        });

        const updateChart = (learningRate) => {
            const nextDataset = buildDataset(learningRate);
            chart.data.labels = nextDataset.labels;
            chart.data.datasets = [nextDataset.dataset];
            chart.update();
        };

        const applyChartTheme = () => {
            const nextColors = chartColors();
            chart.options.plugins.legend.labels.color = nextColors.text;
            chart.options.scales.x.title.color = nextColors.text;
            chart.options.scales.x.ticks.color = nextColors.text;
            chart.options.scales.x.grid.color = nextColors.grid;
            chart.options.scales.y.title.color = nextColors.text;
            chart.options.scales.y.ticks.color = nextColors.text;
            chart.options.scales.y.grid.color = nextColors.grid;
            chart.update('none');
        };

        if (select) {
            select.addEventListener('change', function (event) {
                updateChart(event.target.value);
            });
        }

        const themeObserver = new MutationObserver(function () {
            applyChartTheme();
        });

        themeObserver.observe(document.body, {
            attributes: true,
            attributeFilter: ['data-theme']
        });
    })();
</script>

<br><br>
