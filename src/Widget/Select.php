<?php

namespace Artumi\Forms\Widget;
use Artumi\Forms\Widget;
use Artumi\Forms\Option;

class Select extends Widget {
    public $options;

    public function options() : \Generator {
        foreach($this->options as $option)
        {
            yield $option;
        }
    }
    public function html() : string {
        $s= $this->label().'<select name="'.$this->name.'">';
        $val = $this->get();
        foreach($this->options() as $option)
        {
            $s.=$option->html($val);
        }
        $s.='</select>';
        return $s.$this->getValMsgHTML();
    }
    public function staticOptions(array $options)
    {
        $this->options=[];
        foreach($options as $k=>$v)
        {
            $this->options[$k]=new Option($k,$v);
        }
    }
}
