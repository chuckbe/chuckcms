<?php

namespace Chuckbe\Chuckcms\Models;

use Chuckbe\Chuckcms\Models\Repeater;

use Eloquent;

class Content extends Eloquent
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'type', 'content'
    ];

    protected $casts = [
        'content' => 'array',
    ];

    public function getBySlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }

    public function getRules()
    {
        $rules = [];
        foreach($this->content['fields'] as $fieldKey => $fieldValue){
            $rules[$fieldKey] = $fieldValue['validation'];
        }
        return $rules;
    }

    public function storeEntry($input)
    {
        $slug = $input->get('content_slug');
        $url = $this->getUrlFromInput($this->content['actions']['store']['detail']['url'], $input);
        $page = $this->content['actions']['store']['detail']['page'];
        
        $json = [];
        foreach($this->content['fields'] as $fieldKey => $fieldValue){
            if($fieldValue['type'] !== 'file'){
                $cleanKey = str_replace($slug.'_', '', $fieldKey);
                $json[$cleanKey] = $input->get($fieldKey);
            }
        }
        
        if($this->content['files'] == 'true'){
            foreach($this->content['fields'] as $fieldKey => $fieldValue){
                if($fieldValue['type'] == 'file'){
                    //@todo save input files
                }
            }
        }
        
        Repeater::updateOrCreate(
            ['id' => $input->get('repeater_id')],
            ['slug' => $slug,
            'url' => $url,
            'page' => $page,
            'json' => $json
        ]);
        
        return 'success';
    }

    public function deleteById($id)
    {
        $repeater = Repeater::where('id', $id)->first();
        
        if($repeater->delete()){
            return 'success';
        } else {
            return 'error';
        }
    }

    public function getUrlFromInput($url, $input)
    {
        $fields = $this->getContents($url, '[', ']');
        $finalUrl = $url;
        foreach($fields as $field){
            $finalUrl = str_replace('['.$field.']', $input->get($field), $finalUrl)
        }
        return $finalUrl;
    }

    public function getContents($str, $startDelimiter, $endDelimiter) 
    {
        $contents = array();
        $startDelimiterLength = strlen($startDelimiter);
        $endDelimiterLength = strlen($endDelimiter);
        $startFrom = $contentStart = $contentEnd = 0;
        while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
        $contentStart += $startDelimiterLength;
        $contentEnd = strpos($str, $endDelimiter, $contentStart);
        if (false === $contentEnd) {
          break;
        }
        $contents[] = substr($str, $contentStart, $contentEnd - $contentStart);
        $startFrom = $contentEnd + $endDelimiterLength;
        }

        return $contents;
    }
}
