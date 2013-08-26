<?php

class Application_Model_PrintVehicle extends Application_Model_Report
{

	public function createPdf($data)
	{
    $range = 710;
    $page = $this->pageHeader;


  	$page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                		->drawText('PERMISSÃO', 60, $range+5,'UTF-8');

  	$page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                		->drawText('MARCA', 140, $range+5,'UTF-8');

  	$page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                		->drawText('MODELO', 220, $range+5,'UTF-8');

  	$page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                		->drawText('FABRICAÇÃO', 290, $range+5,'UTF-8');

  	$page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                		->drawText('MODELO', 370, $range+5,'UTF-8');

  	$page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                		->drawText('COMBUSTÍVEL', 430, $range+5,'UTF-8');

    foreach($data as $fleet)
    {

    	$page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                  		->drawText($fleet->permission, 60, $range-20,'UTF-8');

      $page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                  		->drawText($fleet->vehicle_brand, 140, $range-20,'UTF-8');

      list($first_word) = explode(' ', trim($fleet->vehicle_model));
      $page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                  		->drawText($first_word, 220, $range-20,'UTF-8');

      $page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                  		->drawText($fleet->year_fabrication, 310, $range-20,'UTF-8');

      $page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                  		->drawText($fleet->year_model, 380, $range-20,'UTF-8');

      $page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                  		->drawText($fleet->vehicle_fuel, 440, $range-20,'UTF-8');

      $range -= 40;
      if($range < 60)
      {
      	$this->pdf->pages[] = $page;
      	$page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
      	$range = 810;
      }
    }
    echo $this->pdf->render();
	}

}

