<?php
declare(strict_types=1);
use Tests\TestCase;
use Tests\Forms\SimpleButtonForm;

class SimpleButtonFormTest extends TestCase
{
    public function testHTML() : void
    {
        $form = new SimpleButtonForm('frmSimpleButton');
        $html = $form->html();
        $this->assertEquals('<form id="frmSimpleButton"><button name="ok">Submit</button></form>', $html,'Basic form');
    }
    public function testPopulate(): void
    {
        $form = new SimpleButtonForm('frmSimpleButton');
        $form->populate(['ok'=>'']);
        $this->assertEquals('ok',$form->buttonPressed(),'OK was pressed');

    }
    public function testPack(): void
    {
        $form = new SimpleButtonForm('frmSimpleButton');
        $form->populate(['ok'=>'']);
        $a = $form->pack();
        $this->assertCount(1, $a, "Pack has 1 element");
        $this->assertTrue(isset($a['ok']),'There is an element with "ok" as the key');
    }
}
