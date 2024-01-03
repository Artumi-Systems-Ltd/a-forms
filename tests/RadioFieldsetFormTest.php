<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Artumi\Forms\Form;
use Artumi\Forms\Widget\RadioFieldset;

class RadioFieldsetForm extends Form
{
    public function __construct(public string $id)
    {
        $type= new RadioFieldset('type','Type');
        $type->staticOptions(['new'=>'New','old'=>'Old','archive'=>'Archive']);
        $this->addWidget($type);
        $this->addButton('ok','Submit');
    }
}

class RadioFieldsetFormTest extends TestCase
{
    public function testHTML() : void
    {
        $form = new RadioFieldsetForm('frmRadio');
        $form->type='old';
        $html = $form->html();

        $dom = new DomDocument();
        $dom->loadHTML($html);
        $type = $dom->getElementById('frmRadio_type_old');
        $this->assertIsObject($type, 'Radio input with id frmRadio_type_old found');
        $this->assertEquals('checked', $type->getAttribute('checked'), 'Old option is checked');

        $form->type='new';
        $html = $form->html();

        $dom = new DomDocument();
        $dom->loadHTML($html);
        $type = $dom->getElementById('frmRadio_type_new');
        $this->assertIsObject($type, 'Radio input with id frmRadio_type_new found');
        $this->assertEquals('checked', $type->getAttribute('checked'), 'New option is checked');
    }
    public function testPopulate() : void
    {
        $form = new RadioFieldsetForm('frmRadio');
        $form->populate(['type'=>'archive']);
        $this->assertEquals('archive',$form->type->get(),'Radio set to archive');
    }
}
