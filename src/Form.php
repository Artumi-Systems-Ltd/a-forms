<?php
declare(strict_types=1);
namespace Artumi\Forms;

use Illuminate\Support\Facades\Validator as FValidator;
use Illuminate\Validation\Validator;

abstract class Form {
    private string $defaultValidationMsg='There has been an error, please see details below:';
    private string $sValidationMsg='';
    private string $buttonPressed='';
    private array  $widgets=[];
    private array  $buttons=[];
    private ?Validator $lastValidator=null;

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
        $this->updateValidation();
        $s='<form id="'.htmlspecialchars($this->id,ENT_QUOTES).'">';
        $s.=$this->formValMsgHTML();
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
    public function validators() : array
    {
        $a=[];
        foreach($this->widgets as $name=>$widget)
        {
            $validator = $widget->validator();
            if($validator)
            {
                $a[$name]=$validator;
            }
        }
        return $a;

    }
    public function validate() : bool {
        $validator = FValidator::make($this->pack(), $this->validators());
        $this->lastValidator=$validator;
        return $validator->passes();
    }
    /** Passes validation information collected during a validate()
    *   call to widgets
    **/
    private function updateValidation()
    {
        if($this->lastValidator)
        {
            $bGotOne=false;
            foreach($this->widgets as $name=>$widget)
            {
                $errors = $this->lastValidator->errors()->get($name);
                if(count($errors))
                {
                    $bGotOne=true;
                    $widget->setValidationMsg(implode('. ', $errors));
                }
                if($bGotOne)
                {
                    $this->setValidationMsg($this->defaultValidationMsg);
                }
            }
        }
        else {
            $this->resetValidation();
        }
    }
    private function resetValidation() : void {
        $this->sValidationMsg='';
        foreach($this->widgets as $widget){
            $widget->resetValidation();
        }
    }
    public function setValidationMsg(string $sValMsg): void {
        $this->sValidationMsg=$sValMsg;
    }
    private function formValMsgHTML():string {
        if(!$this->sValidationMsg)
        {
            return '';
        }
        return '<div id="'.$this->id().'_valmsg" class="validation">'.$this->sValidationMsg.'</div>';
    }
}
