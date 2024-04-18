<?php

namespace Artumi\Forms\Widget;
use Artumi\Forms\Widget;

class Text extends Widget{

    public $allowed=[
        'list',
        'pattern',
        'size',
        'autocorrect',
        'type',
        'disabled',
        'maxlength',
        'minlength',
        'placeholder',
        'readonly',
        'required',
        'spellcheck',
        'wrap',
        'class',
        'style',
    ];
    public function html() : string {
        return $this->label()
            .'<input '.$this->attribString().'type="text" value="'.htmlspecialchars($this->get(), ENT_QUOTES).'"/>'
            .$this->getValMsgHTML();
    }

}
