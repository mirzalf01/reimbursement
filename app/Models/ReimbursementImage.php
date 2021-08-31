<?php

namespace App\Models;

use App\Models\Reimbursement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReimbursementImage extends Model
{
    use HasFactory;

    protected $table = 'reimbursement_images';

    protected $fillable = [
        'reimbursement_id',
        'img_path'
    ];

    public function reimbursement(){
        return $this->belongsTo(Reimbursement::class, 'reimbursement_id', 'id');
    }
}
