<?php

class Application_Model_PrintLicense
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

	public function createPdf($data,$endDate)
	{
    	try{
      		$this->front($data);
      		$this->back($data,$endDate);
            $this->pdf->pages[] = $this->page;
            return $this->pdf;
        }catch(Zend_Pdf_Exception $e){
          die('PDF error: ' . $e->getMessage());
        }
        catch(Zend_Exception $e){
          die('Error: ' . $e->getMessage());
        }
	}

	protected function front($data)
	{
        $image = Zend_Pdf_Image::imageWithPath(APPLICATION_PATH . '/../public/img/minas.png');
        $this->page->drawImage($image, 44, 620, 200, 760);

		$image = Zend_Pdf_Image::imageWithPath(APPLICATION_PATH . '/../public/img/brasao.png');
        $this->page->drawImage($image, 24, 781, 70, 818);

        // Horizontal Lines
        $this->page->setLineWidth(1)
        ->drawLine(20, 820, 300 , 820);

        $this->page->setLineWidth(1)
            ->drawLine(20, 630, 300, 630);

        $this->page->setLineWidth(1)
            ->drawLine(20, 780, 300, 780);

        $this->page->setLineWidth(1)
            ->drawLine(20, 750, 300, 750);

        $this->page->setLineWidth(1)
            ->drawLine(20, 710, 205, 710);

        $this->page->setLineWidth(1)
            ->drawLine(20, 670, 205, 670);

        $this->page->setLineWidth(1)
            ->drawLine(20, 600, 300, 600);

        // Vertical Lines
        $this->page->setLineWidth(1)
            ->drawLine(21, 600, 21, 820);

        $this->page->setLineWidth(1)
            ->drawLine(300, 600, 300, 820);

        $this->page->setLineWidth(1)
            ->drawLine(75, 780, 75, 820);

        $this->page->setLineWidth(1)
            ->drawLine(205, 630, 205, 750);

        $this->page->setLineWidth(1)
            ->drawLine(110, 630, 110, 670);

        $this->page->setLineWidth(1)
            ->drawLine(180, 600, 180, 630);

        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),9)
                        ->drawText('SUPERINTENDÊNCIA DE TRANSPORTE', 98, 810, 'UTF-8');
        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),9)
                        ->drawText('METROPOLITANO', 140, 800, 'UTF-8');
        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),12)
                        ->drawText('CERTIFICADO DE CONDUTOR TÁXI', 79, 786, 'UTF-8');
        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),12)
                        ->drawText('TÁXI ESPECIAL', 30, 760, 'UTF-8');
        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),12)
                        ->drawText(date('Y'), 265, 760, 'UTF-8');
        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                        ->drawText('Portador', 25, 740, 'UTF-8');
        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                        ->drawText('Permissionário', 25, 700, 'UTF-8');
        if(strlen($data->name) > 29)
        {
    	  	$this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),10)
    	                    ->drawText(Application_Model_General::cutString($data->name,25), 25, 728, 'UTF-8');
    	    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),10)
    	                    ->drawText(Application_Model_General::resumeString($data->name,25), 23, 718, 'UTF-8');
    	    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),10)
    	                    ->drawText(Application_Model_General::cutString($data->name,25), 25, 688, 'UTF-8');
    	    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),10)
    	                    ->drawText(Application_Model_General::resumeString($data->name,25), 23, 678, 'UTF-8');
        }
        else
        {
        	$this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),10)
                            ->drawText(Application_Model_General::cutString($data->name,25), 25, 720, 'UTF-8');
    	    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),10)
    	                    ->drawText(Application_Model_General::cutString($data->name,25), 25, 680, 'UTF-8');
        }
        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                        ->drawText('Permissão', 25, 660, 'UTF-8');
        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),12)
                        ->drawText($data->permission, 35, 640, 'UTF-8');
        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                        ->drawText('Placa', 113, 660, 'UTF-8');
        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),12)
                        ->drawText($data->plate, 125, 640, 'UTF-8');
        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                        ->drawText('Assinatura do Portador', 25, 620, 'UTF-8');
        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                        ->drawText('Visto da SETOP', 190, 620, 'UTF-8');
	}

	protected function back($data,$endDate='')
	{
		// Horizontal Lines
    $this->page->setLineWidth(1)
        ->drawLine(310, 820, 590 , 820);

    $this->page->setLineWidth(1)
        ->drawLine(310, 600, 590, 600);

    $this->page->setLineWidth(1)
        ->drawLine(310, 770, 590, 770);

    $this->page->setLineWidth(1)
        ->drawLine(310, 720, 590, 720);

    // Vertical Lines
    $this->page->setLineWidth(1)
        ->drawLine(310, 600, 310, 820);

    $this->page->setLineWidth(1)
        ->drawLine(590, 600, 590, 820);

    $this->page->setLineWidth(1)
        ->drawLine(420, 720, 420, 820);

    $this->page->setLineWidth(1)
        ->drawLine(310, 600, 310, 820);


    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                    ->drawText('Vinculação', 315, 810, 'UTF-8');
    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),16)
                    ->drawText(Application_Model_General::dateToBr($data->start_permission), 320, 785, 'UTF-8');
    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                    ->drawText('Válido até', 315, 760, 'UTF-8');
    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),16)
                    ->drawText($endDate, 320, 735, 'UTF-8');
    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                    ->drawText('Rúbrica', 425, 810, 'UTF-8');
    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                    ->drawText('Rúbrica', 425, 760, 'UTF-8');
    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                    ->drawText('Observações Importantes', 315, 705, 'UTF-8');
    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                    ->drawText('1- Usá-lo sempre em serviço;', 315, 685, 'UTF-8');
    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                    ->drawText('2- Em caso de perda ou extravio, comunicar imediatamente', 315, 665, 'UTF-8');
    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                    ->drawText('a SETOP;', 315, 655, 'UTF-8');
    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                    ->drawText('3- É obrigatório devolver este Certificado a SETOP quando', 315, 635, 'UTF-8');
    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                    ->drawText('efetuar sua baixa e/ou transferência', 315, 625, 'UTF-8');

	}

}

