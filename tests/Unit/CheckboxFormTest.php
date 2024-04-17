<?php
declare(strict_types=1);
use Tests\TestCase;
use Tests\Forms\CheckboxForm;

class CheckboxFormTest extends TestCase
{
    public function testHTML() : void
    {
        $form = new CheckboxForm('frmCheckbox');
        $form->initialPopulate([
            'active'=>true,
        ]);

        $html = $form->html();
        $this->assertEquals('<form id="frmCheckbox" method="post"><label for="frmCheckbox_active">Active</label><input id="frmCheckbox_active" name="active" type="checkbox" checked /><button name="ok">Submit</button></form>', $html,'Basic form');
    }
    public function testPopulate() : void
    {
        $form = new CheckboxForm('frmCheckbox');
        $form->initialPopulate([
            'active'=>true,
        ]);
        $this->assertTrue($form->active->get(),'Active is true');

        $form = new CheckboxForm('frmCheckbox');
        $form->initialPopulate([]);
        $this->assertFalse($form->active->get(),'Active is false');

        $form->populateFromArray(['active'=>true]);
        $this->assertTrue($form->active->get(),'Active is true');
        $form->populateFromTransaction([]); // no checkbox in post, so set it to false
        $this->assertFalse($form->active->get(),'Active is false');


    }

    public function testPack(): void
    {
        $form = new CheckboxForm('frmCheckbox');
        $form->initialPopulate(['active'=>true,'ok'=>'']); // OK is a button! so not populated
        $a = $form->pack();
        $this->assertCount(1, $a, "Pack has 1 elements");
        $this->assertFalse(isset($a['ok']),'There is not an element with "ok" as the key');
        $this->assertTrue(isset($a['active']),'There is an element with "active" as the key');

        $form->populateFromTransaction(['active'=>true,'ok'=>'']); // OK is a button! Populated here
        $a = $form->pack();
        $this->assertCount(2, $a, "Pack has 2 elements");
        $this->assertTrue(isset($a['ok']),'There is an element with "ok" as the key');
        $this->assertTrue(isset($a['active']),'There is an element with "active" as the key');
    }

}
