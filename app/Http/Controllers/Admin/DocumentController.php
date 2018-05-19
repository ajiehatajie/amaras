<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Document;
use Illuminate\Http\Request;
use App\Category;
use App\Company;
use App\Template;
use App\Profile;
use App\User;
use PhpOffice\PhpWord\PhpWord;
use Storage;
use Carbon\Carbon;


class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $document = Document::where('nomor', 'LIKE', "%$keyword%")
                ->orWhere('companies_id', 'LIKE', "%$keyword%")
                ->orWhere('categories_id', 'LIKE', "%$keyword%")
                ->orWhere('date', 'LIKE', "%$keyword%")
                ->orWhere('price', 'LIKE', "%$keyword%")
                ->orWhere('templates_id', 'LIKE', "%$keyword%")
                ->orWhere('user_id', 'LIKE', "%$keyword%")
                ->paginate($perPage);
        } else {
            $document = Document::paginate($perPage);
        }

        return view('admin.document.index', compact('document'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $category = Category::pluck('name','id');
        $company  = Company::pluck('name','id');
        $template = Template::pluck('name','id');

        return view('admin.document.create',compact('category','company','template'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
			'nomor' => 'required',
			'date' => 'required'
		]);
        $requestData = $request->all();
        
        $templateRender = Template::findOrfail($requestData['templates_id']);
        $company        = Company::findOrfail($requestData['companies_id']);
        $profile        = Profile::findOrfail(1);

        $baca           = storage_path('app/'.$templateRender->file);
        $now            = Carbon::now();    

        $slug = str_slug($company->name,'-');

        $folderResult = Storage::disk('local')->makeDirectory('result/'.$now->toDateString());

        $path   = 'app/result/'.$now->toDateString().'/'.$slug.'.docx';
        $result = storage_path($path);

        $phpWord = new PhpWord();
        $doc = $phpWord->loadTemplate($baca);
        $doc-> setValue('NOMOR',$requestData['nomor']);
        $doc-> setValue('TGL_SURAT',$requestData['date']);
        $doc-> setValue('NILAI',$requestData['price']);
        $doc-> setValue('KEPADA',$company->name);
        $doc-> setValue('ALAMAT',$company->address);
        $doc-> setValue('DIREKTUR',$profile->position);
        $doc-> setValue('TTD',$profile->ttd);
        
        
        
        $doc->saveAs($result);
        

        Document::create([
            'nomor' => $requestData['nomor'],
            'companies_id' => $requestData['companies_id'],
            'categories_id' => $requestData['categories_id'],
            'date' => $requestData['date'],
            'price' => $requestData['price'],
            'templates_id' => $requestData['templates_id'],
            'documentfinal' => $path,
            'user_id' => 1
        ]);

        return redirect('admin/document')->with('flash_message', 'Document added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $document = Document::findOrFail($id);

        return view('admin.document.show', compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $document = Document::findOrFail($id);

        return view('admin.document.edit', compact('document'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
			'nomor' => 'required',
			'date' => 'required'
		]);
        $requestData = $request->all();
        
        $document = Document::findOrFail($id);
        $document->update($requestData);

        return redirect('admin/document')->with('flash_message', 'Document updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Document::destroy($id);

        return redirect('admin/document')->with('flash_message', 'Document deleted!');
    }
}
