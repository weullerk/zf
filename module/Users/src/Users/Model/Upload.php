<?php

namespace Users\Model;

class Upload
{
    public $id;
    public $filename;
    public $label;
    public $user_id;

    public function exchangeArray($data)
    {
        $this->id = isset($data['id']) ? $data['id'] : null;
        $this->filename = isset($data['filename']) ? $data['filename'] : null;
        $this->label = isset($data['label']) ? $data['label'] : null;
        $this->user_id = isset($data['user_id']) ? $data['user_id'] : null;
    }

    public function getArrayCopy() {
        $data = get_object_vars($this);
        return $data;
    }
}