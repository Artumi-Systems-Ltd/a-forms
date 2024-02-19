<?php
declare(strict_types=1);
namespace Tests\Forms;
use Artumi\Forms\Form;
use Artumi\Forms\Widget\Text;
use Artumi\Forms\Widget\Date;
use Artumi\Forms\Widget\RadioFieldset;
use Artumi\Forms\Widget\TextArea;
use Artumi\Forms\Widget\Select;


class MasterForm extends Form
{
    public function __construct(public string $id)
    {
        $name = new Text('name','Name');
        $name->setRequired(true);
        $this->addWidget($name);

        $startdate = new Date('startdate','Start Date');
        $startdate->setRequired(true);
        $this->addWidget($startdate);

        $enddate = new Date('enddate','End Date');
        $enddate->setRequired(true);
        $this->addWidget($enddate);

        $select = new Select('colours','Colours');
        $select->staticOptions(['red'=>'Red','green'=>'Green','yellow'=>'Yellow']);
        $select->setRequired(true);
        $this->addWidget($select);

        $radio = new RadioFieldset('type','Type');
        $radio->staticOptions(['new'=>'New','old'=>'Old']);
        $radio->setRequired(true);
        $this->addWidget($radio);

        $textarea= new TextArea('notes','Notes');
        $textarea->setRequired(true);
        $this->addWidget($textarea);
        $this->addButton('ok','Submit');


        $this->setMethod('post');
        $this->setAction('/master-form-submit');
    }
}
