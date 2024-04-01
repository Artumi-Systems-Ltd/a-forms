<?php

namespace Artumi\Forms\Widget;
use Artumi\Forms\Widget;

class PasswordCreate extends Widget{

    private $sPasswordConfirmation;

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
        $s=parent::validator();
        return $this->appendValidator($s, 'confirmed');
    }
    public function pack()
    {
        return [$this->name=>$this->get(),
            $this->name.'_confirmation'=>$this->sPasswordConfirmation];

    }
    public function populate($aVals)
    {
        if(isset($aVals[$this->name]))
        {
            $this->set($aVals[$this->name]);
        }
        if(isset($aVals[$this->name.'_confirmation']))
        {
            $this->sPasswordConfirmation=$aVals[$this->name.'_confirmation'];
        }
    }
}
