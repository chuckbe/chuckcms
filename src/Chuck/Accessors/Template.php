<?php

namespace Chuckbe\Chuckcms\Chuck\Accessors;

use Chuckbe\Chuckcms\Models\Template as TemplateModel;

class Template
{
    private $template;
    private $templateSettings;

    public function __construct($template = null)
    {
        $this->template = $this->getCurrentTemplate($template);
        $this->templateSettings = $this->getCurrentSettings($this->template);
    }

    public static function forTemplate(string $template)
    {
        return new static($template);
    }

    private function getCurrentSettings(TemplateModel $template_model)
    {
        return $template_model->json;
    }

    private function getCurrentTemplate($template_slug)
    {
        if (is_null($template_slug)) {
            $template = TemplateModel::where('active', true)->where('type', 'default')->first();
        } else {
            $template = TemplateModel::where('slug', $template_slug)->first();
        }

        if (is_null($template)) {
            throw new Exception('Whoops! No Template Defined...');
        }

        return $template;
    }

    public function getSetting($var)
    {
        $setting = $this->resolveSetting($var, $this->templateSettings);

        return !is_null($setting) ? $setting : null;
    }

    private function resolveSetting($var, $settings)
    {
        if (array_key_exists($var, $settings)) {
            $setting = $settings[$var]['value'];
        } else {
            return null;
        }

        return $setting;
    }
}
