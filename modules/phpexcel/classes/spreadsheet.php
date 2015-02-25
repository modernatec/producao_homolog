<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * PHP Excel library. Helper class to make spreadsheet creation easier.
 *
 * @package    Spreadsheet
 * @author     Flynsarmy
 * @website    http://www.flynsarmy.com/
 * @license    TEH FREEZ
 */
class Spreadsheet
{
	const VENDOR_PACKAGE = "vendor/PHPExcel/";
	private $_spreadsheet;

	/*
	 * Purpose: Creates the spreadsheet with given or default settings
	 * Input: array $headers with optional parameters: title, subject, description, author
	 * Returns: void
	 */
	public function __construct($headers=array())
	{
		$headers = array_merge(array(
			'title'			=> 'Relatorios produção',
			'subject'		=> 'Relatorios produção',
			'description'	=> 'relatorios produção',
			'author'		=> 'Flow - Moderna',

		), $headers);

		$this->_spreadsheet = new PHPExcel();
		// Set properties
		$this->_spreadsheet->getProperties()
			->setCreator( $headers['author'] )
			->setTitle( $headers['title'] )
			->setSubject( $headers['subject'] )
			->setDescription( $headers['description'] );
			//->setActiveSheetIndex(0);
		$this->_spreadsheet->getActiveSheet()->setTitle($headers['title']);
	}

	/*
	 * Purpose Writes cells to the spreadsheet
	 * Input: array of array( [row] => array([col]=>[value]) ) ie $arr[row][col] => value
	 * Returns: void
	 */
	public function setData(array $data, $multi_sheet=false)
	{
		if ( empty($this->_spreadsheet) )
			$this->create();

		//Single sheet ones can just dump everything to the current sheet
		if ( !$multi_sheet )
		{
			$Sheet = $this->_spreadsheet->getActiveSheet();
			$this->setSheetData( $data, $Sheet );
		}
		//Hvae to do a little more work with multi-sheet
		else
		{
			foreach ( $data as $sheetName=>$sheetData )
			{
				$Sheet = $this->_spreadsheet->createSheet();
				$Sheet->setTitle( $sheetName );
				$this->setSheetData( $sheetData, $Sheet );
			}
			//Now remove the auto-created blank sheet at start of XLS
			$this->_spreadsheet->removeSheetByIndex( 0 );
		}
	}

	public function setSheetData( array $data, PHPExcel_Worksheet $Sheet )
	{	
		/*
		'font'  => array(
	        	'color' => array('rgb' => '000000'),
	    	),
		*/
		$header = array(	
			'font'  => array(
	        	'color' => array('rgb' => 'ffffff'),
	        	'bold'  => true,
	    	),    	
	    	'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        ),
	    	'fill' => array(
	            'type' => PHPExcel_Style_Fill::FILL_SOLID,
	            'color' => array('rgb' => '000000')
	        ),
			'borders' => array(
				'top' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000'),
				),
				'bottom' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000'),
				),
				'vertical' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000'),
				),
			),

	    );

		$linhaPar = array(
	    	'fill' => array(
	            'type' => PHPExcel_Style_Fill::FILL_SOLID,
	            'color' => array('rgb' => 'ffffff')
	        ),
	        'alignment' => array(
	            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        ),
			'borders' => array(
				'top' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000'),
				),
				'bottom' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000'),
				),
				'vertical' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000'),
				),
			),

	    );

	    $linhaImpar = array(
	    	
	    	'fill' => array(
	            'type' => PHPExcel_Style_Fill::FILL_SOLID,
	            'color' => array('rgb' => 'c1c1c1')
	        ),
	        'alignment' => array(
	            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        ),
			'borders' => array(
				'top' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000'),
				),
				'bottom' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000'),
				),
				'vertical' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000'),
				),
			),

	    );

	    $atrasoPar = array(
	    	'font'  => array(
	        	'color' => array('rgb' => 'ff0000'),
	    	),
	    	'alignment' => array(
	            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        ),
	    	'fill' => array(
	            'type' => PHPExcel_Style_Fill::FILL_SOLID,
	            'color' => array('rgb' => 'ffffff')
	        ),
			'borders' => array(
				'top' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000'),
				),
				'bottom' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000'),
				),
				'vertical' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000'),
				),
			),

	    );

	    $atrasoImpar = array(
	    	'font'  => array(
	        	'color' => array('rgb' => 'ff0000'),
	    	),
	    	'alignment' => array(
	            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        ),
	    	'fill' => array(
	            'type' => PHPExcel_Style_Fill::FILL_SOLID,
	            'color' => array('rgb' => 'c1c1c1')
	        ),
			'borders' => array(
				'top' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000'),
				),
				'bottom' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000'),
				),
				'vertical' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000'),
				),
			),

	    );



	    /*
	    $styleArray3 = array(
	    	'font'  => array(
	        	'color' => array('rgb' => '0eaa19'),
	    	),
	    	'borders' => array(
				'top' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
				'bottom' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
				'vertical' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),
	    );
	    */

	    $letters = range('A','Z');
	    $rows_filter = 0;

		foreach ( $data as $row => $columns ){
			$col = 0;

			if ($rows_filter % 2 == 0) { 
				$cor = $linhaPar;
			}else{
				$cor = $linhaImpar;
			}

			
			echo '<pre>';
			foreach ( $columns as $column => $value ){								
				//$Sheet->setCellValueByColumnAndRow($col, $row, $value);
				$Sheet->setCellValueByColumnAndRow($col, $row, html_entity_decode($value,ENT_QUOTES,'UTF-8'));
				$Sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
				
				switch ($column) {
					case 'taxonomia':
							$new_value = explode("|", $value);
							$cell_link = $Sheet->getCellByColumnAndRow($col, $row);
							if(isset($new_value[1])){
								$cell_link->getHyperlink()->setUrl(urldecode($new_value[1]));
							}
							$Sheet->setCellValueByColumnAndRow($col, $row, html_entity_decode($new_value[0],ENT_QUOTES,'UTF-8'));
						break;
					case 'data_envio':
						//$cor = ($value < PHPExcel_Shared_Date::FormattedPHPToExcel(date('Y'), date('m'), date('d'))) ? $styleArray2 : $cor;
						$Sheet->getStyleByColumnAndRow($col, $row)->getNumberFormat()->setFormatCode(
        PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX14);
						break;	
					case 'data_retorno':
						$atraso = ($value < PHPExcel_Shared_Date::FormattedPHPToExcel(date('Y'), date('m'), date('d'))) ? true : false;
						if($atraso){
							$cor = ($rows_filter % 2 == 0) ? $atrasoPar : $atrasoImpar;
						}

						$Sheet->getStyleByColumnAndRow($col, $row)->getNumberFormat()->setFormatCode(
        PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX14);
						break;
					case 'fechamento':
						//$cor = ($value < PHPExcel_Shared_Date::FormattedPHPToExcel(date('Y'), date('m'), date('d'))) ? $styleArray2 : $cor;
						$Sheet->getStyleByColumnAndRow($col, $row)->getNumberFormat()->setFormatCode(
        PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX14);
						break;
					case 'fechamento_colecao':
						//$cor = ($value < PHPExcel_Shared_Date::FormattedPHPToExcel(date('Y'), date('m'), date('d'))) ? $styleArray2 : $cor;
						$Sheet->getStyleByColumnAndRow($col, $row)->getNumberFormat()->setFormatCode(
        PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX14);
						break;
					case 'anotacoes':
						$Sheet->getColumnDimensionByColumn($col)->setAutoSize(false);
						$Sheet->getColumnDimensionByColumn($col)->setWidth(50);
						$Sheet->getStyleByColumnAndRow($col, $row)->getAlignment()->setWrapText(true);
						break;

					case 'status':
						//$cor = ($value == 'finalizado') ? $finalizado : $cor;
						break;						
				}

				/*
				* Estilo das linhas
				*/
				$Sheet->getStyle('A'.$row.':'.$letters[$col].$row)->applyFromArray($cor);
				$col++;
			}
			$rows_filter++;
		}
		//exit();

		/*
		* Estilo do Header
		*/
		$Sheet->setAutoFilter('A1:'.$letters[$col-1].$rows_filter);
		$Sheet->getStyle('A1:'.$letters[$col-1].'1')->applyFromArray($header);
		$Sheet->getRowDimension(1)->setRowHeight(20);
		
		
	}

	/*
	 * Purpose: Writes spreadsheet to file
	 * Input: array $settings with optional parameters: format, path, name (no extension)
	 * Returns: Path to spreadsheet
	 */
	public function save( $settings=array() )
	{
		if ( empty($this->_spreadsheet) )
			$this->create();

		//Used for saving sheets
		require self::VENDOR_PACKAGE.'IOFactory.php';

		$settings = array_merge(array(
			'format'		=> 'Excel2007',
			'path'			=> 'public/',
			'name'			=> 'NewSpreadsheet'

		), $settings);

		//Generate full path
		$settings['fullpath'] = $settings['path'] . $settings['name'] . '_'.date('d').date('m').date('Y').'.xlsx';

		$Writer = PHPExcel_IOFactory::createWriter($this->_spreadsheet, $settings['format']);
		// If you want to output e.g. a PDF file, simply do:
		//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
		$Writer->save( $settings['fullpath'] );
		return $settings['fullpath'];
	}

	public function read(){
		if ( empty($this->_spreadsheet) )
			$this->create();

		//Used for saving sheets
		require self::VENDOR_PACKAGE.'IOFactory.php';

		$inputFileName = 'public/html5_teste.xlsx';

		//  Read your Excel workbook
		try {
		    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
		    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
		    $objPHPExcel = $objReader->load($inputFileName);
		} catch(Exception $e) {
		    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
		}

		//  Get worksheet dimensions
		return $sheet = $objPHPExcel->getSheet(0); 
		


	}
}