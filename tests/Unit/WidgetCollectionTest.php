<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\Forms\WidgetCollectionForm;
use Tests\TestCase;
use Workbench\App\Models\Author;


class WidgetCollectionTest extends TestCase
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

        $form = new WidgetCollectionForm('frmWidgetCollection');

        $a = ['author_1' => true];
        $form->populateFromTransaction($a);


        $this->assertEquals([1], $form->getWidgetCollectionValues('author'), 'Stephen King selected');

        $a = ['author_1' => true, 'author_2' => true];
        $form->populateFromTransaction($a);
        $this->assertEquals([1, 2], $form->getWidgetCollectionValues('author'), 'Both selected');

        $a = [];
        $form->populateFromTransaction($a);
        $this->assertEquals([], $form->getWidgetCollectionValues('author'), 'none selected');
    }
}
