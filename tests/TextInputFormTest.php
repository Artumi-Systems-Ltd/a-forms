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
        $form->name='Richard';
        $html = $form->html();
        $this->assertEquals('<form id="frmTextArea"><label for="frmTextArea_name">Name</label><input id="frmTextArea_name" name="name" type="text" value="Richard"/><button name="ok">Submit</button></form>', $html,'Basic form');
        $sText ='Richard\'s Quote Test "';
        $form->name=$sText;
        $html = $form->html();
        $this->assertEquals('<form id="frmTextArea"><label for="frmTextArea_name">Name</label><input id="frmTextArea_name" name="name" type="text" value="'.htmlspecialchars($sText,ENT_QUOTES).'"/><button name="ok">Submit</button></form>', $html,'Basic form');
    }
}
