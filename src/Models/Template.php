<?php

namespace Chuckbe\Chuckcms\Models;

use Eloquent;

class Template extends Eloquent
{
    public function pages(){
    	return $this->hasMany('Chuckbe\Chuckcms\Models\Page');
    }

    protected $casts = [
        'fonts' => 'array',
        'css' => 'array',
        'js' => 'array',
        'json' => 'array'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'hintpath', 'path', 'type', 'version', 'author', 'active', 'fonts', 'css', 'js', 'json'
    ];

    public function getEmailTemplates()
    {
        $templates = $this->where('active', 1)->where('type', 'default')->get();
        $emailTemplates = [];
        foreach ($templates as $template) {
            $mailDir = array_slice(scandir(base_path('vendor/'.$template->path.'/src/views/templates/'.$template->slug.'/mails')), 2);
            if (count($mailDir) > 0) {
                $emailTemplates[$template->slug]['hintpath'] = $template->hintpath;
                foreach($mailDir as $mdKey => $mdValue) {
                    if (strpos($mdValue, '.blade.php')) {
                        $emailTemplates[$template->slug]['files'][] = str_replace('.blade.php', '', $mdValue);
                    }    
                }
            }
        }
        return $emailTemplates;
    }
}
