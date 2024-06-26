<?php
declare(strict_types=1);
use Tests\TestCase;
use ArtumiSystemsLtd\AForms\Widget\RadioFieldset;
use Tests\Forms\RadioFieldsetForm;

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
        $form->populateFromArray(['type'=>'archive']);
        $this->assertEquals('archive',$form->type->get(),'Radio set to archive');
    }

    public function testPack(): void
    {
        $form = new RadioFieldsetForm('frmRadio');
        $form->populateFromArray(['type'=>'archive','ok'=>'']);
        $a = $form->pack();
        $this->assertCount(2, $a, "Pack has 2 elements");
        $this->assertTrue(isset($a['ok']),'There is an element with "ok" as the key');
        $this->assertTrue(isset($a['type']),'There is an element with "type" as the key');
        $this->assertEquals('archive',$a['type'],'The "Type" is "archive"');
    }
}
