<?php

namespace Artumi\Forms\Widget;
use Artumi\Forms\Widget;

class Date extends Widget{
    public const string FORMAT='Y-m-d';
    public function html() : string {
        return $this->label().'<input type="date" '.$this->attribString().' value="'.htmlspecialchars($this->get()->format(Date::FORMAT), ENT_QUOTES).'"/>';
    }

}
