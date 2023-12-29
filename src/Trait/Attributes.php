<?php
namespace Artumi\Forms\Trait;
trait Attributes {

    public function attrib(string $name, $default='')
    {
        if(isset($this->attribs[$name]))
            return $this->attribs[$name];
        return $default;
    }
    public function setAttribute(string $name, string $value)
    {
        if(!in_array($name,$this->allowed))
            throw new \InvalidArgumentException("The attrib \"$name\" is not allowed on this type of Widget ");
        $this->attribs[$name]=$value;

    }

}
