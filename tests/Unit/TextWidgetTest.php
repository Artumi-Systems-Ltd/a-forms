<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use Artumi\Forms\Widget\Text;

class TextWidgetTest extends TestCase
{
    public function testRequiredValidator() : void {
        $widget = new Text('name','Name');
        $this->assertEquals('',$widget->validator(),'No validator is set');
        $widget->setRequired(true);
        $this->assertEquals('required',$widget->validator(),'Required Validator is set');
        $widget->setAdditionalValidator('max:255');
        $widget->setRequired(false);
        $this->assertEquals('max:255',$widget->validator(),'max:255 validator is set');
    }

}

