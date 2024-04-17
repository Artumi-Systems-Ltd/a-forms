<?php

namespace Artumi\Forms\Widget;
use Artumi\Forms\Widget;

class PasswordCreate extends Widget{

    private $sPasswordConfirmation;
    public  $aValidationMsgSubstitute=[
        'The password field format is invalid.'=>'The password must include at least one uppercase and lowercase letter, one number, and one special character.'
    ];

    public function html() : string {
        return $this->label()
            .'<input '.$this->attribString().'type="password" value=""/>'
            .'<input '
            .'id="'.$this->id().'_confirmation" name="'.htmlspecialchars($this->name.'_confirmation', ENT_QUOTES).'" '
            .$this->attribString(false)
            .'type="password" value=""/>'
            .$this->getValMsgHTML();
    }

    public function validator() :string {
        //if not changed, then it's valid, unless it's empty and
        //required
        if(!$this->changed())
        {
            if($this->get() || !$this->required())
            {
                return ''; //no validators
            }
        }
        $s=parent::validator();
        return $this->appendValidator($s, 'confirmed|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/');
    }
    public function pack()
    {
        if($this->changed())
        {
            return [$this->name=>$this->get(),
                $this->name.'_confirmation'=>$this->sPasswordConfirmation];
        }
        else {
            return [];
        }
    }
    public function populateFromTransaction($aVals)
    {
        if(isset($aVals[$this->name]))
        {
            if($aVals[$this->name])
                $this->set($aVals[$this->name]);
        }
        if(isset($aVals[$this->name.'_confirmation']))
        {
            $this->sPasswordConfirmation=$aVals[$this->name.'_confirmation'];
        }
    }
    public function populateFromArray($aVals)
    {
        return $this->populateFromTransaction($aVals);
    }
}
