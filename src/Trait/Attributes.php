<?php
namespace Artumi\Forms\Trait;
trait Attributes {

    private $alwaysAllowed = ['id','class','style'];
    public $defaults=[];
    public $attribs = [];

    public function attrib(string $name, $default='')
    {
        if(isset($this->attribs[$name]))
            return $this->attribs[$name];
        return $default;
    }
    public function setAttribute(string $name, string $value)
    {
        if(!in_array($name, $this->alwaysAllowed) && !in_array($name,$this->allowed))
            throw new \InvalidArgumentException("The attrib \"$name\" is not allowed on this type of Widget ");
        $this->attribs[$name]=$value;
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
}
