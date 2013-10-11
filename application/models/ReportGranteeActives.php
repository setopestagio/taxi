<?php

class Application_Model_ReportGranteeActives
{

  public $pdf;
  public $pageHeader;
  public $font;

  public function __construct()
  {
    $this->pdf = new Zend_Pdf();
    $this->pageHeader = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4_LANDSCAPE);
    $this->font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
  }

	public function create($data,$title)
	{
    $this->grantees($data,$title);
    echo $this->pdf->render(); 
	}

	protected function grantees($data, $title='')
	{

    // Line
    $page = $this->pageHeader;

    $image = Zend_Pdf_Image::imageWithPath(APPLICATION_PATH . '/../public/img/brasao.png');
    $page->drawImage($image, 364, 502, 458, 586);

    $page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),13)
                    ->drawText('SECRETARIA DE ESTADO DE TRANSPORTES E OBRAS PÚBLICAS DO ESTADO DE MINAS GERAIS', 125, 485, 'UTF-8');

    $page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                    ->drawText('SUPERINTENDÊNCIA DE TRANSPORTE METROPOLITANO', 265, 470, 'UTF-8');

    $page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                    ->drawText('RELATÓRIO DE '. $title. ' - SISTEMA DE TÁXI METROPOLITANO', 210, 455, 'UTF-8');

    $this->fields($page,440);

    $range = 410;

    foreach($data as $grantee)
    {
    	$page		->setLineWidth(0.5)
        							->drawLine(30, $range, 805 , $range);

      $page   ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                      ->drawText($grantee->permission, 30, $range-22,'UTF-8');

      $page   ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                      ->drawText($grantee->name_city, 82, $range-22,'UTF-8');

      if($grantee->name > 12)
      {
        $page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                  ->drawText($grantee->name, 160, $range-22, 'UTF-8');
      }
      else
      {
        $page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                  ->drawText(Application_Model_General::cutString($grantee->name,12), 163, $range-16, 'UTF-8');
        $page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                  ->drawText(Application_Model_General::resumeString($grantee->name,12), 160, $range-28, 'UTF-8');
      }

      $page   ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
              ->drawText($grantee->cpf, 270, $range-22,'UTF-8');

      $page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText(Application_Model_General::cutString($grantee->address_complete,10), 342, $range-16, 'UTF-8');
      $page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText(Application_Model_General::resumeString($grantee->address_complete,10), 340, $range-28, 'UTF-8');

      $page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText($grantee->neighborhood, 460, $range-22, 'UTF-8');

      $page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText($grantee->zipcode, 540, $range-22, 'UTF-8');

      $page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText($grantee->plate, 585, $range-22, 'UTF-8');

      $page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText($grantee->vehicle_brand, 630, $range-22, 'UTF-8');

      $page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText($grantee->vehicle_model, 670, $range-22, 'UTF-8');

      $page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText($grantee->year_fabrication, 720, $range-22, 'UTF-8');

      $page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText($grantee->vehicle_fuel, 750, $range-22, 'UTF-8');


      $range -= 40;
      if($range < 40)
      {
      	$this->pdf->pages[] = $page;
      	$page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4_LANDSCAPE);
      	$range = 550;

        $this->fields($page,580);
      }
    }
    
	}

  protected function fields($page,$height=440)
  {
    $page   ->setLineWidth(0.5)
            ->drawLine(30, $height, 805 , $height);

    $page   ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
            ->drawText('Permissão', 30, $height-15,'UTF-8');

    $page   ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
            ->drawText('Origem', 90, $height-15,'UTF-8');

    $page   ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
            ->drawText('Nome', 180, $height-15,'UTF-8');

    $page   ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
            ->drawText('CPF', 290, $height-15,'UTF-8');

    $page   ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
            ->drawText('Endereço', 340, $height-15,'UTF-8');

    $page   ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
            ->drawText('Bairro', 465, $height-15,'UTF-8');

    $page   ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
            ->drawText('CEP', 550, $height-15,'UTF-8');

    $page   ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
            ->drawText('Placa', 590, $height-15,'UTF-8');

    $page   ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
            ->drawText('Marca', 630, $height-15,'UTF-8');

    $page   ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
            ->drawText('Modelo', 670, $height-15,'UTF-8');

    $page   ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
            ->drawText('Ano Fab.', 710, $height-15,'UTF-8');

    $page   ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
            ->drawText('Combustível', 755, $height-15,'UTF-8');

  }

}

