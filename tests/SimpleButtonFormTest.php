<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Artumi\Forms\Form;

class SimpleButtonForm extends Form
{
    public function __construct()
    {
        $this->addButton('ok','Submit');

    }
}

class SimpleButtonFormTest extends TestCase
{
    public function testHTML() : void
    {
        $form = new SimpleButtonForm();
        $html = $form->html();
        $this->assertEquals('<form><button name="ok">Submit</button></form>', $html,'Basic form');
    }
}
