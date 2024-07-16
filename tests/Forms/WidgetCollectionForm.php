<?php

declare(strict_types=1);

namespace Tests\Forms;

use ArtumiSystemsLtd\AForms\Form;
use ArtumiSystemsLtd\AForms\Widget\Checkbox;

use Workbench\App\Models\Author;

class WidgetCollectionForm extends Form
{
    public function __construct(public string $id)
    {
        $options = Author::all();
        $chosen = collect([$options[0]]);

        $this->addWidgetCollection($options, 'author', 'id', 'name', Checkbox::class);
        $this->setWidgetCollection($chosen, 'author', 'id');
        $this->addButton('ok', 'Submit');
    }
}
