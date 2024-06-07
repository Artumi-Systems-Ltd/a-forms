<?php
declare(strict_types=1);
namespace Tests\Forms;
use ArtumiSystemsLtd\AForms\Form;
use ArtumiSystemsLtd\AForms\Widget\Checkbox;

class CheckboxForm extends Form
{
    public function __construct(public string $id)
    {
        $active = new Checkbox('active','Active');
        $this->addWidget($active);
        $this->addButton('ok','Submit');
    }

    public function validators() : array {
        return [
            'active'=>'required',
        ];
    }
}
