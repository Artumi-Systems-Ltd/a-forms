<?php
declare(strict_types=1);

namespace Artumi\Forms;


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
    public function __construct(
        public readonly string $name,
        public readonly string $caption,
        public array $attribs = [] )
    {}

    abstract function html(): string;
    public function label() : string {
        return '<label for="'.$this->name.'">'.$this->caption.'</label>';

    }
}
