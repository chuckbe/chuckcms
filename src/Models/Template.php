<?php

namespace Chuckbe\Chuckcms\Models;

use Eloquent;
use Illuminate\Http\Request;

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
        $activeTemplates = $this->where('active', 1)->get()
        ->filter(function($temp){
            if(strstr($temp->type, 'ecommerce') || strstr($temp->type,'default')){
                return $temp;
            }
            return;
        });
        // $templates = $this->where('active', 1)->where('type', 'default')->get();
        
        $emailTemplates = [];
        foreach ($activeTemplates as $template) {
            if (file_exists(base_path('vendor/' . $template->path . '/src/views/templates/' . $template->slug . '/mails'))) {
                $mailDir = array_slice(scandir(base_path('vendor/' . $template->path . '/src/views/templates/' . $template->slug . '/mails')), 2);
                if (count($mailDir) > 0) {
                    $emailTemplates[$template->slug]['hintpath'] = $template->hintpath;
                    foreach ($mailDir as $mdKey => $mdValue) {
                        if (strpos($mdValue, '.blade.php')) {
                            $emailTemplates[$template->slug]['files'][] = str_replace('.blade.php', '', $mdValue);
                        }    
                    }
                }
            }
            if (file_exists(base_path('resources/views/vendor/' . $template->slug . '/templates/' . $template->slug . '/mails'))) {
                $mailDirVendor = array_slice(scandir(base_path('resources/views/vendor/' . $template->slug . '/templates/' . $template->slug . '/mails')), 2);
                if (count($mailDirVendor) > 0) {
                    $emailTemplates[$template->slug]['hintpath'] = $template->hintpath;
                    foreach ($mailDirVendor as $mdKey => $mdValue) {
                        if (strpos($mdValue, '.blade.php')) {
                            $emailTemplates[$template->slug]['files'][] = str_replace('.blade.php', '', $mdValue);
                        }    
                    }
                }
            }
        }
        return $emailTemplates;
    }

    public function getPageViews()
    {
        $templates = $this->where('active', 1)->get();
        $pageViews = [];
        foreach ($templates as $template) {
            if (file_exists(base_path('packages/' . $template->path . '/src/views/templates/' . $template->slug))) {
                $pageDir = array_slice(scandir(base_path('packages/' . $template->path . '/src/views/templates/' . $template->slug)), 2);
                if (count($pageDir) > 0) {
                    $pageViews[$template->slug]['hintpath'] = $template->hintpath;
                    foreach ($pageDir as $pdKey => $pdValue) {
                        if (strpos($pdValue, '.blade.php')) {
                            $pageViews[$template->slug]['files'][] = str_replace('.blade.php', '', $pdValue);
                        }    
                    }
                }
            }
            if (file_exists(base_path('vendor/' . $template->path . '/src/views/templates/' . $template->slug))) {
                $pageDir = array_slice(scandir(base_path('vendor/' . $template->path . '/src/views/templates/' . $template->slug)), 2);
                if (count($pageDir) > 0) {
                    $pageViews[$template->slug]['hintpath'] = $template->hintpath;
                    foreach ($pageDir as $pdKey => $pdValue) {
                        if (strpos($pdValue, '.blade.php')) {
                            $pageViews[$template->slug]['files'][] = str_replace('.blade.php', '', $pdValue);
                        }    
                    }
                }
            }
            if (file_exists(base_path('resources/views/vendor/' . $template->slug . '/templates/' . $template->slug))) {
                $pageDir = array_slice(scandir(base_path('resources/views/vendor/' . $template->slug . '/templates/' . $template->slug)), 2);
                if (count($pageDir) > 0) {
                    $pageViews[$template->slug]['hintpath'] = $template->hintpath;
                    foreach ($pageDir as $pdKey => $pdValue) {
                        if (strpos($pdValue, '.blade.php')) {
                            $pageViews[$template->slug]['files'][] = str_replace('.blade.php', '', $pdValue);
                        }    
                    }
                }
            }
        }
        return $pageViews;
    }

    public function updateFromRequest(Request $request)
    {
        $template = $this->where('id', $request->template_id)->first();

        $template->name = $request->template_name;

        $fonts = [];
        $fonts['raw'] = $request->template_fonts;
        $template->fonts = $fonts;

        $css = [];
        $countCss = count($request->css_slug);
        for ($i=0; $i < $countCss; $i++) { 
            $css[$request->css_slug[$i]]['href'] = $request->css_href[$i];
            $css[$request->css_slug[$i]]['asset'] = $request->css_asset[$i] == 1 ? 'true' : 'false';
        }

        $template->css = $css;

        $js = [];
        $countJs = count($request->js_slug);
        for ($k=0; $k < $countJs; $k++) { 
            $js[$request->js_slug[$k]]['href'] = $request->js_href[$k];
            $js[$request->js_slug[$k]]['asset'] = $request->js_asset[$k] == 1 ? 'true' : 'false';
        }

        $template->js = $js;

        $json = $template->json;
        if (count($json) > 0) {
            foreach ($request->json_slug as $jsonKey => $jsonValue) { 
                $json[$jsonKey]['value'] = $jsonValue;
            }

            $template->json = $json;
        }

        $template->update();
    }
}
