<?php

namespace Artumi\Forms\Widget;
use Artumi\Forms\Widget;

class Email extends Widget{

    public function html() : string {
        return $this->label()
            .'<input '.$this->attribString().'type="email" value="'.htmlspecialchars($this->get(), ENT_QUOTES).'"/>'
            .$this->getValMsgHTML();
    }

    public function validator() :string {
        $s=parent::validator();
        return $this->appendValidator($s, 'email:rfc,dns');
    }
}
