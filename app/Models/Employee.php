<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;

class Employee extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'first_name',
      'last_name',
      'date_of_joining',
      'profile',
      'qualification',
      'department_code',
      'ctc',
      'in_hand_salary',
      'phone_no',
      'address',
      'status'
    ];

    protected $casts = [
        'address' => 'array'
    ];

    public function employeesData() {

      return $this->hasOne('App\Models\Department', 'department_code', 'id');

    }

}
