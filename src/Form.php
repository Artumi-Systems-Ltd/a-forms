<?php
declare(strict_types=1);
namespace Artumi\Forms;

use Illuminate\Support\Facades\Validator as FValidator;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use InvalidArgumentException;

abstract class Form {
    private string $defaultValidationMsg='There has been an error, please see details below:';
    private string $sValidationMsg='';
    private string $buttonPressed='';
    private array  $widgets=[];
    private array  $buttons=[];
    private ?Validator $lastValidator=null;
    private string $sAction='';
    private string $sMethod='post';

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
        $s='<form id="'.htmlspecialchars($this->id,ENT_QUOTES).'"';
        if($this->sAction)
        {
            $s.=' action="'.htmlspecialchars($this->sAction, ENT_QUOTES).'"';
        }
        if($this->sMethod)
        {
            $s.=' method="'.htmlspecialchars($this->sMethod, ENT_QUOTES).'"';
        }
        $s.=' >';
        $s.=$this->csrf();
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
                $this->widgets[$k]->populate($a);
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
            $widgetVals= $widget->pack();
            foreach($widgetVals as $widgetName=>$widgetVal)
            {
                $a[$widgetName]=$widgetVal;
            }
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
    public function setAction(string $url) : void {
        $this->sAction=$url;
    }
    public function setMethod(string $method) : void {
        switch($method) {
            case 'get':
            case 'post':
            case 'dialog':
                $this->sMethod=$method;
                break;
            default:
            throw new InvalidArgumentException('setMethod only accespts get|post|dialog, but received '.$method);
        }
    }
    public function populateFromRequest(Request $request) : void {
        $aVals=$request->all();
        foreach($this->widgets as $name=>$widget){
            if($request->has($name))
            {
                $widget->populate($aVals);
            }
        }
        foreach($this->buttons as $button)
        {
            if($request->has($button->name))
                $this->buttonPressed=$button->name;
        }
    }
    public function csrf() : string {
        $t = csrf_token();
        if($t) {
            return '<input type="hidden" name="_token" value="'.htmlspecialchars($t, ENT_QUOTES).'">';
        }
        return '';
    }
    /**
    * Saves the current data to the session
    */
    public function flash() : void {
        session()->flash('form-'.$this->id(), $this->pack());
    }
    /*
    * Loads the data from the session flash, if there is any.
    * @return true if something was loaded.
    **/
    public function loadFromFlash(): bool {
        $data = session('form-'.$this->id());
        if($data)
        {
            $this->populate($data);
            return true;
        }
        return false;
    }
}
