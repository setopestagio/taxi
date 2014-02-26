<?php

class Application_Model_PrintConfirmation
{

	protected $pdf;
	protected $page;
	protected $font;
	protected $data;

	public function __construct()
	{
		$this->pdf = new Zend_Pdf();
    $this->page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
    $this->font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
	}

	public function getData($id)
	{
		$scheduling = new Application_Model_DbTable_Scheduling();
		return $scheduling->fetchRow($scheduling->select()->where('id = ?',$id) );
	}

	public function createPdf($id)
	{
		try{
			$this->data = $this->getData($id);
  		$this->header();
  		$this->body();
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
    $this->page->drawImage($image, 54, 747, 122, 811);

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

    $this->page->setLineWidth(2)
        ->drawLine(125, 740, 125, 820);

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),13)
                    ->drawText('SUPERINTENDÊNCIA DE TRANSPORTE METROPOLITANO', 150, 780, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                    ->drawText('CONFIRMAÇÃO DE AGENDAMENTO', 235, 760, 'UTF-8');
  }

  protected function body()
  {
    $image = Zend_Pdf_Image::imageWithPath(APPLICATION_PATH . '/../public/img/minas.png');
    $this->page->drawImage($image, 180, 520, 400, 700);

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),17)
                    ->drawText('Nome: ', 100, 630, 'UTF-8');
    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),17)
                    ->drawText($this->data->name, 150, 630, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),15)
                    ->drawText('Data: ', 100, 600, 'UTF-8');
    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),15)
                    ->drawText(Application_Model_General::dateToBr($this->data->date), 150, 600, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),15)
                    ->drawText('Hora: ', 100, 570, 'UTF-8');
    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),15)
                    ->drawText($this->data->str_hour, 150, 570, 'UTF-8');

    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),12)
                    ->drawText('Rodovia Prefeito Américo Gianetti, Serra Verde', 100, 450, 'UTF-8');
    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),12)
                    ->drawText('SETOP - Prédio Minas, Sétimo andar', 100, 435, 'UTF-8');
    $this->page     ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),12)
                    ->drawText('Cidade Administrativa - Belo Horizonte', 100, 420, 'UTF-8');



                    

  }

}

