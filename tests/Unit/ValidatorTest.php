<?php
declare(strict_types=1);
use Tests\TestCase;
use Artumi\Forms\Form;
use Artumi\Forms\Widget\TextArea;

class ValidateTextAreaForm extends Form
{
    public function __construct(public string $id)
    {
        $desc = new TextArea('description','Description');
        $this->addWidget($desc);
        $this->addButton('ok','Submit');
    }
    public function validators() : array
    {
        return [
            'description'=>'required'
        ];
    }
}

class ValidatorTest extends TestCase
{
    public function testNotNull() : void
    {
        $form  = new ValidateTextAreaForm('frmValidateTextArea');
        $form->populate(['description'=>'some text','ok'=>'']);
        $this->assertTrue($form->validate(['description'=>'true']), 'Form is valid');
        $form->populate(['description'=>'','ok'=>'']);
        $this->assertFalse($form->validate(['description'=>'true']), 'Form is invalid');
    }
}
