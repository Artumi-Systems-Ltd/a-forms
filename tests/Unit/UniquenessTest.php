<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\Forms\AuthorAddForm;
use Tests\Forms\AuthorEditForm;
use Tests\TestCase;
use ArtumiSystemsLtd\AForms\Widget\Text;
use Workbench\App\Models\Author;


class UniquenessTest extends TestCase
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

        $addForm = new AuthorAddForm('addauthor');
        $addForm->populateFromTransaction([
            'name' => 'Stephen King',
            'image' => '3.jpg'
        ]);
        $this->assertFalse($addForm->validate(), 'Stephen King name is taken');

        $addForm->populateFromTransaction([
            'name' => 'Neal Stephensen',
            'image' => '4.jpg'
        ]);
        $this->assertTrue($addForm->validate(), 'Neal Stephensen is unique');

        $editForm = new AuthorEditForm('editauthor', $jrr);
        $editForm->populateFromTransaction([
            'name' => 'J R R Tolkien',
            'image' => '2-new.jpg',
        ]);
        $this->assertTrue($editForm->validate(), ' We can update JRR');

        $editForm->populateFromTransaction([
            'name' => 'Stephen King',
            'image' => '2.jpg',
        ]);
        $this->assertFalse($editForm->validate(), 'Stephen King is taken');

        $editForm->populateFromTransaction([
            'name' => 'Neal Stephensen',
            'image' => '4.jpg'
        ]);
        $this->assertTrue($editForm->validate(), 'We can rename J R R to Neal Stephensen');
    }
}
