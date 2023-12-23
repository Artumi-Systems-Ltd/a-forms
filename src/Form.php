<?php

namespace Artumi\Forms;

class Form {
    private
    $widgets=[],
    $buttons=[];

    public function addButton(string $name, string $value) : void
    {
        $this->buttons[$name]=new Button($name, $value);
    }

    public function html() : string
    {
        $s='<form>';
        foreach($this->buttons as $button)
        {
            $s.=$button->html();
        }
        $s.='</form>';
        return $s;
    }
}
