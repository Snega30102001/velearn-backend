<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Courses;
use Illuminate\Http\Request;
use Exception;

class CourseController extends Controller
{
    public function index()
    {
        try {
            return response()->json([
                'status' => true,
                'data'   => Courses::all()
            ]);
        } catch (Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|unique:courses,name'
            ]);

            $course = Courses::create($request->all());

            return response()->json(['status'=>true,'data'=>$course],201);

        } catch (Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],500);
        }
    }

    public function show(Courses $course)
    {
        try {
            return response()->json([
                'status' => true,
                'data'   => $course
            ]);
        } catch (Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],500);
        }
    }

    public function update(Request $request, Courses $course)
    {
        try {

            $request->validate([
                'name' => 'required|unique:courses,name,' . $course->id
            ]);

            $course->update($request->all());

            return response()->json(['status'=>true,'data'=>$course]);

        } catch (Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],500);
        }
    }

    public function destroy(Courses $course)
    {
        try {
            $course->delete();
            return response()->json(['status'=>true,'message'=>'Course deleted']);

        } catch (Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],500);
        }
    }
}
