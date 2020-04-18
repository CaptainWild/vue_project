<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'created_by',
        'device',
        'email',
        'email_verifid_at',
        'force_password',
        'ip',
        'is_active',
        'lat',
        'last_login_at',
        'lng',         
        'mobile_no',
        'name', 
        'password',
        'photo',
        'role_id',
        'sub_contractor_id',
        'updated_by',
        'delete_remark',        
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password','remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = [
        'subcontractor',
        'role',
    ];

    /**
     * a user belongs to a role
     */
    public function role() {
        return $this->belongsTo(Role::class);
    }

    /**
     * a user has many created or updated projects
     */
    public function projects() {
        return $this->hasMany(Project::class);
    }

    public function assigned_projects() {
        return $this->belongsToMany(Project::class)->using(ProjectUser::class)->withTimestamps();
    }

    /**
     * a user has many created or updated sub-contractors 
     */
    public function subcontractors() {
        return $this->hasMany(SubContractor::class);
    }

    /**
     * a user has many created or updated trades
     */
    public function trades() {
        return $this->hasMany(Trade::class);
    }

    /**
     * a user has many created or updated archives
     */
    public function archives() {
        return $this->hasMany(Archive::class);
    }

    /**
     * a user has many created or updated attachments
     */
    public function attachments() {
        return $this->hasMany(Attachment::class);
    }

    /**
     * a user has many created or updated high-risk works
     */
    public function hrws() {
        return $this->hasMany(Hrw::class);
    }

    /**
     * a user has many created or updated high-risk works
     */
    public function hrwChecklists() {
        return $this->hasMany(HrwChecklist::class);
    }

    /**
     * a user has many created or updated workers
     */
    public function workers() {
        return $this->hasMany(Worker::class);
    }

    /**
     * a user has many created or updated workers
     */
    public function swps() {
        return $this->hasMany(Swp::class);
    }

    /**
     * a user has many created or updated workers
     */
    public function swpStatusHistory() {
        return $this->hasMany(SwpStatusHistory::class);
    }

    /**
     * a user belongs to a sub-contractor
     */
    public function subcontractor() {
        return $this->belongsTo(SubContractor::class,'sub_contractor_id');
    }

    /**
     * a user has many created, updated, for signatory ptws
     */
    public function ptws() {
        return $this->hasMany(Ptw::class,'created_by');
    }

    /**
     * a user has many checked ptw-hrw-checklist
     */
    public function ptwhrwchecklists() {
        return $this->hasMany(PtwHrwChecklist::class);
    }

    /** 
     * SCOPES
    */

    public function scopeActive($query) {
        return $query->where('is_active',1);
    }

    public function scopeAssessor($query) {
        return $query->where('role_id',3); // base on seeder Safety Assessor
    }

    public function scopeAuthorizemgr($query) {
        return $query->where('role_id',2); // base on seeder Project Manager
    }


}
