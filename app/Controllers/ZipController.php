<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use ZipArchive;

class ZipController extends BaseController
{
	public function index()
	{
		//
		try {
			//code...
			$zip = new ZipArchive();
			$filename = "test112.zip";
			
			if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
				exit("cannot open <$filename>\n");
			}
			
			// create a file and pass the content to second parameter
			$zip->addFromString("tes_file.txt", "Halo World Wpangestu");
			
			// Add file from localrootdirectory and rename it
			$zip->addFile(FCPATH."index.php","enjoy.php");

			
			$zip->close();


			$file = FCPATH.$filename;

			//Then download the zipped file.
			header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: private');
            header('Pragma: private');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
			unlink($file);
            exit;

		} catch (\Throwable $th) {
			//throw $th;
			d($th);			
		}

	}

	public function generateZip(){

	}
}
