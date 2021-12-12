<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['showall']]);
    }

    public function showall(Request $request){
        return response()->json(Payment::with(['organization:id,organization'])->orderBy('payment_for', $request->sort)->paginate(8));

    }

    public function index(Request $request){
        if(auth()->user()->userinfo->type == 'admin') {
            return response()->json(Payment::with(['user','user.userinfo'])->where('organization_id', auth()->user()->userinfo->organization_id)->orderBy('payment_for', $request->sort)->paginate(8));
        }
        else {    
            return response()->json(
                Payment::with(['user','user.userinfo'])
                ->where('organization_id', auth()->user()->userinfo->organization_id)
                ->where('user_id', auth()->user()->id)
                ->orderBy('payment_for', $request->sort)
                ->paginate(8));
        }
    }

    public function store(PaymentRequest $request){
        for ($i = 0; $i < count($request->user_id); $i++){
            Payment::create($request->validated() + [
                'organization_id' => auth()->user()->userinfo->organization_id,
                'user_id' => $request->user_id[$i],
            ]);
        }
        return $this->success('Payment record created successfully');
    }

    public function update(PaymentRequest $request, $id){
        $announcement = Payment::find($id);
        if(!empty($announcement)){
            $announcement->update($request->validated());

            return $this->success('Announcement updated successfully!');
        }
        else {
            return $this->error('Something went wrong');
        }

    }

    public function destroy($id){
        Payment::destroy($id);
        return $this->success('Payment record deleted successfully!');
    }
}
