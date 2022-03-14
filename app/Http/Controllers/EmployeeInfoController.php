<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Employee_info;
use App\Models\Department;
use App\Models\Education;
use App\Models\Hobbies;
use File;

class EmployeeInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['employees'] = Employee_info::join('departments as D','employee_infos.department_id','=','D.id')
                    ->get(['employee_infos.*','D.department_name']);
                    
        // dd($data);
        return view('employee-list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['departments'] = Department::get();
        $data['educations'] = Education::get();
        $data['hobbies'] = Hobbies::get();
        return view('add-employee',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->input());

        $validate = $request->validate([
            'name'=>'required',
            'email'=>'required|unique:employee_infos',
            'gender'=>'required',
            'contact_number'=>'required',
            'address'=>'required',
            'joining_date'=>'required',
            'experience'=>'required',
            'departmentId'=>'required',
            'hobbies_id'=>'required',
            'dob'=>'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'
        ]);

        $employee = new Employee_info();

       
        if($request->hasFile('image')){
           

            // Filename to store
            // $fileNameToStore = $filename.'_'.time().'.'.$extention;

            $imageName = time() . rand() . '.' . $request->image->extension();

            $request->image->move(public_path('cover_images'), $imageName);


            // upload image
            // $path = $request->file('image')->storeAs('public/cover_images',$fileNameToStore);
        }else{
            $fileNameStore='noimage.jpg';
        }  
       

        $employee->employee_name = $request->name;
        $employee->email = $request->email;
        $employee->gender = $request->gender;
        $employee->contact_number = $request->contact_number;
        $employee->address = $request->address;
        $employee->joining_date = $request->joining_date;
        $employee->experience = $request->experience;
        $employee->department_id = $request->departmentId;
        $employee->education_id = $request->education_id;
        $employee->hobbies_id = implode(",",$request->hobbies_id);
        $employee->dob = $request->dob;
        $employee->photo = $imageName;

       $res =  $employee->save();

       if($res)
       {
           return back()->with('success','Employee Addedd Successfully');
        //    return redirect('/add-employee');
       }
       
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
        
        $data['departments'] = Department::get();
        $data['educations'] = Education::get();
        $data['hobbies'] = Hobbies::get();
        $data['employee'] = Employee_info::where('id',$id)->first();
        $data['hob'] = explode(',', $data['employee']->hobbies_id);
        
        return view('edit-employee',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         // dd($request->file('image'));

         $validate = $request->validate([
            'name'=>'required',
            'email'=>'required',
            'gender'=>'required',
            'contact_number'=>'required',
            'address'=>'required',
            'joining_date'=>'required',
            'experience'=>'required',
            'departmentId'=>'required',
            'hobbies_id'=>'required',
            'dob'=>'required',
            
        ]);

       

       
        
       
        $employee = Employee_info::find($id);
        
        $employee->employee_name = $request->name;
        $employee->email = $request->email;
        $employee->gender = $request->gender;
        $employee->contact_number = $request->contact_number;
        $employee->address = $request->address;
        $employee->joining_date = $request->joining_date;
        $employee->experience = $request->experience;
        $employee->department_id = $request->departmentId;
        $employee->education_id = $request->education_id;
        $employee->hobbies_id = implode(",",$request->hobbies_id);
        $employee->dob = $request->dob;

        if($request->hasFile('image')){
           


            $imageName = time() . rand() . '.' . $request->image->extension();

            $request->image->move(public_path('cover_images'), $imageName);
            $employee->photo = $imageName;

           
        }

       

       $res =  $employee->save();

       if($res)
       {
           return back()->with('success','Employee Updated Successfully');
        //    return redirect('/add-employee');
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee_info::find($id);
       

        if (File::exists(public_path('cover_images/' . $employee->photo))) {
            File::delete(public_path('cover_images/' . $employee->photo));
        }

        Employee_info::where('id',$id)->delete();

        return back()->with('success','Employee Deleted Successfully');
    }

    // for check email starts here..
    public function checkEmail(Request $request)
    {
        $email = $request->email;
        $checkEmail = Employee_info::select('id','email')->where('email',$email)->first();
        if(!empty($checkEmail))
        {
            return response()->json(['msg' => '<span class="error">This Email Already Exist</span>']);
        }else{
            return response()->json(['msg' => '<span class="success">This Email Available</span>']);
        }
      
    }

    // for check email ends here..


    // for fet employee record starts  here..
    public function employeeRecord(Request $request)
    {
        $sort = $_GET['sort'];
        
        $html = '';
        
       $filterData= Employee_info::join('departments as D','employee_infos.department_id','=','D.id')
                    ->orderBy('id',$sort)
                      ->get(['employee_infos.*','D.department_name']);


        if(!empty($filterData))
        {
            $i=1;
            foreach($filterData as $employee)
            {
                $html .= ' <tr>
                <td>'.$i.'</td>
                <td><img src="'.asset("cover_images/".$employee->photo."").'" width="100" height="100"></td>
                <td>'.$employee->employee_name.'</td>
                <td>'.$employee->email.'</td>
                <td>'.$employee->contact_number.'</td>
                <td>'.$employee->gender.'</td>
                <td>'.$employee->department_name.'</td>
                <td>'.date("Y-m-d",strtotime($employee->dob)).'</td>
                <td><a href="'.route("post.edit-employee",$employee->id).'" class="btn btn-success btn-sm">Edit</a>
                 <a href="'.route("post.delete-employee",$employee->id).'" class="btn btn-danger btn-sm delete-confirm">Delete</a>
               </td>
                
              </tr>';

              $i++;
            }
        }

        echo $html;
    }

     // for fet employee record ends  here..

      // for fet search record starts  here..
    public function employeeSearch(Request $request)
    {
        // dd($request->input());
        $html = '';
        $search = $request->search;
        $sort = $request->sort;
     $filterData= Employee_info::join('departments as D','employee_infos.department_id','=','D.id')
                    ->where('employee_infos.employee_name','LIKE','%'.$search.'%')
                    ->orWhere('employee_infos.email','LIKE','%'.$search.'%')                   
                    ->get(['employee_infos.*','D.department_name']);

                    //   dd(DB::getQueryLog());

        if(!empty($filterData))
        {
            $i=1;
            foreach($filterData as $employee)
            {
                $html .= ' <tr>
                <td>'.$i.'</td>
                <td><img src="'.asset("cover_images/".$employee->photo."").'" width="100" height="100"></td>
                <td>'.$employee->employee_name.'</td>
                <td>'.$employee->email.'</td>
                <td>'.$employee->contact_number.'</td>
                <td>'.$employee->gender.'</td>
                <td>'.$employee->department_name.'</td>
                <td>'.date("d-m-Y",strtotime($employee->dob)).'</td>
                <td><a href="'.route("post.edit-employee",$employee->id).'" class="btn btn-success btn-sm">Edit</a>
                 <a href="'.route("post.delete-employee",$employee->id).'" class="btn btn-danger btn-sm delete-confirm">Delete</a>
               </td>
                
              </tr>';

              $i++;
            }
        }

        echo $html;
                    

    }

          // for fet search record ends  here..

}
