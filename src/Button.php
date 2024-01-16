<?php

namespace Artumi\Forms;

class Button {

    public function __construct(
        public readonly string $name,
        private string $value)
    {
    }
    public function html()
    {
        return '<button name="'.$this->name.'">'.htmlspecialchars($this->value).'</button>';
    }
}
