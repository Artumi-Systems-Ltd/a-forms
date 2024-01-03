<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Artumi\Forms\Form;

class DualButtonForm extends Form
{
    public function __construct(public string $id)
    {
        $this->addButton('ok','Submit');
        $this->addButton('cancel','Cancel');

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
}
