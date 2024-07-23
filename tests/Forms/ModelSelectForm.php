<?php

declare(strict_types=1);

namespace Tests\Forms;

use ArtumiSystemsLtd\AForms\Form;
use ArtumiSystemsLtd\AForms\Widget\ModelSelect;
use Workbench\App\Models\Author;

class ModelSelectForm extends Form
{
    public function __construct(public string $id)
    {
        $author = new ModelSelect('author', 'Author');
        $author->setModel(Author::class);
        $this->addWidget($author);
        $this->addButton('ok', 'Submit');
    }

    public function validators(): array
    {
        return [
            'author' => 'required',
        ];
    }
}
