<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
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
}
