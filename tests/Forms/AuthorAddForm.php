<?php

declare(strict_types=1);

namespace Tests\Forms;

use ArtumiSystemsLtd\AForms\Form;
use ArtumiSystemsLtd\AForms\Widget\Text;


class AuthorAddForm extends Form
{
    public function __construct(public string $id)
    {
        $name = new Text('name', 'Name');
        $name->setUnique('authors');
        $name->setRequired(true);
        $this->addWidget($name);

        $image = new Text('image', 'Image');
        $image->setRequired(true);
        $this->addWidget($image);


        $this->addButton('ok', 'Submit');
    }
}
