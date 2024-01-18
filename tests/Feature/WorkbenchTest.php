<?php
declare(strict_types=1);

namespace Tests\Feature;
use Tests\TestCase;


class WorkbenchTest extends TestCase {

    public function testWelcomePage() : void {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
