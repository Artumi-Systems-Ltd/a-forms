<?php
declare(strict_types=1);
use Tests\TestCase;
use Artumi\Forms\Form;

class DualButtonForm extends Form
{
    public function __construct(public string $id)
    {
        $this->addButton('ok','Submit');
        $this->addButton('cancel','Cancel');

    }

    public function validators() : array {
        return [
        ];
    }
}

class DualButtonFormTest extends TestCase
{
    public function testHTML() : void
    {
        $form = new DualButtonForm('frmDualButton');
        $html = $form->html();
        $this->assertEquals('<form id="frmDualButton"><button name="ok">Submit</button><button name="cancel">Cancel</button></form>', $html,'Basic form');
    }
    public function testPopulate()
    {
        $form = new DualButtonForm('frmDualButton');
        $form->populate(['cancel'=>'']);
        $this->assertEquals('cancel',$form->buttonPressed(),'Cancel was pressed');
    }

    public function testPack(): void
    {
        $form = new DualButtonForm('frmDualButton');
        $form->populate(['cancel'=>'']);
        $a = $form->pack();
        $this->assertCount(1, $a, "Pack has 1 elements");
        $this->assertTrue(isset($a['cancel']),'There is an element with "cancel" as the key');
    }
}
