<?php
require_once 'Validation.php';

class StickyForm extends Validation {

    // Validate form based on config
    public function validateForm($data, $formConfig) {
        foreach ($formConfig as $key => &$element) {
            if ($key !== 'masterStatus') {
                // Assign sticky value
                $element['value'] = $data[$key] ?? '';

                $customErrorMsg = $element['errorMsg'] ?? null;

                // Text and textarea validation
                if (isset($element['type']) && in_array($element['type'], ['text', 'textarea']) && isset($element['regex'])) {
                    $isValid = $this->checkFormat($element['value'], $element['regex'], $customErrorMsg);
                    if (!$isValid) {
                        $element['error'] = $this->getErrors()[$element['regex']];
                        $formConfig['masterStatus']['error'] = true;
                    }
                }

                // Select dropdown validation
                if (isset($element['type']) && $element['type'] === 'select') {
                    $element['selected'] = $data[$key] ?? '';
                    if (isset($element['required']) && $element['required'] && ($element['selected'] === '0' || empty($element['selected']))) {
                        $element['error'] = $customErrorMsg ?? 'This field is required.';
                        $formConfig['masterStatus']['error'] = true;
                    }
                }

                // Radio button validation
                if (isset($element['type']) && $element['type'] === 'radio') {
                    $isChecked = false;
                    foreach ($element['options'] as &$option) {
                        $option['checked'] = ($option['value'] === ($data[$key] ?? ''));
                        if ($option['checked']) {
                            $isChecked = true;
                        }
                    }
                    if (isset($element['required']) && $element['required'] && !$isChecked) {
                        $element['error'] = $customErrorMsg ?? 'You must select an option.';
                        $formConfig['masterStatus']['error'] = true;
                    }
                }

                // Checkbox validation
                if (isset($element['type']) && $element['type'] === 'checkbox') {
                    if (isset($element['options'])) {
                        $anyChecked = false;
                        $submitted = $data[$key] ?? [];
                        foreach ($element['options'] as &$option) {
                            $option['checked'] = in_array($option['value'], $submitted);
                            if ($option['checked']) {
                                $anyChecked = true;
                            }
                        }
                        if (isset($element['required']) && $element['required'] && !$anyChecked) {
                            $element['error'] = $customErrorMsg ?? 'You must select at least one option.';
                            $formConfig['masterStatus']['error'] = true;
                        }
                    } else {
                        $element['checked'] = isset($data[$key]);
                        if (isset($element['required']) && $element['required'] && !$element['checked']) {
                            $element['error'] = $customErrorMsg ?? 'This field is required.';
                            $formConfig['masterStatus']['error'] = true;
                        }
                    }
                }
            }
        }

        return $formConfig;
    }

    // Create <option> list for select
    public function createOptions($options, $selectedValue) {
        $html = '';
        foreach ($options as $value => $label) {
            $selected = ($value == $selectedValue) ? 'selected' : '';
            $html .= "<option value=\"$value\" $selected>$label</option>";
        }
        return $html;
    }

    // Render error message
    private function renderError($element) {
        return !empty($element['error']) ? "<div class=\"text-danger\">{$element['error']}</div>" : '';
    }

    // Render text input
    public function renderInput($element) {
        $errorOutput = $this->renderError($element);
        return <<<HTML
<div class="mb-3">
    <label for="{$element['id']}" class="form-label">{$element['label']}</label>
    <input type="text" class="form-control" id="{$element['id']}" name="{$element['name']}" value="{$element['value']}">
    $errorOutput
</div>
HTML;
    }

    // Render textarea
    public function renderTextarea($element) {
        $errorOutput = $this->renderError($element);
        return <<<HTML
<div class="mb-3">
    <label for="{$element['id']}" class="form-label">{$element['label']}</label>
    <textarea class="form-control" id="{$element['id']}" name="{$element['name']}">{$element['value']}</textarea>
    $errorOutput
</div>
HTML;
    }

    // Render select dropdown
    public function renderSelect($element) {
        $errorOutput = $this->renderError($element);
        $optionsHtml = $this->createOptions($element['options'], $element['selected']);
        return <<<HTML
<div class="mb-3">
    <label for="{$element['id']}" class="form-label">{$element['label']}</label>
    <select class="form-select" id="{$element['id']}" name="{$element['name']}">
        $optionsHtml
    </select>
    $errorOutput
</div>
HTML;
    }

    // Render radio buttons
    public function renderRadio($element) {
        $errorOutput = $this->renderError($element);
        $optionsHtml = '';
        foreach ($element['options'] as $option) {
            $checked = $option['checked'] ? 'checked' : '';
            $optionsHtml .= <<<HTML
<div class="form-check">
    <input class="form-check-input" type="radio" id="{$element['id']}_{$option['value']}" name="{$element['name']}" value="{$option['value']}" $checked>
    <label class="form-check-label" for="{$element['id']}_{$option['value']}">{$option['label']}</label>
</div>
HTML;
        }
        return <<<HTML
<div class="mb-3">
    <label>{$element['label']}</label><br>
    $optionsHtml
    $errorOutput
</div>
HTML;
    }
}
?>
