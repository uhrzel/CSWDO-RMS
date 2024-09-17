<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'fam_lastname',
        'fam_firstname',
        'fam_middlename',
        'fam_relationship',
        'fam_birthday',
        'fam_age',
        'fam_gender',
        'fam_status',
        'fam_education',
        'fam_occupation',
        'fam_income',
    ];

  
}
