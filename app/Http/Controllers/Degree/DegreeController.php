<?php

namespace App\Http\Controllers\Degree;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specialization;
use App\Models\Student;
use App\Models\degree;
class DegreeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $degrees =degree::with('student1')->get();
        $students = Student::all();
        $specializations = Specialization::all();
            foreach($degrees as $degree ) {
               return  $degree;
            };
    return view('pages.Degree.index',compact('degrees','students','specializations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        $specializations = Specialization::all();
        $students = Student::all();

     //   return  $students;
        return view('pages.Degree.create',compact(['students','specializations']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       // return $request;
        degree::create([
            'student_id'=>$request->student_id,
            'specializations_id'=>$request->Specialization_id,
            'degree'=>$request->number,
             'teacher_id'=>1
        ]);

return redirect()->route('Degree.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
  $degree = degree::findorFail($request->id);
  $degree->update([
    'student_id'=>$request->student_id,
    'specializations_id'=>$request->specialized_id,
    'degree'=>$request->degree_value,
     'teacher_id'=>1
]);
toastr()->success(trans('messages.Update'));
return redirect()->route('Degree.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        degree::findorfail($request->id)->delete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Degree.index');

    }
}
