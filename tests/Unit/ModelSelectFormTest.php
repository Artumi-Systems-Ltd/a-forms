<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\Forms\ModelSelectForm;
use Tests\TestCase;
use Workbench\App\Models\Author;


class ModelSelectFormTest extends TestCase
{
    public function testRequiredValidator(): void
    {

        $stephenKing = Author::create([
            'name' => 'Stephen King',
            'image' => '1.jpg'
        ]);

        $jrr = Author::create([
            'name' => 'J R R Tolkien',
            'image' => '2.jpg',
        ]);
        $form = new ModelSelectForm('frmModelSelect');

        $a = ['author' => 1];
        $form->populateFromTransaction($a);
        $this->assertEquals(1, $form->getWidget('author')->get(), 'Author 1 selected');

        $a = ['author' => 2];
        $form->populateFromTransaction($a);
        $this->assertEquals(2, $form->getWidget('author')->get(), 'Author 2 selected');

        $a = ['author' => 3];
        $form->populateFromTransaction($a);
        $this->assertEquals(2, $form->getWidget('author')->get(), 'Author 2 still selected as 3 doesn\'t exist in options');
    }
}
