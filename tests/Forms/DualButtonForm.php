<?php
declare(strict_types=1);
namespace Tests\Forms;
use ArtumiSystemsLtd\AForms\Form;

class DualButtonForm extends Form
{
    public function __construct(public string $id)
    {
        $this->addButton('ok','Submit');
        $this->addButton('cancel','Cancel');

    }

    public function validators() : array {
        return [
        ];
    }
}

