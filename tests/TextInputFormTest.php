<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Artumi\Forms\Form;
use Artumi\Forms\Widget\Text;

class TextInputForm extends Form
{
    public function __construct(public string $id)
    {
        $this->addWidget(new Text('name','Name'));
        $this->addButton('ok','Submit');
    }
}

class TextInputFormTest extends TestCase
{
    public function testHTML() : void
    {
        $form = new TextInputForm('frmTextArea');
        $html = $form->html();
        $this->assertEquals('<form id="frmTextArea"><label for="name">Name</label><input name="name" type="text" /><button name="ok">Submit</button></form>', $html,'Basic form');
    }
}
