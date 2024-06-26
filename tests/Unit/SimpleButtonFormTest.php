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
        $this->assertEquals('<form id="frmSimpleButton" method="post"><button name="ok">Submit</button></form>', $html,'Basic form');
    }
    public function testPopulate(): void
    {
        $form = new SimpleButtonForm('frmSimpleButton');
        $form->populateFromArray(['ok'=>'']);
        $this->assertEquals('ok',$form->buttonPressed(),'OK was pressed');

    }
    public function testPack(): void
    {
        $form = new SimpleButtonForm('frmSimpleButton');
        $form->populateFromArray(['ok'=>'']);
        $a = $form->pack();
        $this->assertCount(1, $a, "Pack has 1 element");
        $this->assertTrue(isset($a['ok']),'There is an element with "ok" as the key');
    }
    public function testPutFormMethod(): void
    {
        $form = new SimpleButtonForm('frmSimpleButton');
        $form->setMethod('put');

        $html = $form->html();
        $this->assertEquals('<form id="frmSimpleButton" method="post"><input type="hidden" name="_method" value="put"><button name="ok">Submit</button></form>', $html,'Basic form');

    }
}
