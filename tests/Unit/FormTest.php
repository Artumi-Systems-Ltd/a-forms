<?php
declare(strict_types=1);
namespace Tests;

use Tests\TestCase;
use Tests\Forms\MasterForm;
use DomDocument;

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

}
