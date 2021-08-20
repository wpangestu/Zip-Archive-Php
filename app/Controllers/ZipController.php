<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use ZipArchive;
use CodeIgniter\HTTP\IncomingRequest;
class ZipController extends BaseController
{
	public function index()
	{
		//

		return view('main');
	}

	public function generateZip(){
		try {
			//code...

			$zip = new ZipArchive();
			$filename = "your_zip.zip";
			
			if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
				exit("cannot open <$filename>\n");
			}
			$request = service('request');
			$custom_file = $request->getPost('custom_file');
			$file = $request->getFile('file');

			// create a file and pass the content to second parameter
			$zip->addFromString("custom_file.txt", $custom_file);
			
			// Add file from localrootdirectory and rename it
			$zip->addFile(FCPATH."index.php","enjoy.php");
			// $zip->addFile($file);
			
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
}
