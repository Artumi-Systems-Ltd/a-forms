<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Artumi\Forms\Form;

class DualButtonForm extends Form
{
    public function __construct()
    {
        $this->addButton('ok','Submit');
        $this->addButton('cancel','Cancel');

    }
}

class DualButtonFormTest extends TestCase
{
    public function testHTML() : void
    {
        $form = new DualButtonForm();
        $html = $form->html();
        $this->assertEquals('<form><button name="ok">Submit</button><button name="cancel">Cancel</button></form>', $html,'Basic form');
    }
}
