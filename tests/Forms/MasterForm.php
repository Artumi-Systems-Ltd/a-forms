<?php
declare(strict_types=1);
namespace Tests\Forms;
use ArtumiSystemsLtd\AForms\Form;
use ArtumiSystemsLtd\AForms\Widget\Text;
use ArtumiSystemsLtd\AForms\Widget\Date;
use ArtumiSystemsLtd\AForms\Widget\RadioFieldset;
use ArtumiSystemsLtd\AForms\Widget\TextArea;
use ArtumiSystemsLtd\AForms\Widget\Select;
use ArtumiSystemsLtd\AForms\Widget\Email;
use ArtumiSystemsLtd\AForms\Widget\PasswordCreate;


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

        $email = new Email('email','Email');
        $email->setRequired(true);
        $this->addWidget($email);


        $password = new PasswordCreate('password','New Password');
        $password->setRequired(true);
        $this->addWidget($password);

        $this->addButton('ok','Submit');

        $this->setMethod('post');
        $this->setAction('/master-form-submit');
    }
}
