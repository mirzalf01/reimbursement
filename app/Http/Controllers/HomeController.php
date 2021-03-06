<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reimbursement;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /* public function __construct()
    {
        $this->middleware('auth');
    } */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $info = [
            'approved' => count(Reimbursement::where('user_id', auth()->user()->id)->where('status', 'Approved')->get()),
            'pending' => count(Reimbursement::where('user_id', auth()->user()->id)->where('status', 'Pending')->get()),
            'rejected' => count(Reimbursement::where('user_id', auth()->user()->id)->where('status', 'Rejected')->get()),
            'totalReimburse' => Reimbursement::where('user_id', auth()->user()->id)->where('created_at', 'like', date("Y-m").'%')
                                    ->where('status', 'Approved')
                                    ->sum('amount')
        ];

        $reimburseData = [
            'travel' => count(Reimbursement::where('user_id', auth()->user()->id)->where('Category', 'Travel')->get()),
            'fuel' => count(Reimbursement::where('user_id', auth()->user()->id)->where('Category', 'Fuel')->get()),
            'medical' => count(Reimbursement::where('user_id', auth()->user()->id)->where('Category', 'Medical')->get()),
            'accomodation' => count(Reimbursement::where('user_id', auth()->user()->id)->where('Category', 'Accomodation')->get()),
            'other' => count(Reimbursement::where('user_id', auth()->user()->id)->where('Category', 'Other')->get())
        ];

        $reimbursements = Reimbursement::select(['title', 'amount', 'status'])
            ->where('user_id', auth()->user()->id)
            ->latest()->take(5)->get();
        return view('home', compact('reimbursements', 'info', 'reimburseData'));
    }
}
