<?php

class Application_Model_ReportGranteeAll extends Application_Model_Report
{

	public function create($data)
	{
    $this->grantees($data);
    echo $this->pdf->render(); 
	}

	protected function grantees($data)
	{

    $range = 710;
    $page = $this->pageHeader;

    foreach($data as $grantee)
    {
    	$page		->setLineWidth(0.5)
        							->drawLine(50, $range, 545 , $range);

    	$page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                  		->drawText('Nome: '.$grantee->name, 60, $range-20,'UTF-8');

      $page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                  		->drawText('Permissão: '.$grantee->permission, 340, $range-20,'UTF-8');

      $page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                  		->drawText('Início da permissão: '.Application_Model_General::dateToBr($grantee->start_permission), 60, $range-40,'UTF-8');

      $page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                  		->drawText('Término da permissão: '.Application_Model_General::dateToBr($grantee->end_permission), 340, $range-40,'UTF-8');

      $range -= 60;
      if($range < 60)
      {
      	$this->pdf->pages[] = $page;
      	$page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
      	$range = 810;
      }
    }
    
	}
}

