<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('gradient_descent.heading'); ?></h1>
</div>

<h4><?= __t('gradient_descent.animation_title'); ?></h4>
<p><?= __t('gradient_descent.animation_intro'); ?></p>
<br>

<div class="row g-3">
    <div class="col-lg-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold">Параметры</div>
                        <div class="text-muted small">Минимизируем \(f(x) = (x - a)^2\) или \(f(x,y) = (x - a)^2 + (y - b)^2\)</div>
                    </div>
                    <div class="btn-group">
                        <button id="gd-play" class="btn btn-sm btn-outline-primary">Старт</button>
                        <button id="gd-reset" class="btn btn-sm btn-outline-secondary">Сброс</button>
                    </div>
                </div>

                <hr>

                <div class="mb-3">
                    <label for="gd-mode" class="form-label"><b>Режим</b></label>
                    <select id="gd-mode" class="form-select form-select-sm w-50">
                        <option value="1d" selected>1D</option>
                        <option value="2d">2D</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="gd-learning-rate" class="form-label"><b>Learning rate (α)</b>: <span id="gd-learning-rate-value">0.08</span></label>
                    <input type="range" class="form-range" id="gd-learning-rate" min="0.005" max="0.25" step="0.005" value="0.08">
                </div>

                <div class="mb-3">
                    <label for="gd-start-x" class="form-label"><b>Начальный x</b>: <span id="gd-start-x-value">6</span></label>
                    <input type="range" class="form-range" id="gd-start-x" min="-10" max="10" step="0.5" value="6">
                </div>

                <div class="mb-3 gd-only-2d" style="display:none;">
                    <label for="gd-start-y" class="form-label"><b>Начальный y</b>: <span id="gd-start-y-value">-4</span></label>
                    <input type="range" class="form-range" id="gd-start-y" min="-10" max="10" step="0.5" value="-4">
                </div>

                <div class="mb-3">
                    <label for="gd-target-a" class="form-label"><b>Цель a</b> (минимум по x): <span id="gd-target-a-value">2</span></label>
                    <input type="range" class="form-range" id="gd-target-a" min="-6" max="6" step="0.5" value="2">
                </div>

                <div class="mb-3 gd-only-2d" style="display:none;">
                    <label for="gd-target-b" class="form-label"><b>Цель b</b> (минимум по y): <span id="gd-target-b-value">1</span></label>
                    <input type="range" class="form-range" id="gd-target-b" min="-6" max="6" step="0.5" value="1">
                </div>

                <div class="mb-3">
                    <label for="gd-steps-per-second" class="form-label"><b>Скорость</b> (шагов/сек): <span id="gd-steps-per-second-value">30</span></label>
                    <input type="range" class="form-range" id="gd-steps-per-second" min="5" max="120" step="1" value="30">
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="small text-muted">Итерация</div>
                        <div class="h5 mb-0" id="gd-iter">0</div>
                    </div>
                    <div class="col-6">
                        <div class="small text-muted">Текущий x</div>
                        <div class="h5 mb-0" id="gd-x">6.0000</div>
                    </div>
                    <div class="col-6 mt-3">
                        <div class="small text-muted">f(x)</div>
                        <div class="h5 mb-0" id="gd-fx">16.0000</div>
                    </div>
                    <div class="col-6 mt-3">
                        <div class="small text-muted">|∇f(x)|</div>
                        <div class="h5 mb-0" id="gd-grad">8.0000</div>
                    </div>
                    <div class="col-6 gd-only-2d mt-3" style="display:none;">
                        <div class="small text-muted">Текущий y</div>
                        <div class="h5 mb-0" id="gd-y">-4.0000</div>
                    </div>
                </div>

                <hr>

                <div class="small text-muted">
                    Правило обновления:
                    <div><code>x = x - α · ∇f(x)</code></div>
                    <div class="gd-only-1d">где <code>∇f(x) = 2(x - a)</code></div>
                    <div class="gd-only-2d" style="display:none;">где <code>∇f(x,y) = (2(x-a), 2(y-b))</code></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7">

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="fw-bold mb-2">Траектория (x)</div>
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
                <div class="text-muted small mt-2 gd-only-1d">Точка движется к минимуму (вертикальная линия — <code>a</code>).</div>
                <div class="text-muted small mt-2 gd-only-2d" style="display:none;">Точка движется к минимуму (цель — точка <code>(a,b)</code>).</div>
            </div>
        </div>

        <div class="card shadow-sm mt-3">
            <div class="card-body">
                <div class="fw-bold mb-2">График ошибки</div>
                <div class="ratio ratio-16x9">
                    <canvas id="gd-loss-chart"></canvas>
                </div>
                <div class="text-muted small mt-2">
                    На графике: значение <code>f(x)</code> по итерациям. Если <code>α</code> слишком большое — возможны колебания.
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-3">
            <div class="card-body">
                <div class="fw-bold mb-2">Ссылки</div>
                <div>
                    <?= create_link('part-2/gradient-descent-on-fingers/implementation', '← Назад к реализации'); ?>
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
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    (function () {
        const $ = (id) => document.getElementById(id);

        const playBtn = $("gd-play");
        const resetBtn = $("gd-reset");

        const modeSelect = $("gd-mode");

        const lrInput = $("gd-learning-rate");
        const startXInput = $("gd-start-x");
        const startYInput = $("gd-start-y");
        const targetAInput = $("gd-target-a");
        const targetBInput = $("gd-target-b");
        const spsInput = $("gd-steps-per-second");

        const lrValue = $("gd-learning-rate-value");
        const startXValue = $("gd-start-x-value");
        const startYValue = $("gd-start-y-value");
        const targetAValue = $("gd-target-a-value");
        const targetBValue = $("gd-target-b-value");
        const spsValue = $("gd-steps-per-second-value");

        const iterEl = $("gd-iter");
        const xEl = $("gd-x");
        const yEl = $("gd-y");
        const fxEl = $("gd-fx");
        const gradEl = $("gd-grad");

        const dotEl = $("gd-dot");
        const minEl = $("gd-min");
        const planeEl = $("gd-plane");
        const targetEl2d = $("gd-target");
        const dotEl2d = $("gd-dot-2d");

        let running = false;
        let timerId = null;

        let iter = 0;
        let x = parseFloat(startXInput.value);
        let y = parseFloat(startYInput.value);

        function mode() {
            return modeSelect.value === '2d' ? '2d' : '1d';
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

        function g2d(x, y, a, b) {
            return {
                gx: 2 * (x - a),
                gy: 2 * (y - b)
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
            targetAValue.textContent = parseFloat(targetAInput.value).toFixed(1);
            targetBValue.textContent = parseFloat(targetBInput.value).toFixed(1);
            spsValue.textContent = String(parseInt(spsInput.value, 10));
        }

        const ctx = $("gd-loss-chart").getContext("2d");

        const lossChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: [],
                datasets: [{
                    label: "f(x)",
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
                    legend: { display: false },
                    tooltip: { enabled: true }
                },
                scales: {
                    x: {
                        title: { display: true, text: "итерация" },
                        ticks: { maxTicksLimit: 8 }
                    },
                    y: {
                        title: { display: true, text: "f(x)" },
                        beginAtZero: true
                    }
                }
            }
        });

        function updateUI() {
            const a = parseFloat(targetAInput.value);
            const b = parseFloat(targetBInput.value);

            let fx = 0;
            let gradAbs = 0;

            if (mode() === '2d') {
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
            const is2d = mode() === '2d';
            document.querySelectorAll('.gd-only-2d').forEach((el) => {
                el.style.display = is2d ? '' : 'none';
            });
            document.querySelectorAll('.gd-only-1d').forEach((el) => {
                el.style.display = is2d ? 'none' : '';
            });

            if (planeEl) {
                planeEl.style.display = is2d ? '' : 'none';
            }
        }

        function resetState() {
            iter = 0;
            x = parseFloat(startXInput.value);
            y = parseFloat(startYInput.value);
            lossChart.data.labels = [];
            lossChart.data.datasets[0].data = [];
            lossChart.update();
            updateUI();
        }

        function step() {
            const a = parseFloat(targetAInput.value);
            const b = parseFloat(targetBInput.value);
            const lr = parseFloat(lrInput.value);

            let fx = 0;
            let gradNorm = 0;

            if (mode() === '2d') {
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

            if (gradNorm < 1e-6 || fx < 1e-12) {
                pause();
            }
        }

        function pause() {
            running = false;
            playBtn.textContent = "Старт";
            if (timerId) {
                clearInterval(timerId);
                timerId = null;
            }
        }

        function play() {
            const sps = parseInt(spsInput.value, 10);
            const intervalMs = Math.max(5, Math.floor(1000 / Math.max(1, sps)));
            running = true;
            playBtn.textContent = "Пауза";

            if (timerId) {
                clearInterval(timerId);
            }

            timerId = setInterval(step, intervalMs);
        }

        function togglePlay() {
            if (running) {
                pause();
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
        }

        playBtn.addEventListener("click", function () {
            togglePlay();
        });

        resetBtn.addEventListener("click", function () {
            pause();
            resetState();
        });

        modeSelect.addEventListener("change", function () {
            pause();
            setModeVisibility();
            resetState();
        });

        lrInput.addEventListener("input", onParamsChanged);
        targetAInput.addEventListener("input", onParamsChanged);
        targetBInput.addEventListener("input", onParamsChanged);
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

        syncLabels();
        setModeVisibility();
        resetState();
    })();
</script>
