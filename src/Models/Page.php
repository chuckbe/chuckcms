<?php

namespace Chuckbe\Chuckcms\Models;

use ChuckSite;
use Chuckbe\Chuckcms\Models\Scopes\SiteScope;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;

class Page extends Eloquent implements Sortable
{
    use SortableTrait;
    use HasTranslations;

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

    public function getById($id)
    {
        return $this->where('id', $id)->first();
    }

    public function getByIdWithBlocks($id)
    {
        return $this->where('id', $id)->with('page_blocks')->first();
    }

    public static function getUrl($id)
    {
        return ChuckSite::getSetting('domain').'/'.self::where('id', $id)->first()->slug;
    }

    public function url()
    {
        return ChuckSite::getSetting('domain').'/'.$this->slug;
    }

    public function concept()
    {
        return ChuckSite::getSetting('domain').'/concept/'.$this->slug;
    }

    public function deleteById($id)
    {
        $page = $this->where('id', $id)->first();
        if ($page) {
            PageBlock::where('page_id', $page->id)->delete();
            if ($page->delete()) {
                return 'success';
            } else {
                return 'error';
            }
        } else {
            return 'false';
        }
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
