<?php

namespace App\Http\Controllers\Teachers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Section;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Classroom;
use App\Models\Gender;
use App\Models\Grade;
use App\Models\Image;
use App\Models\My_Parent;
use App\Models\Nationalitie;

use App\Models\Fee_invoice;

use App\Models\Type_Blood;
use App\Models\parCode;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{

    public function index()
    {

        $ids = DB::table('teacher_section')->where('teacher_id', auth()->user()->id)->pluck('section_id');
         $students = Student::whereIn('section_id', $ids)->get();

        return view('pages.Teachers.dashboard.students.index', compact('students'));
    }

    public function sections()
    {
        $ids = DB::table('teacher_section')->where('teacher_id', auth()->user()->id)->pluck('section_id');
        $sections = Section::whereIn('id', $ids)->get();
        return view('pages.Teachers.dashboard.sections.index', compact('sections'));
    }


    public function show($id)
    {

           $Student = Student::with(['qr_code','attendance','Fee_invoice','degree'])->findorfail($id);


           return  view('pages.Students.show',compact('Student'));
    }

    public function edit($id)
    {
        $data['Grades'] = Grade::all();
        $data['parents'] = My_Parent::all();
        $data['Genders'] = Gender::all();
        $data['nationals'] = Nationalitie::all();
        $data['bloods'] = Type_Blood::all();
        $Students =  Student::findOrFail($id);
        return view('pages.Teachers.dashboard.students.edit',$data,compact('Students'));
    }


    public function Update_Student(REQUEST $request)
    {
        try {




            $Edit_Students = Student::findorfail($request->id);
            $Edit_Students->name = ['ar' => $request->name_ar, 'en' => $request->name_en];
            $Edit_Students->Date_Birth = $request->Date_Birth;
            $Edit_Students->Grade_id = $request->Grade_id;
            $Edit_Students->Classroom_id = $request->Classroom_id;
            $Edit_Students->section_id = $request->section_id;
            $Edit_Students->parent_id = $request->parent_id;
            $Edit_Students->academic_year = $request->academic_year;
            $Edit_Students->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('student.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function attendance(Request $request)
    {

        try {

            $attenddate = date('Y-m-d');
            foreach ($request->attendences as $studentid => $attendence) {

                if ($attendence == 'presence') {
                    $attendence_status = true;
                } else if ($attendence == 'absent') {
                    $attendence_status = false;
                }

                Attendance::updateorCreate(
                    [
                        'student_id' => $studentid,
                        'attendence_date' => $attenddate
                    ],
                    [
                    'student_id' => $studentid,
                    'grade_id' => $request->grade_id,
                    'classroom_id' => $request->classroom_id,
                    'section_id' => $request->section_id,
                    'teacher_id' => 1,
                    'attendence_date' => $attenddate,
                    'attendence_status' => $attendence_status
                ]);
            }
            toastr()->success(trans('messages.success'));
            return redirect()->back();
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function editAttendance(Request $request)
    {

        try {
            $date = date('Y-m-d');
            $student_id = Attendance::where('attendence_date', $date)->where('student_id', $request->id)->first();
            if ($request->attendences == 'presence') {
                $attendence_status = true;
            } else if ($request->attendences == 'absent') {
                $attendence_status = false;
            }
            $student_id->update([
                'attendence_status' => $attendence_status
            ]);
            toastr()->success(trans('messages.success'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function attendanceReport()
    {

      //  $ids = DB::table('teacher_section')->where('teacher_id', auth()->user()->id)->pluck('section_id');
      //  $students = Student::whereIn('section_id', $ids)->get();

      $ids = DB::table('teacher_section')->where('teacher_id', auth()->user()->id)->pluck('section_id');
      $students = Student::whereIn('section_id', $ids)->get();


        return view('pages.Teachers.dashboard.students.attendance_report', compact('students'));

    }

    public function attendanceSearch(Request $request)
    {

        $request->validate([
            'from' => 'required|date|date_format:Y-m-d',
            'to' => 'required|date|date_format:Y-m-d|after_or_equal:from'
        ], [
            'to.after_or_equal' => 'تاريخ النهاية لابد ان اكبر من تاريخ البداية او يساويه',
            'from.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
            'to.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
        ]);


        $ids = DB::table('teacher_section')->where('teacher_id', auth()->user()->id)->pluck('section_id');
        $students = Student::whereIn('section_id', $ids)->get();
        $idsTudents = Student::whereIn('section_id', $ids)->pluck('id');
        // return $idsTudents;
        if ($request->student_id == 0) {

            $Students = Attendance::whereIn('student_id',$idsTudents)->whereBetween('attendence_date', [$request->from, $request->to])->get();


            return view('pages.Teachers.dashboard.students.attendance_report', compact('Students','students'));
        } else {

            $Students = Attendance::whereBetween('attendence_date', [$request->from, $request->to])
                ->where('student_id', $request->student_id)->get();
            return view('pages.Teachers.dashboard.students.attendance_report', compact('Students','students'));


        }


    }




    public function FeesReport(){



        $ids = DB::table('teacher_section')->where('teacher_id', auth()->user()->id)->pluck('section_id');
         $students = Student::whereIn('section_id', $ids)->get();

        return view('pages.Teachers.fee_invoices.fees_reports', compact('students'));
    }

    public function FeesSearch(Request $request)
    {



        $request->validate([
            'from' => 'required|date|date_format:Y-m-d',
            'to' => 'required|date|date_format:Y-m-d|after_or_equal:from'
        ], [
            'to.after_or_equal' => 'تاريخ النهاية لابد ان اكبر من تاريخ البداية او يساويه',
            'from.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
            'to.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
        ]);



        $ids = DB::table('teacher_section')->where('teacher_id', auth()->user()->id)->pluck('section_id');
        $students = Student::whereIn('section_id', $ids)->get();
        $idsTudents = Student::whereIn('section_id', $ids)->pluck('id');


        if ($request->student_id == 0) {

            $feeInvoices = Fee_invoice::whereIn('student_id',$idsTudents)->whereBetween('Date', [$request->from, $request->to])->get();
           // return $feeInvoices;
            return view('pages.Teachers.fee_invoices.fees_reports', compact('students','feeInvoices'));

        } else {

            $feeInvoices = Fee_invoice::whereBetween('Date', [$request->from, $request->to])
                ->where('student_id', $request->student_id)->get();
             //   return $feeInvoices;
                return view('pages.Teachers.fee_invoices.fees_reports', compact('students','feeInvoices'));

        }


    }


    public function destroy(Request $request)
    {

        Student::destroy($request->id);
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('student.index');
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


}
