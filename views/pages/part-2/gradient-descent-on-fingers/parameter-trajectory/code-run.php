<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);

// Handle parameters
// ----------------------------------
$learningRateOptions = ['0.01' => '0.01', '0.05' => '0.05', '0.1' => '0.1', '0.12' => '0.12', '0.2' => '0.2'];
$learningRateValue = isset($_GET['learningRate']) && is_string($_GET['learningRate']) ? $_GET['learningRate'] : '0.1';
verify_fields($learningRateValue, array_values($learningRateOptions), '0.1');

$epochsOptions = [10 => 10, 20 => 20, 50 => 50, 100 => 100];
$epochsValue = isset($_GET['epochs']) && is_string($_GET['epochs']) ? $_GET['epochs'] : '20';
verify_fields($epochsValue, array_map('strval', array_values($epochsOptions)), '20');

$learningRate = (float)$learningRateValue;
$epochs = (int)$epochsValue;
// ----------------------------------

ob_start();
//////////////////////////////

include('code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

$lines = preg_split('/\R/', trim($result));
$trajectory = [];

foreach ($lines as $lineIndex => $line) {
    if ($lineIndex === 0) {
        continue;
    }

    $line = trim($line);

    if ($line === '') {
        continue;
    }

    $parts = preg_split('/\t+/', $line);

    if (!$parts || count($parts) < 4) {
        continue;
    }

    $trajectory[] = [
        'epoch' => (int)$parts[0],
        'w' => (float)$parts[1],
        'gradient' => (float)$parts[2],
        'loss' => (float)$parts[3],
    ];
}

$epochCount = count($trajectory);

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('gradient_descent.sample1_title'); ?></h1>
</div>

<?= create_show_code_button(__t('gradient_descent.sample1_title'), 'part-2/gradient-descent-on-fingers/sample-1/parameter-trajectory'); ?>

<div>
    <p>
        <?= __t('gradient_descent.sample1.run_intro'); ?>
    </p>
</div>

<?= create_example_of_use_block(dirname(__FILE__) . '/code.php'); ?>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-6 pe-5">
            <div class="card card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <b><?= __t('gradient_descent.sample1.ui.epoch'); ?>:</b>
                        <span id="gd-epoch-label"><?= $epochCount ? (int)$trajectory[0]['epoch'] : 0; ?></span>
                    </div>

                    <div class="d-flex align-items-center">
                        <button id="gd-play" type="button" class="btn btn-sm btn-outline-primary me-2"><?= __t('common.start'); ?></button>
                        <button id="gd-reset" type="button" class="btn btn-sm btn-outline-secondary"><?= __t('common.reset'); ?></button>
                    </div>
                </div>

                <div class="mt-3">
                    <input id="gd-epoch" type="range" class="form-range" min="1" max="<?= max(1, $epochCount); ?>" step="1" value="1" <?= $epochCount ? '' : 'disabled'; ?> />
                </div>

                <div class="d-flex align-items-center justify-content-between">
                    <div class="small text-muted">
                        <span><b>w</b>: <span id="gd-w"><?= $epochCount ? htmlspecialchars((string)$trajectory[0]['w'], ENT_QUOTES, 'UTF-8') : '--'; ?></span></span>
                        <span class="ms-3"><b>loss</b>: <span id="gd-loss"><?= $epochCount ? htmlspecialchars((string)$trajectory[0]['loss'], ENT_QUOTES, 'UTF-8') : '--'; ?></span></span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="small text-muted me-2"><?= __t('gradient_descent.sample1.ui.speed'); ?></span>
                        <select id="gd-speed" class="form-select form-select-sm" style="width: 120px">
                            <option value="120">0.12 <?=__t('sec')?></option>
                            <option value="250" selected>0.25 <?=__t('sec')?></option>
                            <option value="500">0.5 <?=__t('sec')?></option>
                            <option value="1000">1 <?=__t('sec')?></option>
                        </select>
                    </div>
                </div>

                <hr>

                <div>
                    <canvas id="gd-chart" height="140"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-5 p-0 m-0">
            <form class="mt-2" action="<?= APP_URL ?>part-2/gradient-descent-on-fingers/sample-1/parameter-trajectory/code-run" method="GET">
                <div class="row">
                    <div class="col-6">
                        <div>
                            <b><?= __t('gradient_descent.learning_rate') ?>:</b>
                        </div>
                        <?= create_form_features($learningRateOptions, [$learningRateValue], fieldName: 'learningRate', type: 'select', class: 'w-100'); ?>
                    </div>

                    <div class="col-6">
                        <div>
                            <b><?= __t('gradient_descent.epochs') ?>:</b>
                        </div>
                        <?= create_form_features($epochsOptions, [$epochsValue], fieldName: 'epochs', type: 'select', class: 'w-100'); ?>
                    </div>
                </div>
                <br>

                <div class="form-check form-check-inline float-end p-0 m-0 me-1">
                    <button type="submit" class="btn btn-sm btn-outline-primary"><?= __t('common.regenerate'); ?></button>
                </div>
                <div class="clearfix"></div>
            </form>

            <hr>

            <?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
        </div>
    </div>
</div>

<style>
    [data-theme="dark"] .card.card-body {
        background-color: #1c1c1c;
        color: #ccc;
        border-color: #343434;
    }

    [data-theme="dark"] #gd-chart {
        background-color: #232323;
        border-radius: 10px;
    }
</style>

<script>
    (function () {
        const trajectory = <?= json_encode($trajectory, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
        const epochCount = trajectory.length;
        const i18n = {
            play: <?= json_encode(__t('common.start')) ?>,
            pause: <?= json_encode(__t('common.pause')) ?>,
            resume: <?= json_encode(__t('common.resume')) ?>,
            reset: <?= json_encode(__t('common.reset')) ?>,
        };
        const epochInput = document.getElementById('gd-epoch');
        const epochLabel = document.getElementById('gd-epoch-label');
        const wLabel = document.getElementById('gd-w');
        const lossLabel = document.getElementById('gd-loss');
        const playBtn = document.getElementById('gd-play');
        const resetBtn = document.getElementById('gd-reset');
        const speedSelect = document.getElementById('gd-speed');
        const controlsToLock = [
            epochInput,
            speedSelect,
            document.querySelector('select[name="learningRate"]'),
            document.querySelector('select[name="epochs"]')
        ].filter(Boolean);

        if (!epochCount || typeof Chart === 'undefined') {
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
                    grid: 'rgba(169, 169, 169, 0.18)',
                    gridAlt: 'rgba(169, 169, 169, 0.12)'
                }
                : {
                    text: '#212529',
                    grid: 'rgba(0, 0, 0, 0.1)',
                    gridAlt: 'rgba(0, 0, 0, 0.08)'
                };
        }

        const labels = trajectory.map(t => t.epoch);
        const wData = trajectory.map(t => t.w);
        const lossData = trajectory.map(t => t.loss);

        const ctx = document.getElementById('gd-chart');
        const initialChartColors = chartColors();
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [
                    {
                        label: 'w',
                        data: wData,
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13,110,253,0.1)',
                        tension: 0.2,
                        pointRadius: 0,
                        yAxisID: 'yW'
                    },
                    {
                        label: '<?= __t('gradient_descent.sample1.ui.loss') ?>',
                        data: lossData,
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220,53,69,0.1)',
                        tension: 0.2,
                        pointRadius: 0,
                        yAxisID: 'yLoss'
                    },
                    {
                        label: '<?= __t('gradient_descent.sample1.ui.current') ?>',
                        data: [{ x: labels[0], y: wData[0] }],
                        borderColor: '#0d6efd',
                        backgroundColor: '#0d6efd',
                        pointRadius: 5,
                        showLine: false,
                        yAxisID: 'yW'
                    },
                    {
                        label: '<?= __t('gradient_descent.sample1.ui.current-loss') ?>',
                        data: [{ x: labels[0], y: lossData[0] }],
                        borderColor: '#dc3545',
                        backgroundColor: '#dc3545',
                        pointRadius: 5,
                        showLine: false,
                        yAxisID: 'yLoss'
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: {
                        display: true,
                        labels: { color: initialChartColors.text }
                    }
                },
                scales: {
                    yW: {
                        type: 'linear',
                        position: 'left',
                        title: { display: true, text: 'w', color: initialChartColors.text },
                        ticks: { color: initialChartColors.text },
                        grid: { color: initialChartColors.grid }
                    },
                    yLoss: {
                        type: 'linear',
                        position: 'right',
                        grid: { drawOnChartArea: false, color: initialChartColors.gridAlt },
                        title: { display: true, text: 'loss', color: initialChartColors.text },
                        ticks: { color: initialChartColors.text }
                    },
                    x: {
                        title: { display: true, text: '<?= __t('gradient_descent.sample1.ui.epoch') ?>', color: initialChartColors.text },
                        ticks: { color: initialChartColors.text },
                        grid: { color: initialChartColors.grid }
                    }
                }
            }
        });

        const applyChartTheme = () => {
            const colors = chartColors();
            chart.options.plugins.legend.labels.color = colors.text;
            chart.options.scales.yW.title.color = colors.text;
            chart.options.scales.yW.ticks.color = colors.text;
            chart.options.scales.yW.grid.color = colors.grid;
            chart.options.scales.yLoss.title.color = colors.text;
            chart.options.scales.yLoss.ticks.color = colors.text;
            chart.options.scales.yLoss.grid.color = colors.gridAlt;
            chart.options.scales.x.title.color = colors.text;
            chart.options.scales.x.ticks.color = colors.text;
            chart.options.scales.x.grid.color = colors.grid;
            chart.update('none');
        };

        let timer = null;
        let hasStartedOnce = false;

        const setControlsLocked = (locked) => {
            controlsToLock.forEach((control) => {
                control.disabled = locked;
            });
        };

        const setStep = (step1Based) => {
            const idx = Math.min(Math.max(step1Based - 1, 0), epochCount - 1);
            const t = trajectory[idx];

            epochInput.value = String(idx + 1);
            epochLabel.textContent = String(t.epoch);
            wLabel.textContent = String(t.w);
            lossLabel.textContent = String(t.loss);

            chart.data.datasets[2].data = [{ x: t.epoch, y: t.w }];
            chart.data.datasets[3].data = [{ x: t.epoch, y: t.loss }];
            chart.update('none');
        };

        const updatePlayButton = () => {
            if (timer) {
                playBtn.textContent = i18n.pause;
                return;
            }

            if (hasStartedOnce && Number(epochInput.value) > 1) {
                playBtn.textContent = i18n.resume;
                return;
            }

            playBtn.textContent = i18n.play;
        };

        const play = () => {
            if (timer) {
                return;
            }

            if (Number(epochInput.value) >= epochCount) {
                setStep(1);
            }

            hasStartedOnce = true;
            setControlsLocked(true);
            updatePlayButton();

            timer = setInterval(() => {
                const next = Number(epochInput.value) + 1;
                if (next > epochCount) {
                    clearInterval(timer);
                    timer = null;
                    hasStartedOnce = false;
                    setControlsLocked(false);
                    updatePlayButton();
                    return;
                }
                setStep(next);
            }, Number(speedSelect.value));

            updatePlayButton();
        };

        const pause = () => {
            if (timer) {
                clearInterval(timer);
                timer = null;
            }

            setControlsLocked(false);
            updatePlayButton();
        };

        const reset = () => {
            pause();
            hasStartedOnce = false;
            setStep(1);
            updatePlayButton();
        };

        epochInput.addEventListener('input', () => {
            pause();
            hasStartedOnce = Number(epochInput.value) > 1;
            setStep(Number(epochInput.value));
            updatePlayButton();
        });

        playBtn.addEventListener('click', () => {
            if (timer) {
                pause();
                return;
            }

            play();
        });

        resetBtn.addEventListener('click', () => {
            reset();
        });

        speedSelect.addEventListener('change', () => {
            if (timer) {
                pause();
                play();
            }
        });

        setStep(1);
        applyChartTheme();

        const themeObserver = new MutationObserver(function () {
            applyChartTheme();
        });

        themeObserver.observe(document.body, {
            attributes: true,
            attributeFilter: ['data-theme']
        });

        setControlsLocked(false);
        updatePlayButton();
    })();
</script>

<br><br>
