<template>
    <v-card>        
        <v-card-title>
            <span class="headline">{{ title }}</span>
        </v-card-title>                    
        <v-card-text>    
            <v-alert type="error" dark dense v-if="ptw.ptw_status_id == 11">
                <span>Remarks: {{rejectRemark.remarks}}</span>
            </v-alert>      
            <v-container>
            <v-row>               
                <v-col cols="12" md="6" sm="6">
                    <ProjectPullDown
                        v-model="ptw.project_id"
                        :projectIcon = false
                        :disable = true
                    ></ProjectPullDown>
                </v-col>
                <v-col cols="12" md="6" sm="6">
                    <SubContractorPullDown                    
                        v-model="ptw.sub_contractor_id"
                        :projectId='ptw.project_id'
                        :disable = true                        
                    ></SubContractorPullDown>
                </v-col>
                 <v-col cols="12" sm="3" md="3">
                    <DatePicker
                        dateLabel= "*Start Date"
                        :dateIcon = false
                        v-model ="ptw.start_date"
                        :disable = true
                    ></DatePicker>
                </v-col>
                <v-col cols="12" sm="3" md="3">
                    <TimePicker
                        timeLabel= "*Start Time"
                        :timeIcon = false
                        v-model ="ptw.start_time"
                        :disable = true
                    ></TimePicker>
                </v-col>
                <v-col cols="12" sm="3" md="3">
                    <DatePicker
                        dateLabel= "*End Date"
                        :dateIcon = false
                        v-model ="ptw.end_date"
                        :disable = true
                    ></DatePicker>
                </v-col>            
                <v-col cols="12" sm="3" md="3">
                    <TimePicker
                        timeLabel= "*End Time"
                        :timeIcon = false
                        v-model ="ptw.end_time"
                        :disable = true
                    ></TimePicker>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                    <v-textarea 
                        auto-grow 
                        v-model="ptw.work_to_be_done" 
                        rows="1"
                        :disabled="true"
                        label="Work to perform">
                    </v-textarea>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                    <v-textarea 
                        auto-grow 
                        v-model="ptw.location" 
                        rows="1"
                        :disabled="true"
                        label="Location">
                    </v-textarea>
                </v-col>    
                <v-col cols="12">
                    <HrwPullDown 
                        v-model="ptw.hrw_id"
                        :disable="true"
                    ></HrwPullDown>
                </v-col>

                <v-col cols="12" v-if="ptw.ptw_status_id == 6 || ptw.ptw_status_id == 1"> 
                    <ApproveHrwChecklist></ApproveHrwChecklist>
                </v-col>                     
                <v-col cols="12" v-if="ptw.ptw_status_id == 8"> 
                    <VerifyHrwChecklist
                        v-model = "ptw.hrw_id"
                        :hrwChecklistIds.sync = "hrwChecklistIds"
                        :checklistLabel = "label"
                    ></VerifyHrwChecklist>
                </v-col>
                 <v-col cols="12" v-if="ptw.ptw_type == 'Night'"> 
                    <AsmsDataTable></AsmsDataTable>
                </v-col>    
                     
         
            <v-col cols="12">

                <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                     <v-badge
                        :content="supportingDocsCount('workers')"
                        :value="supportingDocsCount('workers')"
                        color="amber darken-1"
                        overlap              
                    >
                    <v-btn 
                        v-on="on"
                        raised 
                        color="info" 
                        dark
                        fab 
                        @click="openSupporting('workers')"
                    >                   
                    <v-icon>mdi-worker</v-icon>                    
                    </v-btn>
                     </v-badge>
                 </template>
                    <span>Personnel Involve</span>
                </v-tooltip>
                

                <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                    <v-badge
                        :content="supportingDocsCount('equipment')"
                        :value="supportingDocsCount('equipment')"
                        color="amber darken-1"
                        overlap              
                    >
                    <v-btn 
                        v-on="on"
                        raised 
                        color="info" 
                        dark
                        fab 
                        @click="openSupporting('equipment')"
                    >                   
                    <v-icon>mdi-excavator</v-icon>                    
                    </v-btn>
                    </v-badge>
                 </template>
                    <span>Equipment</span>
                </v-tooltip>

                <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                     <v-badge
                        :content="supportingDocsCount('swps')"
                        :value="supportingDocsCount('swps')"
                        color="amber darken-1"
                        overlap              
                    >
                    <v-btn 
                        v-on="on"
                        raised
                        fab 
                        color="info" 
                        dark 
                        @click="openSupporting('swps')"
                    ><v-icon>mdi-safety-goggles</v-icon></v-btn>
                     </v-badge>
                </template>
                <span>Safe Work Procedures</span>
                </v-tooltip>

                 <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                     <v-badge
                        :content="supportingDocsCount('checklists')"
                        :value="supportingDocsCount('checklists')"
                        color="amber darken-1"
                        overlap              
                    >
                    <v-btn 
                        v-on="on"
                        raised
                        fab 
                        color="info" 
                        dark 
                        @click="openSupporting('checklists')"
                    ><v-icon>mdi-clipboard-list-outline</v-icon></v-btn>
                     </v-badge>
                </template>
                <span>Checklists</span>
                </v-tooltip>


                <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                     <v-badge
                        :content="supportingDocsCount('attachments')"
                        :value="supportingDocsCount('attachments')"
                        color="amber darken-2"
                        overlap              
                    >                   
                    <v-btn 
                        v-on="on"
                        raised
                        fab  
                        color="info" 
                        dark 
                    @click="openSupporting('attachments')"
                    ><v-icon>mdi-attachment</v-icon></v-btn>
                     </v-badge>
                </template>
                <span>Attachments</span>
                </v-tooltip>

            </v-col>
            <v-col cols="12">
                <SigneesDataTable></SigneesDataTable>
            </v-col>
            </v-row>
            </v-container>
        </v-card-text>
        <v-card-actions>
            <v-btn 
                raised 
                color="secondary" 
                dark 
                @click="resetForm"
            >Close</v-btn>
            <v-spacer></v-spacer>
            <v-btn 
                v-show="$can.permit('ptw_reject') && (ptw.ptw_status_id != 1 && ptw.ptw_status_id != 12)"
                raised 
                color="warning darken-1" 
                dark                 
                :loading="loading"
                @click="disapprove(9)"
            >Reject</v-btn>
            <v-btn 
                v-show="$can.permit('ptw_halt') && (ptw.ptw_status_id == 1 || ptw.ptw_status_id == 12)"
                raised 
                color="error darken-1" 
                dark 
                :loading="loading"
                @click="disapprove(11)"
            >Halt</v-btn>
             <!-- <v-btn 
                v-show="$can.permit('ptw_resume') && ptw.ptw_status_id == 11"
                raised 
                color="success darken-1" 
                dark 
                :loading="loading"
                @click="formSubmit"
            >Resume</v-btn> -->
            <v-btn 
                v-show="($can.permit('ptw_verify') || $can.permit('ptw_endorsed') || $can.permit('ptw_approve') ) && (ptw.ptw_status_id != 1 && ptw.ptw_status_id != 12 && ptw.ptw_status_id != 11)"
                raised 
                color="success darken-1" 
                dark 
                :loading="loading"
                @click="formSubmit"
            >{{successBtn}}</v-btn>
        </v-card-actions>
        
        <WorkersDialog
            :workersDialog.sync = "viewWorkersDialog"           
        ></WorkersDialog>
        
        <SwpsDialog
            :swpsDialog.sync = "viewSwpsDialog"           
        ></SwpsDialog>
        
        <AttachmentsDialog
            :attachmentsDialog.sync = "viewAttachmentsDialog"
        ></AttachmentsDialog>
        
        <ChecklistsDialog
            :checklistsDialog.sync = "viewChecklistsDialog"
        ></ChecklistsDialog>

        <EquipmentDialog
            :equipmentDialog.sync = "viewEquipmentDialog"
        ></EquipmentDialog>

        <ConfirmationForm
            v-if = 'ptwFormSignDialog'
            :ptwFormSignDialog.sync = "ptwFormSignDialog"
            :ptw_status_id = "ptw_status_id"
            :ptwId = "ptw.id"
            :summarized = "summary"            
            :signatoryId = "ptw.signatory_id"
            :isVerifier = "verifierComputed"
            @save="save"
        ></ConfirmationForm>

        <DisapprovalForm
            :ptwFormDisapprovalDialog.sync = "ptwFormDisapprovalDialog"
            :ptwStatus = "dis_ptw_status_id"
            @save="save"
        ></DisapprovalForm>
    </v-card>
</template>

<script>
import AsmsDataTable from '@/js/views/asms/appliedDataTable';
import ApproveHrwChecklist from '@/js/views/hrws/approveChecklistDataTable';
import AttachmentsDialog from '@/js/views/ptws/viewAttachmentsDialog';
import ChecklistsDialog from '@/js/views/ptws/viewChecklistsDialog';
import ConfirmationForm from '@/js/views/ptws/formSigningDialog';
import DatePicker from '@/js/components/DatePicker';
import DisapprovalForm from '@/js/views/ptws/formDisapprovalDialog'; 
import EquipmentDialog from '@/js/views/ptws/viewEquipmentDialog';
import Form from '@/js/core/form';
import HrwPullDown from '@/js/views/hrws/pulldown';
import ProjectPullDown from '@/js/views/projects/pulldown';
import TimePicker from '@/js/components/TimePicker';
import SigneesDataTable from '@/js/views/ptws/signeesDataTable';
import SubContractorPullDown from '@/js/views/project_subcontractors/subContractorPulldown';
import SwpsDialog from '@/js/views/ptws/viewSwpsDialog';
import VerifyHrwChecklist from '@/js/views/hrws/verifyChecklistDataTable';
import WorkersDialog from '@/js/views/ptws/viewWorkersDialog';

export default {
    components: {
        AsmsDataTable,
        ApproveHrwChecklist,
        AttachmentsDialog,
        ChecklistsDialog,
        ConfirmationForm,
        DatePicker,
        DisapprovalForm,
        EquipmentDialog,
        HrwPullDown,
        ProjectPullDown,
        TimePicker,
        SigneesDataTable,      
        SubContractorPullDown,
        SwpsDialog,
        VerifyHrwChecklist,
        WorkersDialog
    },
    
    props: {
        ptwViewDialog : Boolean,         
    },
    
    data: () => ({     
        dis_ptw_status_id :0,
        draftBtn: true,
        hrwChecklistIds: [],
        loading: false,
        label:'',
        ptwFormSignDialog: false,
        ptwFormDisapprovalDialog: false,
        ptw: {},
        ptw_status_id: 0,        
        summary: {},      
        viewAttachmentsDialog: false,
        viewChecklistsDialog: false,
        viewEquipmentDialog: false,
        viewWorkersDialog: false,
        viewSwpsDialog: false,
        ptwsignee: new Form({ remarks:"",ptw_id:0,ptw_status_id:0,signed_path:'',hrw_checklist_ids:'',signatory_id: 0})
    }),
   
    computed: {
        rejectRemark () {
            return _.last(this.ptw.ptwsignees)
        },
        user(){
            return this.$store.getters.getProfile;
        },
        title () {
            var ref_no = this.ptw.reference_no
            if(this.ptw.ptw_status_id == 6) //endorse
                return 'Approve PTW ('+ref_no+')'
            else if(this.ptw.ptw_status_id == 8 && this.verifierComputed) //pending
                return 'Verify PTW ('+ref_no+')'
            else if(this.ptw.ptw_status_id == 8)
                return 'Endorse PTW ('+ref_no+')'
            else
                return 'View PTW ('+ref_no+')'           
        },
        successBtn() {
            if(this.ptw.ptw_status_id == 6)
                return 'Approve'
            else if(this.ptw.ptw_status_id == 8 && this.verifierComputed)
                return 'Verify'
            else 
                return 'Endorse'
        },
        verifierComputed() {
            if(this.ptw.verifier_id == this.user.id && this.ptw.verified_at == null) {
                return true
            }

            return false
        }         
    },

    watch: {
        'ptw.project_id': {
            immediate: true,
            handler(newVal,oldVal) {
                if(newVal != oldVal && newVal == undefined) {
                    this.ptw.sub_contractor_id = 0
                }
            }            
        },

    },

    created () {
        this.ptw = Object.assign({},this.$store.getters.ptw)
        
        if(this.ptw.ptw_status_id == 6) { //endorsed
            this.ptw_status_id = 1 //approve
        } else if(this.ptw.ptw_status_id == 11) { //halted
            this.ptw_status_id = 12  // resume
        } else if(this.ptw.ptw_status_id == 8 && this.verifierComputed) {
            this.ptw_status_id = 8 //still remain pending
        } else { // default pending
            this.ptw_status_id = 6 //endorse 
        }
    },

    methods: {
        resetForm() {
            this.$store.commit('CLEAR_PTW')
            this.$emit('update:ptwViewDialog',false)            
        },

        formSubmit() {    
           
            this.summary.project = this.ptw.project.title +' ('+this.ptw.project.code+')'
            this.summary.verifier = this.ptw.verifier != null ? this.ptw.verifier.name : 'NONE';
            this.summary.start_date = this.ptw.start_date
            this.summary.start_time = this.ptw.start_time
            this.summary.end_date = this.ptw.end_date
            this.summary.end_time = this.ptw.end_time
            this.summary.work = this.ptw.work_to_be_done
            this.summary.location = this.ptw.location     

            this.ptwFormSignDialog = true
        }, 

        disapprove(status) {
            this.dis_ptw_status_id = status //cancel or reject or halt
            this.ptwFormDisapprovalDialog = true
        },   

        openSupporting(value) {
            if(value == 'workers')
                this.viewWorkersDialog = true
            else if(value == 'swps')
                this.viewSwpsDialog = true
            else if(value == 'attachments')
                this.viewAttachmentsDialog = true
            else if(value == 'checklists')
                this.viewChecklistsDialog = true
            else if(value == 'equipment')
                this.viewEquipmentDialog = true
        },

        supportingDocsCount(value) {
            if(value == 'workers')
                return this.ptw.workers.length
            else if(value == 'swps')
                return this.ptw.swps.length
            else if(value == 'attachments')
                return this.ptw.attachments.length
            else if(value == 'checklists')
                return this.ptw.inspectionchecklists.length
            else if(value == 'equipment')
                return this.ptw.equips.length
        
            return 0;
        },
        
        save(confirmation_data) {
            this.loading = true
            var action = "createPtwSignee";                

            this.ptwsignee.ptw_id = this.ptw.id
            this.ptwsignee.remarks = confirmation_data.remarks
            this.ptwsignee.ptw_status_id = this.ptw_status_id

            if(confirmation_data.ptw_status_id != undefined) {
                this.ptwsignee.ptw_status_id = confirmation_data.ptw_status_id
            }

            if(confirmation_data.signed_path != undefined) {
                this.ptwsignee.signed_path = confirmation_data.signed_path
            }

            if(confirmation_data.signatory_id != undefined) {
                this.ptwsignee.signatory_id = confirmation_data.signatory_id                
            }

            if(this.hrwChecklistIds.length > 0){
                this.ptwsignee.hrw_checklist_ids = JSON.stringify(this.hrwChecklistIds)
            }
                
            this.$store.dispatch(action,this.ptwsignee)
                .then(response => {   
                    this.loading = false                          
                    this.resetForm()
                    this.$emit('refresh')
                    setTimeout(() => {                
                        this.$store.commit('closeSnackbar');
                    },2000);              
                })
                .catch(error=> {
                    this.loading = false 
                    console.log(error);
            });  
        },
    }
}
</script>

<style>

</style>