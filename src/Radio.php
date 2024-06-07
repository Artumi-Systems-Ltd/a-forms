<?php

namespace ArtumiSystemsLtd\AForms;
use ArtumiSystemsLtd\AForms\Widget\RadioFieldset;

class Radio {
    public function __construct(
        public RadioFieldset $fieldset,
        public string $value,
        public string $caption){
    }
    public function html($currentVal){
        if($this->value===$currentVal)
        $s=' checked ';
        else
        $s='';
        $id = $this->fieldset->id().'_'.htmlspecialchars($this->value,ENT_QUOTES);
        return '<input type="radio" '
            .'id="'.$id.'" '
            .'name="'.$this->fieldset->name.'" '
            .'value="'.htmlspecialchars($this->value, ENT_QUOTES).'" '
            .$s.'/>'
            .'<label for="'.$id.'">'.htmlspecialchars($this->caption).'</label>';
    }

}
