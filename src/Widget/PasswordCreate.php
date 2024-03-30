<?php

namespace Artumi\Forms\Widget;
use Artumi\Forms\Widget;

class PasswordCreate extends Widget{

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

}
