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

<?= create_example_of_use_block(dirname(__FILE__) . '/code-usage.php'); ?>

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
                        <button id="gd-play" type="button" class="btn btn-sm btn-outline-primary me-2"><?= __t('gradient_descent.sample1.ui.play'); ?></button>
                        <button id="gd-pause" type="button" class="btn btn-sm btn-outline-secondary"><?= __t('gradient_descent.sample1.ui.pause'); ?></button>
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
                            <option value="120">0.12s</option>
                            <option value="250" selected>0.25s</option>
                            <option value="500">0.5s</option>
                            <option value="1000">1s</option>
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
            <?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
        </div>
    </div>
</div>

<script>
    (function () {
        const trajectory = <?= json_encode($trajectory, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
        const epochCount = trajectory.length;
        const epochInput = document.getElementById('gd-epoch');
        const epochLabel = document.getElementById('gd-epoch-label');
        const wLabel = document.getElementById('gd-w');
        const lossLabel = document.getElementById('gd-loss');
        const playBtn = document.getElementById('gd-play');
        const pauseBtn = document.getElementById('gd-pause');
        const speedSelect = document.getElementById('gd-speed');

        if (!epochCount || typeof Chart === 'undefined') {
            return;
        }

        const labels = trajectory.map(t => t.epoch);
        const wData = trajectory.map(t => t.w);
        const lossData = trajectory.map(t => t.loss);

        const ctx = document.getElementById('gd-chart');
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
                        label: 'loss',
                        data: lossData,
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220,53,69,0.1)',
                        tension: 0.2,
                        pointRadius: 0,
                        yAxisID: 'yLoss'
                    },
                    {
                        label: 'current',
                        data: [{ x: labels[0], y: wData[0] }],
                        borderColor: '#0d6efd',
                        backgroundColor: '#0d6efd',
                        pointRadius: 5,
                        showLine: false,
                        yAxisID: 'yW'
                    },
                    {
                        label: 'current-loss',
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
                    legend: { display: true }
                },
                scales: {
                    yW: { type: 'linear', position: 'left', title: { display: true, text: 'w' } },
                    yLoss: { type: 'linear', position: 'right', grid: { drawOnChartArea: false }, title: { display: true, text: 'loss' } },
                    x: { title: { display: true, text: 'epoch' } }
                }
            }
        });

        let timer = null;

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

        const play = () => {
            if (timer) {
                return;
            }

            timer = setInterval(() => {
                const next = Number(epochInput.value) + 1;
                if (next > epochCount) {
                    clearInterval(timer);
                    timer = null;
                    return;
                }
                setStep(next);
            }, Number(speedSelect.value));
        };

        const pause = () => {
            if (timer) {
                clearInterval(timer);
                timer = null;
            }
        };

        epochInput.addEventListener('input', () => {
            pause();
            setStep(Number(epochInput.value));
        });

        playBtn.addEventListener('click', () => {
            play();
        });

        pauseBtn.addEventListener('click', () => {
            pause();
        });

        speedSelect.addEventListener('change', () => {
            if (timer) {
                pause();
                play();
            }
        });

        setStep(1);
    })();
</script>

<br><br>
