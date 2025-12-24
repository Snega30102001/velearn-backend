<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CourseType;
use Illuminate\Http\Request;
use Exception;

class CourseTypeController extends Controller
{
    public function index()
    {
        try {
            return response()->json([
                'status' => true,
                'data'   => CourseType::with('course')->get()
            ]);
        } catch (Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'course_id' => 'required|exists:courses,id',
                'name'      => 'required'
            ]);

            $type = CourseType::create($request->all());

            return response()->json(['status'=>true,'data'=>$type],201);

        } catch (Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],500);
        }
    }

    public function show(CourseType $courseType)
    {
        try {
            return response()->json([
                'status' => true,
                'data'   => $courseType->load('course')
            ]);
        } catch (Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],500);
        }
    }

    public function update(Request $request, CourseType $courseType)
    {
        try {
            $courseType->update($request->all());
            return response()->json(['status'=>true,'data'=>$courseType]);

        } catch (Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],500);
        }
    }

    public function destroy(CourseType $courseType)
    {
        try {
            $courseType->delete();
            return response()->json(['status'=>true,'message'=>'Course type deleted']);

        } catch (Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],500);
        }
    }

    public function getTypesByCourse($id)
    {
        $types = CourseType::where('course_id', $id)->get();

        return response()->json([
            'status' => true,
            'data' => $types
        ]);
    }
}
