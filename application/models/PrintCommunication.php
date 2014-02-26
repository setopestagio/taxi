<?php

class Application_Model_PrintCommunication
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

	public function createPdf($data, $post)
	{
		try{
  		$this->header();
  		$this->headerData($data,$post);
  		$this->content($post);
  		$this->footer($post);
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
                    ->drawText('COMUNICAÇÃO AO ORGÃO DE TRÂNSITO', 215, 760, 'UTF-8');
  }

  protected function headerData($data,$post)
	{
		// Horizontal Lines
    $this->page->setLineWidth(1.5)
        ->drawLine(50, 735, 545, 735);

    $this->page->setLineWidth(1.5)
        ->drawLine(51, 690, 546, 690);

    $this->page->setLineWidth(1.5)
        ->drawLine(51, 686, 546, 686);

    $this->page->setLineWidth(1.5)
        ->drawLine(51, 645, 546, 645);

    $this->page->setLineWidth(1.5)
        ->drawLine(51, 600, 546, 600);

    // Vertical Lines
    $this->page->setLineWidth(2)
        ->drawLine(51, 690, 51, 735);

    $this->page->setLineWidth(2)
        ->drawLine(545, 690, 545, 735);

    $this->page->setLineWidth(2)
        ->drawLine(51, 600, 51, 686);

    $this->page->setLineWidth(2)
        ->drawLine(545, 600, 545, 686);

    $this->page->setLineWidth(1)
        ->drawLine(320, 645, 320, 686);

    $this->page->setLineWidth(1)
        ->drawLine(385, 645, 385, 686);

    $this->page->setLineWidth(1)
        ->drawLine(190, 600, 190, 645);

    $this->page->setLineWidth(1)
        ->drawLine(297, 600, 297, 645);

    $this->page->setLineWidth(1)
        ->drawLine(415, 600, 415, 645);

    $this->page->setLineWidth(1)
        ->drawLine(460, 600, 460, 645);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Destinatário', 55, 725, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),12)
                ->drawText($post['receiver'], 55, 705, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Nome', 55, 676, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),12)
                ->drawText($data->name, 55, 657, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Permissão', 323, 676, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),12)
                ->drawText($data->permission, 323, 657, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Placa', 390, 676, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),12)
                ->drawText($data->plate, 390, 657, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Chassi', 55, 635, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),12)
                ->drawText($data->chassi, 58, 613, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Marca', 193, 635, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),12)
                ->drawText($data->vehicle_brand, 195, 613, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Modelo', 300, 635, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),12)
                ->drawText(Application_Model_General::cutString($data->vehicle_model,10), 300, 613, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Ano Mod.', 418, 635, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),12)
                ->drawText($data->year_model, 420, 613, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Cor', 465, 635, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),12)
                ->drawText(Application_Model_General::cutString($data->color,5), 465, 613, 'UTF-8');
	}

	protected function content($data)
	{
    // Horizontal Lines
    $this->page->setLineWidth(2)
        ->drawLine(50, 596, 545 , 596);

    $this->page->setLineWidth(2)
        ->drawLine(50, 150, 545, 150);

    // Vertical Lines
    $this->page->setLineWidth(2)
        ->drawLine(51, 150, 51, 596);

    $this->page->setLineWidth(2)
        ->drawLine(545, 150, 545, 596);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('O proprietário do veículo acima especificado preencheu os requisitos exigidos pela SETOP para realizar', 60, 570, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('as seguintes operações:', 60, 558, 'UTF-8');

    // Squares
    $this->page->setLineWidth(0.5)
        ->drawLine(80, 520, 90 , 520);
    $this->page->setLineWidth(0.5)
        ->drawLine(80, 530, 90, 530);
    $this->page->setLineWidth(0.5)
        ->drawLine(80, 520, 80, 530);
    $this->page->setLineWidth(0.5)
        ->drawLine(90, 520, 90, 530);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('1', 100, 522, 'UTF-8');
    if($data['operation'] == 1)
    {
        $this->page->setLineWidth(0.5)
            ->drawLine(80, 520, 90 , 530);
        $this->page->setLineWidth(0.5)
            ->drawLine(80, 530, 90, 520);
        $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText($data['transfer'], 100, 440, 'UTF-8');

        $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText('XXXXXXXXXXXXXXXXXXXXXXXXXXXXX', 115, 360, 'UTF-8');
        $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText('XXXXXXXXXXXXXXXXXXX', 385, 360, 'UTF-8');
        $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX', 75, 290, 'UTF-8');
        $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX', 75, 230, 'UTF-8');
    }

    $this->page->setLineWidth(0.5)
        ->drawLine(170, 520, 180 , 520);
    $this->page->setLineWidth(0.5)
        ->drawLine(170, 530, 180, 530);
    $this->page->setLineWidth(0.5)
        ->drawLine(170, 520, 170, 530);
    $this->page->setLineWidth(0.5)
        ->drawLine(180, 520, 180, 530);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('2', 190, 522, 'UTF-8');

    if($data['operation'] == 2)
    {
        $this->page->setLineWidth(0.5)
            ->drawLine(170, 520, 180 , 530);
        $this->page->setLineWidth(0.5)
            ->drawLine(170, 530, 180, 520);
        $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText($data['brandCar'], 115, 360, 'UTF-8');
        $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText($data['chassi'], 385, 360, 'UTF-8');
        $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX', 100, 440, 'UTF-8');
        $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX', 75, 290, 'UTF-8');
        $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX', 75, 230, 'UTF-8');
    }

    $this->page->setLineWidth(0.5)
        ->drawLine(260, 520, 270 , 520);
    $this->page->setLineWidth(0.5)
        ->drawLine(260, 530, 270, 530);
    $this->page->setLineWidth(0.5)
        ->drawLine(260, 520, 260, 530);
    $this->page->setLineWidth(0.5)
        ->drawLine(270, 520, 270, 530);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('3', 280, 522, 'UTF-8');

    if($data['operation'] == 3)
    {
        $this->page->setLineWidth(0.5)
            ->drawLine(260, 520, 270 , 530);
        $this->page->setLineWidth(0.5)
            ->drawLine(260, 530, 270, 520);
        $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText('Início da Reserva: '.$data['start_date_reservation'], 75, 290, 'UTF-8');

        $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX', 100, 440, 'UTF-8');
        $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText('XXXXXXXXXXXXXXXXXXXXXXXXXXXXX', 115, 360, 'UTF-8');
        $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText('XXXXXXXXXXXXXXXXXXX', 385, 360, 'UTF-8');
        $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX', 75, 230, 'UTF-8');
    }

    $this->page->setLineWidth(0.5)
        ->drawLine(360, 520, 350 , 520);
    $this->page->setLineWidth(0.5)
        ->drawLine(360, 530, 350, 530);
    $this->page->setLineWidth(0.5)
        ->drawLine(360, 520, 360, 530);
    $this->page->setLineWidth(0.5)
        ->drawLine(350, 520, 350, 530);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('4', 370, 522, 'UTF-8');

    if($data['operation'] == 4)
    {
        $this->page->setLineWidth(0.5)
            ->drawLine(350, 520, 360 , 530);
        $this->page->setLineWidth(0.5)
            ->drawLine(350, 530, 360, 520);
         $this->page->setLineWidth(0.5)
            ->drawLine(450, 520, 460 , 530);
        $this->page->setLineWidth(0.5)
            ->drawLine(450, 530, 460, 520);
        if($data['plate'] != '')
        {
          $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
              ->drawText('Placa: '.$data['plate'], 75, 230, 'UTF-8');
        }
        if($data['reservationDatePlate'] != '')
        {

          $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),13)
                ->drawText('RESERVADA', 240, 250, 'UTF-8');
          $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),13)
                ->drawText('Em: '.$data['reservationDatePlate'], 420, 250, 'UTF-8');
        }


        $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX', 100, 440, 'UTF-8');
        $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText('XXXXXXXXXXXXXXXXXXXXXXXXXXXXX', 115, 360, 'UTF-8');
        $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText('XXXXXXXXXXXXXXXXXXX', 385, 360, 'UTF-8');
        $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX', 75, 290, 'UTF-8');
    }
    if($data['operation'] == 5)
    {
        $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX', 100, 440, 'UTF-8');
        $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText('XXXXXXXXXXXXXXXXXXXXXXXXXXXXX', 115, 360, 'UTF-8');
        $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText('XXXXXXXXXXXXXXXXXXX', 385, 360, 'UTF-8');
        $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX', 75, 290, 'UTF-8');
        $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD),11)
                ->drawText('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX', 75, 230, 'UTF-8');
    }

    $this->page->setLineWidth(0.5)
        ->drawLine(450, 520, 460 , 520);
    $this->page->setLineWidth(0.5)
        ->drawLine(450, 530, 460, 530);
    $this->page->setLineWidth(0.5)
        ->drawLine(450, 520, 450, 530);
    $this->page->setLineWidth(0.5)
        ->drawLine(460, 520, 460, 530);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('5', 470, 522, 'UTF-8');


    $this->page->setLineWidth(0.5)
        ->drawLine(450, 520, 460 , 530);
    $this->page->setLineWidth(0.5)
        ->drawLine(450, 530, 460, 520);
    $textSize = 70;
    $count = 0;
    $height = 188;
    while($count < strlen($data['other']))
    {
        $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText(Application_Model_General::formatLongText($data['other'],$count,$textSize), 75, $height, 'UTF-8');
                $count += $textSize;
                $height -= 11;
    }

    $this->page->setLineWidth(1)
        ->drawLine(50, 500, 545, 500);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('1 - Transferência do veículo', 75, 470, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('Para: ', 75, 440, 'UTF-8');

    $this->page->setLineWidth(1)
        ->drawLine(50, 420, 545, 420);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('2 - Substituição do veículo acima pelo de marca: ', 75, 390, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('Modelo: ', 75, 360, 'UTF-8');
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('Chassi: ', 350, 360, 'UTF-8');

    $this->page->setLineWidth(1)
        ->drawLine(50, 340, 545, 340);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('3 - Reserva da permissão: ', 75, 310, 'UTF-8');

    $this->page->setLineWidth(1)
        ->drawLine(50, 280, 545, 280);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('4 - Emplacamento - Permissão ', 75, 250, 'UTF-8');

    $this->page->setLineWidth(1)
        ->drawLine(50, 220, 545, 220);
    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('5 - Outros: ', 75, 200, 'UTF-8');
	}

	protected function footer($data)
	{
		// Horizontal Lines
    $this->page->setLineWidth(2)
        ->drawLine(50, 146, 545 , 146);

    $this->page->setLineWidth(2)
        ->drawLine(50, 80, 545, 80);

    // Vertical Lines
    $this->page->setLineWidth(2)
        ->drawLine(51, 80, 51, 146);

    $this->page->setLineWidth(2)
        ->drawLine(545, 80, 545, 146);

    $this->page->setLineWidth(1)
        ->drawLine(170, 80, 170, 146);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('Validade', 55, 135, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),12)
                ->drawText($data['end_date_communication'], 75, 105, 'UTF-8');

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),11)
                ->drawText('Belo Horizonte, '.date('d/m/Y'), 190, 125, 'UTF-8');

    $this->page->setLineWidth(1)
        ->drawLine(250, 100, 480, 100);

    $this->page ->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),9)
                ->drawText('SETOP', 350, 90, 'UTF-8');
	}

}

