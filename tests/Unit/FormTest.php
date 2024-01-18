<?php
declare(strict_types=1);
namespace Tests;

use Tests\TestCase;
use Tests\Forms\MasterForm;
use DomDocument;
use InvalidArgumentException;
use Illuminate\Http\Request;

class FormTest extends TestCase
{

    public function testInvalidFormMessages() : void
    {
        $form = new MasterForm('frmMaster');
        $form->validate();
        $html = $form->html();
        // we should have a validation error message at the top
        // of the form saying "see below for details" and then
        // we should have one error message per widget.

        $dom = new DomDocument();
        $dom->loadHTML($html);
        $formValidation = $dom->getElementById('frmMaster_valmsg');
        $this->assertNotNull($formValidation,'Form Validation message found');

        $nameValidation = $dom->getElementById('frmMaster_name_v');
        $this->assertNotNull($nameValidation,'Name Widget Validation message found');

        $startdateValidation = $dom->getElementById('frmMaster_startdate_v');
        $this->assertNotNull($startdateValidation,'Start Date Widget Validation message found');

        $enddateValidation = $dom->getElementById('frmMaster_enddate_v');
        $this->assertNotNull($enddateValidation,'End Date Widget Validation message found');

        $coloursValidation = $dom->getElementById('frmMaster_colours_v');
        $this->assertNotNull($coloursValidation,'Colours Widget Validation message found');

        $typeValidation = $dom->getElementById('frmMaster_type_v');
        $this->assertNotNull($typeValidation,'Type Widget Validation message found');

        $notesValidation = $dom->getElementById('frmMaster_notes_v');
        $this->assertNotNull($notesValidation,'Notes Widget Validation message found');

    }
    /**
    * We're checking that the <form action=""> is set correctly
    **/
    public function testAction(): void {

        $form = new MasterForm('frmMaster');
        $form->setAction('/foo');
        $html = $form->html();
        $dom = new DOMDocument();
        $dom->loadHTML($html);
        $form = $dom->getElementById('frmMaster');
        $this->assertEquals('/foo', $form->getAttribute('action'),'Action set to /foo');
        $this->assertEquals('post',$form->getAttribute('method'),'Method set to post');
    }

    /**
    * We're checking that the <form method=""> is set correctly
    **/
    public function testMethod() : void {

        $form = new MasterForm('frmMaster');
        $form->setAction('/foo');
        $form->setMethod('post');
        $html = $form->html();
        $dom = new DOMDocument();
        $dom->loadHTML($html);
        $formElement = $dom->getElementById('frmMaster');
        $this->assertEquals('/foo', $formElement->getAttribute('action'),'Action set to /foo');
        $this->assertEquals('post',$formElement->getAttribute('method'),'Method set to post');
        $form->setMethod('get');
        $html = $form->html();
        $dom->loadHTML($html);
        $formElement = $dom->getElementById('frmMaster');
        $this->assertEquals('/foo', $formElement->getAttribute('action'),'Action set to /foo');
        $this->assertEquals('get',$formElement->getAttribute('method'),'Method set to get');

        $form->setMethod('dialog');
        $html = $form->html();
        $dom->loadHTML($html);
        $formElement = $dom->getElementById('frmMaster');
        $this->assertEquals('/foo', $formElement->getAttribute('action'),'Action set to /foo');
        $this->assertEquals('dialog',$formElement->getAttribute('method'),'Method set to dialog');
    }
    /**
     * We're testing that you can't add an invalid method.
     **/
    public function testInvalidMethod(): void {
        $this->expectException(InvalidArgumentException::class);
        $form = new MasterForm('frmMaster');
        $form->setMethod('posty');
    }

    public function testPopulateFromRequest() : void {
        $request = Request::create('/some-endpoint','POST', [
            'name'=>'Richard',
            'startdate'=>'2023-01-01',
            'enddate'=>'2024-02-02',
            'colours'=>'green',
            'type'=>'old',
            'notes'=>'Boom',
            'ok'=>'',
        ]);
        $form = new MasterForm('frmMaster');
        $form->populateFromRequest($request);
        $this->assertEquals('Richard',$form->name->get(),'Name is richard');
        $this->assertEquals('2023-01-01',$form->startdate->get(),'Start date is 2023-01-01');
        $this->assertEquals('2024-02-02',$form->enddate->get(),'End date is 2024-02-02');
        $this->assertEquals('green',$form->colours->get(),'Colours is green');
        $this->assertEquals('old',$form->type->get(),'type is old');
        $this->assertEquals('Boom',$form->notes->get() ,' notes is Boom');
        $this->assertEquals('ok',$form->buttonPressed(),'OK button was pressed');
    }
    public function testCSRFToken()
    {
        $response = $this->get('/master-form');
        $response->assertStatus(200);
    }
}
