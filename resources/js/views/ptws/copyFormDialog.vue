<template>
<v-dialog v-model="copyDialog"  max-width="900px" persistent scrollable>
    <v-form 
        ref="copyform"
        v-model="valid"                
        lazy-validation
        @submit.prevent="save"      
    >
    <v-card>        
        <v-card-title>
            <span class="headline pink--text">{{ formTitle }}</span>
        </v-card-title>
        <v-card-text>          
            <v-container>
                <v-row>
                    <v-col cols="12" md="4">
                        <ProjectPullDown
                            v-model="ptw.project_id"
                            :projectIcon = false
                        ></ProjectPullDown>
                    </v-col>
                    <v-col cols="12" md="4">
                        <SubContractorPullDown                    
                            v-model="ptw.sub_contractor_id"
                            :projectId='ptw.project_id'
                        ></SubContractorPullDown>
                    </v-col>  
                    <v-col cols="12" md="4">
                        <v-select
                            :items="sa2ComputedList"
                            :loading="loading"
                            v-model="ptw.verifier_id" 
                            label="Verifier / Coordinator (if any)"
                            placeholder="None"
                            item-text="name"
                            item-value="id"
                            clearable
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="3" md="3">
                        <DatePicker
                            dateLabel= "*Start Date"
                            :dateIcon = false
                            v-model ="ptw.start_date"
                        ></DatePicker>
                    </v-col>
                    <v-col cols="12" sm="3" md="3">
                        <TimePicker
                            timeLabel= "*Start Time"
                            :timeIcon = false
                            v-model ="ptw.start_time"
                        ></TimePicker>
                    </v-col>
                    <v-col cols="12" sm="3" md="3">
                        <DatePicker
                            dateLabel= "*End Date"
                            :dateIcon = false
                            v-model ="ptw.end_date"
                        ></DatePicker>
                    </v-col>
                
                    <v-col cols="12" sm="3" md="3">
                        <TimePicker
                            timeLabel= "*End Time"
                            :timeIcon = false
                            v-model ="ptw.end_time"
                        ></TimePicker>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                        <v-textarea 
                            auto-grow 
                            clearable 
                            v-model="ptw.work_to_be_done" 
                            outlined
                            no-resize
                            label="Work to perform">
                        </v-textarea>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                        <v-textarea 
                            auto-grow 
                            clearable 
                            v-model="ptw.location" 
                            outlined
                            no-resize
                            label="Location">
                        </v-textarea>
                    </v-col>
                    <v-col cols="12">
                        <HrwPullDown v-model="ptw.hrw_id"
                            :checklistGroupId.sync="checklistGroupId"
                        ></HrwPullDown>
                    </v-col>          
                    <v-col cols="12">                
                        <HrwChecklist
                            v-model="ptw.hrw_id"
                            :hrwChecklistIds.sync="hrwChecklistIds"
                        ></HrwChecklist>
                    </v-col>
                    <v-col cols="12" v-if="ptw.ptw_type == 'Night'">                
                        <AsmsDataTable
                            :asmChecklistIds.sync="asmChecklistIds"
                        ></AsmsDataTable>
                    </v-col>  
                    <v-col cols="12">
                        <ChecklistDataTable
                            :checklistIds.sync = "checklistIds"
                            v-model="checklistGroupId"
                        ></ChecklistDataTable>
                    </v-col> 
                    <v-col cols="12">
                        <SwpDataTable                    
                            :swpIds.sync="swpIds"
                        ></SwpDataTable>
                    </v-col>
                    <v-col cols="12">
                        <WorkersDataTable
                            v-model="ptw.sub_contractor_id"
                            :workerIds.sync = "workerIds"
                        ></WorkersDataTable>
                    </v-col>  
                    <v-col cols="12">
                        <EquipmentDataTable
                            v-model="ptw.sub_contractor_id"
                            :equipmentIds.sync = "equipmentIds"
                        ></EquipmentDataTable>
                    </v-col>            
                    <v-col cols="12">
                        <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                            <v-btn 
                                v-on="on"
                                color="primary"
                                dark
                                @click="uploadTemp"
                                :loading="loading"
                                block
                            >
                                <v-icon dark>mdi-attachment</v-icon>
                                <span>General Attachments</span>
                            </v-btn>
                        </template>
                        <span>General Attachment</span>
                        </v-tooltip>
                    </v-col>                     
            
                </v-row>
            </v-container> 
        
        </v-card-text>

        <v-card-actions>
            <v-btn 
                raised 
                color="secondary darken-1" 
                dark 
                @click="resetForm"
            >Close</v-btn>
            <v-spacer></v-spacer>            
            <v-btn 
                @click="formSubmit"
                raised 
                color="success darken-1" 
                dark 
                :loading="loading"                
            >Copy</v-btn>
        </v-card-actions>
        
        <TempAttachments 
            v-if="tempAttachmentDialog"       
            :tempAttachmentDialog.sync="tempAttachmentDialog"
            reference_table = "ptws"
            src_mod = "generals"
            :reference_id = "ptw.id"
            title = "Upload / Remove General Attachment(s)"
        >
        </TempAttachments>
    </v-card>
    </v-form>
</v-dialog>
</template>

<script>
import AsmsDataTable from '@/js/views/asms/indexDataTable';
import ChecklistDataTable from '@/js/views/checklists/list';
import DatePicker from '@/js/components/DatePicker';
import EquipmentDataTable from '@/js/views/subcontractors/equipsDataTable';
import HrwPullDown from '@/js/views/hrws/pulldown';
import HrwChecklist from '@/js/views/hrws/checklistDataTable';
import ProjectPullDown from '@/js/views/projects/pulldown';
import TempAttachments from '@/js/views/attachments/indexStoreDialog';
import TimePicker from '@/js/components/TimePicker';
import SubContractorPullDown from '@/js/views/project_subcontractors/subContractorPulldown';
import SwpDataTable from '@/js/views/swps/list';
import WorkersDataTable from '@/js/views/subcontractors/workersDataTable';

export default {
    components: {
        AsmsDataTable,
        ChecklistDataTable,
        DatePicker,
        EquipmentDataTable,
        HrwPullDown,
        HrwChecklist,
        ProjectPullDown,
        TempAttachments,
        TimePicker,      
        SubContractorPullDown,
        SwpDataTable,
        WorkersDataTable,
    },
    props: {
        copyDialog : Boolean,
    },

    data: () => ({ 
        asmChecklistIds: [],       
        attachments: [],
        checklistIds: [],
        checklistGroupId: 0,
        draftBtn: true,
        equipmentIds: [],
        hrwChecklistIds: [],        
        loading: false,
        ptwStatusId: 5,
        ptw: {},
        swpIds: [],
        tempAttachmentDialog: false,
        valid: true,
        workerIds: [],
    }),

    computed: {
        formTitle () {
            return 'Copy PTW ('+this.ptw.reference_no+')'
        }, 
        swpCategoryIdComputed () {            
            if(this.ptw.id != undefined && this.ptw.swps.length > 0) {            
                return this.ptw.swps[0].swp_category_id;
            }            
            return 0;
        },
        sa2ComputedList () {
            return this.$store.getters.subcontractorAssessors
        },       
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
        'ptw.sub_contractor_id': {
            immediate: true,
            handler(newVal,oldVal) {
                if(newVal != oldVal) {
                    this.verifiers(newVal)
                }
            }            
        }

    },

    created () {
        this.ptw = Object.assign({},this.$store.getters.ptw)       
    },

    methods: {
        uploadTemp() {
            this.tempAttachmentDialog = true
        },
        resetForm() {
            this.$store.commit('CLEAR_PTW')
            this.attachments = []
            this.checklistIds = []
            this.equipmentIds = []
            this.$store.commit('RESET_SUBCONTRACTOR_EQUIPMENT_LIST')
            this.hrwChecklistIds = []
            this.$store.commit('RESET_HRW_CHECKLIST')
            this.swpIds = []
            this.$store.commit('RESET_SWP_CATEGORY')
            this.workerIds = []
            this.$store.commit('RESET_SUBCONTRACTOR_WORKERS_LIST')
            this.$store.commit('RESET_MAIN_CON_ASSESSORS')      
            this.$store.commit('DESTROY_TEMP_ATTACHMENT')   
            this.$emit('update:copyDialog',false)            
        },

        verifiers(sub_contractor_id) {            
            this.$store.commit('RESET_SUBCONTRACTOR_ASSESSORS_LIST')
            if(sub_contractor_id != undefined) {
                var action = 'fetchSubContractorAssessors' //default is the assessor for now
              
                this.$store.dispatch(action,{sub_contractor_id: sub_contractor_id})
                .catch(error=> {
                    this.loading = false 
                    console.log(error);
                });
            }
        },

        formSubmit() {
            if(this.$refs.copyform.validate()) {
               this.save()
            }
        }, 
        
        save() {
            this.loading = true
            let ptwForm = new FormData();
                
            var action = "copyPtw";                
            
            ptwForm.append('id',this.ptw.id);

            ptwForm.append('ptw_status_id', this.ptwStatusId);
            ptwForm.append('end_date',this.ptw.end_date);
            ptwForm.append('end_time',this.ptw.end_time);   
            ptwForm.append('hrw_id',this.ptw.hrw_id);  
            ptwForm.append('location',this.ptw.location);  
            ptwForm.append('project_id',this.ptw.project_id);            
            ptwForm.append('sub_contractor_id',this.ptw.sub_contractor_id);
            ptwForm.append('start_date',this.ptw.start_date);            
            ptwForm.append('start_time',this.ptw.start_time);
            ptwForm.append('verifier_id',this.ptw.verifier_id);
            ptwForm.append('work_to_be_done',this.ptw.work_to_be_done);

            if(this.$store.getters.tempAttachments.workers != undefined) {

                var workerAttachmentObjects = []
                var workerAttachments = this.$store.getters.tempAttachments.workers

                for( var i = 0; i < Object.keys(workerAttachments).length; i++ ){
                    if(workerAttachments[i].file_name instanceof File) {
                        ptwForm.append('worker_attachments[' + i + ']', workerAttachments[i].file_name);
                        ptwForm.append('worker_descriptions[' + i + ']', workerAttachments[i].description);
                    } else {
                        workerAttachmentObjects.push(workerAttachments[i])                        
                    }
                }

                ptwForm.append('worker_attachment_objects',JSON.stringify(workerAttachmentObjects))
            }

            if(this.$store.getters.tempAttachments.equips != undefined) {

                var equipAttachmentObjects = []
                var equipAttachments = this.$store.getters.tempAttachments.equips

                for( var i = 0; i < Object.keys(equipAttachments).length; i++ ){
                    if(equipAttachments[i].file_name instanceof File) {
                        ptwForm.append('equip_attachments[' + i + ']', equipAttachments[i].file_name);
                        ptwForm.append('equip_descriptions[' + i + ']', equipAttachments[i].description);
                    } else {
                        equipAttachmentObjects.push(equipAttachments[i])                        
                    }
                }

                ptwForm.append('equip_attachment_objects',JSON.stringify(equipAttachmentObjects))
            }

            if(this.$store.getters.tempAttachments.generals != undefined) {

                var generalAttachmentObjects = []
                var generalAttachments = this.$store.getters.tempAttachments.generals

                for( var i = 0; i < Object.keys(generalAttachments).length; i++ ){
                    if(generalAttachments[i].file_name instanceof File) {
                        ptwForm.append('general_attachments[' + i + ']', generalAttachments[i].file_name);
                        ptwForm.append('general_descriptions[' + i + ']', generalAttachments[i].description);
                    } else {
                        generalAttachmentObjects.push(generalAttachments[i])                        
                    }
                }

                ptwForm.append('general_attachment_objects',JSON.stringify(generalAttachmentObjects))
            }    

            ptwForm.append('checklist_ids', JSON.stringify(this.checklistIds))
            ptwForm.append('hrw_checklist_ids', JSON.stringify(this.hrwChecklistIds))
            ptwForm.append('swp_ids', JSON.stringify(this.swpIds))
            ptwForm.append('worker_ids', JSON.stringify(this.workerIds))
            ptwForm.append('equipment_ids', JSON.stringify(this.equipmentIds))
            ptwForm.append('worker_certificate_ids', JSON.stringify(this.$store.getters.workercertificateIds))
            
           this.$store.dispatch(action,ptwForm)
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