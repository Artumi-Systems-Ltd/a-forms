<?php
declare(strict_types=1);
namespace Tests\Forms;
use ArtumiSystemsLtd\AForms\Form;
use ArtumiSystemsLtd\AForms\Widget\PasswordCreate;

class PasswordCreateForm extends Form
{
    public function __construct(public string $id)
    {
        $pass = new PasswordCreate('password','Enter new Password');
        $pass->setRequired(true);
        $this->addWidget($pass);
        $this->addButton('ok','Submit');
    }
}

