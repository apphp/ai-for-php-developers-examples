<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('gradient_descent.heading'); ?></h1>
</div>

<h4><?= __t('gradient_descent.implementation'); ?></h4>
<br>

<?= create_show_code_button(__t('gradient_descent.animation_gd_title'), 'part-2/gradient-descent-on-fingers/implementation', buttonText: __t('gradient_descent.animation.back_to_toc')); ?>
<p><?= __t('gradient_descent.animation_intro'); ?></p>
<br>

<div class="row g-3">
    <div class="col-lg-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold"><?= __t('gradient_descent.animation.ui.parameters'); ?></div>
                        <div class="text-muted small">
                            <span class="gd-only-1d"><?= __t('gradient_descent.animation.ui.objective_1d'); ?></span>
                            <span class="gd-only-2d-objective" style="display:none;"><?= __t('gradient_descent.animation.ui.objective_2d'); ?></span>
                            <span class="gd-only-3dxyz" style="display:none;"><?= __t('gradient_descent.animation.ui.objective_3d'); ?></span>
                            <span class="gd-only-3d-surface" style="display:none;"><?= __t('gradient_descent.animation.ui.objective_3d_surface'); ?></span>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button id="gd-play" class="btn btn-sm btn-outline-primary"><?= __t('common.start'); ?></button>
                        <button id="gd-reset" class="btn btn-sm btn-outline-secondary"><?= __t('common.reset'); ?></button>
                    </div>
                </div>

                <hr>

                <div class="mb-3">
                    <label for="gd-mode" class="form-label"><b><?= __t('gradient_descent.animation.ui.mode'); ?></b></label>
                    <select id="gd-mode" class="form-select form-select-sm w-50">
                        <option value="1d" selected>1D</option>
                        <option value="2d">2D</option>
                        <option value="3d">3D</option>
                        <option value="3d-surface">3D + surface</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="gd-learning-rate" class="form-label"><b><?= __t('gradient_descent.animation.ui.learning_rate'); ?></b>: <span id="gd-learning-rate-value">0.08</span></label>
                    <input type="range" class="form-range" id="gd-learning-rate" min="0.005" max="0.25" step="0.005" value="0.08">
                </div>

                <div class="mb-3">
                    <label for="gd-start-x" class="form-label"><b><?= __t('gradient_descent.animation.ui.start_x'); ?></b>: <span id="gd-start-x-value">6</span></label>
                    <input type="range" class="form-range" id="gd-start-x" min="-10" max="10" step="0.5" value="6">
                </div>

                <div class="mb-3 gd-only-2d" style="display:none;">
                    <label for="gd-start-y" class="form-label"><b><?= __t('gradient_descent.animation.ui.start_y'); ?></b>: <span id="gd-start-y-value">-4</span></label>
                    <input type="range" class="form-range" id="gd-start-y" min="-10" max="10" step="0.5" value="-4">
                </div>

                <div class="mb-3 gd-only-3dxyz" style="display:none;">
                    <label for="gd-start-z" class="form-label"><b><?= __t('gradient_descent.animation.ui.start_z'); ?></b>: <span id="gd-start-z-value">3</span></label>
                    <input type="range" class="form-range" id="gd-start-z" min="-10" max="10" step="0.5" value="3">
                </div>

                <div class="mb-3">
                    <label for="gd-target-a" class="form-label"><b><?= __t('gradient_descent.animation.ui.target_a'); ?></b>: <span id="gd-target-a-value">2</span></label>
                    <input type="range" class="form-range" id="gd-target-a" min="-6" max="6" step="0.5" value="2">
                </div>

                <div class="mb-3 gd-only-2d" style="display:none;">
                    <label for="gd-target-b" class="form-label"><b><?= __t('gradient_descent.animation.ui.target_b'); ?></b>: <span id="gd-target-b-value">1</span></label>
                    <input type="range" class="form-range" id="gd-target-b" min="-6" max="6" step="0.5" value="1">
                </div>

                <div class="mb-3 gd-only-3dxyz" style="display:none;">
                    <label for="gd-target-c" class="form-label"><b><?= __t('gradient_descent.animation.ui.target_c'); ?></b>: <span id="gd-target-c-value">-2</span></label>
                    <input type="range" class="form-range" id="gd-target-c" min="-6" max="6" step="0.5" value="-2">
                </div>

                <div class="mb-3">
                    <label for="gd-steps-per-second" class="form-label"><b><?= __t('gradient_descent.animation.ui.speed'); ?></b>: <span id="gd-steps-per-second-value">30</span></label>
                    <input type="range" class="form-range" id="gd-steps-per-second" min="5" max="120" step="1" value="30">
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="small text-muted"><?= __t('gradient_descent.animation.ui.iteration'); ?></div>
                        <div class="h5 mb-0" id="gd-iter">0</div>
                    </div>
                    <div class="col-6">
                        <div class="small text-muted"><?= __t('gradient_descent.animation.ui.current_x'); ?></div>
                        <div class="h5 mb-0" id="gd-x">6.0000</div>
                    </div>
                    <div class="col-6 mt-3">
                        <div class="small text-muted"><?= __t('gradient_descent.animation.ui.fx'); ?></div>
                        <div class="h5 mb-0" id="gd-fx">16.0000</div>
                    </div>
                    <div class="col-6 mt-3">
                        <div class="small text-muted"><?= __t('gradient_descent.animation.ui.grad_abs'); ?></div>
                        <div class="h5 mb-0" id="gd-grad">8.0000</div>
                    </div>
                    <div class="col-6 gd-only-2d mt-3" style="display:none;">
                        <div class="small text-muted"><?= __t('gradient_descent.animation.ui.current_y'); ?></div>
                        <div class="h5 mb-0" id="gd-y">-4.0000</div>
                    </div>
                    <div class="col-6 gd-only-3dxyz mt-3" style="display:none;">
                        <div class="small text-muted"><?= __t('gradient_descent.animation.ui.current_z'); ?></div>
                        <div class="h5 mb-0" id="gd-z">3.0000</div>
                    </div>
                </div>

                <hr>

                <div class="small text-muted">
                    <?= __t('gradient_descent.animation.ui.update_rule'); ?>
                    <div>$x = x - α · ∇f(x)$</div>
                    <div class="gd-only-1d"><?= __t('gradient_descent.animation.ui.grad_1d'); ?></div>
                    <div class="gd-only-2d-grad" style="display:none;"><?= __t('gradient_descent.animation.ui.grad_2d'); ?></div>
                    <div class="gd-only-3dxyz" style="display:none;"><?= __t('gradient_descent.animation.ui.grad_3d'); ?></div>
                    <div class="gd-only-3d-surface" style="display:none;"><?= __t('gradient_descent.animation.ui.grad_2d'); ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7">

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="fw-bold mb-2"><?= __t('gradient_descent.animation.ui.trajectory'); ?></div>
                <div class="gd-track gd-only-1d" id="gd-track">
                    <div class="gd-axis"></div>
                    <div class="gd-min" id="gd-min"></div>
                    <div class="gd-dot" id="gd-dot"></div>
                </div>
                <div class="gd-plane gd-only-2d" id="gd-plane" style="display:none;">
                    <div class="gd-plane-grid"></div>
                    <div class="gd-plane-target" id="gd-target"></div>
                    <div class="gd-plane-dot" id="gd-dot-2d"></div>
                </div>
                <div id="gd-plot-3d" class="gd-only-3d" style="display:none; height: 360px;"></div>
                <div class="text-muted small mt-2 gd-only-1d"><?= __t('gradient_descent.animation.ui.trajectory_hint_1d'); ?></div>
                <div class="text-muted small mt-2 gd-only-2d" style="display:none;"><?= __t('gradient_descent.animation.ui.trajectory_hint_2d'); ?></div>
                <div class="text-muted small mt-2 gd-only-3dxyz" style="display:none;"><?= __t('gradient_descent.animation.ui.trajectory_hint_3d'); ?></div>
                <div class="text-muted small mt-2 gd-only-3d-surface" style="display:none;"><?= __t('gradient_descent.animation.ui.trajectory_hint_3d_surface'); ?></div>
            </div>
        </div>

        <div class="card shadow-sm mt-3">
            <div class="card-body">
                <div class="fw-bold mb-2"><?= __t('gradient_descent.animation.ui.loss_chart'); ?></div>
                <div class="ratio ratio-16x9">
                    <canvas id="gd-loss-chart"></canvas>
                </div>
                <div class="text-muted small mt-2">
                    <?= __t('gradient_descent.animation.ui.loss_chart_hint'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .gd-track {
        position: relative;
        width: 100%;
        height: 64px;
        border-radius: 10px;
        border: 1px solid rgba(127, 127, 127, 0.35);
        background: linear-gradient(90deg, rgba(13,110,253,.08), rgba(25,135,84,.08));
        overflow: hidden;
    }

    .gd-axis {
        position: absolute;
        left: 0;
        right: 0;
        top: 50%;
        height: 2px;
        transform: translateY(-50%);
        background: rgba(127, 127, 127, 0.35);
    }

    .gd-dot {
        position: absolute;
        top: 50%;
        width: 14px;
        height: 14px;
        border-radius: 999px;
        transform: translate(-50%, -50%);
        background: #0d6efd;
        box-shadow: 0 6px 18px rgba(13,110,253,.25);
    }

    .gd-min {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 2px;
        transform: translateX(-50%);
        background: rgba(25,135,84,.9);
    }

    .gd-plane {
        position: relative;
        width: 100%;
        height: 280px;
        border-radius: 10px;
        border: 1px solid rgba(127, 127, 127, 0.35);
        background: rgba(13,110,253,.04);
        overflow: hidden;
    }

    .gd-plane-grid {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(127,127,127,.18) 1px, transparent 1px),
            linear-gradient(90deg, rgba(127,127,127,.18) 1px, transparent 1px);
        background-size: 28px 28px;
        opacity: 0.6;
    }

    .gd-plane-dot,
    .gd-plane-target {
        position: absolute;
        width: 14px;
        height: 14px;
        border-radius: 999px;
        transform: translate(-50%, -50%);
    }

    .gd-plane-dot {
        background: #0d6efd;
        box-shadow: 0 6px 18px rgba(13,110,253,.25);
    }

    .gd-plane-target {
        background: rgba(25,135,84,.95);
        box-shadow: 0 6px 18px rgba(25,135,84,.18);
    }

    [data-theme="dark"] .card.shadow-sm,
    [data-theme="dark"] .card.shadow-sm .card-body {
        background-color: #1c1c1c;
        color: #ccc;
    }

    [data-theme="dark"] .card.shadow-sm {
        border-color: #343434;
    }

    [data-theme="dark"] .gd-track {
        border-color: rgba(169, 169, 169, 0.2);
        background: linear-gradient(90deg, rgba(13,110,253,.12), rgba(25,135,84,.12));
    }

    [data-theme="dark"] .gd-plane {
        border-color: rgba(169, 169, 169, 0.2);
        background: #232323;
    }

    [data-theme="dark"] .gd-plane-grid {
        background-image:
            linear-gradient(rgba(169,169,169,.12) 1px, transparent 1px),
            linear-gradient(90deg, rgba(169,169,169,.12) 1px, transparent 1px);
    }

    [data-theme="dark"] .ratio.ratio-16x9 {
        background-color: #232323;
        border-radius: 10px;
        padding: 8px;
    }

    [data-theme="dark"] #gd-plot-3d {
        background-color: #232323;
        border-radius: 10px;
    }
</style>

<script>
    (function () {
        const i18n = {
            start: <?= json_encode(__t('common.start')) ?>,
            pause: <?= json_encode(__t('common.pause')) ?>,
            reset: <?= json_encode(__t('common.reset')) ?>,
            resume: <?= json_encode(__t('common.resume')); ?>,
            chart_iteration: <?= json_encode(__t('gradient_descent.animation.ui.chart_iteration')) ?>,
            chart_fx: <?= json_encode(__t('gradient_descent.animation.ui.chart_fx')) ?>,
            chart_series_fx: <?= json_encode(__t('gradient_descent.animation.ui.chart_series_fx')) ?>,
        };

        const $ = (id) => document.getElementById(id);

        const playBtn = $("gd-play");
        const resetBtn = $("gd-reset");

        const modeSelect = $("gd-mode");

        const lrInput = $("gd-learning-rate");
        const startXInput = $("gd-start-x");
        const startYInput = $("gd-start-y");
        const startZInput = $("gd-start-z");
        const targetAInput = $("gd-target-a");
        const targetBInput = $("gd-target-b");
        const targetCInput = $("gd-target-c");
        const spsInput = $("gd-steps-per-second");

        const lrValue = $("gd-learning-rate-value");
        const startXValue = $("gd-start-x-value");
        const startYValue = $("gd-start-y-value");
        const startZValue = $("gd-start-z-value");
        const targetAValue = $("gd-target-a-value");
        const targetBValue = $("gd-target-b-value");
        const targetCValue = $("gd-target-c-value");
        const spsValue = $("gd-steps-per-second-value");

        const iterEl = $("gd-iter");
        const xEl = $("gd-x");
        const yEl = $("gd-y");
        const zEl = $("gd-z");
        const fxEl = $("gd-fx");
        const gradEl = $("gd-grad");

        const dotEl = $("gd-dot");
        const minEl = $("gd-min");
        const planeEl = $("gd-plane");
        const targetEl2d = $("gd-target");
        const dotEl2d = $("gd-dot-2d");
        const plot3dEl = $("gd-plot-3d");

        let running = false;
        let sessionLocked = false;
        let timerId = null;

        let hasStartedOnce = false;

        let iter = 0;
        let x = parseFloat(startXInput.value);
        let y = parseFloat(startYInput.value);
        let z = parseFloat(startZInput.value);

        let pathX = [];
        let pathY = [];
        let pathZ = [];

        let plot3dReady = false;

        function mode() {
            if (modeSelect.value === '3d') {
                return '3d';
            }
            if (modeSelect.value === '3d-surface') {
                return '3d-surface';
            }
            return modeSelect.value === '2d' ? '2d' : '1d';
        }

        function is3dAny() {
            return mode() === '3d' || mode() === '3d-surface';
        }

        function f1d(x, a) {
            const d = x - a;
            return d * d;
        }

        function g1d(x, a) {
            return 2 * (x - a);
        }

        function f2d(x, y, a, b) {
            const dx = x - a;
            const dy = y - b;
            return dx * dx + dy * dy;
        }

        function f3d(x, y, z, a, b, c) {
            const dx = x - a;
            const dy = y - b;
            const dz = z - c;
            return dx * dx + dy * dy + dz * dz;
        }

        function g2d(x, y, a, b) {
            return {
                gx: 2 * (x - a),
                gy: 2 * (y - b)
            };
        }

        function g3d(x, y, z, a, b, c) {
            return {
                gx: 2 * (x - a),
                gy: 2 * (y - b),
                gz: 2 * (z - c)
            };
        }

        function clamp(v, min, max) {
            return Math.max(min, Math.min(max, v));
        }

        function toTrackX(value) {
            const min = -10;
            const max = 10;
            const t = (value - min) / (max - min);
            return clamp(t, 0, 1) * 100;
        }

        function toPlaneX(value) {
            return toTrackX(value);
        }

        function toPlaneY(value) {
            const min = -10;
            const max = 10;
            const t = (value - min) / (max - min);
            const p = clamp(t, 0, 1) * 100;
            return 100 - p;
        }

        function setText(el, value) {
            el.textContent = value;
        }

        function syncLabels() {
            lrValue.textContent = parseFloat(lrInput.value).toFixed(3);
            startXValue.textContent = parseFloat(startXInput.value).toFixed(1);
            startYValue.textContent = parseFloat(startYInput.value).toFixed(1);
            startZValue.textContent = parseFloat(startZInput.value).toFixed(1);
            targetAValue.textContent = parseFloat(targetAInput.value).toFixed(1);
            targetBValue.textContent = parseFloat(targetBInput.value).toFixed(1);
            targetCValue.textContent = parseFloat(targetCInput.value).toFixed(1);
            spsValue.textContent = String(parseInt(spsInput.value, 10));
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
                    background: '#232323'
                }
                : {
                    text: '#212529',
                    grid: 'rgba(0, 0, 0, 0.1)',
                    background: '#ffffff'
                };
        }

        const ctx = $("gd-loss-chart").getContext("2d");
        const initialChartColors = chartColors();

        const lossChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: [],
                datasets: [{
                    label: i18n.chart_series_fx,
                    data: [],
                    borderColor: "rgba(13,110,253,1)",
                    backgroundColor: "rgba(13,110,253,0.12)",
                    tension: 0.2,
                    pointRadius: 0,
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                animation: false,
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                        labels: { color: initialChartColors.text }
                    },
                    tooltip: { enabled: true }
                },
                scales: {
                    x: {
                        title: { display: true, text: i18n.chart_iteration },
                        ticks: { maxTicksLimit: 8, color: initialChartColors.text },
                        title: { display: true, text: i18n.chart_iteration, color: initialChartColors.text },
                        grid: { color: initialChartColors.grid }
                    },
                    y: {
                        title: { display: true, text: i18n.chart_fx, color: initialChartColors.text },
                        ticks: { color: initialChartColors.text },
                        grid: { color: initialChartColors.grid },
                        beginAtZero: true
                    }
                }
            }
        });

        function applyChartTheme() {
            const colors = chartColors();
            lossChart.options.scales.x.ticks.color = colors.text;
            lossChart.options.scales.x.title.color = colors.text;
            lossChart.options.scales.x.grid.color = colors.grid;
            lossChart.options.scales.y.ticks.color = colors.text;
            lossChart.options.scales.y.title.color = colors.text;
            lossChart.options.scales.y.grid.color = colors.grid;
            lossChart.update('none');
        }

        function applyPlot3dTheme() {
            if (!plot3dEl || !plot3dReady || typeof window.Plotly === 'undefined') {
                return;
            }

            const dark = isDarkMode();
            window.Plotly.relayout(plot3dEl, {
                paper_bgcolor: dark ? '#232323' : '#ffffff',
                plot_bgcolor: dark ? '#232323' : '#ffffff',
                font: {
                    color: dark ? '#cccccc' : '#212529'
                },
                'scene.bgcolor': dark ? '#232323' : '#ffffff',
                'scene.xaxis.backgroundcolor': dark ? '#232323' : '#ffffff',
                'scene.xaxis.gridcolor': dark ? 'rgba(169,169,169,0.18)' : 'rgba(0,0,0,0.1)',
                'scene.xaxis.zerolinecolor': dark ? 'rgba(169,169,169,0.25)' : 'rgba(0,0,0,0.2)',
                'scene.xaxis.color': dark ? '#cccccc' : '#212529',
                'scene.yaxis.backgroundcolor': dark ? '#232323' : '#ffffff',
                'scene.yaxis.gridcolor': dark ? 'rgba(169,169,169,0.18)' : 'rgba(0,0,0,0.1)',
                'scene.yaxis.zerolinecolor': dark ? 'rgba(169,169,169,0.25)' : 'rgba(0,0,0,0.2)',
                'scene.yaxis.color': dark ? '#cccccc' : '#212529',
                'scene.zaxis.backgroundcolor': dark ? '#232323' : '#ffffff',
                'scene.zaxis.gridcolor': dark ? 'rgba(169,169,169,0.18)' : 'rgba(0,0,0,0.1)',
                'scene.zaxis.zerolinecolor': dark ? 'rgba(169,169,169,0.25)' : 'rgba(0,0,0,0.2)',
                'scene.zaxis.color': dark ? '#cccccc' : '#212529'
            });
        }

        function applyTheme() {
            applyChartTheme();
            applyPlot3dTheme();
        }

        const lockableControls = [
            modeSelect,
            lrInput,
            startXInput,
            startYInput,
            startZInput,
            targetAInput,
            targetBInput,
            targetCInput,
            spsInput,
        ];

        function setLockedUI(locked) {
            sessionLocked = locked;
            lockableControls.forEach((el) => {
                if (!el) return;
                el.disabled = locked;
            });

            // During a run only Pause/Start and Cancel/Reset should be available.
            playBtn.disabled = false;
            resetBtn.disabled = false;
        }

        function updateUI() {
            const a = parseFloat(targetAInput.value);
            const b = parseFloat(targetBInput.value);
            const c = parseFloat(targetCInput.value);

            let fx = 0;
            let gradAbs = 0;

            if (mode() === '3d') {
                const g = g3d(x, y, z, a, b, c);
                fx = f3d(x, y, z, a, b, c);
                gradAbs = Math.sqrt((g.gx * g.gx) + (g.gy * g.gy) + (g.gz * g.gz));
                setText(yEl, y.toFixed(4));
                setText(zEl, z.toFixed(4));
            } else if (mode() === '3d-surface') {
                const g = g2d(x, y, a, b);
                fx = f2d(x, y, a, b);
                gradAbs = Math.sqrt((g.gx * g.gx) + (g.gy * g.gy));
                setText(yEl, y.toFixed(4));
            } else if (mode() === '2d') {
                const g = g2d(x, y, a, b);
                fx = f2d(x, y, a, b);
                gradAbs = Math.sqrt((g.gx * g.gx) + (g.gy * g.gy));
                setText(yEl, y.toFixed(4));
                dotEl2d.style.left = toPlaneX(x).toFixed(4) + "%";
                dotEl2d.style.top = toPlaneY(y).toFixed(4) + "%";
                targetEl2d.style.left = toPlaneX(a).toFixed(4) + "%";
                targetEl2d.style.top = toPlaneY(b).toFixed(4) + "%";
            } else {
                const g = g1d(x, a);
                fx = f1d(x, a);
                gradAbs = Math.abs(g);
                dotEl.style.left = toTrackX(x).toFixed(4) + "%";
                minEl.style.left = toTrackX(a).toFixed(4) + "%";
            }

            setText(iterEl, String(iter));
            setText(xEl, x.toFixed(4));
            setText(fxEl, fx.toFixed(4));
            setText(gradEl, gradAbs.toFixed(4));
        }

        function setModeVisibility() {
            const m = mode();
            const is2d = m === '2d' || is3dAny();
            const is3d = is3dAny();
            document.querySelectorAll('.gd-only-2d').forEach((el) => {
                el.style.display = is2d ? '' : 'none';
            });
            document.querySelectorAll('.gd-only-1d').forEach((el) => {
                el.style.display = is2d ? 'none' : '';
            });

            document.querySelectorAll('.gd-only-2d-objective').forEach((el) => {
                el.style.display = m === '2d' ? '' : 'none';
            });

            document.querySelectorAll('.gd-only-2d-grad').forEach((el) => {
                el.style.display = m === '2d' ? '' : 'none';
            });

            document.querySelectorAll('.gd-only-3d').forEach((el) => {
                el.style.display = is3d ? '' : 'none';
            });

            document.querySelectorAll('.gd-only-3dxyz').forEach((el) => {
                el.style.display = m === '3d' ? '' : 'none';
            });

            document.querySelectorAll('.gd-only-3d-surface').forEach((el) => {
                el.style.display = m === '3d-surface' ? '' : 'none';
            });

            if (planeEl) {
                planeEl.style.display = (is2d && !is3d) ? '' : 'none';
            }

            if (plot3dEl) {
                plot3dEl.style.display = is3d ? '' : 'none';
            }
        }

        function buildSurface(a, b) {
            const min = -10;
            const max = 10;
            const steps = 41;
            const xs = [];
            const ys = [];

            for (let i = 0; i < steps; i++) {
                const t = i / (steps - 1);
                xs.push(min + t * (max - min));
                ys.push(min + t * (max - min));
            }

            const zGrid = [];
            for (let yi = 0; yi < ys.length; yi++) {
                const row = [];
                for (let xi = 0; xi < xs.length; xi++) {
                    row.push(f2d(xs[xi], ys[yi], a, b));
                }
                zGrid.push(row);
            }

            return { xs, ys, zGrid };
        }

        function ensurePlot3d() {
            if (!plot3dEl) {
                return;
            }
            if (!is3dAny()) {
                return;
            }
            if (typeof window.Plotly === 'undefined') {
                plot3dReady = false;
                return;
            }

            const a = parseFloat(targetAInput.value);
            const b = parseFloat(targetBInput.value);
            const c = parseFloat(targetCInput.value);

            const traces = [];

            if (mode() === '3d-surface') {
                const surface = buildSurface(a, b);
                traces.push({
                    type: 'surface',
                    x: surface.xs,
                    y: surface.ys,
                    z: surface.zGrid,
                    opacity: 0.85,
                    colorscale: 'Viridis',
                    showscale: false,
                    hoverinfo: 'skip'
                });
            }

            const pathTrace = {
                type: 'scatter3d',
                mode: 'lines+markers',
                x: pathX,
                y: pathY,
                z: pathZ,
                line: { color: 'rgba(13,110,253,0.9)', width: 6 },
                marker: { size: 3, color: 'rgba(13,110,253,1)' },
                hoverinfo: 'skip'
            };

            const currentTrace = {
                type: 'scatter3d',
                mode: 'markers',
                x: [x],
                y: [y],
                z: [mode() === '3d-surface' ? f2d(x, y, a, b) : z],
                marker: { size: 6, color: 'rgba(13,110,253,1)' },
                hoverinfo: 'skip'
            };

            const targetTrace = {
                type: 'scatter3d',
                mode: 'markers',
                x: [a],
                y: [b],
                z: [mode() === '3d-surface' ? 0 : c],
                marker: { size: 6, color: 'rgba(25,135,84,1)' },
                hoverinfo: 'skip'
            };

            traces.push(pathTrace, currentTrace, targetTrace);

            const layout = {
                margin: { l: 0, r: 0, b: 0, t: 0 },
                paper_bgcolor: isDarkMode() ? '#232323' : '#ffffff',
                plot_bgcolor: isDarkMode() ? '#232323' : '#ffffff',
                font: {
                    color: isDarkMode() ? '#cccccc' : '#212529'
                },
                scene: {
                    bgcolor: isDarkMode() ? '#232323' : '#ffffff',
                    xaxis: {
                        title: 'x',
                        range: [-10, 10],
                        backgroundcolor: isDarkMode() ? '#232323' : '#ffffff',
                        gridcolor: isDarkMode() ? 'rgba(169,169,169,0.18)' : 'rgba(0,0,0,0.1)',
                        zerolinecolor: isDarkMode() ? 'rgba(169,169,169,0.25)' : 'rgba(0,0,0,0.2)',
                        color: isDarkMode() ? '#cccccc' : '#212529'
                    },
                    yaxis: {
                        title: 'y',
                        range: [-10, 10],
                        backgroundcolor: isDarkMode() ? '#232323' : '#ffffff',
                        gridcolor: isDarkMode() ? 'rgba(169,169,169,0.18)' : 'rgba(0,0,0,0.1)',
                        zerolinecolor: isDarkMode() ? 'rgba(169,169,169,0.25)' : 'rgba(0,0,0,0.2)',
                        color: isDarkMode() ? '#cccccc' : '#212529'
                    },
                    zaxis: mode() === '3d-surface'
                        ? {
                            title: 'f(x,y)',
                            backgroundcolor: isDarkMode() ? '#232323' : '#ffffff',
                            gridcolor: isDarkMode() ? 'rgba(169,169,169,0.18)' : 'rgba(0,0,0,0.1)',
                            zerolinecolor: isDarkMode() ? 'rgba(169,169,169,0.25)' : 'rgba(0,0,0,0.2)',
                            color: isDarkMode() ? '#cccccc' : '#212529'
                        }
                        : {
                            title: 'z',
                            range: [-10, 10],
                            backgroundcolor: isDarkMode() ? '#232323' : '#ffffff',
                            gridcolor: isDarkMode() ? 'rgba(169,169,169,0.18)' : 'rgba(0,0,0,0.1)',
                            zerolinecolor: isDarkMode() ? 'rgba(169,169,169,0.25)' : 'rgba(0,0,0,0.2)',
                            color: isDarkMode() ? '#cccccc' : '#212529'
                        },
                    camera: {
                        eye: { x: 1.35, y: 1.65, z: 0.85 }
                    }
                },
            };

            window.Plotly.newPlot(plot3dEl, traces, layout, {
                responsive: true,
                displayModeBar: false
            });

            plot3dReady = true;
            applyPlot3dTheme();
        }

        function updatePlot3d() {
            if (!plot3dEl || !is3dAny() || !plot3dReady || typeof window.Plotly === 'undefined') {
                return;
            }

            const a = parseFloat(targetAInput.value);
            const b = parseFloat(targetBInput.value);
            const c = parseFloat(targetCInput.value);

            const pathIdx = mode() === '3d-surface' ? 1 : 0;
            const currentIdx = mode() === '3d-surface' ? 2 : 1;
            const targetIdx = mode() === '3d-surface' ? 3 : 2;

            window.Plotly.restyle(plot3dEl, { x: [pathX], y: [pathY], z: [pathZ] }, [pathIdx]);

            window.Plotly.restyle(plot3dEl, {
                x: [[x]],
                y: [[y]],
                z: [[mode() === '3d-surface' ? f2d(x, y, a, b) : z]]
            }, [currentIdx]);

            window.Plotly.restyle(plot3dEl, {
                x: [[a]],
                y: [[b]],
                z: [[mode() === '3d-surface' ? 0 : c]]
            }, [targetIdx]);
        }

        function resetState() {
            iter = 0;
            x = parseFloat(startXInput.value);
            y = parseFloat(startYInput.value);
            z = parseFloat(startZInput.value);

            hasStartedOnce = false;
            playBtn.textContent = i18n.start;

            pathX = [x];
            pathY = [y];
            pathZ = [mode() === '3d-surface' ? f2d(x, y, parseFloat(targetAInput.value), parseFloat(targetBInput.value)) : z];

            lossChart.data.labels = [];
            lossChart.data.datasets[0].data = [];
            lossChart.update();
            updateUI();

            ensurePlot3d();
        }

        function step() {
            const a = parseFloat(targetAInput.value);
            const b = parseFloat(targetBInput.value);
            const c = parseFloat(targetCInput.value);
            const lr = parseFloat(lrInput.value);

            let fx = 0;
            let gradNorm = 0;

            if (mode() === '2d') {
                const g = g2d(x, y, a, b);
                x = x - lr * g.gx;
                y = y - lr * g.gy;
                gradNorm = Math.sqrt((g.gx * g.gx) + (g.gy * g.gy));
                fx = f2d(x, y, a, b);
            } else if (mode() === '3d') {
                const g = g3d(x, y, z, a, b, c);
                x = x - lr * g.gx;
                y = y - lr * g.gy;
                z = z - lr * g.gz;
                gradNorm = Math.sqrt((g.gx * g.gx) + (g.gy * g.gy) + (g.gz * g.gz));
                fx = f3d(x, y, z, a, b, c);
            } else if (mode() === '3d-surface') {
                const g = g2d(x, y, a, b);
                x = x - lr * g.gx;
                y = y - lr * g.gy;
                gradNorm = Math.sqrt((g.gx * g.gx) + (g.gy * g.gy));
                fx = f2d(x, y, a, b);
            } else {
                const g = g1d(x, a);
                x = x - lr * g;
                gradNorm = Math.abs(g);
                fx = f1d(x, a);
            }

            iter++;

            lossChart.data.labels.push(iter);
            lossChart.data.datasets[0].data.push(fx);

            if (lossChart.data.labels.length > 300) {
                lossChart.data.labels.shift();
                lossChart.data.datasets[0].data.shift();
            }

            lossChart.update();
            updateUI();

            if (mode() === '3d' || mode() === '3d-surface') {
                pathX.push(x);
                pathY.push(y);
                pathZ.push(mode() === '3d-surface' ? f2d(x, y, a, b) : z);

                if (pathX.length > 500) {
                    pathX.shift();
                    pathY.shift();
                    pathZ.shift();
                }

                updatePlot3d();
            }

            if (gradNorm < 1e-6 || fx < 1e-12) {
                hasStartedOnce = false;
                stopAndUnlock();
            }
        }

        function pause() {
            running = false;
            playBtn.textContent = hasStartedOnce ? i18n.resume : i18n.start;
            if (timerId) {
                clearInterval(timerId);
                timerId = null;
            }
        }

        function stopAndUnlock() {
            pause();
            setLockedUI(false);
        }

        function play() {
            const sps = parseInt(spsInput.value, 10);
            const intervalMs = Math.max(5, Math.floor(1000 / Math.max(1, sps)));

            if (!hasStartedOnce && iter > 0) {
                resetState();
            }

            running = true;
            playBtn.textContent = i18n.pause;

            setLockedUI(true);
            hasStartedOnce = true;

            if (timerId) {
                clearInterval(timerId);
            }

            timerId = setInterval(step, intervalMs);
        }

        function togglePlay() {
            if (running) {
                stopAndUnlock();
                return;
            }

            play();
        }

        function onParamsChanged() {
            syncLabels();
            updateUI();
            if (running) {
                play();
            }

            if (is3dAny()) {
                ensurePlot3d();
            }
        }

        playBtn.addEventListener("click", function () {
            togglePlay();
        });

        resetBtn.addEventListener("click", function () {
            stopAndUnlock();
            resetState();
        });

        modeSelect.addEventListener("change", function () {
            stopAndUnlock();
            setModeVisibility();
            resetState();
        });

        lrInput.addEventListener("input", onParamsChanged);
        targetAInput.addEventListener("input", onParamsChanged);
        targetBInput.addEventListener("input", onParamsChanged);
        targetCInput.addEventListener("input", onParamsChanged);
        spsInput.addEventListener("input", onParamsChanged);

        startXInput.addEventListener("input", function () {
            syncLabels();
            if (!running) {
                resetState();
            }
        });

        startYInput.addEventListener("input", function () {
            syncLabels();
            if (!running) {
                resetState();
            }
        });

        startZInput.addEventListener("input", function () {
            syncLabels();
            if (!running) {
                resetState();
            }
        });

        syncLabels();
        setModeVisibility();
        resetState();
        applyTheme();

        const themeObserver = new MutationObserver(function () {
            applyTheme();
        });

        themeObserver.observe(document.body, {
            attributes: true,
            attributeFilter: ['data-theme']
        });

        setLockedUI(false);
    })();
</script>
