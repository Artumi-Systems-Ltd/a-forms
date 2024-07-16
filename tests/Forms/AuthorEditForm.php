<?php

declare(strict_types=1);

namespace Tests\Forms;

use ArtumiSystemsLtd\AForms\Form;
use ArtumiSystemsLtd\AForms\Widget\Text;
use Workbench\App\Models\Author;


class AuthorEditForm extends Form
{
    public function __construct(public string $id, Author $author)
    {
        $name = new Text('name', 'Name');
        $name->setUnique('authors', $author->id);
        $name->setRequired(true);
        $this->addWidget($name);

        $image = new Text('image', 'Image');
        $image->setRequired(true);
        $this->addWidget($image);

        $this->addButton('ok', 'Submit');
    }
}
