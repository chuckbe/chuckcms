<?php

namespace Chuckbe\Chuckcms\Chuck;

use Chuckbe\Chuckcms\Models\Resource;
use Chuckbe\Chuckcms\Models\Repeater;

use App\Http\Requests;

class PageBlockRepository
{
    public function getRenderedByPageBlocks($ogpageblocks)
    {
        $pageblocks = [];
        foreach($ogpageblocks as $pageblock){
            $findThis = $this->getResources($pageblock->body, '[', ']');
            // THERE ARE DYNAMICS IN THIS PAGEBLOCK, LET'S RETRIEVE IT
            if(count($findThis) > 0){
                // PAGEBLOCK CONTAINS A LOOP, LET'S RETRIEVE IT
                if (strpos($findThis[0], 'LOOP') !== false) {
                    $repeater_slug = implode(" ",$this->getResources($pageblock->body, '[LOOP=', ']'));
                    $repeater_body = implode(" ",$this->getResources($pageblock->body, '[LOOP='.$repeater_slug.']', '[/LOOP]'));
                    
                    $newbody = str_replace('[LOOP='.$repeater_slug.']'.$repeater_body.'[/LOOP]',$this->getRepeaterContents($repeater_slug, $repeater_body),$pageblock->body);

                // THERE IS NO LOOP, SO JUST RETRIEVE THE DYNAMIC CONTENT
                } else{
                    $newbody = $this->getResourceContent($findThis, $pageblock->id, $pageblock->body);//Maybe write a function in the model?    
                }
            } else {
                $newbody = $pageblock->body;
            }
            $pageblocks[] = array(
                'id' => $pageblock->id,
                'page_id' => $pageblock->page_id,
                'name' => $pageblock->name,
                'slug' => $pageblock->slug,
                'body' => $newbody,
                'raw' => $pageblock->body,
                'order' => $pageblock->order
                );
        }
        return $pageblocks;
    }

    public function getRenderedByPageBlock($pageblock)
    {   
        $findThis = $this->getResources($pageblock->body, '[', ']');
        // THERE ARE DYNAMICS IN THIS PAGEBLOCK, LET'S RETRIEVE IT
        if(count($findThis) > 0){
            // PAGEBLOCK CONTAINS A LOOP, LET'S RETRIEVE IT
            if (strpos($findThis[0], 'LOOP') !== false) {
                $repeater_slug = implode(" ",$this->getResources($pageblock->body, '[LOOP=', ']'));
                $repeater_body = implode(" ",$this->getResources($pageblock->body, '[LOOP='.$repeater_slug.']', '[/LOOP]'));
                
                $newbody = str_replace('[LOOP='.$repeater_slug.']'.$repeater_body.'[/LOOP]',$this->getRepeaterContents($repeater_slug, $repeater_body),$pageblock->body);

            // THERE IS NO LOOP, SO JUST RETRIEVE THE DYNAMIC CONTENT
            } else{
                $newbody = $this->getResourceContent($findThis, $pageblock->id, $pageblock->body);  
            }
        } else {
            $newbody = $pageblock->body;
        }
        $new_pageblock = array(
            'id' => $pageblock->id,
            'page_id' => $pageblock->page_id,
            'name' => $pageblock->name,
            'slug' => $pageblock->slug,
            'body' => $newbody,
            'raw' => $pageblock->body
        );
        
        return $new_pageblock;
    }

    public function updateBody($pageblock, $html)
    {
        $pageblock->body = $html;
        $pageblock->update();
        return $this->getRenderedByPageBlock($pageblock);
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

    public function getResourceContent($resources, $page_block_id, $page_block_body)
    {
        $body = $page_block_body;
        foreach($resources as $resource){
            $res_arr = explode('+', $resource);
            $res_slug = (string)$res_arr[0];
            $res_json = (string)$res_arr[1];
            $res_object = Resource::where('page_block_id', $page_block_id)->where('slug', $res_slug)->first();
            $json = $res_object->json;
            $match = $json[$res_json];
            $body = str_replace('[' . $res_slug . '+' . $res_json . ']', $match, $body);
        }
        return $body;
    }

    public function getRepeaterContents($repeater_slug, $page_block_body)
    {
        $slug = $repeater_slug;
        if (strpos($repeater_slug, ' LIMIT=') !== false) {
            $explode = explode(' LIMIT=', $repeater_slug);
            $slug = $explode[0];
            $limit = (int)$explode[1];
            $contents = Repeater::where('slug', $slug)->limit($limit)->get();
        } else {
            $contents = Repeater::where('slug', $slug)->get();
        }
        $resources = $this->getResources($page_block_body, '[' . $slug . '+', ']');
        $new_body = [];
        foreach($contents as $content){
            $body = $page_block_body;
            foreach ($resources as $resource) {
                $json = $content->json;
                $match = $json[$resource];
                $body = str_replace('[' . $slug . '+' . $resource . ']', $match, $body);
            }
            $new_body[] = $body;
        }
        $str_body = implode(" ", $new_body);
        return $str_body;
    }

    public function moveUpById($id)
    {
        $pageblock = $this->find($id);
        $og_order = $pageblock->order;
        $target_pb = $this->where('page_id', $pageblock->page_id)->where('order', ($og_order - 1))->first();

        $pageblock->order = $og_order - 1;
        $target_pb->order = $og_order;

        $pageblock->update();
        $target_pb->update();
        return $this->getRenderedById($pageblock->id);
    }

    public function moveDownById($id)
    {
        $pageblock = $this->find($id);
        $og_order = $pageblock->order;
        $target_pb = $this->where('page_id', $pageblock->page_id)->where('order', ($og_order + 1))->first();

        $pageblock->order = $og_order + 1;
        $target_pb->order = $og_order;

        $pageblock->update();
        $target_pb->update();
        return $this->getRenderedById($pageblock->id);
    }

    public function moveOrderDownByPageId($id)
    {
        $pageblocks = $this->where('page_id', $id)->increment('order');
    }

    public function addBlockTop($contents, $page)
    {
        $this->moveOrderDownByPageId($page->id);
        $pageblock = new PageBlock();
        $pageblock->page_id = $page->id;
        $pageblock->name = "Dit is een test";
        $pageblock->slug = "slug3";
        $pageblock->body = $contents;
        $pageblock->order = 1;
        $pageblock->save();
        return $pageblock;
    }
}
