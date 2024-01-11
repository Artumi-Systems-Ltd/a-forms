<?php
declare(strict_types=1);
namespace Tests\Forms;
use Artumi\Forms\Form;
use Artumi\Forms\Widget\Text;

class TextInputForm extends Form
{
    public function __construct(public string $id)
    {
        $this->addWidget(new Text('name','Name'));
        $this->addButton('ok','Submit');
    }
    public function validators() : array {
        return [
            'name'=>'required',
        ];
    }
}
