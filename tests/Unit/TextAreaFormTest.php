<?php
declare(strict_types=1);
use Tests\TestCase;
use Tests\Forms\TextAreaForm;

class TextAreaFormTest extends TestCase
{
    public function testHTML() : void
    {
        $form = new TextAreaForm('frmTest');
        $html = $form->html();
        $dom = new DOMDocument();
        $dom->loadHTML($html);
        $this->assertEquals('frmTest',$dom->getElementById('frmTest')->id,"Form has correct ID");
        $this->assertEquals('frmTest_description',$dom->getElementById('frmTest_description')->id, "Textarea has correct default ID");
        $this->assertEquals(60,$dom->getElementById('frmTest_description')->getAttribute("cols"), "Cols has correct default value");
        $this->assertEquals(5,$dom->getElementById('frmTest_description')->getAttribute("rows"), "Rows has correct default value");

        $sTestText='<textarea rows="20"> test';


        $form->description=$sTestText;
        $html= $form->html();
        $dom = new DomDocument();
        $dom->loadHTML($html);
        $textarea = $dom->getElementById('frmTest_description');
        $this->assertEquals($sTestText, $textarea->nodeValue, "Textarea can contain html");
        $label = $dom->getElementsByTagName('label')[0];
        $this->assertEquals('Description (required)', $label->nodeValue, "Label has required text");
    }
    public function testInvalidArgument() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $form = new TextAreaForm('frmTest');
        $form->description->setAttribute('class-wrong','My class');
    }
    public function testValidArgument() : void
    {
        $form = new TextAreaForm('frmTest');
        $form->description->setAttribute('class','My-class');
        $this->assertEquals('My-class',$form->description->attrib('class'));
    }
    public function testPopulate() : void
    {
        $form = new TextAreaForm('frmTest');
        $form->populate(['description'=>'</textarea>','ok'=>'']);
        $this->assertEquals('</textarea>',$form->description->get(),'</textarea> returned properbly de-escaped');
    }

    public function testIDAttribChange() : void
    {
        $form = new TextAreaForm('frmTest');
        $form->description->setAttribute('id','a-new-id');
        $sTestText='<textarea rows="20"> test';
        $form->description=$sTestText;
        $html= $form->html();
        $dom = new DomDocument();
        $dom->loadHTML($html);
        $textarea = $dom->getElementById('a-new-id');
        $this->assertEquals($sTestText, $textarea->nodeValue, "Textarea works with new id");

    }
    public function testAdditionalValidator() : void
    {
        $form  = new TextAreaForm('frmTest');
        $form->description->setRequired(true);
        $form->description->setAdditionalValidator('max:255');
        $this->assertEquals('required|max:255',$form->description->validator(),'Validator extended');
    }

    public function testPack(): void
    {
        $form = new TextAreaForm('frmTest');
        $form->populate(['description'=>'</textarea>','ok'=>'']);
        $a = $form->pack();
        $this->assertCount(2, $a, "Pack has 2 elements");
        $this->assertTrue(isset($a['ok']),'There is an element with "ok" as the key');
        $this->assertTrue(isset($a['description']),'There is an element with "description" as the key');
        $this->assertEquals('</textarea>',$a['description'],'The "description" is "</textarea>"');
    }

}
