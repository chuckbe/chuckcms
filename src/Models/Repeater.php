<?php

namespace Chuckbe\Chuckcms\Models;

use Eloquent;

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
            if(array_key_exists($value, $json)) {
                $json = $json[$value];
            } else {
                return null;
            }
        }

        return $json;
    }
}
