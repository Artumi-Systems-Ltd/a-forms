<?php

namespace Artumi\Forms\Widget;
use Artumi\Forms\Widget;

class TextArea extends Widget {
    public
    $defaults=[
        'rows'=>5,
        'cols'=>60,
    ],
    $allowed=[
        'autocapitalize',
        'autocomplete',
        'autocorrect',
        'autofocus',
        'cols',
        'rows',
        'dirname',
        'disabled',
        'form',
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

        return '<textarea '.$this->attribString().'>'.htmlspecialchars($this->get(),ENT_QUOTES).'</textarea>';
    }
}
