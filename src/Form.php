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
    public function addWidget(Widget $widget)
    {
        $this->widgets[$widget->name]=$widget;
    }

    public function html() : string
    {
        $s='<form>';
        foreach($this->widgets as $widget)
        {
            $s.=$widget->html();
        }
        foreach($this->buttons as $button)
        {
            $s.=$button->html();
        }
        $s.='</form>';
        return $s;
    }
}
