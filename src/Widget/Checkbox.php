<?php

namespace ArtumiSystemsLtd\AForms\Widget;
use ArtumiSystemsLtd\AForms\Widget;

class Checkbox extends Widget {

    public function html() : string {
        $s= $this->label()
            .'<input '.$this->attribString().'type="checkbox" ';
        if($this->get())
        {
            $s.='checked ';
        }
        return $s.'/>'.$this->getValMsgHTML();
    }
    public function populateFromTransaction($a)
    {
        if(isset($a[$this->name]))
        {
            $this->set($a[$this->name]);
        }
        else {
            $this->set(false);
        }
    }

    public function get(){
        return (bool) $this->value;
    }
}
