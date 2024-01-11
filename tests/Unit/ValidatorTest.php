<?php
declare(strict_types=1);
use Tests\TestCase;
use Artumi\Forms\Widget\TextArea;
use Tests\Forms\ValidateTextAreaForm;

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
