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

        $form->populate(['name'=>'Mandy','ok'=>'']);
        $this->assertEquals('Mandy',$form->name->get(),'Mandy populated');
    }


    public function testPack(): void
    {
        $form = new TextInputForm('frmTextArea');
        $form->name='Richard';
        $a = $form->pack();
        $this->assertCount(1, $a, "Pack has 1 elements");
        $this->assertTrue(isset($a['name']),'There is an element with "name" as the key');
        $this->assertEquals('Richard',$a['name'],'The "name" is "Richard"');
    }
}
