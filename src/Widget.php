<?php
declare(strict_types=1);

namespace Artumi\Forms;

use Artumi\Forms\Form;
use Artumi\Forms\Trait\Attributes;
use InvalidArgumentException;


/**
* Represents a "Widget" for use in Forms. A simple widget would
* correspond to something like an <input> with it's <label> and
* perhaps some validation messages also, if the form was being
* redisplayed after an error. But actually these widgets should be
* able to cope with more complex inputs. Like a Start Date and End
* Date widget should be able to understand the validation rules
* between the start and end dates.
*
* @class
**/
abstract class Widget {
    use Attributes;

    public
    $value,
    $form,
    $bRequiredField=false,
    $sAdditionalValidator='',
    $defaults=[],
    $allowed=[
        "id"
    ];
    public $aValidationMsgSubstitute=[];
    private string $sValidationMsg='';

    public function __construct(
        public readonly string $name,
        public readonly string $caption,
        public array $attribs = [] )
    {}

    abstract function html() : string;
    public function set($value){
        $this->value=$value;
    }
    public function setRequired(bool $bRequired) : void {
        $this->bRequiredField=$bRequired;
    }
    public function required() : bool
    {
        return $this->bRequiredField;
    }
    public function requiredIndicator(): string {
        return '<span class="text-red">(required)</span>';
    }
    public function get(){
        return $this->value;
    }
    public function label() : string {
        $s='<label for="'.$this->id().'">'.$this->caption;
        if($this->required()){
            $s.=' '.$this->requiredIndicator();
        }
        $s.='</label>';
        return $s;
    }
    /**
     * Produces text of all the attrib=value elements to add to the form element.
     * @var bool $bIncludeIdAndName = true
     **/
    public function attribString(bool $bIncludeIdAndName=true) : string
    {
        if($bIncludeIdAndName)
        {
            $s='id="'.$this->id().'" name="'.htmlspecialchars($this->name, ENT_QUOTES).'" ';
        }
        else {
            $s='';
        }
        foreach(array_merge($this->defaults,$this->attribs) as $k=>$v)
        {
            if($k=="id")
            {
                continue;
            }
            $s.=htmlspecialchars($k, ENT_QUOTES).'="'.htmlspecialchars((string) $v, ENT_QUOTES).'" ';
        }
        return $s;
    }
    public function setForm(Form $f) : void
    {
        $this->form=$f;
    }
    public function id() : string
    {
        if($this->attrib('id'))
            return $this->attrib('id');
        if($this->form)
            return $this->form->id().'_'.$this->name;
        return $this->name;
    }
    /**
    * validator returns a string that can be parsed by Laravel's
    * Validation logic  https://laravel.com/docs/10.x/validation#available-validation-rules
    **/
    public function validator() :string {
        $s='';
        if($this->required())
        {
            $s='required';
            if($this->sAdditionalValidator)
            {
                return $s.'|'.$this->sAdditionalValidator;
            }
            return $s;
        }
        return $this->sAdditionalValidator;
    }
    /**
     * Adds another validator to the current string | separated list
     * that confirms tothe laravel validator logic
     **/
    public function appendValidator(string $sExistingValidator, string $sNewValidator)
    {
        if($sExistingValidator)
        {
            $sExistingValidator.='|';
        }
        else {
            $sExistingValidator='';
        }
        $sExistingValidator.=$sNewValidator;
        return $sExistingValidator;

    }
    /**
    * Additional to the "required" validator which we manage
    * separately. See validator() function
    **/
    public function setAdditionalValidator(string $s) : void
    {
        $this->sAdditionalValidator=$s;
    }

    public function setValidationMsg(string $sValMsg): void {
        $this->sValidationMsg=$sValMsg;
    }
    public function setValidation(array $aErrors): void {
        $a=[];
        foreach ($aErrors as $i => $sError) {
            if(isset($this->aValidationMsgSubstitute[$sError]))
            {
                $a[]=$this->aValidationMsgSubstitute[$sError];
            }
            else {
                $a[]=$sError;
            }
        }
        $this->setValidationMsg(implode(' ',$a));
    }
    public function resetValidation(): void {
        $this->sValidationMsg='';
    }
    public function getValMsgHTML() : string {
        if(!$this->sValidationMsg)
        {
            return '';
        }
        return '<div id="'.$this->id().'_v" class="validation">'.$this->sValidationMsg.'</div>';

    }
    public function pack()
    {
        return [$this->name=>$this->get()];
    }
    public function populate($a)
    {
        if(isset($a[$this->name]))
            $this->set($a[$this->name]);
    }
}
