<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollegeRequest;
use App\Http\Requests\CourseRequest;
use App\Models\College;
use App\Models\Course;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => ['showall']]);
    }

    public function showall()
    {
        return response()->json(Course::with(['college:id,college'])->get());
    }
    
    public function index(Request $request)
    {
        return response()->json(Course::with(['college:id,college'])->orderBy('course', $request->sort)->paginate(8));
    }

    public function store(CourseRequest $request)
    {
       Course::create($request->validated() + ['abbreviation' => $request->abbreviation]);
       return $this->success('Course added succesfully!');
    }

    public function update(CourseRequest $request, $id)
    {
        $course = Course::find($id);
        if(!empty($course)) {
            $course->update($request->validated() + ['abbreviation' => $request->abbreviation]);
            return $this->success('Course updated successfully!');
        }
        else {
            return $this->error('Course id not found');
        }
    }

    public function destroy($id)
    {
        Course::destroy($id);
        return $this->success('Course deleted successfully!');
    }
}
