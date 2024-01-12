<?php
declare(strict_types=1);
namespace Artumi\Forms;

use Illuminate\Support\Facades\Validator as FValidator;
use Illuminate\Validation\Validator;

abstract class Form {
    private string $buttonPressed='';
    private array  $widgets=[];
    private array  $buttons=[];
    private Validator|null $lastValidator;

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
    public function populate(array $a) : void {
        foreach ($a as $k=>$v)
        {
            if(isset($this->widgets[$k]))
                $this->widgets[$k]->set($v);
            else if (isset($this->buttons[$k]))
                $this->buttonPressed=$k;
        }

    }
    public function buttonPressed() : string
    {
        return $this->buttonPressed;
    }
    public function pack() : array {
        $a=[];
        foreach($this->widgets as $name=>$widget)
        {
            $a[$name]=$widget->get();
        }
        if($this->buttonPressed)
        {
            $a[$this->buttonPressed]='';
        }
        return $a;
    }
    abstract public function validators() : array ;
    public function validate() : bool {
        $validator = FValidator::make($this->pack(), $this->validators());
        $this->lastValidator=$validator;
        return $validator->passes();

    }

}
