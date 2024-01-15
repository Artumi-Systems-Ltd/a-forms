<?php

namespace Artumi\Forms\Widget;
use Artumi\Forms\Widget;

class Date extends Widget{
    public const string FORMAT='Y-m-d';
    public function html() : string {
        $val = $this->getHTMLVal();
        return $this->label()
            .'<input type="date" '.$this->attribString().' value="'.$this->getHTMLVal().'"/>'
            .$this->getValMsgHTML();
    }
    public function getHTMLVal() : string
    {
        $v = $this->get();
        if(is_null($v))
        {
            return '';
        }
        return htmlspecialchars($v->format(Date::FORMAT),ENT_QUOTES);

    }

}
