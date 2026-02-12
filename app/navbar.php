<?php

$section = !empty($section) ? htmlspecialchars($section) : '';
$subSection = !empty($subSection) ? htmlspecialchars($subSection) : '';
$page ??= 'index';
$sideBar ??= '';
//$menu = include('menu.php');

// Determine current request path for active nav state
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$currentPath = str_ireplace(APP_URL_DIR, '', $currentPath);

?>

<nav id="sidebarMenu" class="<?= $sideBar === 'collapsed' ? 'col-md-1 col-lg-1 collapsed' : 'col-md-3 col-lg-2 collapse'; ?> d-md-block bg-light sidebar overflow-auto pb-4">
    <div class="position-sticky pt-3">
        <!-- Toggle Button -->
        <div id="btn-panel-close" data-status="<?= $sideBar === 'collapsed' ? 'expand' : 'collapse'; ?>" title="<?= $sideBar === 'collapsed' ? __t('common.expand') : __t('common.collapse'); ?>">
            <svg id="svg-panel-close" class="<?= $sideBar === 'collapsed' ? 'rotate-180' : ''; ?>" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18" preserveAspectRatio="xMidYMid meet" width="18" height="18" style="vertical-align: middle;"><g clip-path="url(#PanelLeftClose_svg__a)"><path stroke="#777" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M4.791 14.5v-13m8.653 13H2.556c-.413 0-.809-.152-1.1-.423A1.394 1.394 0 0 1 1 13.055V2.945C1 2.147 1.696 1.5 2.556 1.5h10.888c.86 0 1.556.647 1.556 1.445v10.11c0 .798-.697 1.445-1.556 1.445Z"></path><path fill="#777" d="M8.017 7.618a.4.4 0 0 0 0 .566l2.4 2.4a.4.4 0 0 0 .683-.283v-4.8a.4.4 0 0 0-.683-.283l-2.4 2.4Z"></path></g><defs><clipPath id="PanelLeftClose_svg__a"><path d="M0 0h18v18H0z"></path></clipPath></defs></svg>
        </div>

        <div id="navbar" class="<?= $sideBar === 'collapsed' ? 'nonvisible' : ''; ?>">

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span><i class="fas fa-home me-1"></i> <?= __t('nav.introduction'); ?></span>
            </h6>

            <!-- INTRO -->
            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                    <a class="nav-link<?= in_array($currentPath, ['/', '/home'], true) ? ' active' : '' ?>" href="<?=APP_URL?>home">
                        <span data-feather="file-text">• </span><small><?= __t('nav.getting_started'); ?></small>
                    </a>
                    <a class="nav-link<?= str_starts_with($currentPath, $linkPath = '/ml-ecosystem-in-php') ? ' active' : '' ?>" href="<?=APP_URL?>ml-ecosystem-in-php">
                        <span data-feather="file-text">• </span><small><?= __t('ml_ecosystem.title'); ?></small>
                    </a>
                </li>
            </ul>

            <!-- PART I -->
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span><i class="fas fa-book me-1"></i> <?= __t('nav.part1_title'); ?></span>
            </h6>

            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                    <a class="nav-link<?= str_starts_with($currentPath, $linkPath = '/part-1/what-is-a-model') ? ' active' : '' ?>" href="<?=APP_URL . ltrim($linkPath, '/')?>">
                        <span data-feather="file-text">• </span><small><?= __t('nav.part1_what_is_model'); ?></small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="disabled nav-link<?= str_starts_with($currentPath, $linkPath = '/part-1/vectors-dimensions-and-feature-spaces') ? ' active' : '' ?>" href="<?=APP_URL . ltrim($linkPath, '/')?>">
                        <span data-feather="file-text">• </span><small><?= __t('nav.part1_vectors'); ?></small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="disabled nav-link<?= str_starts_with($currentPath, $linkPath = '/part-1/distances-and-similarity') ? ' active' : '' ?>" href="<?=APP_URL . ltrim($linkPath, '/')?>">
                        <span data-feather="file-text">• </span><small><?= __t('nav.part1_distances'); ?></small>
                    </a>
                </li>
            </ul>

            <!-- PART II -->
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span><i class="fas fa-book me-1"></i> <?= __t('nav.part2_title'); ?></span>
            </h6>

            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                    <a class="nav-link<?= str_starts_with($currentPath, $linkPath = '/part-2/errors-and-loss-functions') ? ' active' : '' ?>" href="<?=APP_URL . ltrim($linkPath, '/')?>">
                        <span data-feather="file-text">• </span><small><?= __t('nav.part2_error_loss_functions'); ?></small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= str_starts_with($currentPath, $linkPath = '/part-2/linear-regression-as-basic-model') ? ' active' : '' ?>" href="<?=APP_URL . ltrim($linkPath, '/')?>">
                        <span data-feather="file-text">• </span><small><?= __t('linear_regression.heading')?></small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= str_starts_with($currentPath, $linkPath = '/part-2/gradient-descent-on-fingers') ? ' active' : '' ?>" href="<?=APP_URL . ltrim($linkPath, '/')?>">
                        <span data-feather="file-text">• </span><small><?= __t('gradient_descent.heading')?></small>
                    </a>
                </li>
            </ul>

            <!-- PART III -->
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span><i class="fas fa-book me-1"></i> <?= __t('nav.part3_title'); ?></span>
            </h6>

            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                    <a class="nav-link<?= str_starts_with($currentPath, $linkPath = '/part-3/probability-as-degree-of-confidence') ? ' active' : '' ?>" href="<?=APP_URL . ltrim($linkPath, '/')?>">
                        <span data-feather="file-text">• </span><small><?= __t('nav.part3_probability_confidence'); ?></small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= str_starts_with($currentPath, $linkPath = '/part-3/logistic-regression') ? ' active' : '' ?>" href="<?=APP_URL . ltrim($linkPath, '/')?>">
                        <span data-feather="file-text">• </span><small><?= __t('nav.part3_logistic_regression'); ?></small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= str_starts_with($currentPath, $linkPath = '/part-3/why-naive-bayes-works') ? ' active' : '' ?>" href="<?=APP_URL . ltrim($linkPath, '/')?>">
                        <span data-feather="file-text">• </span><small><?= __t('why_naive_bayes_works.title'); ?></small>
                    </a>
                </li>
            </ul>

            <!-- PART IV -->
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span><i class="fas fa-book me-1"></i> <?= __t('nav.part4_title'); ?></span>
            </h6>

            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                    <a class="nav-link<?= str_starts_with($currentPath, $linkPath = '/part-4/k-nearest-neighbors-algorithm-and-local-solutions') ? ' active' : '' ?>" href="<?=APP_URL . ltrim($linkPath, '/')?>">
                        <span data-feather="file-text">• </span><small><?= __t('nav.part4_knn_local_solutions'); ?></small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= str_starts_with($currentPath, $linkPath = '/part-4/decision-trees-and-space-partitioning') ? ' active' : '' ?>" href="<?=APP_URL . ltrim($linkPath, '/')?>">
                        <span data-feather="file-text">• </span><small><?= __t('nav.part4_decision_trees_space_partitioning'); ?></small>
                    </a>
                </li>
            </ul>

            <!-- PART V -->
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span><i class="fas fa-book me-1"></i> <?= __t('nav.part5_title'); ?></span>
            </h6>

            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                    <a class="disabled nav-link<?= str_starts_with($currentPath, $linkPath = '/part-5/why-do-words-turn-into-numbers') ? ' active' : '' ?>" href="<?=APP_URL . ltrim($linkPath, '/')?>">
                        <span data-feather="file-text">• </span><small><?= __t('nav.part5_why_do_words_turn_into_numbers'); ?></small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="disabled nav-link<?= str_starts_with($currentPath, $linkPath = '/part-5/bag-of-words-and-tf-idf') ? ' active' : '' ?>" href="<?=APP_URL . ltrim($linkPath, '/')?>">
                        <span data-feather="file-text">• </span><small><?= __t('nav.part5_bag_of_words_and_tf_idf'); ?></small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="disabled nav-link<?= str_starts_with($currentPath, $linkPath = '/part-5/embeddings-as-continuous-spaces-of-meaning') ? ' active' : '' ?>" href="<?=APP_URL . ltrim($linkPath, '/')?>">
                        <span data-feather="file-text">• </span><small><?= __t('nav.part5_embeddings_as_continuous_spaces_of_meaning'); ?></small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="disabled nav-link<?= str_starts_with($currentPath, $linkPath = '/part-5/transformers-from-static-vectors-to-understanding-meaning') ? ' active' : '' ?>" href="<?=APP_URL . ltrim($linkPath, '/')?>">
                        <span data-feather="file-text">• </span><small><?= __t('nav.part5_transformers_from_static_vectors_to_understanding_meaning'); ?></small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= str_starts_with($currentPath, $linkPath = '/part-5/hands-on-embedding-in-php-with-transformers') ? ' active' : '' ?>" href="<?=APP_URL . ltrim($linkPath, '/')?>">
                        <span data-feather="file-text">• </span><small><?= __t('nav.part5_hands_on_embedding_in_php_with_transformers'); ?></small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= str_starts_with($currentPath, $linkPath = '/part-5/retrieval-augmented-generation-as-engineering-system') ? ' active' : '' ?>" href="<?=APP_URL . ltrim($linkPath, '/')?>">
                        <span data-feather="file-text">• </span><small><?= __t('nav.part5_retrieval_augmented_generation_as_engineering_system'); ?></small>
                    </a>
                </li>
            </ul>

            <br><br>
        </div>
    </div>
</nav>
