<?php
declare(strict_types=1);
namespace Tests\Forms;
use Artumi\Forms\Form;

class SimpleButtonForm extends Form
{
    public function __construct(public string $id)
    {
        $this->addButton('ok','Submit');

    }
    public function validators() : array {
        return [
        ];
    }
}
