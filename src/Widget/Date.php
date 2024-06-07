<?php

namespace ArtumiSystemsLtd\AForms\Widget;
use ArtumiSystemsLtd\AForms\Widget;
use \DateTime;

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
    public function set($sValue)
    {
        if(is_string($sValue))
        {
            $v = DateTime::createFromFormat('Y-m-d', $sValue);
        }
        else if($sValue instanceof DateTime)
        {
            $v = $sValue;
        }
        else if(is_numeric($sValue))
        {
            $v = new DateTime();
            $v->setTimestamp($sValue);

        }
        else {
            $v=null;
        }
        $this->value=$v;

    }
    public function pack()
    {
        $v = $this->get();
        if($v instanceof DateTime) {
            return [$this->name=>$v->format(self::FORMAT)];
        }
        return [$this->name=>$v];
    }

}
