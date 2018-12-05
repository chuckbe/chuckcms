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
            if(file_exists(base_path('vendor/'.$template->path.'/src/views/templates/'.$template->slug.'/mails'))){
                $mailDir = array_slice(scandir(base_path('vendor/'.$template->path.'/src/views/templates/'.$template->slug.'/mails')), 2);
                if (count($mailDir) > 0) {
                    $emailTemplates[$template->slug]['hintpath'] = $template->hintpath;
                    foreach($mailDir as $mdKey => $mdValue) {
                        if (strpos($mdValue, '.blade.php')) {
                            $emailTemplates[$template->slug]['files'][] = str_replace('.blade.php', '', $mdValue);
                        }    
                    }
                }

                if(file_exists(base_path('resources/views/vendor/'.$template->slug.'/templates/'.$template->slug.'/mails'))){
                    $mailDirVendor = array_slice(scandir(base_path('resources/views/vendor/'.$template->slug.'/templates/'.$template->slug.'/mails')), 2);
                    if (count($mailDirVendor) > 0) {
                        $emailTemplates[$template->slug]['hintpath'] = $template->hintpath;
                        foreach($mailDirVendor as $mdKey => $mdValue) {
                            if (strpos($mdValue, '.blade.php')) {
                                $emailTemplates[$template->slug]['files'][] = str_replace('.blade.php', '', $mdValue);
                            }    
                        }
                    }
                }
            }
        }
        return $emailTemplates;
    }

    public function getPageViews()
    {
        $templates = $this->where('active', 1)->where('type', 'default')->get();
        $pageViews = [];
        foreach ($templates as $template) {
            if(file_exists(base_path('vendor/'.$template->path.'/src/views/templates/'.$template->slug))){
                $pageDir = array_slice(scandir(base_path('vendor/'.$template->path.'/src/views/templates/'.$template->slug)), 2);
                if (count($pageDir) > 0) {
                    $pageViews[$template->slug]['hintpath'] = $template->hintpath;
                    foreach($pageDir as $pdKey => $pdValue) {
                        if (strpos($pdValue, '.blade.php')) {
                            $pageViews[$template->slug]['files'][] = str_replace('.blade.php', '', $pdValue);
                        }    
                    }
                }
            }
            if(file_exists(base_path('resources/views/vendor/'.$template->slug.'/templates/'.$template->slug))){
                $pageDir = array_slice(scandir(base_path('resources/views/vendor/'.$template->slug.'/templates/'.$template->slug)), 2);
                if (count($pageDir) > 0) {
                    $pageViews[$template->slug]['hintpath'] = $template->hintpath;
                    foreach($pageDir as $pdKey => $pdValue) {
                        if (strpos($pdValue, '.blade.php')) {
                            $pageViews[$template->slug]['files'][] = str_replace('.blade.php', '', $pdValue);
                        }    
                    }
                }
            }
        }
        return $pageViews;
    }
}
