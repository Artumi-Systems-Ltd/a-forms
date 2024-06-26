<?php
declare(strict_types=1);
namespace Tests\Forms ;

use ArtumiSystemsLtd\AForms\Form;
use ArtumiSystemsLtd\AForms\Widget\Date;

class DateForm extends Form
{
    public function __construct(public string $id)
    {
        $this->addWidget(new Date('startdate','Start Date'));
        $this->addButton('ok','Submit');
    }
    public function validators() : array {
        return [
            'startdate'=>'required',
        ];
    }
}
