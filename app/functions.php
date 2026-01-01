<?php

function running_time(float $microtimeEnd, float $microtimeStart): string {
    $timeDif = ($microtimeEnd - $microtimeStart);
    return (string)($timeDif > 0.001 ? round($timeDif, 3) : '< 0.001');
}

function memory_usage(float $endMemory, float $startMemory): string {
    $memoryUsed = $endMemory - $startMemory;
    return round($memoryUsed / 1024 / 1024, 3);
}

function ucshortwords(string $text) {
    return str_ireplace(
        ['Llm', 'Ai ', ' Ai', ' Ml', 'Nlp ', ' For ', ' And '],
        ['LLM', 'AI ', ' AI', ' ML', 'NLP ', ' for ', ' and '],
        $text
    );
}

function dd($data = [], bool $exit = false): void {
    echo '<pre>';
    print_r($data);
    echo '</pre>';

    if ($exit) {
        exit;
    }
}

function ddd($data = []): void {
    dd($data, true);
}

function humanize($data) {
    $data = str_replace(['-', '_'], ' ', $data);
    $data = ucwords($data);
    $data = str_ireplace(['Php', 'Llm', 'PHPml'], ['PHP', 'LLM', 'PHP-ML'], $data);
    return $data;
}

function array_flatten(array $array = []): array {
    $return = [];
    array_walk_recursive($array, function ($a) use (&$return) {
        $return[] = $a;
    });
    return $return;
}

function array_to_matrix(array $matrix): string {
    $result = [];

    foreach ($matrix as $row) {
        // Convert each row to a string with brackets
        $result[] = '[' . implode(', ', $row) . ']';
    }

    // Join rows with newlines
    return implode("\n", $result);
}

function array_to_vector(array $vector): string {
    return '[' . implode(', ', $vector) . ']';
}

function array_reduce_samples(array $samples, int $index): array {
    return array_map(function ($subArray) use ($index) {
        return isset($subArray[$index]) ? [$subArray[$index]] : [];
    }, $samples);
}

function verify_fields(array|string &$features, array $verificationData, array|string $defaultData): void {
    if (empty($features)) {
        $features = $defaultData;
    } else {
        if (is_array($features)) {
            foreach ($features as $feature) {
                if (!in_array($feature, $verificationData)) {
                    $features = $defaultData;
                    break;
                }
            }
        } else {
            if (!in_array($features, $verificationData)) {
                $features = $defaultData;
            }
        }
    }
}

function create_show_code_button(string $title, string $page): string {
    $output = '<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">' . $title . '</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="' . APP_URL . $page . '" class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>';

    return $output;
}

function create_run_code_button(
    string $title,
    string $page,
    string $buttonText = 'Run Code',
): string {
    $output = '<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <h2 class="h4">' . $title . '</h2>
        <div class="btn-toolbar mb-2 mb-md-0">';

        $output .= '<div class="btn-group">
                <a href="' . APP_URL . $page . '" class="btn btn-sm btn-outline-primary">&#9654;&nbsp; '.$buttonText.'</a>
            </div>';

        $output .= '</div>
    </div>';

    return $output;
}

/**
 * @param string $datasetFile
 * @param string $title
 * @param bool $opened
 * @param string $language      php|js
 * @param string $copyButtonId
 * @return string
 */
function create_example_of_use_links(string $datasetFile = '', string $title = 'Example of use', bool $opened = false, string $language = 'php', string $copyButtonId = 'copyButton'): string {

    if ($opened) {
        $output = ($title ? '<p>' . $title . ':</p>' : '') . '
        <div class="bd-clipboard">
            <button id="'  .$copyButtonId . '" type="button" class="btn-clipboard" onclick="copyToClipboard(\''  .$copyButtonId . '\')">
            Copy
            </button>&nbsp;
        </div>';

        if ($language === 'js') {
            $output .= '<div id="'  .$copyButtonId . '-code" class="code-wrapper p-0"><pre><code id="code" class="language-javascript">' . htmlentities(file_get_contents($datasetFile)) . '</code></pre></div>';
        } else {
            $output .= '<div id="'  .$copyButtonId . '-code" class="code-wrapper"><code id="code"><span>' . highlight_file($datasetFile, true) . '</code></div>';
        }
    } else {
        $output = '
        <p class="btn btn-link px-0 py-0" id="toggleExampleOfUse" data-bs-toggle="collapse" href="#collapseExampleOfUse" role="button" aria-expanded="false" aria-controls="collapseExampleOfUse" title="Click to expand">
            ' . $title . ' <i id="toggleIcon" class="fa-regular fa-square-plus"></i>
        </p>
        <div class="collapse pb-4" id="collapseExampleOfUse">
            <div class="bd-clipboard">
                <button id="'  .$copyButtonId . '" type="button" class="btn-clipboard" onclick="copyToClipboard(\''  .$copyButtonId . '\')">Copy</button>&nbsp;
            </div>
            <div id="'  .$copyButtonId . '-code" class="code-wrapper">
                <code id="code">' . highlight_file($datasetFile, true) . '</code>
            </div>
        </div>';
    }

    return $output;
}

function create_dataset_and_test_data_links(array|string $datasetData = '', array $testData = [], bool $fullWidth = false): string {
    $output = '<p class="btn btn-link px-0 py-0 me-4" id="toggleDataset" data-bs-toggle="collapse" href="#collapseDataset" role="button" aria-expanded="false" aria-controls="collapseDataset" title="Click to expand">
        Dataset <i id="toggleIconDataset" class="fa-regular fa-square-plus"></i>
    </p>';

    if ($testData) {
        $output .= '<p class="btn btn-link px-0 py-0" id="toggleTestData" data-bs-toggle="collapse" href="#collapseTestData" role="button" aria-expanded="false" aria-controls="collapseTestData" title="Click to expand">
        Test Data <i id="toggleIconTestData" class="fa-regular fa-square-plus"></i>
        </p>';
    }

    $output .= '<div class="row">';

    if (is_array($datasetData) && empty($testData)) {
        $output .= '<div class="collapse col-md-12 ' . ($fullWidth ? 'col-lg-12' : 'col-lg-7 pe-4') . ' mb-4 pe-4" id="collapseDataset">
                <div class="card card-body pb-0">
                    <code class="gray">
            <pre>';

        foreach ($datasetData as $test) {
            $output .= $test . PHP_EOL;
        }

        $output .= '</pre>
                    </code>
                </div>
            </div>';
    } else {
        if ($datasetData) {
            $output .= '<div class="collapse col-md-12 ' . ($fullWidth ? 'col-lg-12' : 'col-lg-7 pe-4') . ' mb-4" id="collapseDataset">
                    <div class="card card-body pb-0">
                    <code id="dataset">
                        ' . highlight_file($datasetData, true) . '
                    </code>
                    </div>
                    </div>';
        }

        if ($testData) {
            $output .= '<div class="collapse col-md-12 col-lg-5 mb-4 ps-2" id="collapseTestData">
                    <div class="card card-body pb-0">
                    <code class="gray">
                    <pre>';

            foreach ($testData as $test) {
                $output .= $test . PHP_EOL;
            }

            $output .= '</pre>
                    </code>
                    </div>
                    </div>';
        }
    }

    $output .= '</div>';

    return $output;
}

function create_link(string $section, string $subsection, string $page, string $link, array $pages, string $urlSection, string $urlSubSection, string $urlPage): string {
    $active = '';
    if ($urlSection === $section && $urlSubSection === $subsection && in_array($urlPage, $pages)) {
        $active = ' active';
    }

    $output = '<a class="nav-link' . $active . '" href="' . create_href($section, $subsection, $page) . '">';

    $output .= '<span data-feather="file-text">&bull; </span>';
    $output .= '<small>' . $link . '</small>';
    $output .= '</a>';

    return $output;
}

function create_href(string $section = '', string $subsection = '', string $page = ''): string {
    if (APP_SEO_LINKS) {
        return APP_URL . ($section ? $section . '/' : '') . ($subsection ? $subsection . '/' : '') . $page;
    }

    return 'index.php?section=' . $section . '&subsection=' . $subsection . '&page=' . $page;
}

function create_form_fields(string $section, string $subsection, string $page): string {
    $output = '<input type="hidden" name="section" value="' . $section . '" />';
    $output .= '<input type="hidden" name="subsection" value="' . $subsection . '" />';
    $output .= '<input type="hidden" name="page" value="' . $page . '" />';

    return $output;
}

function create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result = '', $showResult = true) {
    $output = '<div class="mb-1">
                <b>Result:</b>
                <span class="float-end">Memory: '.memory_usage($memoryEnd, $memoryStart).' Mb</span>
                <span class="float-end me-2">Time <span class="d-xs-hide">running:</span> '.running_time($microtimeEnd, $microtimeStart).' sec.</span>
            </div>';

    if ($showResult) {
        $output .= '<code class="code-result">
                <pre>'.$result.'</pre>
            </code>';
    }

    return $output;
}

