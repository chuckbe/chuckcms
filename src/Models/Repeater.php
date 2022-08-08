<?php

namespace Chuckbe\Chuckcms\Models;

use Eloquent;
use Chuckbe\Chuckcms\Models\Scopes\SiteScope;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $slug
 * @property string $url
 * @property string $page
 * @property array  $json
 */
class Repeater extends Eloquent
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'url', 'page', 'json',
    ];

    protected $casts = [
        'json' => 'array',
    ];
    
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
 
        static::addGlobalScope(new SiteScope);
    }

    public function getJson(string $string)
    {
        $json = $this->resolveJson($string);

        return !is_null($json) ? $json : null;
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
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key) ?? $this->getJson($key);
    }
}
