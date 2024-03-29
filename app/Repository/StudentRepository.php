<?php

namespace App\Repository;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Classroom;
use App\Models\Gender;
use App\Models\Grade;
use App\Models\Image;
use App\Models\My_Parent;
use App\Models\Nationalitie;
use App\Models\Section;
use App\Models\Student;
use App\Models\Type_Blood;
use App\Models\parCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class StudentRepository implements StudentRepositoryInterface{


    public function Get_Student()
    {
        $students = Student::where('created_by',auth()->user()->id)->get();
        return view('pages.Students.index',compact('students'));
    }

    public function Edit_Student($id)
    {
        $data['Grades'] = Grade::where('created_by',auth()->user()->id)->get();
        $data['parents'] = My_Parent::where('created_by',auth()->user()->id)->get();
        $data['Genders'] = Gender::all();
        $data['nationals'] = Nationalitie::all();
        $data['bloods'] = Type_Blood::all();
        $Students =  Student::findOrFail($id);
        return view('pages.Students.edit',$data,compact('Students'));
    }

    public function Update_Student($request)
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

            $Edit_Students->created_by = auth()->user()->id;
            $Edit_Students->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('Students.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function Create_Student(){



       $data['my_classes'] = Grade::where('created_by',auth()->user()->id)->get();
       $data['parents'] = My_Parent::where('created_by',auth()->user()->id)->get();
       $data['Genders'] = Gender::all();
       $data['nationals'] = Nationalitie::all();
       $data['bloods'] = Type_Blood::all();
       return view('pages.Students.add',$data);

    }

    public function Show_Student($id)
    {


           $Student = Student::with(['qr_code','attendance','Fee_invoice','degree'])->findorfail($id);


           return  view('pages.Students.show',compact('Student'));
    }


    public function Get_classrooms($id){

        $list_classes = Classroom::where("Grade_id", $id)->where('created_by',auth()->user()->id)->pluck("Name_Class", "id");
        return $list_classes;

    }

    //Get Sections
    public function Get_Sections($id){

        $list_sections = Section::where("Class_id", $id)->where('created_by',auth()->user()->id)->pluck("Name_Section", "id");
        return $list_sections;
    }

    public function Store_Student($request){


        DB::beginTransaction();

        try {


            $students = new Student();
            $students->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $students->Date_Birth = $request->Date_Birth;
            $students->Grade_id = $request->Grade_id;
            $students->Classroom_id = $request->Classroom_id;
            $students->section_id = $request->section_id;
            $students->parent_id = $request->parent_id;
            $students->token = uniqid();
            $students->academic_year = $request->academic_year;

            $students->created_by = auth()->user()->id;
            $students->save();

             $studen = Student::latest()->first();
         //    return  $studen->token;
            $code = QrCode::generate(env('SOCKET_URL') . ':' . env('SOCKET_PORT').'/qr?parcode='.$studen->token,public_path('qrcode/'.$studen->token.'.svg'));
            parCode::create([
            'student_id'=>$studen->id,
            'qr'=> $studen->token
            ]);

            // insert img
            if($request->hasfile('photos'))
            {
                foreach($request->file('photos') as $file)
                {
                    $name = $file->getClientOriginalName();
                    $file->storeAs('attachments/students/'.$students->name, $file->getClientOriginalName(),'upload_attachments');

                    // insert in image_table
                    $images= new Image();
                    $images->filename=$name;
                    $images->imageable_id= $students->id;
                    $images->imageable_type = 'App\Models\Student';
                    $images->save();
                }
            }
            DB::commit(); // insert data
            toastr()->success(trans('messages.success'));
            return redirect()->route('Students.create');

        }

        catch (\Exception $e){
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function Delete_Student($request)
    {

        Student::destroy($request->id);
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Students.index');
    }

    public function Upload_attachment($request)
    {
        foreach($request->file('photos') as $file)
        {
            $name = $file->getClientOriginalName();
            $file->storeAs('attachments/students/'.$request->student_name, $file->getClientOriginalName(),'upload_attachments');

            // insert in image_table
            $images= new image();
            $images->filename=$name;
            $images->imageable_id = $request->student_id;
            $images->imageable_type = 'App\Models\Student';
            $images->save();
        }
        toastr()->success(trans('messages.success'));
        return redirect()->route('Students.show',$request->student_id);
    }

    public function Download_attachment($studentsname, $filename)
    {
        return response()->download(public_path('attachments/students/'.$studentsname.'/'.$filename));
    }

    public function Delete_attachment($request)
    {
        // Delete img in server disk
        Storage::disk('upload_attachments')->delete('attachments/students/'.$request->student_name.'/'.$request->filename);

        // Delete in data
        image::where('id',$request->id)->where('filename',$request->filename)->delete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Students.show',$request->student_id);
    }
/////////parcode
    public function Download_attachment_parcode($filename)
    {
        return response()->download(public_path('qrcode/'.$filename));
    }

}
