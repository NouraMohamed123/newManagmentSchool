<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentsRequest;
use App\Repository\StudentRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\parcode;
use App\Models\Attendance;

use App\Models\Grade;
use Illuminate\Support\Facades\DB;
use App\Models\Student;


class StudentController extends Controller
{

    protected $Student;

    public function __construct(StudentRepositoryInterface $Student)
    {
        $this->Student = $Student;
    }


    public function index()
    {
       return $this->Student->Get_Student();
    }


    public function create()
    {
        return $this->Student->Create_Student();
    }

    public function store(StoreStudentsRequest $request)
    {
       return $this->Student->Store_Student($request);
    }

    public function show($id){

     return $this->Student->Show_Student($id);

    }


    public function edit($id)
    {
       return $this->Student->Edit_Student($id);
    }


    public function update(StoreStudentsRequest $request)
    {
        return $this->Student->Update_Student($request);
    }


    public function destroy(Request $request)
    {
        return $this->Student->Delete_Student($request);
    }

    public function Get_classrooms($id)
    {
       return $this->Student->Get_classrooms($id);
    }

    public function Get_Sections($id)
    {
        return $this->Student->Get_Sections($id);
    }

    public function Upload_attachment(Request $request)
    {
        return $this->Student->Upload_attachment($request);
    }

    public function Download_attachment($studentsname,$filename)
    {
        return $this->Student->Download_attachment($studentsname,$filename);
    }

    public function Delete_attachment(Request $request)
    {
        return $this->Student->Delete_attachment($request);

    }
    public function Download_attachment_parcode($filename)
    {
        return $this->Student->Download_attachment_parcode($filename);
    }




    public function parcode($qrs){

        $qr1 = parcode::where('qr',$qrs)->first();



if ($qr1->student_id) {


    $student_data =Student::with(['grade','classroom','section'])->findorfail($qr1->student_id);


    if(Attendance::where('student_id',$qr1->student_id)->where('attendence_date',date('Y-m-d'))->count() == 1)
    {

        return response()->json([
            'msg'=>'هذا الطالب موجود مسبقا',
         ]

         );

    }else{
        Attendance::create([
            'student_id'=> $qr1->student_id,
            'grade_id'=> $student_data->Grade_id,



            'classroom_id'=> $student_data->Classroom_id,
            'section_id'=> $student_data->section_id,
            'teacher_id'=> 1,
            'attendence_date'=> date('Y-m-d'),
            'attendence_status'=>1
        ]);
        return response()->json([
            'students'=>$student_data,
         ]

         );
    }




}







    }




    public function attendanceReport()
    {


        $my_classes  =Grade::where('created_by',auth()->user()->id)->get();
      //  $ids = DB::table('teacher_section')->where('teacher_id', auth()->user()->id)->pluck('section_id');
      //  $students = Student::whereIn('section_id', $ids)->get();
       $students = Student::where('created_by',auth()->user()->id)->get();
        return view('pages.Students.attendence_report', compact('students','my_classes'));

    }

    public function attendanceSearch(Request $request)
    {



        $my_classes  =Grade::where('created_by',auth()->user()->id)->get();

        $request->validate([
            'from' => 'required|date|date_format:Y-m-d',
            'to' => 'required|date|date_format:Y-m-d|after_or_equal:from'
        ], [
            'to.after_or_equal' => 'تاريخ النهاية لابد ان اكبر من تاريخ البداية او يساويه',
            'from.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
            'to.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
        ]);



        if ($request->student_id == 0) {

            $Students = Attendance::whereBetween('attendence_date', [$request->from, $request->to])->where('grade_id',$request->Grade_id)->where('classroom_id',$request->Classroom_id)->where('section_id',$request->section_id)->get();

            return view('pages.Students.attendence_report', compact('Students','my_classes'));
        } else {

            $Students = Attendance::whereBetween('attendence_date', [$request->from, $request->to])
                ->where('student_id', $request->student_id)->get();
            return view('pages.Students.attendence_report', compact('Students','my_classes'));


        }


    }


    public function student_section()
    {
        $my_classes  =Grade::where('created_by',auth()->user()->id)->get();
        return view('pages.Students.student_group.report',compact('my_classes'));


    }

    public function student_section_id($id)
    {
       return  Student::where('created_by',auth()->user()->id)->where('section_id',$id)->pluck('name','id');


    }

    public function student_section_post(Request $request)
    {

     $Students =  Student::where('created_by',auth()->user()->id)->where('Grade_id',$request->Grade_id)->where('Classroom_id',$request->Classroom_id)->where('section_id',$request->section_id)->with('attendance')->get();
   $my_classes  =Grade::where('created_by',auth()->user()->id)->get();
   return view('pages.Students.student_group.report',compact('Students','my_classes'));

    }
}
