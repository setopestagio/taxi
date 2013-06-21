<?php

class Application_Model_PrintPendencies
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

	public function createPdf($data,$pendencies,$auxiliars)
	{
		$this->header($data);
		$this->content($data,$pendencies,$auxiliars);
		$this->footer();
    $this->pdf->pages[] = $this->page;
    return $this->pdf;
	}

	protected function header($data)
	{

    $image = Zend_Pdf_Image::imageWithPath(APPLICATION_PATH . '/../public/img/brasao.png');
    $this->page->drawImage($image, 54, 747, 118, 811);

    // Horizontal Lines
    $this->page->setLineWidth(2)
        ->drawLine(50, 820, 545 , 820);

    $this->page->setLineWidth(2)
        ->drawLine(50, 740, 545, 740);

    $this->page->setLineWidth(1)
        ->drawLine(450, 780, 545, 780);

    // Vertical Lines
    $this->page->setLineWidth(2)
        ->drawLine(51, 740, 51, 819);

    $this->page->setLineWidth(2)
        ->drawLine(544, 740, 544, 820);

    $this->page->setLineWidth(0.5)
        ->drawLine(120, 740, 120, 820);

    $this->page->setLineWidth(0.5)
        ->drawLine(450, 740, 450, 820);

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                    ->drawText('SUPERINTENDÊNCIA DE TRANSPORTE METROPOLITANO', 135, 780, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),10)
                    ->drawText('EXTRATO DE PENDÊNCIAS', 205, 760, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                    ->drawText('Permissão', 453, 809, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),13)
                    ->drawText($data->permission, 465, 790, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                    ->drawText('Placa', 453, 770, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),13)
                    ->drawText($data->plate, 465, 750, 'UTF-8');
	}

	protected function content($data,$pendencies,$auxiliars)
	{
		// Horizontal Lines
    $this->page->setLineWidth(2)
        ->drawLine(50, 736, 545 , 736);

    $this->page->setLineWidth(2)
        ->drawLine(50, 500, 545, 500);

    $this->page->setLineWidth(1)
        ->drawLine(50, 722, 545, 722);

    $this->page->setLineWidth(1)
        ->drawLine(50, 682, 545, 682);

    $this->page->setLineWidth(1)
        ->drawLine(50, 640, 545, 640);

    $this->page->setLineWidth(1)
        ->drawLine(50, 627, 545, 627);

    $this->page->setLineWidth(0.3)
        ->drawLine(50, 613, 545, 613);

    // Vertical Lines
    $this->page->setLineWidth(2)
        ->drawLine(51, 736, 51, 500);

    $this->page->setLineWidth(2)
        ->drawLine(544, 736, 544, 500);

    $this->page->setLineWidth(1)
        ->drawLine(357, 722, 357, 682);

    $this->page->setLineWidth(1)
        ->drawLine(450, 722, 450, 682);

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),10)
                    ->drawText('PERMISSIONÁRIO', 250, 725, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),10)
                    ->drawText('PENDÊNCIAS', 260, 630, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                    ->drawText('Permissionário', 55, 712, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),12)
                    ->drawText($data->name, 55, 692, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                    ->drawText('Início Permissão', 360, 712, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),12)
                    ->drawText(Application_Model_General::dateToBr($data->start_permission), 365, 692, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                    ->drawText('Baixa Permissão', 453, 712, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),12)
                    ->drawText(Application_Model_General::dateToBr($data->end_permission), 457, 692, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                    ->drawText('Condutor(es) Auxiliar(es): ', 55, 670, 'UTF-8');

    $this->pendencies($pendencies);
    $this->auxiliars($auxiliars);
	}

	protected function auxiliars($auxiliars)
	{
		if(isset($auxiliars[0]))
		{
			$this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                    	->drawText($auxiliars[0]['name'], 170, 670, 'UTF-8');
		}
		if(isset($auxiliars[1]))
		{
			$this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                    	->drawText($auxiliars[1]['name'], 170, 650, 'UTF-8');
		}
		
	}

	protected function pendencies($pendencies)
	{

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                    ->drawText('Data do auto', 75, 617, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                    ->drawText('Pendência/Nada Consta', 155, 617, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                    ->drawText('Artigo', 330, 617, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                    ->drawText('Notificação', 435, 617, 'UTF-8');

    if($pendencies == 'NADA CONSTA')
    {
   		$this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                    	->drawText($pendencies, 155, 600, 'UTF-8');
    }
    else
    {

    }
	}

	protected function footer()
	{

		// Horizontal Lines
    $this->page->setLineWidth(2)
        ->drawLine(50, 495, 545 , 495);

    $this->page->setLineWidth(2)
        ->drawLine(50, 440, 545, 440);

    $this->page->setLineWidth(1)
        ->drawLine(58, 460, 150, 460);

    $this->page->setLineWidth(1)
        ->drawLine(258, 460, 450, 460);

    // Vertical Lines
    $this->page->setLineWidth(2)
        ->drawLine(51, 495, 51, 440);

    $this->page->setLineWidth(2)
        ->drawLine(544, 495, 544, 440);

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                    ->drawText('Data', 57, 483, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),12)
                    ->drawText(date('d/m/Y'), 75, 463, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                    ->drawText('Assinatura DCM', 315, 450, 'UTF-8');
	}
}

