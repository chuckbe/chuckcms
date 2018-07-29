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
}
