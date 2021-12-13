<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentsRequest;
use App\Http\Requests\AnnouncementRequest;
use App\Models\Announcement;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

class StudentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        return response()->json(
            User::whereHas('userinfo', function($query){
                $query->where('first_name', 'like', '%'.request()->get('search').'%')
                ->orWhere('last_name', 'like', '%'.request()->get('search').'%');
            })
            ->with(['userinfo', 
            'userinfo.section:id,section,year_level', 
            'userinfo.organization:id,organization'])
            ->where('account_status', 'approved')->paginate(8));
    }

    public function index()
    {
        return response()->json(User::with(['userinfo', 'userinfo.section:id,section,year_level', 'userinfo.organization:id,organization', 'userinfo.course:id,course'])->whereHas('userinfo', function($query){
                $query->where('type', 'member');
            })->where('account_status', 'approved')->paginate(8));
    }
    public function admins()
    {
        if(auth()->user()->userinfo->type == 'admin'){
            return response()->json(User::with([
                'userinfo', 
                'userinfo.section:id,section,year_level', 
                'userinfo.organization:id,organization'
                ])->whereHas('userinfo', function($query){
                    $query->where('type', 'admin');
                })->where('account_status', 'approved')->paginate(8));
            }
            else {
                return response()->json(User::with([
                    'userinfo', 
                    'userinfo.section:id,section,year_level', 
                    'userinfo.organization:id,organization'
                    ])->whereHas('userinfo', function($query){
                        $query->where('type', 'admin');
                    })->where('account_status', 'approved')->paginate(8));

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentsRequest $request)
    {
        $userinfo = UserInfo::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'contact' => $request->contact,
            'type' => $request->type,
            'year_level' => $request->year_level,
            'section_id' => $request->section_id,
            'academic_year' => $request->acad_year,
            'organization_id' => $request->organization_id,
            'course_id' => $request->course_id,
        ]);
        User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'student_id' => $request->student_id,
            'user_info_id' => $userinfo->id,
            'account_status' => $request->account_status,
        ]);
        return $this->success('Student created successfully');
    }

    public function pendingStudents()
    {
        return response()->json(User::whereHas('userinfo', function (Builder $query) {
            $query->where('type', 'admin');
        })->with([
            'userinfo', 
            'userinfo.course:id,course',
            'userinfo.section:id,section,year_level', 
            'userinfo.organization:id,organization'
            ])->where('account_status', 'pending')->paginate(8));
    }

    public function approveStudent($id)
    {
        $member = User::find($id);

        if(!empty($member)){
            $member->update([
                'account_status' => 'approved'
            ]);

            $updated_user = User::with(['userinfo', 'userinfo.section:id,section,year_level', 'userinfo.course:id,course', 'userinfo.organization:id,organization'])->find($id);
            return response()->json([$updated_user, 'msg' => 'Member approved successfully!']);
        }
        else{
            return $this->error('Something went wrong!');
        }
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
        $userinfo = UserInfo::find($id);
        $user = User::find($id);

        if(!empty($userinfo)){
            $userinfo->update([
                'first_name' => $request->userinfo['first_name'],
                'middle_name' => $request->userinfo['middle_name'],
                'last_name' => $request->userinfo['last_name'],
                'gender' => $request->userinfo['gender'],
                'contact' => $request->userinfo['contact'],
                'type' => $request->userinfo['type'],
                'academic_year' => $request->userinfo['acad_year'],
                'year_level' => $request->userinfo['year_level'],
                'section_id' => $request->userinfo['section_id'],
                'organization_id' => $request->userinfo['organization_id'],
                'course_id' => $request->userinfo['course_id'],
            ]);

            $user->update([
                'email' => $request->email,
                'student_id' => $request->student_id,
            ]);

            $updated_user = User::with(['userinfo', 'userinfo.section:id,section,year_level', 'userinfo.course:id,course', 'userinfo.organization:id,organization'])->find($id);
            return response()->json([$updated_user, 'msg' => 'Student information updated successfully!']);
        }
        else 
        {
            return $this->error('Student data not found.');
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
        User::destroy($id);
        return $this->success('Student record deleted successfully');
    }

    public function storeAnnouncement(AnnouncementRequest $request){
        
        $students = User::where('account_status', 'approved')->with(['userinfo'])->get();

        $admins = User::where('account_status', 'approved')->with(['userinfo'])->get();
        
        $msg = 'What: ' . $request->what . ' Where: ' . $request->where . ' When : ' .$request->when .' Who : '. $request->who .'';
        
        Announcement::create($request->validated() + ['organization_id' => 1]);
        // return response()->json(['msg' => $msg, 'student' => $students, 'specific' => $student->userinfo->contact]);
        foreach($students as $student){
            $this->sendSmsNotification($student->userinfo->contact, $msg);
        }

        foreach($admins as $admin){
            $this->sendSmsNotification($admin->userinfo->contact, $msg);
        }

        return $this->success('Announcement created successfully');

    }

    public function updateAnnouncement(AnnouncementRequest $request, $id){
        $announcement = Announcement::find($id);
        if(!empty($announcement)){
            $announcement->update($request->validated());

            return $this->success('Announcement updated successfully!');
        }
        else {
            return $this->error('Something went wrong');
        }

    }

    public function sendSmsNotification($num, $msg)
    {
        $basic  = new \Vonage\Client\Credentials\Basic("da56e004", "cb74kGr5VP8LIkMT");
        $client = new \Vonage\Client($basic);
        
        $response = $client->sms()->send(new \Vonage\SMS\Message\SMS($num, 'OrganizationPortal', $msg));
        // $message = $response->current();

        // if ($message->getStatus() == 0) {
        //     echo "The message was sent successfully\n";
        // } else {
        //     echo "The message failed with status: " . $message->getStatus() . "\n";
        // }
     }
}
