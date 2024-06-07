<?php
declare(strict_types=1);
use Tests\TestCase;
use ArtumiSystemsLtd\AForms\Widget\TextArea;

class WidgetTest extends TestCase
{
    public function testWidgetWithoutForm()
    {
        $desc = new TextArea('mydesc','My Description');
        $this->assertEquals(
            '<label for="mydesc">My Description</label><textarea id="mydesc" name="mydesc" rows="5" cols="60" ></textarea>',
            $desc->html(),
            'Name used as id'
        );

    }
}
