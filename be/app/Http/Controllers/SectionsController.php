<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => ['showall']]);
    }
    
    public function showall()
    {
        return response()->json(Section::get(['id', 'section', 'year_level']));
    }

    public function index(Request $request)
    {
        return response()->json(Section::orderBy('section', $request->sort)->paginate(8));
    }

    public function store(SectionRequest $request)
    {
        Section::create($request->validated());
       return $this->success('Section added succesfully!');
    }

    public function update(SectionRequest $request, $id)
    {
        $org = Section::find($id);
        if(!empty($org)) {
            $org->update($request->validated());
            return $this->success('Section updated successfully!');
        }
        else {
            return $this->error('Section id not found');
        }
    }

    public function destroy($id)
    {
        Section::destroy($id);
        return $this->success('Section deleted successfully!');
    }
}
