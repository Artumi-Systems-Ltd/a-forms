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
        foreach($this->options() as $option)
        {
            $s.='<option value="'.$option->value.'">'.$option->caption.'</option>';
        }
        $s.='</select>';
        return $s;
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
