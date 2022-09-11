<?php

namespace App\Http\Controllers\Teachers\dashboard\Degree;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specialization;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
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

        $degrees =degree::where('teacher_id',auth('teacher')->user()->id)->with(['specialized','student'])->get();

        $ids = DB::table('teacher_section')->where('teacher_id', auth()->user()->id)->pluck('section_id');
         $students = Student::whereIn('section_id', $ids)->get();
        $specializations = Specialization::all();

    return view('pages.Teachers.dashboard.Degree.index',compact('degrees','students','specializations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $specializations = Specialization::all();
        $ids = DB::table('teacher_section')->where('teacher_id', auth()->user()->id)->pluck('section_id');
         $students = Student::whereIn('section_id', $ids)->get();

     //   return  $students;
        return view('pages.Teachers.dashboard.Degree.create',compact(['students','specializations']));
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
             'teacher_id'=>auth()->user()->id
        ]);

return redirect()->route('Degree1.index');
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
return redirect()->route('Degre1e.index');

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
        return redirect()->route('Degree1.index');

    }
}
