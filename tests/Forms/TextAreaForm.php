<?php
declare(strict_types=1);
namespace Tests\Forms;
use Artumi\Forms\Form;
use Artumi\Forms\Widget\TextArea;

class TextAreaForm extends Form
{
    public function __construct(public string $id)
    {
        $desc = new TextArea('description','Description');
        $this->addWidget($desc);
        $this->addButton('ok','Submit');
    }

    public function validators() : array {
        return [
            'description'=>'required',
        ];
    }
}

