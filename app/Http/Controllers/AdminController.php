<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Appointment;
class AdminController extends Controller
{
    public function addview(){

        return view('admin.add_doctor');
    }

    public function upload(Request $request){
        $doctor = new Doctor;

        //get image file
        $image=$request->file;

        //using time and file type as the name
        $imagename=time().'.'.$image->getClientOriginalExtension();

        //move to public folder
        $request->file->move('doctorimage', $imagename);

        //save img from public folder to db
        $doctor->image=$imagename;

        $doctor->name=$request->name;
        $doctor->email=$request->email;
        $doctor->phone=$request->phone;
        $doctor->specialty=$request->specialty;

        $doctor->save();

        return redirect()->back()->with('message','Doctor Added Successfully');
    }

    public function showappointment(){
            $data=appointment::all();

        return view('admin.showappointment',compact('data'));
    }

    public function approved($id){
        //update table
        $data=appointment::find($id);
        $data->status='Approved';

        $data->save();

        return redirect()->back();
}

public function rejected($id){
    //update table
    $data=appointment::find($id);
    $data->status='Rejected';

    $data->save();

    return redirect()->back();
}

public function showdoctor(){

    $data=doctor::all();

    return view('admin.showdoctor',compact('data'));
}

public function deletedoctor($id){
    //update table
    $data=doctor::find($id);
    $data->delete();

    return redirect()->back();
}

public function updatedoctor($id){
    $data=doctor::find($id);
    return view('admin.update_doctor',compact('data'));
}

public function editdoctor(Request $request, $id){
    $doctor=doctor::find($id);

    $doctor->name=$request->name;
    $doctor->email=$request->email;
    $doctor->phone=$request->phone;
    $doctor->specialty=$request->specialty;

    $image=$request->file;
    if($image)
    {
        $imagename=time().'.'.$image->getClientOriginalExtension();
        //move to public folder
        $request->file->move('doctorimage', $imagename);

        //save img from public folder to db
        $doctor->image=$imagename;
    }

    $doctor->save();


    return redirect()->back()->with('message','Doctor Updated Successfully');
}


}
