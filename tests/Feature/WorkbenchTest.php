<?php
declare(strict_types=1);

namespace Tests\Feature;
use Tests\TestCase;
use \DOMDocument;

class WorkbenchTest extends TestCase {

    public function testWelcomePage() : void {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
    public function testMasterFormPage(): void {
        $response = $this->get('/master-form');
        $response->assertStatus(200);

        $dom = new DOMDocument();
        $dom->loadHTML($response->getContent());
        $this->assertEquals('frmMaster',$dom->getElementById('frmMaster')->id,"Form has correct ID");
        $this->assertEquals('frmMaster_notes',$dom->getElementById('frmMaster_notes')->id, "Textarea has correct default ID");
    }
}
