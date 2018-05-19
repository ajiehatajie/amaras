<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Storage;
use App\Template;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TemplateController extends Controller
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
            $template = Template::where('name', 'LIKE', "%$keyword%")
                ->orWhere('file', 'LIKE', "%$keyword%")
                ->orWhere('notes', 'LIKE', "%$keyword%")
                ->paginate($perPage);
        } else {
            $template = Template::paginate($perPage);
        }

        return view('admin.template.index', compact('template'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.template.create');
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
			'name' => 'required',
			'file' => 'required|max:50000|mimes:docx,doc,rtf'
		]);
        $requestData = $request->all();
        $uploadedFile = $request->file('file');      
       
        $now = Carbon::now();                
        
        $path = $now->toDateString();
        $pathUpload = $uploadedFile->store('template');
       

        Template::create([
            'name' => $requestData['name'],
            'file' => $pathUpload
        ]);

        return redirect('admin/template')->with('flash_message', 'Template added!');
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
        $template = Template::findOrFail($id);

        return view('admin.template.show', compact('template'));
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
        $template = Template::findOrFail($id);

        return view('admin.template.edit', compact('template'));
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
			'name' => 'required',
			'file' => 'required'
		]);
        $requestData = $request->all();
        
        $template = Template::findOrFail($id);
        $template->update($requestData);

        return redirect('admin/template')->with('flash_message', 'Template updated!');
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
        $template = Template::findOrFail($id);
      
        Storage::delete($template->filename);
        Template::destroy($id);

        return redirect('admin/template')->with('flash_message', 'Template deleted!');
    }


   


}
