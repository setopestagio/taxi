<?php

class Application_Model_Report
{

	public $pdf;
	public $pageHeader;
	public $font;

	public function __construct($title)
	{
		$this->pdf = new Zend_Pdf();
    $this->pageHeader = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
    $this->font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
		$this->header($this->pageHeader,$title);
	}

	public function header($page,$title='')
	{
		// Line
    $image = Zend_Pdf_Image::imageWithPath(APPLICATION_PATH . '/../public/img/brasao.png');
    $page->drawImage($image, 54, 742, 138, 816);

    // Horizontal Lines
    $page->setLineWidth(2)
        ->drawLine(50, 820, 545 , 820);

    $page->setLineWidth(2)
        ->drawLine(50, 740, 545, 740);

    // Vertical Lines
    $page->setLineWidth(2)
        ->drawLine(51, 740, 51, 819);

    $page->setLineWidth(2)
        ->drawLine(544, 740, 544, 820);

    $page->setLineWidth(0.5)
        ->drawLine(140, 740, 140, 820);

    $page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),13)
                    ->drawText('SUPERINTENDÊNCIA DE TRANSPORTE METROPOLITANO', 155, 780, 'UTF-8');

    $page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                    ->drawText('RELATÓRIO '. $title, 250, 760, 'UTF-8');
	}

}

