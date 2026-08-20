<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends Base_Controller {
	
	public function __construct()
	{
		// Set module id
		$this->module_id = TAM_MODULE_ID_REPORT;
		
		parent::__construct();
		
		// Load model
		$this->load->model("rpt_model");
		// Load libraries used by this controller. PHPExcel is loaded lazily by the Excel export.
		$this->load->library('zip');
		
		// Set max execution time		
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 0);
		set_time_limit(0);
	}
	public function attendance_excel()
	{
		try
		{
			$this->assertReportReadPermission();
			$this->load->library('Excel');
			$rows = $this->rpt_model->GetAttendanceReportData()->result_array();
			$data = array();

			foreach ($rows as $row)
			{
				$data[] = array(
					$row['attendance_id']
				, 	$this->formatAttendanceValue($row['attendance_date'], 'Y-m-d')
				, 	$row['student_no']
				, 	$row['student_name']
				, 	$row['department']
				, 	$row['activity_name']
				, 	$row['attendance_status']
				, 	$this->formatAttendanceValue($row['check_in_time'], 'Y-m-d H:i')
				);
			}

			$this->excel->createXLS('Attendance Report');
			$this->excel->printTable(0, array(
				'Attendance ID', 'Attendance Date', 'Student No.', 'Student Name',
				'Department', 'Activity', 'Status', 'Check-in Time'
			), $data);
			$this->excel->outputXLS('attendance_report.xlsx');
			exit;
		}
		catch (Exception $ex)
		{
			$this->json_responder->Error($ex);
		}
	}

	public function attendance_pdf()
	{
		try
		{
			$this->assertReportReadPermission();
			$rows = $this->rpt_model->GetAttendanceReportData()->result_array();

			require_once APPPATH . 'third_party/dompdf/autoload.inc.php';
			$dompdf = new \Dompdf\Dompdf();
			$dompdf->loadHtml($this->buildAttendancePdfHtml($rows), 'UTF-8');
			$dompdf->setPaper('A4', 'landscape');
			$dompdf->render();
			$dompdf->stream('attendance_report.pdf', array('Attachment' => TRUE));
			exit;
		}
		catch (Exception $ex)
		{
			$this->json_responder->Error($ex);
		}
	}

	private function assertReportReadPermission()
	{
		if ( ! can_read($this->modulePermissions))
		{
			throw new Exception(
				sprintf("No permission to %s [<b>%s</b>].", "read", $this->data["module_name"])
			, 	ERROR_CODE_PERMISSION_DENIED
			);
		}
	}

	private function formatAttendanceValue($value, $format)
	{
		if ($value === NULL || $value === '')
		{
			return '';
		}

		if ($value instanceof DateTimeInterface)
		{
			return $value->format($format);
		}

		$timestamp = strtotime((string) $value);
		return $timestamp === FALSE ? (string) $value : date($format, $timestamp);
	}

	private function buildAttendancePdfHtml($rows)
	{
		$html = '<!DOCTYPE html><html><head><meta charset="UTF-8"><style>';
		$html .= 'body{font-family:DejaVu Sans, sans-serif;font-size:10px;}';
		$html .= 'h1{font-size:18px;margin-bottom:4px;}';
		$html .= 'table{width:100%;border-collapse:collapse;}';
		$html .= 'th,td{border:1px solid #777;padding:5px;text-align:left;}';
		$html .= 'th{background:#e8eef5;}';
		$html .= '</style></head><body>';
		$html .= '<h1>Attendance Report</h1>';
		$html .= '<table><thead><tr>';

		foreach (array('Attendance ID', 'Attendance Date', 'Student No.', 'Student Name', 'Department', 'Activity', 'Status', 'Check-in Time') as $heading)
		{
			$html .= '<th>' . htmlspecialchars($heading, ENT_QUOTES, 'UTF-8') . '</th>';
		}

		$html .= '</tr></thead><tbody>';
		foreach ($rows as $row)
		{
			$html .= '<tr>';
			foreach (array(
				$row['attendance_id'], $this->formatAttendanceValue($row['attendance_date'], 'Y-m-d'), $row['student_no'],
				$row['student_name'], $row['department'], $row['activity_name'],
				$row['attendance_status'], $this->formatAttendanceValue($row['check_in_time'], 'Y-m-d H:i')
			) as $value)
			{
				$html .= '<td>' . htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8') . '</td>';
			}
			$html .= '</tr>';
		}
		$html .= '</tbody></table></body></html>';

		return $html;
	}

}
