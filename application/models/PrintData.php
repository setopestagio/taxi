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
			$this->addressDocuments($data);
      $this->registered($data);
      $this->vehicle($data);
      $this->info($data->info);
      $this->auxiliar();
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

	protected function addressDocuments($data)
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

  protected function registered($data)
  {
    // Horizontal Lines
    $this->page->setLineWidth(1.5)
        ->drawLine(51, 542, 546, 542);

    $this->page->setLineWidth(1.5)
        ->drawLine(51, 528, 546, 528);

    $this->page->setLineWidth(1.5)
        ->drawLine(51, 490, 546, 490);

    // Vertical Lines
    $this->page->setLineWidth(2)
        ->drawLine(51, 489, 51, 542);

    $this->page->setLineWidth(2)
        ->drawLine(546, 489, 546, 542);

    $this->page->setLineWidth(1)
        ->drawLine(300, 490, 300, 542);

    $this->page->setLineWidth(1)
        ->drawLine(440, 490, 440, 542);

    $this->page->setLineWidth(1)
        ->drawLine(145, 490, 145, 528);

    $this->page->setLineWidth(1)
        ->drawLine(222, 490, 222, 528);

    $this->page->setLineWidth(1)
        ->drawLine(370, 490, 370, 528);

    // Words
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('CADASTRAMENTO', 135, 532);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('DATA DE RESERVA', 330, 532);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('DATA EMPLACAMENTO', 442, 532);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Categoria', 54, 518);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Início da Permissão', 147, 518);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Baixa da Permissão', 224, 518);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Início Reserva', 302, 518);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Final Reserva', 372, 518);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('Táxi Especial', 55, 498);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText(Application_Model_General::dateToBr($data->start_permission), 155, 498);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText(Application_Model_General::dateToBr($data->end_permission), 235, 498);
  }

  protected function vehicle($data)
  {
    // Horizontal Lines
    $this->page->setLineWidth(1.5)
        ->drawLine(51, 485, 546, 485);

    $this->page->setLineWidth(1.5)
        ->drawLine(51, 400, 546, 400);

    $this->page->setLineWidth(1.5)
        ->drawLine(51, 473, 546, 473);

    $this->page->setLineWidth(1.5)
        ->drawLine(51, 437, 546, 437);

    $this->page->setLineWidth(1)
        ->drawLine(265, 426, 546, 426);

    // Vertical Lines
    $this->page->setLineWidth(2)
        ->drawLine(51, 485, 51, 400);

    $this->page->setLineWidth(2)
        ->drawLine(546, 485, 546, 400);

    $this->page->setLineWidth(1)
        ->drawLine(125, 473, 125, 437);

    $this->page->setLineWidth(1)
        ->drawLine(230, 473, 230, 437);

    $this->page->setLineWidth(1)
        ->drawLine(290, 473, 290, 437);

    $this->page->setLineWidth(1)
        ->drawLine(350, 473, 350, 437);

    $this->page->setLineWidth(1)
        ->drawLine(450, 473, 450, 437);

    $this->page->setLineWidth(1)
        ->drawLine(265, 437, 265, 400);

    $this->page->setLineWidth(1)
        ->drawLine(410, 426, 410, 400);

    // Words
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),9)
                ->drawText('VEÍCULO', 265, 476);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Marca', 55, 464);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Modelo', 128, 464);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Ano Fab.', 233, 464);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Ano Mod.', 294, 464);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Cor', 352, 464);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Combustível', 452, 464);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Chassi', 55, 428);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),9)
                ->drawText('TAXÍMETRO', 385, 428);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Marca', 267, 418);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Modelo', 412, 418);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->vehicle_brand, 55, 448);
    // $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
    //             ->drawText($data->model, 128, 448);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->year_fabrication, 240, 448);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->year_model, 300, 448);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->color, 353, 448);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->vehicle_fuel, 453, 448);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->chassi, 55, 408);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->taximeter_brand, 269, 404);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->taximeter_model, 415, 404);
  }

  protected function info($info)
  {
    // Horizontal Lines
    $this->page->setLineWidth(1.5)
        ->drawLine(51, 396, 546, 396);

    $this->page->setLineWidth(1.5)
        ->drawLine(51, 290, 546, 290);

    $this->page->setLineWidth(1)
        ->drawLine(51, 382, 546, 382);

    // Vertical Lines
    $this->page->setLineWidth(2)
        ->drawLine(51, 290, 51, 396);

    $this->page->setLineWidth(2)
        ->drawLine(546, 290, 546, 396);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText('INFORMAÇÕES COMPLEMENTARES', 195, 385);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText($info, 55, 370);
  }

  protected function auxiliar()
  {
    // Horizontal Lines
    $this->page->setLineWidth(1.5)
        ->drawLine(51, 286, 546, 286);

    $this->page->setLineWidth(1.5)
        ->drawLine(51, 200, 546, 200);

    $this->page->setLineWidth(1)
        ->drawLine(51, 272, 546, 272);

    // Vertical Lines
    $this->page->setLineWidth(2)
        ->drawLine(51, 200, 51, 286);

    $this->page->setLineWidth(2)
        ->drawLine(546, 200, 546, 286);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText('CONDUTOR(ES) AUXILIAR(ES)', 210, 276);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('Nome', 80, 256);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('Início Auxiliar', 350, 256);
  }

}

