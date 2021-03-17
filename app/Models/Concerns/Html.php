<?php

namespace App\Models\Concerns;

trait Html
{
    /**
     * DOM id scoped by the record's id.
     * 
     * @return string
     */
    function domId()
    {
        return $this->getTable() . '_' . $this->id;
    }
}
