<?php

namespace Chuckbe\Chuckcms\Chuck\Accessors;

use Chuckbe\Chuckcms\Chuck\RepeaterRepository;
use Chuckbe\Chuckcms\Models\Repeater as RepeaterModel;

class Repeater
{
    private $repeaterRepository;
    private $repeater;

    public function __construct(RepeaterModel $repeater, RepeaterRepository $repeaterRepository)
    {
        $this->repeater = $repeater;
        $this->repeaterRepository = $repeaterRepository;
    }

    public function for(string $string)
    {
        return $this->repeater->where('slug', $string)->get();
    }

    public function find($id)
    {
        return $this->repeater->where('id', $id)->first();
    }
}
