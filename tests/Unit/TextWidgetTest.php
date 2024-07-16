<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use ArtumiSystemsLtd\AForms\Widget\Text;

class TextWidgetTest extends TestCase
{
    public function testRequiredValidator(): void
    {
        $widget = new Text('name', 'Name');
        $this->assertEquals('', $widget->validator(), 'No validator is set');
        $widget->setRequired(true);
        $this->assertEquals('required', $widget->validator(), 'Required Validator is set');
        $widget->addAdditionalValidator('max:255');
        $this->assertEquals('required|max:255', $widget->validator(), 'max:255 validator is set');
        $widget->setRequired(false);
        $this->assertEquals('max:255', $widget->validator(), 'max:255 validator is still set');
        $this->assertTrue($widget->removeAdditionalValidator('max:255'), 'Validator is removed');
        $this->assertFalse($widget->removeAdditionalValidator('max:255'), 'Validator is not available to remove');
        $this->assertEquals('', $widget->validator(), 'No validator is set');
    }
}
