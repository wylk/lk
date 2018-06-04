<?php
class Xls
{
	public static function download_csv($filename, $fields, $data)
	{
		$filename = date($filename . '_YmdHis', time()) . '.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename=' . $filename);
		header('Cache-Type: charset=gb2312');
		echo '﻿<style>table td{border:1px solid #ccc;}</style>';
		echo '<table>';
		echo '  <tr>';
		foreach ($fields as $field) {
			echo '      <th><b> ' . $field . ' </b></th>';
		}
		echo '  </tr>';
		$cnt = 0;
		$limit = 50000;
		foreach ($data as $key => $value) {
			++$cnt;
			if ($limit == $cnt) {
				ob_flush();
				flush();
				usleep(100);
				$cnt = 0;
			}
			echo '  <tr>';
			foreach ($value as $v) {
				echo '      <td align="center">' . $v . '</td>';
			}
			echo '  </tr>';
		}
		echo '</table>';
		exit;
	}
}