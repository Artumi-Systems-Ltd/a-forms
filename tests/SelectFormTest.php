<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Artumi\Forms\Form;
use Artumi\Forms\Widget\Select;

class SelectForm extends Form
{
    public function __construct(public string $id)
    {
        $age = new Select('age','Age');
        $age->staticOptions(['red'=>'Red','blue'=>'Blue','green'=>'Green']);
        $this->addWidget($age);
        $this->addButton('ok','Submit');
    }
}

class SelectFormTest extends TestCase
{
    public function testHTML() : void
    {
        $form = new SelectForm('frmSelect');
        $html = $form->html();
        $this->assertEquals('<form id="frmSelect"><label for="age">Age</label><select name="age"><option value="red">Red</option>'
                            .'<option value="blue">Blue</option><option value="green">Green</option></select><button name="ok">Submit</button></form>', $html,'Basic form');
    }
}
