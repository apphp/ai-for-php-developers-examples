<?php

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

// Small helper to render a page with the common layout
function render_page(PhpRenderer $renderer, Response $response, array $breadcrumbs, string $contentTemplate, array $extraData = []): Response {
    $data = array_merge([
        'breadcrumbs' => $breadcrumbs,
        'contentTemplate' => $contentTemplate,
    ], $extraData);

    return $renderer->render($response, 'layout.php', $data);
}

// Render functions
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

function create_show_code_button(string $title, string $page, string $buttonText = ''): string {
    $output = '<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">' . $title . '</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="' . APP_URL . ltrim($page, '/') . '" class="btn btn-sm btn-outline-primary">' . ($buttonText ? $buttonText : __t('common.show_code')) . '</a>
        </div>
    </div>
</div>';

    return $output;
}

function create_run_code_button(
    string $title,
    string $page,
    string $buttonText = '',
): string {
    $output = '<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <h2 class="h4">' . $title . '</h2>
        <div class="btn-toolbar mb-2 mb-md-0">';

    $output .= '<div class="btn-group">
                <a href="' . APP_URL . $page . '" class="btn btn-sm btn-outline-primary">&#9654;&nbsp; ' . ($buttonText ?: __t('common.run_code')) . '</a>
            </div>';

    $output .= '</div>
    </div>';

    return $output;
}

/**
 * @param string $datasetFile
 * @param string $title
 * @param bool $opened
 * @param string $language php|js
 * @param string $copyButtonId
 * @param string $expandButtonId  Should be unique for each example of use or empty to use default
 * @return string
 */
function create_example_of_use_links(string $datasetFile = '', string $title = 'Example of use', bool $opened = false, string $language = 'php', string $copyButtonId = 'copyButton', string $expandButtonId = ''): string {

    // Use translated default title when caller did not override it
    if ($title === 'Example of use') {
        $title = __t('common.example_of_use');
    }

    if ($opened) {
        $output = ($title ? '<p>' . $title . ':</p>' : '') . '
        <div class="bd-clipboard">
            <button id="' . $copyButtonId . '" type="button" class="btn-clipboard" data-text-copied="' . __t('common.copied') . '" onclick="copyToClipboard(\'' . $copyButtonId . '\')">
            ' . __t('common.copy') . '
            </button>&nbsp;
        </div>';

        if ($language === 'js') {
            $output .= '<div id="' . $copyButtonId . '-code" class="code-wrapper p-0"><pre><code id="code" class="language-javascript">' . htmlentities(file_get_contents($datasetFile)) . '</code></pre></div>';
        } else {
            $output .= '<div id="' . $copyButtonId . '-code" class="code-wrapper"><code id="code"><span>' . highlight_file($datasetFile, true) . '</code></div>';
        }
    } else {
        $output = '
        <p class="btn btn-link px-0 py-0" id="toggleExampleOfUse" data-bs-toggle="collapse" href="#collapseExampleOfUse' . $expandButtonId . '" role="button" aria-expanded="false" aria-controls="collapseExampleOfUse' . $expandButtonId . '" title="' . __t('common.click_to_expand') . '">
            ' . $title . ' <i id="toggleIcon" class="fa-regular fa-square-plus"></i>
        </p>
        <div class="collapse pb-4" id="collapseExampleOfUse' . $expandButtonId . '">
            <div class="bd-clipboard">
                <button id="' . $copyButtonId . '" type="button" class="btn-clipboard" data-text-copied="' . __t('common.copied') . '" onclick="copyToClipboard(\'' . $copyButtonId . '\')">Copy</button>&nbsp;
            </div>
            <div id="' . $copyButtonId . '-code" class="code-wrapper">
                <code id="code">' . highlight_file($datasetFile, true) . '</code>
            </div>
        </div>';
    }

    return $output;
}

function create_example_of_use_block(string $codeFile, string $copyButtonId = 'copyButton'): string {
    $html = '<div>
    <p class="btn btn-link px-0 py-0" id="toggleExampleOfUse" data-bs-toggle="collapse" href="#collapseExampleOfUse" role="button" aria-expanded="false" aria-controls="collapseExampleOfUse" title="Click to expand">
        ' . __t('common.example_of_use') . ' <i id="toggleIcon" class="fa-regular fa-square-plus"></i>
    </p>
    <div class="collapse pb-4" id="collapseExampleOfUse">
        <div class="bd-clipboard">
            <button id="' . $copyButtonId . '" type="button" class="btn-clipboard" data-text-copied="' . __t('common.copied') . '" onclick="copyToClipboard()">
                ' . __t('common.copy') . '
            </button>
            &nbsp;
        </div>
        <div id="' . $copyButtonId . '-code" class="code-wrapper">
            <code id="code">
                ' . highlight_file($codeFile, true) . '
            </code>
        </div>
    </div>
</div>';

    return $html;
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

function create_link(string $page, string $link, bool $disabled = false): string {
    return $disabled ? '<span class="btn-link disabled">' . $link . '</span>' : '<a class="btn-link" href="' . create_href($page) . '">' . $link . '</a>';
}

function create_href(string $page = ''): string {
    return APP_URL . $page;
}

function create_form_fields(string $section, string $subsection, string $page): string {
    $output = '<input type="hidden" name="section" value="' . $section . '" />';
    $output .= '<input type="hidden" name="subsection" value="' . $subsection . '" />';
    $output .= '<input type="hidden" name="page" value="' . $page . '" />';

    return $output;
}

function create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result = '', $showResult = true) {
    $output = '<div class="mb-1">
                <b>' . __t('common.result') . ':</b>
                <span class="float-end">' . __t('common.memory') . ': ' . memory_usage($memoryEnd, $memoryStart) . ' Mb</span>
                <span class="float-end me-2">' . __t('common.time') . ' <span class="d-xs-hide">' . __t('common.time_running') . ':</span> ' . running_time($microtimeEnd, $microtimeStart) . ' ' . __t('common.seconds_short') . '</span>
            </div>';

    if ($showResult) {
        $output .= '<code class="code-result">
                <pre>' . $result . '</pre>
            </code>';
    }

    return $output;
}

function get_current_language(): string {
    $supported = ['en', 'ru'];
    $default = 'en';

    $cookieLang = $_COOKIE['lang'] ?? '';

    if (in_array($cookieLang, $supported, true)) {
        return $cookieLang;
    }

    return $default;
}

function load_translations(string $lang): array {
    static $cache = [];

    if (isset($cache[$lang])) {
        return $cache[$lang];
    }

    $file = __DIR__ . '/lang/' . $lang . '.php';

    if (is_file($file)) {
        $cache[$lang] = include $file;
    } else {
        $cache[$lang] = [];
    }

    return $cache[$lang];
}

function __t(string $key, array $replacements = []): string {
    static $translationsByLang = [];

    $lang = get_current_language();

    if (!isset($translationsByLang[$lang])) {
        $translationsByLang[$lang] = load_translations($lang);
    }

    $translations = $translationsByLang[$lang];
    $text = $translations[$key] ?? $key;

    if ($replacements) {
        foreach ($replacements as $search => $value) {
            $text = str_replace('{' . $search . '}', (string)$value, $text);
        }
    }

    return $text;
}

function create_form_features(array $features = [], array $data = [], string $fieldName = 'features', string $type = 'checkbox', int|float $step = 1, bool $precisionCompare = false, string $class = '', string $style = '', string $event = '', int $initId = 0) {
    $output = '';
    $ind = $initId;
    $type = in_array($type, ['select', 'radio', 'checkbox', 'number']) ? $type : 'checkbox';

    if ($type === 'select') {
        $output = '<select class="form-select float-start ' . $class . '" id="select_' . $fieldName . '" name="' . $fieldName . '" ' . $event . '>';

        foreach ($features as $name => $feature) {
            if (str_starts_with($name, 'group')) {
                $label = $feature['label'] ?? '';
                $options = $feature['options'] ?? [];
                $output .= '<optgroup label="[ ' . $label . ' ]">';

                foreach ($options as $optionName => $optionValue) {
                    $output .= '<option value="' . $optionValue . '"' . (in_array($optionValue, $data) ? ' selected' : '') . '>' . $optionName . '</option>';
                }
                $output .= '</optgroup>';
            } else {
                $output .= '<option value="' . $feature . '"' . (in_array($feature, $data) ? ' selected' : '') . '>' . $name . '</option>';
            }
        }
        $output .= '</select>';
    } else {
        $totalFeatures = count($features);

        foreach ($features as $name => $feature) {
            $ind++;

            if ($type === 'number') {
                $min = min($feature);
                $max = max($feature);
                $maxLength = 5;

                // Loop through the array and compare the values - to prevent floating-point precision issues
                $found = false;

                if ($precisionCompare) {
                    foreach ($feature as $item) {
                        if (round($item, 2) === round($data[0], 2)) {
                            $found = true;
                            break;
                        }
                    }
                } else {
                    $found = in_array($data[0], $feature);
                }

                $output .= '<div class="form-check-inline mt-2 ml-0 pl-0 ' . $class . '">
                    <input class="form-inline-number" type="number" id="inlineNumber' . $ind . '" name="' . $fieldName . '" min="' . $min . '" max="' . $max . '" oninput="javascript:if (this.value.length > this.maxLength || this.value > ' . $max . ') this.value=' . $min . ';" maxlength="' . $maxLength . '" value="' . ($found ? $data[0] : '1') . '" step="' . $step . '" style="' . ($style ?: 'min-width:50px') . '">
                    <label class="form-check-label" for="inlineNumber' . $ind . '">&nbsp;' . $name . '</label>
                    </div>';
            } elseif ($type === 'radio') {
                $output .= '<div class="form-check form-check-inline mt-2 ' . $class . '">
                    <input class="form-check-input" type="radio" id="inlineRadio' . $ind . '" name="' . $fieldName . '" value="' . $feature . '"' . (in_array($feature, $data) ? ' checked' : '') . '>
                    <label class="form-check-label" for="inlineRadio' . $ind . '">' . $name . '</label>
                    </div>';
            } else {
                // Checkbox
                $output .= '<div class="form-check form-check-inline mt-1 ' . $class . '">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox' . $ind . '" name="' . $fieldName . ($totalFeatures > 1 ? '[]' : '') . '" value="' . $feature . '"' . (in_array($feature, $data) ? ' checked' : '') . '>
                    <label class="form-check-label" for="inlineCheckbox' . $ind . '">' . $name . '</label>
                    </div>';
            }
        }
    }

    return $output;
}
