<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class StudentController extends Controller
{
    public function getStudents(){
        return Student::with('country','state')->orderBy('created_at','desc')->get();
    }
    public function getCountry(){
        return Country::all();
    }

    public function getStates(Request $request){
        return State::where('country_id',$request->country_id)->get();
    }

    public function saveStudents(Request $request){
        foreach ($request->students as $newstudent){

            $student=new Student();
            $student->name=$newstudent['name'];
            $student->country_id=$newstudent['country_id'];
            $student->state_id=$newstudent['state_id'];
            $student->image=$this->savePhoto($newstudent['image'][0]['data']);
            $student->save();
        }
        return Student::with('country','state')->orderBy('created_at','desc')->get();
    }

    private function savePhoto($photo)
    {
        $fileName = '';
       /* try {

        }
        catch (\Exception $e) {
            $msg = $e;
        }*/
        if(strlen($photo) > 128) {
            list($ext, $data)   = explode(';', $photo);
            list(, $data)       = explode(',', $data);
            $data = base64_decode($data);
            $mime_type = substr($photo, 11, strpos($photo, ';')-11);
            $fileName = 'photo'.rand(11111,99999).'.'.$mime_type;
            //file_put_contents('uploads/images/'.$fileName, $data);

             $img=Image::make($data)->resize(100, 50)->stream();
            //$img=Image::make($data)->stream();
           // $img->resize(350, 350);
            Storage::disk('local')->put($fileName,$img);
        }
        return $fileName;
    }
}
