<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnouncementRequest;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['showall', 'destroy']]);
    }

    public function showall(Request $request){
        return response()->json(Announcement::with(['organization:id,organization'])->orderBy('what', $request->sort)->paginate(8));
    }

    public function index(Request $request){
        return response()->json(Announcement::whereIn('organization_id', [auth()->user()->userinfo->organization_id, 1])->orderBy('what', $request->sort)->paginate(8));
    }
    public function forMembers(Request $request){
        return response()->json(Announcement::where('organization_id', auth()->user()->userinfo->organization_id)->orderBy('what', $request->sort)->paginate(8));
    }

    public function store(AnnouncementRequest $request){
        
        $students = User::where('id', '<>', auth()->user()->id)->where('account_status', 'approved')->whereHas('userinfo', function($query){
            $query->where('organization_id', auth()->user()->userinfo->organization_id);
        })->with(['userinfo'])->get();

        $admins = User::where('id', '<>', auth()->user()->id)->where('account_status', 'approved')->whereHas('userinfo', function($query){
            $query->where('type', 'admin');
        })->with(['userinfo'])->get();
        
        $msg = 'What: ' . $request->what . ' Where: ' . $request->where . ' When : ' .$request->when .' Who : '. $request->who .'';
        
        Announcement::create($request->validated() + ['organization_id' => auth()->user()->userinfo->organization_id]);
        // return response()->json(['msg' => $msg, 'student' => $students, 'specific' => $student->userinfo->contact]);
        foreach($students as $student){
            $this->sendSmsNotification($student->userinfo->contact, $msg);
        }

        foreach($admins as $admin){
            $this->sendSmsNotification($admin->userinfo->contact, $msg);
        }

        return $this->success('Announcement created successfully');

    }

    public function update(AnnouncementRequest $request, $id){
        $announcement = Announcement::find($id);
        if(!empty($announcement)){
            $announcement->update($request->validated());

            return $this->success('Announcement updated successfully!');
        }
        else {
            return $this->error('Something went wrong');
        }

    }

    public function destroy($id){
        Announcement::destroy($id);
        return $this->success('Announcement deleted successfully!');
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
