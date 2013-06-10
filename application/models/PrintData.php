<?php

class Application_Model_PrintData
{

	protected $pdf;
	protected $page;
	protected $font;

	public function __construct()
	{
		$this->pdf = new Zend_Pdf();
    $this->page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
    $this->font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
	}

	public function createPdf($data)
	{
		try{
			$this->header();
			$this->headerData($data);
			$this->address($data);
      $this->pdf->pages[] = $this->page;
      return $this->pdf;
    }catch(Zend_Pdf_Exception $e){
        die('PDF error: ' . $e->getMessage());
    }
    catch(Zend_Exception $e){
        die('Error: ' . $e->getMessage());
    }
	}

	protected function header()
	{

    // Line
    // $image = Zend_Pdf_Image::imageWithPath(APPLICATION_PATH . '/views/img/logo_mg.png');
    // $this->page->drawImage($image, $leftPos, $bottomPos, $rightPos, $topPos);

    // Horizontal Lines
    $this->page->setLineWidth(2)
        ->drawLine(50, 820, 545 , 820);

    $this->page->setLineWidth(2)
        ->drawLine(50, 740, 460, 740);

    $this->page->setLineWidth(2)
        ->drawLine(460, 700, 544, 700);

    // Vertical Lines
    $this->page->setLineWidth(2)
        ->drawLine(51, 740, 51, 819);

    $this->page->setLineWidth(2)
        ->drawLine(544, 740, 544, 820);

    $this->page->setLineWidth(2)
        ->drawLine(544, 699, 544, 820);

    $this->page->setLineWidth(0.5)
        ->drawLine(120, 740, 120, 820);

    $this->page->setLineWidth(0.5)
        ->drawLine(460, 699, 460, 820);

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                    ->drawText('SUPERINTENDÊNCIA DE TRANSPORTE METROPOLITANO', 135, 780);

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),10)
                    ->drawText('CADASTRO DE PERMISSIONÁRIO', 205, 760);

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),14)
                    ->drawText('FOTO', 480, 755);
	}

	protected function headerData($data)
	{
		// Horizontal Lines
    $this->page->setLineWidth(1.5)
        ->drawLine(50, 735, 457, 735);

    $this->page->setLineWidth(1.5)
        ->drawLine(51, 720, 457, 720);

    $this->page->setLineWidth(1.5)
        ->drawLine(51, 690, 546, 690);

    // Vertical Lines
    $this->page->setLineWidth(2)
        ->drawLine(51, 690, 51, 735);

    $this->page->setLineWidth(2)
        ->drawLine(456, 690, 456, 735);

    $this->page->setLineWidth(1)
        ->drawLine(320, 690, 320, 720);

    $this->page->setLineWidth(1)
        ->drawLine(385, 690, 385, 720);

    // Words
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),10)
                ->drawText('DADOS DO PERMISSIONÁRIO', 175, 724);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Nome', 55, 712);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText($data->name, 55, 697);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Permissão', 323, 712);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText($data->permission, 323, 697);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Placa', 390, 712);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText($data->plate, 390, 697);
	}

	protected function address($data)
	{
		// Horizontal Lines
    $this->page->setLineWidth(1.5)
        ->drawLine(51, 655, 546, 655);

    $this->page->setLineWidth(1.5)
        ->drawLine(51, 620, 546, 620);

    $this->page->setLineWidth(1.5)
        ->drawLine(51, 583, 546, 583);

    $this->page->setLineWidth(1.5)
        ->drawLine(51, 545, 546, 545);

    // Vertical Lines
    $this->page->setLineWidth(2)
        ->drawLine(51, 544, 51, 690);

    $this->page->setLineWidth(2)
        ->drawLine(545, 544, 545, 690);

    $this->page->setLineWidth(1)
        ->drawLine(320, 655, 320, 690);

    $this->page->setLineWidth(1)
        ->drawLine(385, 655, 385, 690);

    $this->page->setLineWidth(1)
        ->drawLine(160, 620, 160, 655);

    $this->page->setLineWidth(1)
        ->drawLine(385, 620, 385, 655);

    $this->page->setLineWidth(1)
        ->drawLine(120, 583, 120, 620);

    $this->page->setLineWidth(1)
        ->drawLine(200, 583, 200, 620);

    $this->page->setLineWidth(1)
        ->drawLine(290, 583, 290, 620);

    $this->page->setLineWidth(1)
        ->drawLine(385, 583, 385, 620);

    $this->page->setLineWidth(1)
        ->drawLine(158, 544, 158, 583);

    $this->page->setLineWidth(1)
        ->drawLine(255, 544, 255, 583);

    $this->page->setLineWidth(1)
        ->drawLine(345, 544, 345, 583);

    $this->page->setLineWidth(1)
        ->drawLine(385, 544, 385, 583);

    // Words
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Endereço', 55, 680);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->address, 55, 662);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Número', 323, 680);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->number, 323, 662);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Bairro', 390, 680);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->neighborhood, 390, 662);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Telefone', 55, 645);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->phone, 55, 628);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Município', 163, 645);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->name_city, 163, 628);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('CEP', 390, 644);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->zipcode, 390, 628);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Identidade', 55, 610);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->rg, 55, 590);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Orgão Emissor', 123, 610);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->rg_issuer, 124, 590);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Habilitação', 203, 610);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->cnh, 204, 590);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Orgão Emissor', 293, 610);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->cnh_issuer, 294, 590);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('CPF', 390, 610);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->cpf, 390, 590);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Serviço Militar', 55, 573);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->army, 55, 553);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Orgão Emissor', 162, 573);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->army_issuer, 162, 553);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Título Eleitor', 259, 573);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->voter, 259, 553);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Zona', 348, 573);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->voter_zone, 349, 553);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('IAPAS', 388, 573);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->iapas, 389, 553);
	}

}

