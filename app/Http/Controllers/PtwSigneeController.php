<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ptw;
use App\PtwSignee;
use App\Http\Traits\SignatureTrait;
use Carbon\Carbon;

class PtwSigneeController extends Controller
{
    use SignatureTrait;
    /**
     * Apply auth middleware
    */
    public function __construct() 
    {
        $this->middleware('auth:api');
    }

    /**
     * Store a newly created resource in storage.
     * Currently caters cancelled, endorse and rejection status only
     * note: for rejection return to applicant (for now)
     * later: email or notify assessor and applicant whenever this function is triggered
     * @param  \App\Ptw $ptw
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Ptw $ptw)
    {
        if(!empty($request->hrw_checklist_ids)) {
            $hrw_checklist_id_requests = json_decode($request->hrw_checklist_ids);
        
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

        unset($request->hrw_checklist_ids);// not a member of ptw_signees table
            
        if($request->ptw_status_id == 2 || $request->ptw_status_id == 1){ //cancelled or approved
            $signatory = 0;

            //if approved
            if($request->ptw_status_id == 1) {
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
            }
            
        } else if($request->ptw_status_id == 9) { //rejected
            $signatory = $ptw->created_by;
        } else if($request->ptw_status_id == 11 || $request->ptw_status_id == 12) { // halted || resumed
            $signatory = 0;
        } else { //endorsed
            $signatory = $request->signatory_id;
        }
        
        $fields = [
            'ptw_status_id' => $request->ptw_status_id,
            'signatory_id'  => $signatory,         
            'updated_by' => auth()->id(),
        ];

        if($ptw->ptw_status_id == 8 && $ptw->verifier_id == auth()->id() && $ptw->verified_at == null) {
            $fields['verified_at'] = Carbon::now();
        }

        $ptw->update($fields);

        unset($request->signatory_id); // not a member of ptw_signees table

        $signature = '';
        if(isset($request->signed_path) && !empty($request->signed_path)){
            $signature = $this->decodeAndStore('ptws',$ptw->id,$request->signed_path);     
        }

        $request->request->add(['signed_by' => auth()->id(), 'signed_path' => $signature]); //add request

        return response()->json($ptw->addSignee($request->all()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PtwSignee  $ptwsignee
     * @return \Illuminate\Http\Response
     */
    public function destroy(PtwSignee $ptwsignee)
    {
        $result = $ptwsignee->delete();
        return response()->json($result);
    }
}
