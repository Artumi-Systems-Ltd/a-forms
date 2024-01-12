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
    $allowed=[];

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
            $s.=$this->requiredIndicator();
        }
        $s.='</label>';
        return $s;
    }
    public function attribString() : string
    {
        $s='id="'.$this->id().'" name="'.htmlspecialchars($this->name, ENT_QUOTES).'" ';
        foreach(array_merge($this->defaults,$this->attribs) as $k=>$v)
        {
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
    public function validator() : string {
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
    * Additional to the "required" validator which we manage
    * separately. See validator() function
    **/
    public function setAdditionalValidator(string $s) : void
    {
        $this->sAdditionalValidator=$s;
    }
}
