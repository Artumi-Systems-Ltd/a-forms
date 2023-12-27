<?php
declare(strict_types=1);

namespace Artumi\Forms;

use Artumi\Forms\Form;
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
    public
    $value,
    $form,
    $defaults=[],
    $allowed=[];

    public function __construct(
        public readonly string $name,
        public readonly string $caption,
        public array $attribs = [] )
    {}

    abstract function html(): string;
    public function set($value){
        $this->value=$value;
    }
    public function get(){
        return $this->value;
    }
    public function label() : string {
        return '<label for="'.$this->id().'">'.$this->caption.'</label>';

    }
    public function attribString()
    {
        $s='id="'.$this->id().'" name="'.htmlspecialchars($this->name, ENT_QUOTES).'" ';
        foreach(array_merge($this->defaults,$this->attribs) as $k=>$v)
        {
            $s.=htmlspecialchars($k, ENT_QUOTES).'="'.htmlspecialchars((string) $v, ENT_QUOTES).'" ';
        }
        return $s;
    }
    public function setForm(Form $f)
    {
        $this->form=$f;
    }
    public function id() : string
    {
        if($this->attrib('id'))
            return $this->attrib('id');
        if($this->form)
            return $this->form->id().'_'.$this->name;
        return $this->name.'asd';
    }
    public function attrib(string $name, $default='')
    {
        if(isset($this->attribs[$name]))
            return $this->attribs;
        return $default;
    }
    public function setAttrib(string $name, string $value)
    {
        if(!isset($this->allowed[$name]))
            throw new InvalidArgumentException("The attrib \"$name\" is not allowed on this type of Widget ");
        $this->attrib[$name]=$value;

    }
}
