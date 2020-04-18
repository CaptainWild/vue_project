<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\PtwUpdated;

class Ptw extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'created_by',
        'end_date',
        'end_time',        
        'hrw_id',
        'lat', 
        'lng',         
        'location',
        'project_id',
        'ptw_status_id',
        'ptw_type',
        'remarks',
        'reference_no',
        'signatory_id',        
        'start_date',        
        'start_time',        
        'sub_contractor_id',        
        'updated_by',
        'verifier_id',
        'verified_at',
        'version_index',
        'work_to_be_done',
        'delete_remark',
    ];

    protected $dispatchesEvents = [
        'created'=> PtwUpdated::class,
        'updated'=> PtwUpdated::class
    ];

    protected $with = [        
        'attachments',
        'creator',
        'equips',
        'hrw',
        'inspectionchecklists',
        'project',
        'ptwasmchecklists',        
        'ptwsignees',
        'ptwhrwchecklists',        
        'ptwstatus',
        'ptwworkercertificates',
        'signatory',
        'swps',
        'subcontractor',
        'verifier',
        'workers'                
    ];

    // protected $casts = [
    //     'start_date' => 'date:d/m/Y',
    //     'end_date' => 'date:d/m/Y',
    //     'updated_at' => 'date:d/m/Y',
    // ];

    public function addSignee($signee) {
       return $this->ptwsignees()->create($signee);
    }

    public function addAsmChecklist($asm_checklist) {
        return $this->ptwasmchecklists()->create($asm_checklist);
    } 

    public function addHrwChecklist($hrw_checklist) {
        return $this->ptwhrwchecklists()->create($hrw_checklist);
    }

    public function addChecklist($checklist) {
        return $this->inspectionchecklists()->create($checklist);
    }

    public function addPtwChecklistItem($ptwchecklistitem) {
        return $this->ptwchecklistitems()->create($ptwchecklistitem);
    }

    public function addWorkerCertificates($ptwworkercertificate) {
        return $this->ptwworkercertificates()->create($ptwworkercertificate);
    }

    public function addAttachments($attachment) {
        return $this->attachments()->create($attachment);
    }

    public function attachWorkers($worker_ids,$attach) {       
        foreach(json_decode($worker_ids) as $worker_id) {
            if($attach){              
                $this->workers()->attach($worker_id);
            } else {
                $this->workers()->detach($worker_id);
            }            
        }
    }

    public function attachSwps($swp_ids,$attach) {
        foreach(json_decode($swp_ids) as $swp_id) {
            if($attach)
                $this->swps()->attach($swp_id);
            else
                $this->swps()->detach($swp_id);
        }
    }

    public function attachEquipment($equipment_ids,$attach) {
        foreach(json_decode($equipment_ids) as $equipment_id) {
            if($attach)
                $this->equips()->attach($equipment_id);
            else
                $this->equips()->detach($equipment_id);
        }
    }

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function signatory() {
        return $this->belongsTo(User::class,'signatory_id');
    }

    public function verifier() {
        return $this->belongsTo(User::class,'verifier_id');
    }

    public function hrw() {
        return $this->belongsTo(Hrw::class);
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function ptwstatus() {
        return $this->belongsTo(PtwStatus::class,'ptw_status_id');
    }

    public function subcontractor() {
        return $this->belongsTo(SubContractor::class,'sub_contractor_id');
    }

    public function swps() {
        return $this->belongsToMany(Swp::class)->using(PtwSwp::class)->withTimestamps();
    }

    public function workers() {
        return $this->belongsToMany(Worker::class)->using(PtwWorker::class)->withTimestamps();
    }    

    public function equips() {
        return $this->belongsToMany(Equip::class)->using(EquipPtw::class)->withTimestamps();
    }

    public function ptwsignees() {
        return $this->hasMany(PtwSignee::class);
    }

    public function ptwworkercertificates() {
        return $this->hasMany(PtwWorkerCertificate::class);
    }

    public function ptwhrwchecklists() {
        return $this->hasMany(PtwHrwChecklist::class);
    }

    public function ptwchecklistitems() {
        return $this->hasMany(PtwChecklistItem::class);
    }

    public function attachments() {
        return $this->hasMany(Attachment::class,'reference_id')->where('reference_table','ptws');
    }

    public function inspectionchecklists() {
        return $this->hasMany(InspectionChecklist::class);
    }

    public function ptwasmchecklists() {
        return $this->hasMany(PtwAsmChecklist::class);
    }
}
