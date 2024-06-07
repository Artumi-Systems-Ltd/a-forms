<?php
declare(strict_types=1);
namespace Tests\Forms;
use ArtumiSystemsLtd\AForms\Form;
use ArtumiSystemsLtd\AForms\Widget\Select;

class SelectForm extends Form
{
    public function __construct(public string $id)
    {
        $colour = new Select('colour','Colour');
        $colour->staticOptions(['red'=>'Red','blue'=>'Blue','green'=>'Green']);
        $this->addWidget($colour);
        $this->addButton('ok','Submit');
    }

    public function validators() : array {
        return [
            'colour'=>'required',
        ];
    }
}
