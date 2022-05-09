<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EducationDetail;
use App\Models\ExperienceDetail;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();
        return view('user/index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'phone_no' => 'required',
            'country_code'=>'required',
            'linkedin_url'=>'required',

        ],
            [
                'first_name.required' => 'First Name is Required',
                'last_name.required' => 'Last Name is Required',
                'email.required' => 'Email is Required',
                'phone_no.required' => 'Phone Number is Required',
                'country_code.required' => 'Country Code is Required',
                'linkedin_url.required' => 'Linkedin Url is Required',
            ]);
        if ($validated->fails()) {
            return redirect()->back()
                ->withErrors($validated)
                ->withInput();
        }
        $data = $request->all();
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->country_code = $request->country_code;
        $user->phone_no = $request->phone_no;
        $user->linkedin_url	 = $request->linkedin_url;
        if ($image = $request->file('resume')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $user->resume = $profileImage;
        }

        $user->save();

        $course_names = $request->course_name;
        $institution_names = $request->institution_name;
        $years = $request->year;
        $percentages = $request->percentage;

        foreach ($course_names as $key => $course_name) {
            $course_names[] = EducationDetail::create([
                'user_id' => $user->id,
                'course_name' => $course_name,
                'institution_name' => $institution_names[$key],
                'year' => $years[$key],
                'percentage' => $percentages[$key],
            ]);
        }

        $company_names = $request->company_name;
        $job_positions = $request->job_position;
        $started_years = $request->started_year;
        $started_months = $request->started_month;
        $end_years = $request->end_year;
        $end_months = $request->end_month;

        foreach ($company_names as $key => $company_name) {
            $course_names[] = ExperienceDetail::create([
                'user_id' => $user->id,
                'company_name' => $company_name,
                'job_position' => $job_positions[$key],
                'started_year' => $started_years[$key],
                'started_month' => $started_months[$key],
                'end_year' => $end_years[$key],
                'end_month' => $end_months[$key],

            ]);
        }

        return redirect('/');   

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $educations = EducationDetail::where('user_id',$id)->get();
        $experiences = ExperienceDetail::where('user_id',$id)->get();

        return view('user/edit',compact('user','educations','experiences'));
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
        $user =User::find($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->country_code = $request->country_code;
        $user->phone_no = $request->phone_no;
        $user->linkedin_url = $request->linkedin_url;
        if ($image = $request->file('resume')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $user->resume = $profileImage;
        }
        $user->save();

        $course_names = $request->course_name;
        $institution_names = $request->institution_name;
        $years = $request->year;
        $percentages = $request->percentage;
        $education_ids = $request->education_id;
        foreach ($education_ids as $key => $education_id) {

            $education=EducationDetail::where('id',$education_id)->first();
            // $education->user_id=$user->id;
            $education->course_name=$course_names[$key];
            $education->institution_name=$institution_names[$key];
            $education->year=$years[$key];
            $education->percentage=$percentages[$key];
            $education->save();

        }

        $company_names = $request->company_name;
        $job_positions = $request->job_position;
        $started_years = $request->started_year;
        $started_months = $request->started_month;
        $end_years = $request->end_year;
        $end_months = $request->end_month;
        $experience_ids = $request->experience_id;

        foreach ($experience_ids as $key => $experience_id) {

            $experience=ExperienceDetail::where('id',$experience_id)->first();
            // $experience->user_id=$user->id;
            $experience->company_name=$company_names[$key];
            $experience->job_position=$job_positions[$key];
            $experience->started_year=$started_years[$key];
            $experience->end_year=$end_years[$key];
            $experience->started_month=$started_months[$key];
            $experience->end_month=$end_months[$key];
            $experience->save();
        }

        return redirect('/');   

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user_id=$request->id;
        $user = User::find($user_id);
        
        if(!$user)
        {
            return 0;
        }
        $user = User::find($user_id)->delete();
        return 1;
    }
}
