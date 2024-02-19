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

    public function testMasterFormInvalidSubmission(): void {
        //missing most of the data, but Jones is passed through
        $response = $this->post('/master-form-submit',['name'=>'Jones']);
        $response->assertStatus(302);

        $this->assertEquals('http://localhost/master-form',$response->headers->get('location'),'Redirecting to redisplay form');
        $response2 = $this->get('/master-form');
        $dom = new DOMDocument();
        $dom->loadHTML($response2->getContent());
        $this->assertEquals('Jones',$dom->getElementById('frmMaster_name')->getAttribute(('value')), "name value was passed through flash");

    }
}
