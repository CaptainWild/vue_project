<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asm;
use App\Attachment;
use App\Project;
use App\Ptw;
use App\PtwChecker;
use App\HrwChecklist;
use App\Http\Traits\AttachmentsTrait;
use App\Http\Traits\SignatureTrait;
use Carbon\Carbon;
use Storage;

class PtwController extends Controller
{
    use AttachmentsTrait,SignatureTrait;

    /**
     * Apply auth middleware
    */
    public function __construct() 
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {                
        //applicant role show only ptw that he created
        if(auth()->user()->role_id == 4) {
            return response()->json(auth()->user()->ptws()->orderBy('created_at','desc')->get());
        } else if(in_array(auth()->user()->role_id,array(2,3))) {            
        //the ptws that will be shown in the safety assessor and authorize manager
            return response()->json(Ptw::where('signatory_id', auth()->id())
                    ->orWhereHas('ptwsignees', function ($q) {
                        $q->where('signed_by', auth()->id());
                    })->orderBy('created_at','desc')->get()
            );
        } else {
            return response()->json(Ptw::orderBy('created_at','desc')->get());
        }
    }

    /**
     * Store a newly created resource in storage.
     * a DRAFT(5) submission means that there is no validation done
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {             
        $attributes['created_by']       = auth()->id();
        $attributes['end_date']         = $request->end_date;
        $attributes['end_time']         = $request->end_time == 'null' ? NULL : $request->end_time;
        $attributes['location']         = $request->location == 'undefined' ? '' : $request->location;
        $attributes['hrw_id']           = $request->hrw_id ?? 0;
        $attributes['ptw_status_id']    = $request->ptw_status_id;
        $attributes['ptw_type']         = $request->ptw_type;
        $attributes['project_id']       = $request->project_id ?? 0;
        $attributes['reference_no']     = $this->generateReferenceNo($request->project_id);
        $attributes['remarks']          = $request->remarks == 'undefined' ? '' : $request->remarks;
        $attributes['signatory_id']     = $request->signatory_id ?? 0;
        $attributes['start_date']       = $request->start_date;
        $attributes['start_time']       = $request->start_time == 'null' ? NULL : $request->start_time;        
        $attributes['sub_contractor_id']= $request->sub_contractor_id ?? 0;        
        $attributes['verifier_id']      = $request->verifier_id  == 'undefined' ? 0 : $request->verifier_id;
        $attributes['work_to_be_done']  = $request->work_to_be_done == 'undefined' ? '' : $request->work_to_be_done;
        
        $ptw = Ptw::create($attributes);
                
        if($ptw) {
            // multiple attachments
            if($request->hasFile('general_attachments')) {            
                $this->storePtwAttachments($ptw, $request->file('general_attachments'),$request->general_descriptions,'generals');
            }

            // multiple attachments for equipment
            if($request->hasFile('equip_attachments')) {            
                $this->storePtwAttachments($ptw, $request->file('equip_attachments'),$request->equip_descriptions,'equips');
            }

            // multiple attachments for workers
            if($request->hasFile('worker_attachments')) {   
                $this->storePtwAttachments($ptw, $request->file('worker_attachments'),$request->worker_descriptions,'workers');
            } 
                      
            
            //not draft 
            //save signature image into s3
            //save into ptw-signees-table            
            if($request->ptw_status_id != 5) {      
                $signature = $this->decodeAndStore('ptws',$ptw->id,$request->signed_path);
                
                $ptw->addSignee([
                    'ptw_status_id' => $request->ptw_status_id,
                    'remarks'       => $request->remarks,
                    'signed_by'     => auth()->id(),
                    'signed_path'   => $signature
                ]);
            }

            if($ptw->ptw_type == 'Night'){
                $this->attachDetachAsms($ptw);
            }                

            $this->attachWorkerCertificate($ptw);
            
            $this->attachDetachChecklist($ptw);

            $this->attachHrwChecklist($ptw);
            
            $this->attachDetachPtwSwpsWorkersEquips($ptw);
            
        }

        return response()->json($ptw);
    }


    
     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ptw  $ptw
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ptw $ptw) 
    {       
        
        $attributes['updated_by']       = auth()->id();
        $attributes['end_date']         = $request->end_date;
        $attributes['end_time']         = $request->end_time == 'null' ? NULL : $request->end_time;
        $attributes['location']         = $request->location == 'undefined' ? '' : $request->location;
        $attributes['hrw_id']           = $request->hrw_id ?? 0;
        $attributes['ptw_status_id']    = $request->ptw_status_id;
        $attributes['ptw_type']         = $request->ptw_type;
        $attributes['project_id']       = $request->project_id ?? 0;
        $attributes['remarks']          = $request->remarks == 'undefined' ? '' : $request->remarks;
        $attributes['signatory_id']     = $request->signatory_id ?? 0;
        $attributes['start_date']       = $request->start_date;
        $attributes['start_time']       = $request->start_time == 'null' ? NULL : $request->start_time;        
        $attributes['sub_contractor_id']= $request->sub_contractor_id ?? 0;
        $attributes['verifier_id']      = $request->verifier_id  == 'undefined' ? 0 : $request->verifier_id;        
        $attributes['work_to_be_done']  = $request->work_to_be_done == 'undefined' ? '' : $request->work_to_be_done;
        $attributes['version_index']    = $ptw->version_index + 1;
        // multiple attachments
        $this->ptwAttachments($ptw, $request->general_attachment_objects, 'generals');
        
        if($request->hasFile('general_attachments')) {            
            $this->storePtwAttachments($ptw, $request->file('general_attachments'),$request->general_descriptions,'generals');
        }

        //equipment attachments start
        $this->ptwAttachments($ptw, $request->equip_attachment_objects, 'equips');
        
        if($request->hasFile('equip_attachments')) {            
            $this->storePtwAttachments($ptw, $request->file('equip_attachments'),$request->equip_descriptions,'equips');
        }

        //worker attachments start                
        $this->ptwAttachments($ptw, $request->worker_attachment_objects, 'workers');
            
        if($request->hasFile('worker_attachments')) {   
            $this->storePtwAttachments($ptw, $request->file('worker_attachments'),$request->worker_descriptions,'workers');
        }

        //not draft (it can be in rejected (9))
        //save signature image into s3
        //save into ptw-signees-table            
        if($request->ptw_status_id != 5) {      
            $signature = $this->decodeAndStore('ptws',$ptw->id,$request->signed_path);

            $ptw->addSignee([
                'ptw_status_id' => $request->ptw_status_id,
                'remarks'       => $request->remarks,
                'signed_by'     => auth()->id(),
                'signed_path'   => $signature
            ]);
        }

        //if the hrw_id has been changed
        if($ptw->hrw_id != $request->hrw_id) {
            $ptw->ptwhrwchecklists->each->delete();
        }

        if($ptw->ptw_type == 'Night') {
            $this->attachDetachAsms($ptw);
        }

        $this->attachWorkerCertificate($ptw);

        $this->attachDetachChecklist($ptw);

        $this->attachHrwChecklist($ptw);

        $this->attachDetachPtwSwpsWorkersEquips($ptw);

        $result = $ptw->update($attributes);

        return response()->json($result);
    }

    /**
     * batch approval (1) for all endorsed (6) Ptw
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function batchApprovalStore(Request $request) {
        $results = [];
        if(!empty($request->ptw_ids)) {
           
            $ptw_ids = json_decode($request->ptw_ids);

            $ptws = Ptw::whereIn('id', $ptw_ids)->get();
            
            foreach($ptws as $ptw) {
                $signature = $this->decodeAndStore('ptws',$ptw->id,$request->signed_path);
      
                $result = $ptw->update([
                    'ptw_status_id' => $request->ptw_status_id ?? 1,
                    'signatory_id'  => 0,         
                    'updated_by' => auth()->id()
                ]);

                $ptw->addSignee([
                    'ptw_status_id' => $request->ptw_status_id,
                    'remarks'       => $request->remarks,
                    'signed_by'     => auth()->id(),
                    'signed_path'   => $signature
                ]);
              
                // generate inspection checklist items records 
                //based on start date and end date of the ptw
                $ptwinspectionchecklists = $ptw->inspectionchecklists()->get();
                
                if(count($ptwinspectionchecklists)) {
                    foreach($ptwinspectionchecklists as $ptwinspectionchecklist) {

                        $start_date = new Carbon($ptw->start_date);
                        $end_date   = $ptw->end_date;
                        
                        while (strtotime($start_date) <= strtotime($end_date)) {
                            
                            $ptwinspectionchecklist->addInspectionChecklistItem([
                                'created_by' => auth()->id(),
                                'inspection_date' => $start_date                
                            ]);
                            
                            $start_date = $start_date->addDay();                
                        }
                    }
                }

                $ptw_start_date = new Carbon($ptw->start_date);
                $ptw_end_date   = $ptw->end_date;
                // generate ptw checklist items records
                while (strtotime($ptw_start_date) <= strtotime($ptw_end_date)) {
                    $ptw->ptwchecklistitems()->create([                            
                            'checklist_date' => $ptw_start_date,      
                            'created_by' => auth()->id(),
                            'hrw_id' => $ptw->hrw_id,                      
                    ]);

                    $ptw_start_date = $ptw_start_date->addDay();                
                }
            
                array_push($results,$result);
            }
        } else {
            //empty ptwIds
        }

        return response()->json($results);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ptw $ptw
     * @param String $remarks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ptw $ptw, $remarks)
    {
        $result = $ptw->update(['delete_remark' => $remarks]);
 
        $result = $ptw->delete();
        return response()->json($result);
    }

    /**
     * complete (4) selected Permit
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ptw $ptw
     * @return \Illuminate\Http\Response
     */
    public function complete(Request $request, Ptw $ptw)
    {
        $result = $ptw->update([
            'ptw_status_id' => 4,
            'remarks'       => $request->remarks,
            'signatory_id'  => 0,         
            'updated_by'    => auth()->id(),            
        ]);
           
        $ptw->addSignee([
            'ptw_status_id' => 4,
            'remarks'       => $request->remarks,
            'signed_by'     => auth()->id(),
        ]);
        
        return response()->json($result);
    }

    /**
     * revoke (10) selected Permit
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ptw $ptw
     * @return \Illuminate\Http\Response
     */
    public function revoke(Request $request, Ptw $ptw) 
    {
        $result = $ptw->update([
            'ptw_status_id' => 10,
            'remarks'       => $request->remarks,
            'signatory_id'  => 0,         
            'updated_by'    => auth()->id(),            
        ]);
           
        $ptw->addSignee([
            'ptw_status_id' => 10,
            'remarks'       => $request->remarks,
            'signed_by'     => auth()->id(),
        ]);

        $inspectionchecklists = $ptw->inspectionchecklists();
                       
        if($inspectionchecklists->count() > 0) {
            foreach($inspectionchecklists->get() as $inspectionchecklist) {
                
                $inspectionchecklistitems = $inspectionchecklist->inspectionchecklistitems()->get();
                
                foreach($inspectionchecklistitems as $inspectionchecklistitem) {
                    $inspectionchecklistitem->update(['inspection_checklist_item_status_id' => 4]);
                }                
            }
        }

        return response()->json($result);
    }

    /**
     * copy selected Permit
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ptw $ptw
     * @return \Illuminate\Http\Response
     */
    public function copy(Request $request, Ptw $ptw)
    {
        $attributes['created_by']       = auth()->id();
        $attributes['end_date']         = $request->end_date;
        $attributes['end_time']         = $request->end_time == 'null' ? NULL : $request->end_time;
        $attributes['location']         = $request->location == 'undefined' ? '' : $request->location;
        $attributes['hrw_id']           = $request->hrw_id ?? 0;
        $attributes['ptw_status_id']    = $request->ptw_status_id;
        $attributes['project_id']       = $request->project_id ?? 0;
        $attributes['reference_no']     = $this->generateReferenceNo($request->project_id);
        $attributes['remarks']          = $request->remarks == 'undefined' ? '' : $request->remarks;
        $attributes['signatory_id']     = $request->signatory_id ?? 0;
        $attributes['start_date']       = $request->start_date;
        $attributes['start_time']       = $request->start_time == 'null' ? NULL : $request->start_time;        
        $attributes['sub_contractor_id']= $request->sub_contractor_id ?? 0;        
        $attributes['verifier_id']      = $request->verifier_id  == 'undefined' ? 0 : $request->verifier_id;
        $attributes['work_to_be_done']  = $request->work_to_be_done == 'undefined' ? '' : $request->work_to_be_done;
        
        $copiedPtw = Ptw::create($attributes);

        if($copiedPtw) {
             // multiple attachments
             if($request->hasFile('general_attachments')) {            
                $this->storePtwAttachments($copiedPtw, $request->file('general_attachments'),$request->general_descriptions,'generals');
            }

            // multiple attachments for equipment
            if($request->hasFile('equip_attachments')) {            
                $this->storePtwAttachments($copiedPtw, $request->file('equip_attachments'),$request->equip_descriptions,'equips');
            }

            // multiple attachments for workers
            if($request->hasFile('worker_attachments')) {   
                $this->storePtwAttachments($copiedPtw, $request->file('worker_attachments'),$request->worker_descriptions,'workers');
            }           
        
            $this->attachWorkerCertificate($copiedPtw);
            
            $this->attachDetachChecklist($copiedPtw);

            $this->attachHrwChecklist($copiedPtw);
            
            $this->attachDetachPtwSwpsWorkersEquips($copiedPtw);
        }

        return response()->json($copiedPtw);
    }

    private function attachWorkerCertificate(Ptw $ptw)
    {
        $worker_certificate_ids = request()->worker_certificate_ids ?? new stdClass();

        if(!empty($worker_certificate_ids)) {
            $worker_certificate_id_requests = json_decode($worker_certificate_ids);

            $ptwworkercertificates = $ptw->ptwworkercertificates();
            
            if($ptwworkercertificates->count() > 0) {
                $ptw_worker_certificates = $ptwworkercertificates->get();
                foreach($ptw_worker_certificates as $ptw_worker_certificate) {
                    
                    if(!property_exists($worker_certificate_id_requests,$ptw_worker_certificate->worker_id)) {
                        $ptw_worker_certificate->delete();                        
                    } else {
                        //if the worker is existing from the request object then
                        //next objective is to check whether the work certificate in 
                        //the existing worker id object has been changed or not 
                        $work_certificates_obj = $worker_certificate_id_requests->{$ptw_worker_certificate->worker_id};
                        foreach($work_certificates_obj as $key => $work_certificate_obj) {                            
                            if($work_certificate_obj->id == $ptw_worker_certificate->worker_certificate_id) {
                                
                                $ptw_worker_certificate->full_path = $work_certificate_obj->full_path;
                                $ptw_worker_certificate->folder_name = $work_certificate_obj->folder_name;
                                $ptw_worker_certificate->file_name = $work_certificate_obj->file_name;
                                $ptw_worker_certificate->description = $work_certificate_obj->description;
                                $ptw_worker_certificate->mime = $work_certificate_obj->mime;
                                $ptw_worker_certificate->expiry_at = $work_certificate_obj->expiry_at;
                                $ptw_worker_certificate->updated_by = auth()->id();
                                $ptw_worker_certificate->save();

                                unset($worker_certificate_id_requests->{$ptw_worker_certificate->worker_id}[$key]);

                                break;
                            }
                        }
                                                      
                    }
                }

            }

            foreach($worker_certificate_id_requests as $worker_id => $worker_certificates)
            {
                foreach($worker_certificates as $worker_certificate)
                {
                    $ptw->addWorkerCertificates([
                        'worker_id' => $worker_id,
                        'worker_certificate_id' => $worker_certificate->id,
                        'role_id' => $worker_certificate->role_id,
                        'full_path' => $worker_certificate->full_path,
                        'file_name' => $worker_certificate->file_name,
                        'folder_name' => $worker_certificate->folder_name,                        
                        'description' => $worker_certificate->description,
                        'mime'  => $worker_certificate->mime,
                        'expiry_at' => $worker_certificate->expiry_at,
                        'created_by' => auth()->id()
                    ]);
                }
            }
           

        } else {
            $ptw->ptwworkercertificates->each->delete();
        }

    }

    /**
     * attach / detach checklists
     *  @param  \App\Ptw $ptw
     */
    private function attachDetachChecklist(Ptw $ptw)
    {
        $checklist_ids = request()->checklist_ids ?? array();
         //ptw - inspection-checklists and inspection-checklist-items
         if(!empty($checklist_ids)) {
            $checklist_id_requests = json_decode($checklist_ids);

            $ptwinspectionchecklists = $ptw->inspectionchecklists();
            
            if($ptwinspectionchecklists->count() > 0) {
                $ptw_inspection_checklists = $ptwinspectionchecklists->get();
                foreach($ptw_inspection_checklists as $ptwinspectionchecklist) {
                    
                    if(!in_array($ptwinspectionchecklist->checklist_id,$checklist_id_requests)) {
                        $ptwinspectionchecklist->delete();                        
                    } else {
                        $key = array_search($ptwinspectionchecklist->checklist_id, $checklist_id_requests);
                        unset($checklist_id_requests[$key]);
                    }
                }
            } 
            
            foreach($checklist_id_requests as $checklist_id) {                    
                $inspectionchecklist = $ptw->addChecklist([
                        'checklist_id'      => $checklist_id,
                        'created_by'        => auth()->id(),
                        'end_date'          => $ptw->end_date,
                        'end_time'          => $ptw->end_time,
                        'location'          => $ptw->location,
                        'project_id'        => $ptw->project_id ,
                        'sub_contractor_id' => $ptw->sub_contractor_id,
                        'start_date'        => $ptw->start_date,
                        'start_time'        => $ptw->start_time,
                        'work_to_be_done'   => $ptw->work_to_be_done
                    ]);
            }
        } else {
            $ptw->inspectionchecklists->each->delete();
        }
    }

    /**
     * attach / detach high risk work
     *  @param  \App\Ptw $ptw
     */
    private function attachHrwChecklist(Ptw $ptw)
    {
        $hrw_checklist_ids = request()->hrw_checklist_ids ?? array();
         //ptw - signee(user) - hrw - checklist
         if(!empty($hrw_checklist_ids)) {
            $hrw_checklist_id_requests = json_decode($hrw_checklist_ids);
            
            $ptwhrwchecklists = $ptw->ptwhrwchecklists()->where('checked_by',auth()->id());
            if($ptwhrwchecklists->count() > 0) {
                
                $ptwhrwchecklists->update(['checked' => 0]);
                
                $ptwhrwchecklists->whereIn('hrw_checklist_id',$hrw_checklist_id_requests)    
                    ->update(['checked' => 1]);
                
            } else {

                $hrw_checklists = $ptw->hrw->hrwchecklists()->get();
                
                foreach($hrw_checklists as $hrw_checklist) {
                    $checked = 0;
                    
                    if(in_array($hrw_checklist->id,$hrw_checklist_id_requests)) {
                        $checked = 1;
                    }
                    
                    $ptw->addHrwChecklist([
                        'checked'           => $checked,
                        'checked_by'        => auth()->id(),
                        'description'       => $hrw_checklist->description,
                        'hrw_checklist_id'  => $hrw_checklist->id,                        
                        'seq_no'            => $hrw_checklist->seq_no,
                    ]);
                }   
            }    
        }
    }

    /**
     * generate ptw reference number
     * 
     * @param  $projectId
     */
    private function generateReferenceNo($projectId)
    {
        $project = Project::find($projectId);

        $ref_no = $project->code .'-'. str_pad($project->running_number,5,0, STR_PAD_LEFT);

        $project->running_number += 1;
        $project->save();

        return $ref_no;
    }


    /**
     * attach / detach swps / workers of the ptw
     * 
     * @param  \App\Ptw $ptw
     */
    private function attachDetachPtwSwpsWorkersEquips(Ptw $ptw) 
    {
        $equipment_ids = request()->equipment_ids ?? array();
        $swp_ids    = request()->swp_ids ?? array();
        $worker_ids = request()->worker_ids ?? array();
       
        //ptw - equips attach
        $ptw->equips()->detach(); // all
        if(!empty($equipment_ids)) {
            $ptw->attachEquipment($equipment_ids, true);
        }
        
        //ptw - workers attach
        $ptw->workers()->detach(); // all
        if(!empty($worker_ids)) {
            $ptw->attachWorkers($worker_ids, true);
        }
        
        //ptw - swps attach
        $ptw->swps()->detach(); // all
        if(!empty($swp_ids)) {
            $ptw->attachSwps($swp_ids, true);
        }
    }

    /**
     * store Attachment (in s3) that is tied to a ptw with a specific src_mod
     * @param \App\Ptw $ptw
     * @param File $files
     * @param Array $descriptions
     * @param String $src
     */
    private function storePtwAttachments(Ptw $ptw, $files, $descriptions,$src)
    {
        $folder = "/attachments/ptws/{$ptw->id}";
        
        foreach($files as $idx => $file) {
            $s3 = Storage::disk('s3')->put($folder, $file);
            
            $ptw->addAttachments([
                'reference_table'=> 'ptws',
                'description'    => $descriptions[$idx],                      
                'created_by'     => auth()->id(),
                'file_name'      => $file->getClientOriginalName(),
                'folder_name'    => $folder,
                'full_path'      => $s3,
                'mime'           => $file->getMimeType(),
                'src_mod'        => $src,
            ]);
        }        
    }

    /**
     *  delete and restore attachments of a src_mod that is tied to ptw
     * @param \App\Ptw $ptw
     * @param Object $attachmentObjects
     * @param String $src
     */
    private function ptwAttachments(Ptw $ptw,$attachmentObjects, $src) 
    {
        if(isset($attachmentObjects) || empty($attachmentObjects)) {
            $ptw->attachments->where('src_mod', $src)->each->delete();
        }

        if(!empty($attachmentObjects)) {            
            $attachmentObjectsRequests = json_decode($attachmentObjects);
            
            foreach($attachmentObjectsRequests as $attachmentObjectsRequest) {
                Attachment::withTrashed()->find($attachmentObjectsRequest->id)->restore();
            }
        }
    }

    /**
     * attach / detach additional safety measures (for night ptws)
     *  @param  \App\Ptw $ptw
     */
    private function attachDetachAsms(Ptw $ptw) 
    {
        $asm_checklist_ids = request()->asm_checklist_ids ?? array();
        
        if(!empty($asm_checklist_ids)) {
           $asm_checklist_id_requests = json_decode($asm_checklist_ids);
           
           $ptwasmchecklists = $ptw->ptwasmchecklists()->where('checked_by',auth()->id());
           if($ptwasmchecklists->count() > 0) {
               
               $ptwasmchecklists->update(['checked' => 0]);
               
               $ptwasmchecklists->whereIn('asm_id',$asm_checklist_id_requests)    
                   ->update(['checked' => 1]);
               
           } else {

               $asm_checklists = Asm::all();
               
               foreach($asm_checklists as $asm_checklist) {
                   $checked = 0;
                   
                   if(in_array($asm_checklist->id,$asm_checklist_id_requests)) {
                       $checked = 1;
                   }
                   
                   $ptw->addAsmChecklist([
                       'checked'    => $checked,
                       'checked_by' => auth()->id(),
                       'asm_id'     => $asm_checklist->id,                        
                   ]);
               }   
           }    
       }
    }
    
}
