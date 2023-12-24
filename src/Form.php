<?php

namespace Artumi\Forms;

class Form {
    private
    $widgets=[],
    $buttons=[];
    public function __construct(public string $id){}

    public function id() : string {
        return $this->id;
    }

    public function addButton(string $name, string $value) : void
    {
        $this->buttons[$name]=new Button($name, $value);
    }
    public function addWidget(Widget $widget)
    {
        $widget->setForm($this);
        $this->widgets[$widget->name]=$widget;
    }

    public function html() : string
    {
        $s='<form id="'.htmlspecialchars($this->id,ENT_QUOTES).'">';
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
    public function __get(string $sName) : Widget {
        return $this->widgets[$sName];
    }
    public function __set(string $sName, $value) : void {
        $this->widgets[$sName]->set($value);
    }
}
