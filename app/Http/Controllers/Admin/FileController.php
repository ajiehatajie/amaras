<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use App\Template;
use PhpOffice\PhpWord\PhpWord;

class FileController extends Controller
{

    public function __construct() 
    {
        \PhpOffice\PhpWord\Settings::setZipClass(\PhpOffice\PhpWord\Settings::PCLZIP);
      
    }
    public function View(Template $file)
    {
        return Storage::response($file->file);
    }
    public function Download(Template $file)
    {
        
        return Storage::download($file->file);
    }

    public function ReadFile($file) 
    {
        $data = Template::findOrFail($file);
       
        $baca = storage_path('app/'.$data->file);
        $result = storage_path('app/result/amaras.docx');

        return response()->file($result);
      
        $phpWord = new PhpWord();
        $doc = $phpWord->loadTemplate($baca);
        $doc-> setValue('userName','AMARAS');
        $doc-> setValue('weekday','Minggu');
        
        $doc->saveAs($result);
        dd($doc);
        echo $doc;

    }

}
