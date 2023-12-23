<?php

namespace Artumi\Forms\Widget;
use Artumi\Forms\Widget;

class Text extends Widget{

    public function html() : string {
        return $this->label().'<input name="'.$this->name.'" type="text" />';
    }

}
