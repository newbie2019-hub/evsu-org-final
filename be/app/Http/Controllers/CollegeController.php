<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollegeRequest;
use App\Models\College;
use Illuminate\Http\Request;

class CollegeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showall()
    {
        return response()->json(College::get());
    }

    public function index(Request $request)
    {
        return response()->json(College::orderBy('college', $request->sort)->paginate(8));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CollegeRequest $request)
    {
        College::create($request->validated() + ['abbreviation' => $request->abbreviation]);
        return $this->success('College saved successfully!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CollegeRequest $request, $id)
    {
        $college = College::find($id);
        if(!empty($college)) {
            $college->update($request->validated() + ['abbreviation' => $request->abbreviation]);
            return $this->success('College information updated successfully!');
        }
        else {
            return $this->error('College saved successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        College::destroy($id);
        return $this->success('College deleted successfully!');
    }
}
