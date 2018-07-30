<?php

namespace Chuckbe\Chuckcms\Models;

use Chuckbe\Chuckcms\Models\FormEntry;

use Eloquent;

class Form extends Eloquent
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'form'
    ];

    protected $casts = [
        'form' => 'array',
    ];

    public function getBySlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }

    public function getRules()
    {
        $rules = [];
        foreach($this->form['fields'] as $fieldKey => $fieldValue){
            $rules[$fieldKey] = $fieldValue['validation'];
        }
        return $rules;
    }

    public function storeEntry($input)
    {
        if($this->form['actions']['store'] == 'true'){
            $entry = new FormEntry();
            $entry->slug = $input->get('_form_slug');
            $json = [];
            foreach($this->form['fields'] as $fieldKey => $fieldValue){
                if($fieldValue['type'] !== 'file'){
                    $json[$fieldKey] = $input->get($fieldKey);
                }
            }
            if($this->form['files'] == 'true'){
                foreach($this->form['fields'] as $fieldKey => $fieldValue){
                    if($fieldValue['type'] == 'file'){
                        //@todo save input files
                    }
                }
            }
            $entry->entry = $json;
            if($entry->save()){
                return 'success';
            }
        }else {
            return 'success';
        }
    }

    public function deleteById($id)
    {
        $form = $this->where('id', $id)->first();
        if($form){
            FormEntry::where('slug', $form->slug)->delete();
            if($form->delete()){
                return 'success';
            } else {
                return 'error';
            }
        } else {
            return 'false';
        }
    }

    public function deleteBySlug($slug)
    {
        $form = $this->where('slug', $slug)->first();
        if($form){
            FormEntry::where('slug', $slug)->delete();
            if($form->delete()){
                return 'success';
            } else {
                return 'error';
            }
        } else {
            return 'false';
        }
    }

    public function getMailData($sendData, $input)
    {
        $mailData = [];
        foreach($sendData as $sendKey => $sendValue){
            $findThis = $this->getResources($sendValue, '[', ']');
            if(count($findThis) > 0){
            
                $inputSlug = $findThis[0];
                $inputData = str_replace('[' . $findThis[0] . ']', $input->get($findThis[0]), $sendValue);
                
            } else {
                $inputData = $sendValue;
            }

            $mailData[$sendKey] = $inputData;
        }
        return $mailData;
    }

    public function getResources($str, $startDelimiter, $endDelimiter) 
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
