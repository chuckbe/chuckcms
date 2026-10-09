<?php

namespace Chuckbe\Chuckcms\Models;

use ChuckSite;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;

class Page extends Model implements Sortable
{
    use SortableTrait;
    use HasTranslations;

    public $sortable = [
        'order_column_name'  => 'order',
        'sort_when_creating' => true,
    ];

    public function template()
    {
        return $this->belongsTo('Chuckbe\Chuckcms\Models\Template');
    }

    public function page_blocks()
    {
        return $this->hasMany('Chuckbe\Chuckcms\Models\PageBlock')->orderBy('order');
    }

    public function getByIdWithBlocks($id)
    {
        return $this->where('id', $id)->with('page_blocks')->first();
    }

    public static function getUrl($id)
    {
        return ChuckSite::getSetting('domain').'/'.self::where('id', $id)->first()->slug;
    }

    public $translatable = ['title', 'slug'];

    protected $casts = [
        'meta' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_column',
    ];
}
