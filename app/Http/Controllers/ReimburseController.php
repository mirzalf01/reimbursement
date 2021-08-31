<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reimbursement;
use App\Models\ReimbursementImage;
use File;

class ReimburseController extends Controller
{
    public function index(){
        $reimbursements = Reimbursement::with('user', 'images')
            ->where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalReimburse = Reimbursement::where('user_id', auth()->user()->id)->where('created_at', 'like', date("Y-m").'%')
            ->where('status', 'Approved')
            ->sum('amount');
        return view('reimbursements.index', compact('reimbursements', 'totalReimburse'));
    }

    public function create(){
        return view('reimbursements.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'title' => ['required', 'max:255', 'string'],
            'category' => ['required', 'max:30', 'string'],
            'amount' => ['required', 'numeric', 'integer'],
            'images' => ['required', 'array', 'min:1']
        ]);

        $reimbursement = Reimbursement::create([
            'user_id' => auth()->user()->id,
            'title' => ucwords($request->title),
            'description' => ucfirst($request->description),
            'category' => $request->category,
            'amount' => $request->amount,
            'status' => 'Pending'
        ]);

        foreach ($request->images as $key => $image) {
            $file = $image;
            $fileName = time()."_".$file->getClientOriginalName();
            $path = 'receipt_images';
            $file->move($path, $fileName);

            ReimbursementImage::create([
                'reimbursement_id' => $reimbursement->id,
                'img_path' => $fileName
            ]);
        }

        return redirect()->route('reimbursements.index')->with(['storeSuccess' => 'Record created!']);

        
    }
}
