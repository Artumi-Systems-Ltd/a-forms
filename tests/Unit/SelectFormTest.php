<?php
declare(strict_types=1);
use Tests\TestCase;
use Tests\Forms\SelectForm;

class SelectFormTest extends TestCase
{
    public function testHTML() : void
    {
        $form = new SelectForm('frmSelect');
        $form->colour='red';
        $html = $form->html();
        $this->assertEquals('<form id="frmSelect" method="post" ><label for="frmSelect_colour">Colour</label><select name="colour"><option value="red" selected >Red</option>'
                            .'<option value="blue">Blue</option><option value="green">Green</option></select><button name="ok">Submit</button></form>', $html,'Basic form');
    }
    public function testPopulate() : void
    {
        $form = new SelectForm('frmSelect');
        $form->populate(['colour'=>'green']);
        $this->assertEquals('green',$form->colour->get(),'Colour is green');
    }

    public function testPack(): void
    {
        $form = new SelectForm('frmSelect');
        $form->populate(['colour'=>'green','ok'=>'']);
        $a = $form->pack();
        $this->assertCount(2, $a, "Pack has 2 elements");
        $this->assertTrue(isset($a['ok']),'There is an element with "ok" as the key');
        $this->assertTrue(isset($a['colour']),'There is an element with "colour" as the key');
        $this->assertEquals('green',$a['colour'],'The "colour" is "green"');
    }
}
