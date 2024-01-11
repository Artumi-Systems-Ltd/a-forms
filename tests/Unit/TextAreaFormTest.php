<?php
declare(strict_types=1);
use Tests\TestCase;
use Artumi\Forms\Form;
use Artumi\Forms\Widget\TextArea;

class TextAreaForm extends Form
{
    public function __construct(public string $id)
    {
        $desc = new TextArea('description','Description');
        $this->addWidget($desc);
        $this->addButton('ok','Submit');
    }

    public function validators() : array {
        return [
            'description'=>'required',
        ];
    }
}

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
