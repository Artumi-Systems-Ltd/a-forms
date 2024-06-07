<?php
declare(strict_types=1);
namespace Tests\Forms;
use ArtumiSystemsLtd\AForms\Form;

use ArtumiSystemsLtd\AForms\Widget\RadioFieldset;

class RadioFieldsetForm extends Form
{
    public function __construct(public string $id)
    {
        $type= new RadioFieldset('type','Type');
        $type->staticOptions(['new'=>'New','old'=>'Old','archive'=>'Archive']);
        $this->addWidget($type);
        $this->addButton('ok','Submit');
    }
    public function validators() : array {
        return [
            'type'=>'required',
        ];
    }
}

