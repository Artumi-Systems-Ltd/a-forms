<?php

namespace ArtumiSystemsLtd\AForms;
class Option {
    public function __construct(
        public string $value,
        public string $caption){
    }
    public function html($currentVal){
        if($this->value===$currentVal)
            $s=' selected ';
        else
            $s='';
        return '<option value="'.$this->value.'"'.$s.'>'.$this->caption.'</option>';
    }

}
