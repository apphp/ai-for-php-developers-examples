<?php
    $sideBar = $_COOKIE['sidebar'] ?? '';
    $darkSwitch = $_COOKIE['darkSwitch'] ?? '';
    $dataTheme = $darkSwitch === 'dark' ? ' data-theme="dark"' : '';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title><?= htmlspecialchars($title ?? 'AI for PHP Developers', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="icon" type="image/webp" href="/favicon.webp">

    <link href="<?=APP_ASSETS_URL?>assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=APP_ASSETS_URL?>assets/dist/css/dark-mode.css" rel="stylesheet">
    <link href="<?=APP_ASSETS_URL?>assets/dist/css/highlight/default.min.css" rel="stylesheet">
    <link href="<?=APP_ASSETS_URL?>assets/dashboard.css" rel="stylesheet">
    <link href="<?=APP_ASSETS_URL?>assets/dist/css/all.min.css" rel="stylesheet" crossorigin="anonymous">

    <script>
        window.MathJax = {
            tex: {
                inlineMath: [['$', '$'], ['\\(', '\\)']], // Настройка для инлайн-формул
                displayMath: [['$$', '$$'], ['\\[', '\\]']] // Настройка для блочных формул
            }
        };
    </script>
    <script type="text/javascript" id="MathJax-script" src="<?=APP_ASSETS_URL?>assets/dist/js/mathjax/tex-mml-chtml.js"></script>
</head>
<body<?=$dataTheme;?>>
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="<?=APP_URL?>">AI for PHP Developers (examples)</a>

    <button id="btn-toggler" class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="ms-auto"></div>

<!--    <div class="search-container col-12 col-sm-4 col-md-3 col-lg-2 mt-1 mt-sm-0 mb-sm-0 me-5">-->
<!--        <form action="--><?php //= create_href('search', 'index')?><!--" method="get">-->
<!--            <input type="text" name="s" maxlength="100" class="form-control" placeholder="Search..." aria-label="Search">-->
<!--        </form>-->
<!--    </div>-->

    <div class="form-check form-switch form-switch-mode mt-1" title="Swith Light/Dark Mode">
        <input type="checkbox" class="form-check-input cursor-pointer float-end float-sm-none" id="darkSwitch" <?= $darkSwitch ? 'checked' : ''?>>
        <label class="custom-control-label" for="darkSwitch"></label>
    </div>

    <!--    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">-->
    <!--    <div class="navbar-nav">-->
    <!--        <div class="nav-item text-nowrap">-->
    <!--            <a class="nav-link px-3" href="#"></a>-->
    <!--        </div>-->
    <!--    </div>-->
</header>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../app/navbar.php'; ?>

        <main id="main" class="<?= $sideBar === 'collapsed' ? 'col-md-12 col-lg-12 expanded' : 'col-md-9 col-lg-10'; ?> ms-sm-auto px-md-4 pt-3 pb-4">
            <?php include __DIR__ . '/../app/breadcrumbs.php'; ?>

            <?php
                if (!empty($contentTemplate)):
                    // Content templates live in the same directory as this layout
                    include __DIR__ . '/pages/' . $contentTemplate;
                endif;
            ?>
        </main>
    </div>
</div>

<script src="<?=APP_ASSETS_URL?>assets/dist/js/bootstrap/bootstrap.bundle.min.js"></script>
<script src="<?=APP_ASSETS_URL?>assets/dashboard.js"></script>
<script src="<?=APP_ASSETS_URL?>assets/dist/js/dark-mode-switch.js"></script>

</body>
</html>
