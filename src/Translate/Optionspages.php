<?php

namespace Framework\Translate;

class Optionspages
{

    const DEFAULT_LOCALE = 'en_US';

    public function __construct()
    {
        add_filter('acf/settings/current_language', [$this, 'getCurrentLang'], 77);
        add_filter('acf/load_value', [$this, 'setDefaultValue'], 10, 3);
        add_action('admin_notices', [$this, 'showAdminNotice'], 77);
        add_action('admin_init', [$this, 'disableTranslate']);
    }

    /* ---
      Functions
    --- */

    public function getCurrentLang()
    {
        $lang = function_exists('pll_current_language') ? pll_current_language('locale') : null;
        return $lang ?: self::DEFAULT_LOCALE;
    }

    public function setDefaultValue($value, $postId, $field)
    {
        if (is_null($postId) || (function_exists('str_contains') ? !str_contains($postId, 'options') : strpos($postId, 'options') === false)) {
            return $value;
        }

        if (!is_null($value)) {
            if (is_array($value)) {
                $isEmpty = array_filter($value, function ($content) {
                    return $content !== '';
                });
                if (!empty($isEmpty)) {
                    return $value;
                }
            } else {
                if ($value !== '') {
                    return $value;
                }
            }
        }

        remove_filter('acf/settings/current_language', [$this, 'getCurrentLang'], 77);
        remove_filter('acf/load_value', [$this, 'setDefaultValue'], 10);

        $value = get_field($field['name'], 'option');

        add_filter('acf/settings/current_language', [$this, 'getCurrentLang'], 77);
        add_filter('acf/load_value', [$this, 'setDefaultValue'], 10, 3);

        return $value;
    }

    public function showAdminNotice()
    {
        if (!isset($_GET['page'])
            || !function_exists('pll_current_language')
            || !in_array($_GET['page'], apply_filters('wpf_acf_optionspage', []))) {
            return;
        }

        ?>
        <div class="notice notice-info">
            <p><?php
                echo __('Remember that settings saved on this page apply only to currently selected language. Change it using switch on top bar to configure settings for other languages.',
                    'wpf'); ?></p>
        </div>
        <?php
    }

    public function disableTranslate()
    {
        if (!isset($_GET['page'])
            || !in_array($_GET['page'], apply_filters('wpf_acf_optionspage_notranslate', []))) {
            return;
        }

        remove_all_filters('acf/settings/current_language', 77);
        remove_all_filters('admin_notices', 77);
    }
}
