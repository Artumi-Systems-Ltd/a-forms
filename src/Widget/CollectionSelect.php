<?php

namespace ArtumiSystemsLtd\AForms\Widget;

use ArtumiSystemsLtd\AForms\Widget;
use ArtumiSystemsLtd\AForms\Option;
use Illuminate\Support\Collection;

class CollectionSelect extends Select
{
    public $options;

    public function setCollectionOptions(Collection $collection, string $idField = 'id', string $nameField = 'name')
    {
        $this->options = [];
        foreach ($collection as $item) {
            $this->options[$item[$idField]] = new Option($item[$idField], $item[$nameField]);
        }
    }
}
