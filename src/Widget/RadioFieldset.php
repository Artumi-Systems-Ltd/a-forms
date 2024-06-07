<?php

namespace ArtumiSystemsLtd\AForms\Widget;
use ArtumiSystemsLtd\AForms\Widget;
use ArtumiSystemsLtd\AForms\Radio;

class RadioFieldset extends Widget {
    public $options;

    public function options() : \Generator {
        foreach($this->options as $option)
        {
            yield $option;
        }
    }
    public function html() : string {
        $s= $this->label();
        $s.='<fieldset class="radiofieldset">';
        $s.='<legend>Please choose one:</legend>';
        $val = $this->get();
        foreach($this->options() as $option)
        {
            $s.='<div>';
            $s.=$option->html($val);
            $s.='</div>';
        }
        $s.='</fieldset>';
        return $s.$this->getValMsgHTML();
    }
    public function staticOptions(array $options)
    {
        $this->options=[];
        foreach($options as $k=>$v)
        {
            $this->options[$k]=new Radio($this, $k,$v);
        }
    }
}
