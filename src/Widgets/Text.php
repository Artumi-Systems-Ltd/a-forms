<?php

namespace Artumi\Forms\Widgets;
use Artumi\Forms\Widget;

class Text extends Widget{

    public function html() : string {
        return '<label for="'.$this->name.'">'.$this->caption.'</label><input name="'.$this->name.'" type="text" />';
    }

}
