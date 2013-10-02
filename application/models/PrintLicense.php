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
        $this->page->drawImage($image, 34, 620, 190, 760);

		    $image = Zend_Pdf_Image::imageWithPath(APPLICATION_PATH . '/../public/img/brasao.png');
        $this->page->drawImage($image, 14, 781, 60, 818);

        // Horizontal Lines
        $this->page->setLineWidth(1)
            ->drawLine(11, 820, 280 , 820);

        $this->page->setLineWidth(1)
            ->drawLine(11, 630, 280, 630);

        $this->page->setLineWidth(1)
            ->drawLine(11, 780, 280, 780);

        $this->page->setLineWidth(1)
            ->drawLine(11, 750, 280, 750);

        $this->page->setLineWidth(1)
            ->drawLine(11, 710, 195, 710);

        $this->page->setLineWidth(1)
            ->drawLine(11, 670, 195, 670);

        $this->page->setLineWidth(1)
            ->drawLine(11, 600, 280, 600);

        // Vertical Lines
        $this->page->setLineWidth(1)
            ->drawLine(11, 600, 11, 820);

        $this->page->setLineWidth(1)
            ->drawLine(280, 600, 280, 820);

        $this->page->setLineWidth(1)
            ->drawLine(65, 780, 65, 820);

        $this->page->setLineWidth(1)
            ->drawLine(195, 630, 195, 750);

        $this->page->setLineWidth(1)
            ->drawLine(100, 630, 100, 670);

        $this->page->setLineWidth(1)
            ->drawLine(170, 600, 170, 630);

        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),9)
                        ->drawText('SUPERINTENDÊNCIA DE TRANSPORTE', 88, 810, 'UTF-8');
        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),9)
                        ->drawText('METROPOLITANO', 130, 800, 'UTF-8');
        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),12)
                        ->drawText('CERTIFICADO DE CONDUTOR TÁXI', 67, 786, 'UTF-8');
        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),12)
                        ->drawText('TÁXI ESPECIAL', 17, 760, 'UTF-8');
        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),12)
                        ->drawText(date('Y'), 250, 760, 'UTF-8');
        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                        ->drawText('Portador', 15, 740, 'UTF-8');
        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                        ->drawText('Permissionário', 15, 700, 'UTF-8');
        if(strlen($data->name) > 25)
        {
    	  	$this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),10)
    	                    ->drawText(Application_Model_General::cutString($data->name,20), 15, 728, 'UTF-8');
    	    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),10)
    	                    ->drawText(Application_Model_General::resumeString($data->name,20), 13, 718, 'UTF-8');
    	    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),10)
    	                    ->drawText(Application_Model_General::cutString($data->name_grantee,20), 15, 688, 'UTF-8');
    	    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),10)
    	                    ->drawText(Application_Model_General::resumeString($data->name_grantee,20), 13, 678, 'UTF-8');
        }
        else
        {
        	$this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),10)
                            ->drawText(Application_Model_General::cutString($data->name,20), 15, 720, 'UTF-8');
    	    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),10)
    	                    ->drawText(Application_Model_General::cutString($data->name_grantee,20), 15, 680, 'UTF-8');
        }
        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                        ->drawText('Permissão', 15, 660, 'UTF-8');
        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),12)
                        ->drawText($data->permission, 20, 640, 'UTF-8');
        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                        ->drawText('Placa', 103, 660, 'UTF-8');
        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),12)
                        ->drawText($data->plate, 105, 640, 'UTF-8');
        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                        ->drawText('Assinatura do Portador', 15, 620, 'UTF-8');
        $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),10)
                        ->drawText('Visto da SETOP', 175, 620, 'UTF-8');
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

