<?php
declare(strict_types=1);
namespace Tests ;
use Tests\TestCase;
use Tests\Forms\DateForm;
use DateTime;
use DOMDocument;
use Artumi\Forms\Widget\Date;

class DateFormTest extends TestCase
{
    public function testHTML() : void
    {
        $form = new DateForm('frmDate');
        $form->startdate = new DateTime('today');
        $html = $form->html();

        $dom = new DOMDocument();
        $dom->loadHTML($html);
        $startdate = $dom->getElementById('frmDate_startdate');
        $this->assertEquals(date('Y-m-d'), $startdate->getAttribute('value'), 'Date contains start value');
    }
    public function testPopulate() : void
    {
        $form = new DateForm('frmDate');
        $form->populateFromArray(['startdate'=>'2024-01-01','ok'=>'']);
        $this->assertEquals('2024-01-01',$form->startdate->get()->format(Date::FORMAT));
    }

    public function testPack(): void
    {
        $form = new DateForm('frmSimpleButton');
        $form->populateFromArray(['startdate'=>'2024-01-01','ok'=>'']);
        $a = $form->pack();
        $this->assertCount(2, $a, "Pack has 2 elements");
        $this->assertTrue(isset($a['ok']),'There is an element with "ok" as the key');
        $this->assertTrue(isset($a['startdate']),'There is an element with "startdate" as the key');
        $this->assertEquals('2024-01-01',$a['startdate'],'Start date is 2024-01-01');
    }
}
