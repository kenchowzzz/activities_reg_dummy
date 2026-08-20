<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH."/third_party/PHPExcel.php";

class Excel extends PHPExcel {
	
	protected $excelObj;
	protected $sheet_config;

    public function __construct() {
		
        parent::__construct();

    }
	
	public function createXLS($title = "Sheet1") {
		$this->excelObj = new PHPExcel;
		$this->sheet_config = array();
		
		// init first sheet
		$this->excelObj->setActiveSheetIndex(0);
		$this->excelObj->getActiveSheet()->setTitle($title);
		$this->sheet_config[0] = array(
			'row_pointer' => 1
		);
		
		return 0;
	}
	
	public function createNewSheet($title) {
		$this->excelObj->createSheet(sizeof($this->sheet_config));
		$this->excelObj->setActiveSheetIndex(sizeof($this->sheet_config));
		$this->excelObj->getActiveSheet()->setTitle($title);
		$this->sheet_config[sizeof($this->sheet_config)] = array(
			'row_pointer' => 1
		);
		
		return sizeof($this->sheet_config) - 1;
	}
	
	public function addLine($sheet, $line, $merge = 2, $bold = false, $font_size = 11, $col = 0, $autosize = false, $word_wrap = false, $row_height = -1) {
		if (isset($this->sheet_config[$sheet])) {
			$this->excelObj->setActiveSheetIndex($sheet);
			$this->excelObj->getActiveSheet()->getCellByColumnAndRow($col, $this->sheet_config[$sheet]['row_pointer'])->setValue($line);
			$this->excelObj->getActiveSheet()->getCellByColumnAndRow($col, $this->sheet_config[$sheet]['row_pointer'])->getStyle()->getFont()->setBold($bold);
			$this->excelObj->getActiveSheet()->getCellByColumnAndRow($col, $this->sheet_config[$sheet]['row_pointer'])->getStyle()->getFont()->setSize($font_size);
			if ($autosize) {
				$this->excelObj->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col))->setAutoSize(true);
			}
			if ($merge > 1) {
				$this->excelObj->getActiveSheet()->mergeCellsByColumnAndRow($col, $this->sheet_config[$sheet]['row_pointer'], ($col + $merge - 1), $this->sheet_config[$sheet]['row_pointer']);
			}
			if ($word_wrap)
			{
				$this->excelObj->getActiveSheet()->getCellByColumnAndRow($col, $this->sheet_config[$sheet]['row_pointer'])->getStyle()->getAlignment()->setWrapText(true);
			}
			if ($row_height > 0)
			{
				$this->excelObj->getActiveSheet()->getRowDimension($this->sheet_config[$sheet]['row_pointer'])->setRowHeight($row_height);
			}
			
			$this->sheet_config[$sheet]['row_pointer'] = $this->sheet_config[$sheet]['row_pointer'] + 1;
		} else {
			throw new Exception('Invalid sheet');
		}
	}
	
	
	/*
	 * $mode: 1 - Vertical Headers
	 * 		  2 - Horizontal headers
	 */
	public function printTable($sheet, $itemArr = array(), $itemData = array(), $int_as_text = false, $mode = 2, $col = 0, $word_wrap = false, $highlights = array()) {
		if (isset($this->sheet_config[$sheet])) {
			$this->excelObj->setActiveSheetIndex($sheet);
			if (sizeof($itemArr) > 0 && sizeof($itemData) > 0) {
				if ($mode == 1) {
					foreach ($itemData as $dataRow) {
						$curCol = $col;
						$curRow = $this->sheet_config[$sheet]['row_pointer'];
						if (sizeof($dataRow) == sizeof($itemArr)) {
							foreach ($itemArr as $item) {
								$this->excelObj->getActiveSheet()->getCellByColumnAndRow($curCol, $curRow)->setValue($item);
								$this->excelObj->getActiveSheet()->getCellByColumnAndRow($curCol, $curRow)->getStyle()->getFont()->setBold(true);
								if ($int_as_text) {
									$this->excelObj->getActiveSheet()->getCellByColumnAndRow($curCol, $curRow)->getStyle()->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
								}
								$curRow++;
							}
							$curRow = $this->sheet_config[$sheet]['row_pointer'];
							$curCol++;
							foreach ($dataRow as $data) {
								$this->excelObj->getActiveSheet()->getCellByColumnAndRow($curCol, $curRow)->setValue($data);
								if ($int_as_text) {
									$this->excelObj->getActiveSheet()->getCellByColumnAndRow($curCol, $curRow)->getStyle()->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
								}
								if ($word_wrap)
								{
									// Set word wrap to true for '\r' new line charater
									$this->excelObj->getActiveSheet()->getCellByColumnAndRow($curCol, $curRow)->getStyle()->getAlignment()->setWrapText(true);
								}

								$curRow++;
							}
							$this->sheet_config[$sheet]['row_pointer'] = $this->sheet_config[$sheet]['row_pointer'] + sizeof($itemArr) + 1;
						}
						else
						{
							throw new Exception(sprintf('The size of $itemArr[%s] and $dataRow[%s] is not mapped.', sizeof($itemArr), sizeof($dataRow)));
						}
					}
				} else if ($mode == 2) {
					// print head
					$curCol = $col;
					foreach ($itemArr as $item) {
						$this->excelObj->getActiveSheet()->getCellByColumnAndRow($curCol, $this->sheet_config[$sheet]['row_pointer'])->setValue($item);
						$this->excelObj->getActiveSheet()->getCellByColumnAndRow($curCol, $this->sheet_config[$sheet]['row_pointer'])->getStyle()->getFont()->setBold(true);
						if ($int_as_text) {
							$this->excelObj->getActiveSheet()->getCellByColumnAndRow($curCol, $this->sheet_config[$sheet]['row_pointer'])->getStyle()->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
						}
						$curCol++;
					}
					$this->sheet_config[$sheet]['row_pointer'] = $this->sheet_config[$sheet]['row_pointer'] + 1;
					// print data
					foreach ($itemData as $dataRow) {
						if (sizeof($dataRow) == sizeof($itemArr)) {
							$curCol = $col;
							foreach ($dataRow as $data) {
								$this->excelObj->getActiveSheet()->getCellByColumnAndRow($curCol, $this->sheet_config[$sheet]['row_pointer'])->setValue($data);
								if ($int_as_text) {
									$this->excelObj->getActiveSheet()->getCellByColumnAndRow($curCol, $this->sheet_config[$sheet]['row_pointer'])->getStyle()->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
								}
								if ($word_wrap)
								{
									// Set word wrap to true for '\r' new line charater
									$this->excelObj->getActiveSheet()->getCellByColumnAndRow($curCol, $this->sheet_config[$sheet]['row_pointer'])->getStyle()->getAlignment()->setWrapText(true);
								}
								$curCol++;
							}
							$this->sheet_config[$sheet]['row_pointer'] = $this->sheet_config[$sheet]['row_pointer'] + 1;
						}
						else
						{
							throw new Exception(sprintf('The size of $itemArr[%s] and $dataRow[%s] is not mapped.', sizeof($itemArr), sizeof($dataRow)));
						}
					}
				} else {
					throw new Exception('Invalid mode');
				}
			}

			//highlight
			foreach($highlights as $highlight){
				$this->excelObj->getActiveSheet()->getStyle($highlight["cell"])->getFont()->getColor()->setARGB($highlight["color"]);
			}
			
		}
	}

	/*
	 * $mode: 1 - Vertical Headers
	 * 		  2 - Horizontal headers
	 */
	public function printTableWithCellOptions($sheet, $itemArr = array(), $itemData = array(), $mode = 2, $col = 0, $word_wrap = FALSE) {
		if (isset($this->sheet_config[$sheet])) {
			$this->excelObj->setActiveSheetIndex($sheet);
			
			$active_sheet_obj = $this->excelObj->getActiveSheet();
			
			if (sizeof($itemArr) > 0 && sizeof($itemData) > 0) {
				if ($mode == 1) {
					foreach ($itemData as $dataRow) {
						$curCol = $col;
						$curRow = $this->sheet_config[$sheet]['row_pointer'];
						if (sizeof($dataRow) == sizeof($itemArr)) {
							foreach ($itemArr as $item) {
								$active_sheet_obj->getCellByColumnAndRow($curCol, $curRow)->setValue($item['value']);
								$active_sheet_obj->getCellByColumnAndRow($curCol, $curRow)->getStyle()->getFont()->setBold(true);
								$this->setCellByOptions($active_sheet_obj, $sheet, $curCol, $item);
								$curRow++;
							}
							$curRow = $this->sheet_config[$sheet]['row_pointer'];
							$curCol++;
							foreach ($dataRow as $data) {
								$this->setCellByOptions($active_sheet_obj, $sheet, $curCol, $data);
								$curRow++;
							}
							$this->sheet_config[$sheet]['row_pointer'] = $this->sheet_config[$sheet]['row_pointer'] + sizeof($itemArr) + 1;
						}
						else
						{
							throw new Exception(sprintf('The size of $itemArr[%s] and $dataRow[%s] is not mapped.', sizeof($itemArr), sizeof($dataRow)));
						}
					}
				} else if ($mode == 2) {
					// print head
					$curCol = $col;
					foreach ($itemArr as $item) {
						$active_sheet_obj->getCellByColumnAndRow($curCol, $this->sheet_config[$sheet]['row_pointer'])->setValue($item['value']);
						$active_sheet_obj->getCellByColumnAndRow($curCol, $this->sheet_config[$sheet]['row_pointer'])->getStyle()->getFont()->setBold(true);
						$this->setCellByOptions($active_sheet_obj, $sheet, $curCol, $item);
						$curCol++;
					}
					$this->sheet_config[$sheet]['row_pointer'] = $this->sheet_config[$sheet]['row_pointer'] + 1;
					// print data
					foreach ($itemData as $dataRow) {
						if (sizeof($dataRow) == sizeof($itemArr)) {
							$curCol = $col;
							foreach ($dataRow as $data) {
								$this->setCellByOptions($active_sheet_obj, $sheet, $curCol, $data);
								$curCol++;
							}
							$this->sheet_config[$sheet]['row_pointer'] = $this->sheet_config[$sheet]['row_pointer'] + 1;
						}
						else
						{
							throw new Exception(sprintf('The size of $itemArr[%s] and $dataRow[%s] is not mapped.', sizeof($itemArr), sizeof($dataRow)));
						}
					}
					
					if ($word_wrap)
					{
						$active_sheet_obj->getStyle('A1:'.PHPExcel_Cell::stringFromColumnIndex($curCol-1).$active_sheet_obj->getHighestRow())->getAlignment()->setWrapText(true); 
					}
				} else {
					throw new Exception('Invalid mode');
				}
			}
		}
	}
	
	public function setColumnWidth($sheet, $col, $width) {
		if (isset($this->sheet_config[$sheet])) {
			$this->excelObj->setActiveSheetIndex($sheet);
			$this->excelObj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth($width);
		} else {
			throw new Exception('Invalid sheet');
		}
	}
	
	public function setColumnWidthAutoSize($sheet) {
		if (isset($this->sheet_config[$sheet])) {
			$this->excelObj->setActiveSheetIndex($sheet);
			$cell_iterator = $this->excelObj->getActiveSheet()->getRowIterator()->current()->getCellIterator();
		    $cell_iterator->setIterateOnlyExistingCells(FALSE);
		    foreach ($cell_iterator as $cell) {
		        $this->excelObj->getActiveSheet()->getColumnDimension($cell->getColumn())->setAutoSize(true);
		    }
		} else {
			throw new Exception('Invalid sheet');
		}
	}
	
	public function setRowHeightAutoSize($sheet) {
		if (isset($this->sheet_config[$sheet])) {
			$this->excelObj->setActiveSheetIndex($sheet);
		    foreach ($this->excelObj->getActiveSheet()->getRowDimensions() as $rd) {
		        $rd->setRowHeight(-1); 
		    }
		} else {
			throw new Exception('Invalid sheet');
		}
	}
	
	public function outputXLS($filename = "output.xlsx") {
		$this->excelObj->setActiveSheetIndex(0);
		// Redirect output to a client’s web browser (Excel5)
		ob_clean();
		header('Cache-Control: max-age=0');
		// header('Content-Type: text/html; charset=UTF-8');
		header('Content-Disposition: attachment;filename="'. $filename .'"');
		
		if (end_with($filename, FILE_FORMAT_XLS)) {
			header('Content-Type: application/vnd.ms-excel');
			$objWriter = PHPExcel_IOFactory::createWriter($this->excelObj, 'Excel5');
		}
		else if(end_with($filename, FILE_FORMAT_CSV)){
			header('Content-Type: text/csv');
			$objWriter = PHPExcel_IOFactory::createWriter($this->excelObj, 'CSV');
			$objWriter->setPreCalculateFormulas(false);
		} else {
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			$objWriter = PHPExcel_IOFactory::createWriter($this->excelObj, 'Excel2007');
		}
		// header('Content-Type: application/vnd.ms-excel');
		// $objWriter = PHPExcel_IOFactory::createWriter($this->excelObj, 'Excel5');
		$objWriter->save('php://output');
	}


	/**
	 * $data: $active_sheet_obj
	 * 		  $data['value']
	 *		  $data['number_format']
	 * 		  $data['word_wrap'] - Not recommend to set word wrap cell by cell due to performance issue
	 */
	private function setCellByOptions($active_sheet_obj, $sheet, $curCol, $data) {
		if (isset($this->sheet_config[$sheet])) {
			// Set number format (Default: Number)
			if (isset($data['number_format']) && $data['number_format'])
			{
				$active_sheet_obj->getCellByColumnAndRow($curCol, $this->sheet_config[$sheet]['row_pointer'])->getStyle()->getNumberFormat()->setFormatCode($data['number_format']);
			}
			
			// Set value
			if (isset($data['number_format']) && $data['number_format'] == PHPExcel_Style_NumberFormat::FORMAT_TEXT)
			{
				$active_sheet_obj->getCellByColumnAndRow($curCol, $this->sheet_config[$sheet]['row_pointer'])->setValueExplicit($data['value'], PHPExcel_Cell_DataType::TYPE_STRING);
			}
			else
			{
				$active_sheet_obj->getCellByColumnAndRow($curCol, $this->sheet_config[$sheet]['row_pointer'])->setValue($data['value']);
			}
			
			// Set word wrap
			if (isset($data['word_wrap']) && $data['word_wrap'])
			{
				// Set word wrap to true for '\r' new line charater
				$active_sheet_obj->getCellByColumnAndRow($curCol, $this->sheet_config[$sheet]['row_pointer'])->getStyle()->getAlignment()->setWrapText(true);
			}
		} else {
			throw new Exception('Invalid sheet');
		}
	}
}
