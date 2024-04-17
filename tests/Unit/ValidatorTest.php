<?php
declare(strict_types=1);
use Tests\TestCase;
use Tests\Forms\ValidateTextAreaForm;

class ValidatorTest extends TestCase
{
    public function testNotNull() : void
    {
        $form  = new ValidateTextAreaForm('frmValidateTextArea');
        $form->populateFromArray(['description'=>'some text','ok'=>'']);
        $this->assertTrue($form->validate(), 'Form is valid');
        $form->populateFromArray(['description'=>'','ok'=>'']);
        $this->assertFalse($form->validate(), 'Form is invalid');
    }
}
