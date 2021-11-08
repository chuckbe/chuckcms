<?php

namespace Chuckbe\Chuckcms\Models;

use Eloquent;

/**
 * @property array $form
 */
class Form extends Eloquent
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'form',
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
        foreach ($this->form['fields'] as $fieldKey => $fieldValue) {
            $rules[$fieldKey] = $fieldValue['validation'];
        }
        $rules['chuck_telephone'] = 'honeypot';
        $rules['chuck_email'] = 'required|honeytime:12';

        return $rules;
    }

    public function storeEntry($input)
    {
        if ($this->form['actions']['store'] == 'true' || $this->form['actions']['store'] == true) {
            $entry = new FormEntry();
            $entry->slug = $input->get('_form_slug');
            $json = [];
            foreach ($this->form['fields'] as $fieldKey => $fieldValue) {
                if ($fieldValue['type'] !== 'file') {
                    $json[$fieldKey] = $input->get($fieldKey);
                }
            }
            if ($this->form['files'] == 'true') {
                foreach ($this->form['fields'] as $fieldKey => $fieldValue) {
                    if ($fieldValue['type'] == 'file') {
                        if ($input->hasFile($fieldKey)) {
                            $avatar = $input->file($fieldKey);
                            $random = str_random(8);
                            $filename = time().'_'.$random.'.'.$avatar->getClientOriginalExtension();
                            if (!file_exists(public_path('/files/uploads/'))) {
                                mkdir(public_path('/files/uploads/'), 0777, true);
                            }
                            $avatar->move(public_path('/files/uploads/'), $filename);
                            $filepath = '/files/uploads/'.$filename;
                        } else {
                            $filepath = null;
                        }
                        $json[$fieldKey] = $filepath;
                    }
                }
            }
            $entry->entry = $json;
            if ($entry->save()) {
                return $entry;
            } else {
                return 'error';
            }
        } else {
            return 'pass';
        }
    }

    public function deleteById($id)
    {
        $form = $this->where('id', $id)->first();
        if ($form) {
            FormEntry::where('slug', $form->slug)->delete();
            if ($form->delete()) {
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
        if ($form) {
            FormEntry::where('slug', $slug)->delete();
            if ($form->delete()) {
                return 'success';
            } else {
                return 'error';
            }
        } else {
            return 'false';
        }
    }

    public function getMailData($sendData, $input, $entry)
    {
        $mailData = [];
        foreach ($sendData as $sendKey => $sendValue) {
            $findThis = $this->getResources($sendValue, '[', ']');
            if (count($findThis) > 0) {
                foreach ($findThis as $founded) {
                    if (strpos($founded, $input->get('_form_slug')) !== false) {
                        $sendValue = str_replace('['.$founded.']', $input->get($founded), $sendValue);
                    }
                }
                $inputData = $sendValue;
            } else {
                $inputData = $sendValue;
            }

            $mailData[$sendKey] = $inputData;
            if ($sendKey == 'files' && $sendValue == 'true') {
                $mailData[$sendKey] = [];
                foreach ($this->form['fields'] as $fKey => $fValue) {
                    if ($fValue['type'] == 'file') {
                        $mailData[$sendKey][] = $entry->entry[$fKey];
                    }
                }
            }
        }

        return $mailData;
    }

    public function getResources($str, $startDelimiter, $endDelimiter)
    {
        $contents = [];
        $startDelimiterLength = strlen($startDelimiter);
        $endDelimiterLength = strlen($endDelimiter);
        $startFrom = 0;
        $contentStart = 0;
        $contentEnd = 0;
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
