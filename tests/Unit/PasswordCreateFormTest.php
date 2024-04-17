<?php
declare(strict_types=1);
use Tests\TestCase;
use Tests\Forms\PasswordCreateForm;

class PasswordCreateFormTest extends TestCase
{
    public function testPopulate() : void
    {
        $form = new PasswordCreateForm('frmPassCreate');
        //We're putting in a real looking password hash
        $form->initialPopulate(['pass'=>'$2y$10$.lOL8TE1Yse1dBTvPeQUx.3zkwe3V1A1x24UCfdI.puzfNN15bsnW']);
        $form->password->setRequired(false);
        $this->assertTrue($form->validate(),'The form is valid');
        $form->password->setRequired(true);

        $this->assertEquals(0,count($form->packChanged()),'Nothing packed');
        $this->assertFalse($form->validate(),'The form is invalid');
        $html = $form->html();
        //check the form input has no value entered.
        $dom = new DomDocument();
        $dom->loadHTML($html);
        $passWidget=$dom->getElementById('frmPassCreate_password');
        $this->assertEquals("", $passWidget->getAttribute('value'),'Password widget has no value');

        $post = ['password'=>'']; // The user has not entered a new password.
        $form->populateFromArray($post);

        $this->assertFalse($form->password->changed(), 'The password has not been changed');
        $this->assertFalse($form->validate(),'The form is invalid');
        $post = ['password'=>'password']; // invalid password !
        $form->populateFromArray($post);
        $this->assertTrue($form->password->changed(), 'The password has been changed');
        $this->assertFalse($form->validate(),'The form is not valid');
        $this->assertFalse($form->validate(),'The form is still not valid');

        $html = $form->html();
        //check the form input has no value entered.
        $dom = new DomDocument();
        $dom->loadHTML($html);
        $passWidget=$dom->getElementById('frmPassCreate_password');
        $this->assertEquals("", $passWidget->getAttribute('value'),'Password widget still has no value');

        $post=['password'=>'MyGoodPass123$','password_confirmation'=>'MyGoodPass123$'];
        $form->populateFromArray($post);
        $this->assertTrue($form->password->changed(), 'The password has been changed');
        $this->assertTrue($form->validate(),'The form is valid');
        $this->assertTrue($form->validate(),'The form is still valid');

    }
}
