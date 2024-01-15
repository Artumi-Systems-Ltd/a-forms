<?php

namespace Artumi\Forms\Widget;
use Artumi\Forms\Widget;
use Artumi\Forms\Radio;

class RadioFieldset extends Widget {
    public $options;

    public function options() : \Generator {
        foreach($this->options as $option)
        {
            yield $option;
        }
    }
    public function html() : string {
        $s='<fieldset>';
        $s.='<legend>'.htmlspecialchars($this->caption,ENT_QUOTES).'</legend>';
        $s.='<div>';
        $val = $this->get();
        foreach($this->options() as $option)
        {
            $s.=$option->html($val);
        }
        $s.='</div>';
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
