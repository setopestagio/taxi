<?php

class Application_Model_PrintVehicle extends Application_Model_Report
{

	public function createPdf($data)
	{
    $range = 710;
    $page = $this->pageHeader;


  	$page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                		->drawText('PERMISSÃO', 30, $range+5,'UTF-8');

  	$page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                		->drawText('MARCA', 110, $range+5,'UTF-8');

  	$page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                		->drawText('MODELO', 190, $range+5,'UTF-8');

  	$page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                		->drawText('FABRICAÇÃO', 260, $range+5,'UTF-8');

  	$page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                		->drawText('MODELO', 340, $range+5,'UTF-8');

  	$page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                		->drawText('COMBUSTÍVEL', 400, $range+5,'UTF-8');

    $page   ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                    ->drawText('VIDA ÚTIL', 495, $range+5,'UTF-8');

    foreach($data as $fleet)
    {

    	$page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                  		->drawText($fleet->permission, 30, $range-20,'UTF-8');

      $page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                  		->drawText($fleet->vehicle_brand, 110, $range-20,'UTF-8');

      list($first_word) = explode(' ', trim($fleet->vehicle_model));
      $page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                  		->drawText($first_word, 190, $range-20,'UTF-8');

      $page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                  		->drawText($fleet->year_fabrication, 260, $range-20,'UTF-8');

      $page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                  		->drawText($fleet->year_model, 340, $range-20,'UTF-8');

      $page		->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                  		->drawText($fleet->vehicle_fuel, 400, $range-20,'UTF-8');

      $page   ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                      ->drawText((date('Y') - $fleet->year_fabrication), 515, $range-20,'UTF-8');

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

