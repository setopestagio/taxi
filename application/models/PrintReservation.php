<?php

class Application_Model_PrintReservation
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

	public function createPdf($data,$reservation)
	{
		$this->header();
		$this->content($data,$reservation);
		$this->footer($data,$reservation);
    $this->pdf->pages[] = $this->page;
    return $this->pdf;
	}

  protected function header()
  {

    $image = Zend_Pdf_Image::imageWithPath(APPLICATION_PATH . '/../public/img/brasao.png');
    $this->page->drawImage($image, 54, 747, 118, 811);

    // Horizontal Lines
    $this->page->setLineWidth(2)
        ->drawLine(50, 820, 545 , 820);

    $this->page->setLineWidth(2)
        ->drawLine(50, 740, 545, 740);

    // Vertical Lines
    $this->page->setLineWidth(2)
        ->drawLine(51, 740, 51, 819);

    $this->page->setLineWidth(2)
        ->drawLine(544, 740, 544, 820);

    $this->page->setLineWidth(0.5)
        ->drawLine(120, 740, 120, 820);

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),14)
                    ->drawText('SUPERINTENDÊNCIA DE TRANSPORTE METROPOLITANO', 130, 780, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),12)
                    ->drawText('SOLICITAÇÃO DE RESERVA DE PERMISSÃO', 195, 760, 'UTF-8');
  }

  protected function content($data,$reservation)
  {
  	// Horizontal Lines
    $this->page->setLineWidth(2)
        ->drawLine(50, 736, 545 , 736);

    $this->page->setLineWidth(2)
        ->drawLine(50, 540, 545, 540);

    $this->page->setLineWidth(1)
        ->drawLine(50, 722, 545, 722);

    $this->page->setLineWidth(1)
        ->drawLine(50, 682, 545, 682);

    $this->page->setLineWidth(1)
        ->drawLine(50, 640, 545, 640);

    $this->page->setLineWidth(1)
        ->drawLine(50, 627, 545, 627);

    $this->page->setLineWidth(1)
        ->drawLine(250, 560, 515, 560);

    // Vertical Lines
    $this->page->setLineWidth(2)
        ->drawLine(51, 736, 51, 540);

    $this->page->setLineWidth(2)
        ->drawLine(544, 736, 544, 540);

    $this->page->setLineWidth(1)
        ->drawLine(357, 722, 357, 682);

    $this->page->setLineWidth(1)
        ->drawLine(450, 722, 450, 682);

    $this->page->setLineWidth(1)
        ->drawLine(188, 640, 188, 682);

    $this->page->setLineWidth(1)
        ->drawLine(357, 640, 357, 682);

    $this->page->setLineWidth(1)
        ->drawLine(450, 640, 450, 682);

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),10)
                    ->drawText('PERMISSIONÁRIO', 250, 725, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),10)
                    ->drawText('SOLICITAÇÃO', 260, 630, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                    ->drawText('Nome', 55, 712, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),12)
                    ->drawText($data->name, 55, 692, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                    ->drawText('Permissão', 360, 712, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),12)
                    ->drawText($data->permission, 365, 692, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                    ->drawText('Placa', 453, 712, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),12)
                    ->drawText($data->plate, 457, 692, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                    ->drawText('Chassi', 55, 670, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),12)
                    ->drawText($data->chassi, 55, 652, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                    ->drawText('Marca', 192, 670, 'UTF-8');
    $vehicleModel = explode(" ",$data->vehicle_model);
    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),12)
                    ->drawText($vehicleModel[0], 190, 652, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                    ->drawText('Modelo', 360, 670, 'UTF-8');

    $vehicleBrand = explode(" ",$data->vehicle_brand);
    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),12)
                    ->drawText($vehicleBrand[0], 360, 652, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                    ->drawText('Ano Modelo', 454, 670, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),14)
                    ->drawText($data->year_model, 460, 652, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),12)
                    ->drawText('O permissionário, acima identificado, socilita a SETOP reserva de permissão por um período', 60, 610, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),12)
                    ->drawText('de '.$reservation->period.', a contar desta data.', 60, 590, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                    ->drawText('Assinatura', 355, 550, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                    ->drawText('Belo Horizonte, '.date('d/m/Y'), 55, 555, 'UTF-8');
  }

  protected function footer($data,$reservation)
  {

  	// Horizontal Lines
    $this->page->setLineWidth(2)
        ->drawLine(50, 535, 545 , 535);

    $this->page->setLineWidth(2)
        ->drawLine(50, 350, 545, 350);

    $this->page->setLineWidth(1)
        ->drawLine(50, 522, 545, 522);

    $this->page->setLineWidth(1)
        ->drawLine(50, 480, 545, 480);

    $this->page->setLineWidth(1)
        ->drawLine(50, 440, 545, 440);

    $this->page->setLineWidth(1)
        ->drawLine(50, 390, 545, 390);

    $this->page->setLineWidth(1)
        ->drawLine(330, 405, 535, 405);

    // Vertical Lines
    $this->page->setLineWidth(2)
        ->drawLine(51, 535, 51, 350);

    $this->page->setLineWidth(2)
        ->drawLine(544, 535, 544, 350);

    $this->page->setLineWidth(1)
        ->drawLine(170, 440, 170, 390);

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),10)
                    ->drawText('MOTIVO', 270, 525, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),13)
                    ->drawText($reservation->reason, 55, 500, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                    ->drawText('Informações Complementares', 55, 472, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),13)
                    ->drawText($reservation->info, 55, 450, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                    ->drawText('Vencimento da Reserva', 55, 432, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),13)
                    ->drawText( Date('d/m/Y', strtotime("+365 days")), 70, 405, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                    ->drawText('Autorização (uso exclusivo da SETOP)', 173, 432, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),13)
                    ->drawText(date('d/m/Y'), 183, 405, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                    ->drawText('Assinatura', 405, 397, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),12)
                    ->drawText('IMPORTANTE: O permissionário tem o prazo de 15 (quinze) dias para comprovar a reserva', 55, 377, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),12)
                    ->drawText('de permissão junto ao Orgão de Trânsito', 190, 360, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),7)
                    ->drawText('1ª via: permissionário; 2ª via: SETOP', 250, 342, 'UTF-8');
  }

}

