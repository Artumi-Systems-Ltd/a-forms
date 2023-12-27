<?php

namespace Artumi\Forms\Widget;
use Artumi\Forms\Widget;

class Text extends Widget{

    public function html() : string {
        return $this->label().'<input '.$this->attribString().'type="text" value="'.htmlspecialchars($this->get(), ENT_QUOTES).'"/>';
    }

}
