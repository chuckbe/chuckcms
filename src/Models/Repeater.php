<?php

namespace Chuckbe\Chuckcms\Models;

use Eloquent;

/**
 * @property string $slug
 * @property string $url
 * @property string $page
 * @property array $json
 */
class Repeater extends Eloquent
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'url', 'page', 'json'
    ];

    protected $casts = [
        'json' => 'array',
    ];

    public function getJson(string $string)
    {
        $json = $this->resolveJson($string);
        return $json ? $json : null;
    }

    private function resolveJson($var)
    {
        $json = $this->json;
        $split = explode('.', $var);
        foreach ($split as $value) {
            if (array_key_exists($value, $json)) {
                $json = $json[$value];
            } else {
                return null;
            }
        }

        return $json;
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key) ?? $this->getJson($key);
    }
}
