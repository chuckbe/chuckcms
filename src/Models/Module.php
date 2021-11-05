<?php

namespace Chuckbe\Chuckcms\Models;

use Eloquent;

class Module extends Eloquent
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'hintpath', 'path', 'type', 'version', 'author', 'json',
    ];

    /**
     * The attributes that are castable.
     *
     * @var array
     */
    protected $casts = [
        'json' => 'array',
    ];

    public function getSettingsAttribute()
    {
        if (array_key_exists('settings', $this->json)) {
            return $this->json['settings'];
        }

        if (!array_key_exists('admin', $this->json)) {
            return [];
        }

        if (!array_key_exists('settings', $this->json['admin'])) {
            return [];
        }

        return $this->json['admin']['settings'];
    }

    public function getSetting(string $string)
    {
        $setting = $this->resolveSetting($string);

        return !is_null($setting) ? $setting : null;
    }

    private function resolveSetting($var)
    {
        $setting = $this->settings;
        $split = explode('.', $var);
        foreach ($split as $value) {
            if (array_key_exists($value, $setting)) {
                $setting = $setting[$value];
            } else {
                return null;
            }
        }

        return $setting;
    }
}
