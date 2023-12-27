<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Artumi\Forms\Form;
use Artumi\Forms\Widget\Date;

class DateForm extends Form
{
    public function __construct(public string $id)
    {
        $this->addWidget(new Date('startdate','Start Date'));
        $this->addButton('ok','Submit');
    }
}

class DateFormTest extends TestCase
{
    public function testHTML() : void
    {
        $form = new DateForm('frmDate');
        $form->startdate = new DateTime('today');
        $html = $form->html();

        $dom = new DomDocument();
        $dom->loadHTML($html);
        $startdate = $dom->getElementById('frmDate_startdate');
        $this->assertEquals(date('Y-m-d'), $startdate->getAttribute('value'), 'Date contains start value');
    }
}
