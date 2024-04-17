<?php
declare(strict_types=1);
use Tests\TestCase;
use Tests\Forms\DualButtonForm;


class DualButtonFormTest extends TestCase
{
    public function testHTML() : void
    {
        $form = new DualButtonForm('frmDualButton');
        $html = $form->html();
        $this->assertEquals('<form id="frmDualButton" method="post"><button name="ok">Submit</button><button name="cancel">Cancel</button></form>', $html,'Basic form');
    }
    public function testPopulate()
    {
        $form = new DualButtonForm('frmDualButton');
        $form->populateFromArray(['cancel'=>'']);
        $this->assertEquals('cancel',$form->buttonPressed(),'Cancel was pressed');
    }

    public function testPack(): void
    {
        $form = new DualButtonForm('frmDualButton');
        $form->populateFromArray(['cancel'=>'']);
        $a = $form->pack();
        $this->assertCount(1, $a, "Pack has 1 elements");
        $this->assertTrue(isset($a['cancel']),'There is an element with "cancel" as the key');
    }
}
