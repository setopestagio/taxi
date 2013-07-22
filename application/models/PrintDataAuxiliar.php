<?php

class Application_Model_PrintDataAuxiliar
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

	public function createPdf($data,$auxiliars='')
	{
		try{
    		$this->header();
    		$this->headerData($data);
    		$this->addressDocuments($data);
            $this->registered($data);
            $this->vehicle($data);
            $this->info($data->info);
            $this->term($data);
            $this->signData();
            $this->footer($data);
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

    $image = Zend_Pdf_Image::imageWithPath(APPLICATION_PATH . '/../public/img/brasao.png');
    $this->page->drawImage($image, 54, 747, 118, 811);

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
                    ->drawText('SUPERINTENDÊNCIA DE TRANSPORTE METROPOLITANO', 135, 780, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),10)
                    ->drawText('CADASTRO DE AUXILIAR', 220, 760, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),14)
                    ->drawText('FOTO', 480, 755, 'UTF-8');
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
                ->drawText('DADOS DO AUXILIAR', 190, 724, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Nome', 55, 712, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText($data->name, 55, 697, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Permissão', 323, 712, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText($data->permission, 323, 697, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Placa', 390, 712, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText($data->plate, 390, 697, 'UTF-8');
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
                ->drawText('Endereço', 55, 680, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->address, 55, 662, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Número', 323, 680, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->number, 323, 662, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Bairro', 390, 680, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->neighborhood, 390, 662, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Telefone', 55, 645, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->phone, 55, 628, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Município', 163, 645, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->name_city, 163, 628, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('CEP', 390, 644, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->zipcode, 390, 628, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Identidade', 55, 610, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->rg, 55, 590, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Orgão Emissor', 123, 610, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->rg_issuer, 124, 590, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Habilitação', 203, 610, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->cnh, 204, 590, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Orgão Emissor', 293, 610, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->cnh_issuer, 294, 590, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('CPF', 390, 610, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->cpf, 390, 590, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Serviço Militar', 55, 573, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->army, 55, 553, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Orgão Emissor', 162, 573, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->army_issuer, 162, 553, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Título Eleitor', 259, 573, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->voter, 259, 553, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Zona', 348, 573, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->voter_zone, 349, 553, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('IAPAS', 388, 573, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->iapas, 389, 553, 'UTF-8');
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
        ->drawLine(380, 490, 380, 528);

    $this->page->setLineWidth(1)
        ->drawLine(180, 490, 180, 528);

    // Words
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText('CADASTRAMENTO', 225, 532, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Categoria', 54, 518, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Início Auxiliar', 187, 518, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Baixa Auxiliar', 384, 518, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('TÁXI ESPECIAL', 55, 498, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText(Application_Model_General::dateToBr($data->start_permission), 187, 498, 'UTF-8');
    // $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
    //             ->drawText($data->end_permission, 385, 498, 'UTF-8');
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
                ->drawText('VEÍCULO', 265, 476, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Marca', 55, 464, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Modelo', 128, 464, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Ano Fab.', 233, 464, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Ano Mod.', 294, 464, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Cor', 352, 464, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Combustível', 452, 464, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Chassi', 55, 428, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),9)
                ->drawText('TAXÍMETRO', 385, 428, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Marca', 267, 418, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Modelo', 412, 418, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->vehicle_brand, 55, 448, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText(substr($data->vehicle_model,0,15), 128, 448, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->year_fabrication, 240, 448, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->year_model, 300, 448, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->color, 353, 448, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->vehicle_fuel, 453, 448, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->chassi, 55, 408, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->taximeter_brand, 269, 404, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText($data->taximeter_model, 415, 404, 'UTF-8');
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
                ->drawText('INFORMAÇÕES COMPLEMENTARES', 195, 385, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText(nl2br($info), 55, 370, 'UTF-8');
  }

  protected function term($data)
  {
    // Horizontal Lines
    $this->page->setLineWidth(1.5)
        ->drawLine(51, 215, 546, 215);

    $this->page->setLineWidth(1.5)
        ->drawLine(51, 90, 546, 90);

    $this->page->setLineWidth(1)
        ->drawLine(51, 200, 546, 200);

    // Vertical Lines
    $this->page->setLineWidth(2)
        ->drawLine(51, 90, 51, 215);

    $this->page->setLineWidth(2)
        ->drawLine(546, 90, 546, 215);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText('TERMO DE COMPROMISSO - CONDUTOR AUXILIAR', 160, 204, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText($data->name, 65, 185, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('está autorizado a atuar no Serviço Público de Transporte Individual de Passageiros por Taxi Convencional', 65, 171, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('e Taxi Especial da RMBH, como condutor auxiliar, no veículo de placa ', 65, 158, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText($data->plate . " ,", 384, 158, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('de propriedade de ', 65, 144, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText($data->name_grantee . ".", 148, 144, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('Para tal, compromete-se a cumprir o Regulamento do Serviço Público de Transporte Individual de', 65, 125, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('Passageiros por Taxi da RMBH e Portarias concernentes ao Serviço, estando ciente de seus termos e', 65, 112, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('conteúdos', 65, 101, 'UTF-8');

  }

  protected function signData()
  {
    // Horizontal Lines
    $this->page->setLineWidth(1.5)
        ->drawLine(51, 285, 546, 285);

    $this->page->setLineWidth(1.5)
        ->drawLine(51, 220, 546, 220);

    $this->page->setLineWidth(1.5)
        ->drawLine(210, 240, 370, 240);

    $this->page->setLineWidth(1.5)
        ->drawLine(385, 240, 530, 240);

    // Vertical Lines
    $this->page->setLineWidth(2)
        ->drawLine(51, 220, 51, 285);

    $this->page->setLineWidth(2)
        ->drawLine(546, 220, 546, 285);

    $this->page->setLineWidth(1)
        ->drawLine(200, 220, 200, 285);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('Local e Data', 56, 270, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('Belo Horizonte, '.date('d/m/Y'), 56, 240, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('Assinatura do Auxiliar', 240, 230, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('SETOP', 440, 230, 'UTF-8');
  }

  protected function footer($data)
  {
    // Horizontal Lines
    $this->page->setLineWidth(1.5)
        ->drawLine(51, 86, 546, 86);

    $this->page->setLineWidth(1.5)
        ->drawLine(51, 20, 546, 20);

    $this->page->setLineWidth(1.5)
        ->drawLine(51, 53, 546, 53);

    $this->page->setLineWidth(1.5)
        ->drawLine(163, 65, 297, 65);

    $this->page->setLineWidth(1.5)
        ->drawLine(303, 65, 437, 65);

    $this->page->setLineWidth(1.5)
        ->drawLine(443, 65, 543, 65);

    $this->page->setLineWidth(1.5)
        ->drawLine(163, 32, 297, 32);

    $this->page->setLineWidth(1.5)
        ->drawLine(303, 32, 437, 32);

    $this->page->setLineWidth(1.5)
        ->drawLine(443, 32, 543, 32);

    // Vertical Lines
    $this->page->setLineWidth(2)
        ->drawLine(51, 20, 51, 86);

    $this->page->setLineWidth(2)
        ->drawLine(546, 20, 546, 86);

    $this->page->setLineWidth(1.5)
        ->drawLine(160, 20, 160, 86);

    $this->page->setLineWidth(1.5)
        ->drawLine(300, 20, 300, 86);

    $this->page->setLineWidth(1.5)
        ->drawLine(440, 20, 440, 86);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('Vinculação Auxiliar', 55, 76, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('Baixa Auxiliar', 55, 44, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                ->drawText('Assinatura Permissionário', 180, 57, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                ->drawText('Assinatura Auxiliar', 335, 57, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                ->drawText('SETOP', 480, 57, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                ->drawText('Assinatura Permissionário', 180, 24, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                ->drawText('Assinatura Auxiliar', 335, 24, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                ->drawText('SETOP', 480, 24, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),13)
                ->drawText(Application_Model_General::dateToBr($data->start_permission), 70, 60, 'UTF-8');
  }

}

