<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
class CsvDataImportService extends BaseService {

	public function import($file, $importType) {

		$factory = new CsvDataImportFactory();
		$instance = $factory->getImportClassInstance($importType);
		$rowsImported = 0;
		$row = 1;
		if (($handle = fopen($file->getTempName(), "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$num = count($data);
				$temp = array();
				$row++;
				if ($row != 2) {
					for ($c = 0; $c < $num; $c++) {
						$temp[] = $data[$c];
					}
					$result = $instance->import($temp);
					if($result) {
						$rowsImported++;
					}
				}
			}
			fclose($handle);
		}
		return $rowsImported;
	}

}

?>
