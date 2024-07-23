<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\Forms\CollectionSelectForm;
use Tests\TestCase;


class CollectionSelectFormTest extends TestCase
{
    public function testRequiredValidator(): void
    {
        $form = new CollectionSelectForm('frmCollectSelection');

        $a = ['colour' => 1];
        $form->populateFromTransaction($a);
        $this->assertEquals(1, $form->getWidget('colour')->get(), 'Option 1 selected');
        $a = ['colour' => 3];
        $form->populateFromTransaction($a);
        $this->assertEquals(3, $form->getWidget('colour')->get(), 'Option 3 selected');
    }
}
