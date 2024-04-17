<?php
declare(strict_types=1);

namespace Tests\Feature;
use Illuminate\Http\Request;
use Tests\TestCase;
use \DOMDocument;
use Tests\Forms\MasterForm;

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

        $this->assertEquals('frmMaster_email',$dom->getElementById('frmMaster_email')->id, "Email widget has correct default ID");
        $this->assertEquals('frmMaster_password',$dom->getElementById('frmMaster_password')->id, "Password widget has correct default ID");
        $this->assertEquals('frmMaster_password_confirmation',$dom->getElementById('frmMaster_password_confirmation')->id, "Password confirmation widget has correct default ID");
    }

    public function testMasterFormInvalidSubmission(): void {
        //missing most of the data, but Jones is passed through
        $response = $this->post('/master-form-submit',['name'=>'Jones','password'=>'asd','password_confirmation'=>'dsa']);
        $response->assertStatus(302);

        $this->assertEquals('http://localhost/master-form',$response->headers->get('location'),'Redirecting to redisplay form');
        $response2 = $this->get('/master-form');
        $dom = new DOMDocument();
        $dom->loadHTML($response2->getContent());
        $this->assertEquals('Jones',$dom->getElementById('frmMaster_name')->getAttribute(('value')), "name value was passed through flash");
        $this->assertEquals('',$dom->getElementById('frmMaster_password')->getAttribute(('value')), "password value was not passed through flash");
        $this->assertEquals('',$dom->getElementById('frmMaster_password_confirmation')->getAttribute(('value')), "password_confirmation value was not passed through flash");
        $this->assertEquals('The password field confirmation does not match. The password field must be at least 8 characters. The password must include at least one uppercase and lowercase letter, one number, and one special character.',$dom->getElementById('frmMaster_password_v')->textContent, "password validation confirmation works");
    }

    public function testMasterFormValidSubmission(): void {
        //This should be a valid post, so should redirect to the valid
        //page
        $post = [
            'name'=>'Jones',
            'password'=>'mypaAss$123',
            'password_confirmation'=>'mypaAss$123',
            'startdate'=>'2020-01-01',
            'enddate'=>'2025-01-01',
            'type'=>'new',
            'colours'=>'red',
            'email'=>'test@artumi.com',
            'notes'=>'A note'
        ];

        $form = new MasterForm('frmTest');
        $form->populateFromArray($post);
        $this->assertTrue($form->validate(),'Post is valid');

        $request = new Request($post);
        $form = new MasterForm('frmTest');
        $form->populateFromRequest($request);

        $valid= $form->validate();

        $this->assertTrue($form->validate(),'Post is valid');

        $packed = $form->pack();
        $form  = new MasterForm('frmTest');
        $form->populateFromArray($packed);
        //We're checking the post is valid, but I want to see it working through
        //HTTP posting as well
        $response = $this->post('/master-form-submit',$post);
        $response->assertStatus(302);
        $this->assertEquals('http://localhost/master-form-success',$response->headers->get('location'),'Redirecting to success form');
    }
}
