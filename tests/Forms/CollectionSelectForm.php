<?php

declare(strict_types=1);

namespace Tests\Forms;

use ArtumiSystemsLtd\AForms\Form;
use ArtumiSystemsLtd\AForms\Widget\CollectionSelect;

class CollectionSelectForm extends Form
{
    public function __construct(public string $id)
    {
        $colour = new CollectionSelect('colour', 'Colour');
        $collection = collect([
            ['id' => 1, 'name' => 'Option 1'],
            ['id' => 2, 'name' => 'Option 2'],
            ['id' => 3, 'name' => 'Option 3'],
            ['id' => 4, 'name' => 'Option 4'],
        ]);
        $colour->setCollectionOptions($collection);
        $this->addWidget($colour);
        $this->addButton('ok', 'Submit');
    }

    public function validators(): array
    {
        return [
            'colour' => 'required',
        ];
    }
}
