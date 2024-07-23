<?php

namespace ArtumiSystemsLtd\AForms\Widget;

class ModelSelect extends CollectionSelect
{
    public $options;

    public function setModel(string $className, string $idField = 'id', string $nameField = 'name'): void
    {
        $this->setCollectionOptions($className::select([$idField, $nameField])->get());
    }
}
