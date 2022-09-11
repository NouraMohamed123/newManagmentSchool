<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Repository\FeeInvoicesRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Fee_invoice;
class FeesInvoicesController extends Controller
{

    protected $Fees_Invoices;
    public function __construct(FeeInvoicesRepositoryInterface $Fees_Invoices)
    {
        $this->Fees_Invoices = $Fees_Invoices;
    }

    public function index()
    {
        return $this->Fees_Invoices->index();
    }



    public function store(Request $request)
    {
        return $this->Fees_Invoices->store($request);
    }


    public function show($id)
    {
        return $this->Fees_Invoices->show($id);
    }


    public function edit($id)
    {
        return $this->Fees_Invoices->edit($id);
    }


    public function update(Request $request)
    {
        return $this->Fees_Invoices->update($request);
    }


    public function destroy(Request $request)
    {
        return $this->Fees_Invoices->destroy($request);
    }
    ////////////////////////////////new

    // public function attendanceReport()
    // {

    //    // $ids = DB::table('teacher_section')->where('teacher_id', auth()->user()->id)->pluck('section_id');
    //    // $students = Student::whereIn('section_id', $ids)->get();


    // }

    public function FeesReport(){

        $students = Student::where('created_by',auth()->user()->id)->get();
        return view('pages.Fees_Invoices.fees_reports', compact('students'));
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



        $students = Student::where('created_by',auth()->user()->id)->get();

        if ($request->student_id == 0) {

            $feeInvoices = Fee_invoice::whereBetween('Date', [$request->from, $request->to])->where('created_by',auth()->user()->id)->get();
           // return $feeInvoices;
            return view('pages.Fees_Invoices.fees_reports', compact('students','feeInvoices'));
         //   return view('pages.Teachers.dashboard.students.attendance_report', compact('Students', 'students'));
        } else {

            $feeInvoices = Fee_invoice::whereBetween('Date', [$request->from, $request->to])
                ->where('student_id', $request->student_id)->where('created_by',auth()->user()->id)->get();
             //   return $feeInvoices;
                return view('pages.Fees_Invoices.fees_reports', compact('students','feeInvoices'));
        //    return view('pages.Teachers.dashboard.students.attendance_report', compact('Students', 'students'));


        }


    }
}
