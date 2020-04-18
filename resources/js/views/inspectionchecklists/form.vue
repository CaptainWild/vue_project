<template>
    <v-form 
        ref="form"
        v-model="valid"                
        lazy-validation
        @submit.prevent="save"      
    >
    <v-card>        
        <v-card-title>
            <span class="headline">{{ formTitle }}</span>
        </v-card-title>
        <v-card-text>          
            <v-container>
            <v-row>            
            <v-col cols="12" md="6" sm="6">
                <ProjectPullDown
                    v-model="inspectionChecklist.project_id"
                    :projectIcon = false
                ></ProjectPullDown>
            </v-col>
            <v-col cols="12" md="6" sm="6">
                <SubContractorPullDown                    
                    v-model="inspectionChecklist.sub_contractor_id"
                    :projectId='inspectionChecklist.project_id'
                ></SubContractorPullDown>
            </v-col>           
            <v-col cols="12" sm="3" md="3">
                <DatePicker
                    dateLabel= "*Start Date"
                    :dateIcon = false
                    v-model ="inspectionChecklist.start_date"
                ></DatePicker>
            </v-col>
            <v-col cols="12" sm="3" md="3">
                <DatePicker
                    dateLabel= "*End Date"
                    :dateIcon = false
                    v-model ="inspectionChecklist.end_date"
                ></DatePicker>
            </v-col>
            <v-col cols="12" sm="3" md="3">
                <TimePicker
                    timeLabel= "*Start Time"
                    :timeIcon = false
                    v-model ="inspectionChecklist.start_time"
                ></TimePicker>
            </v-col>
            <v-col cols="12" sm="3" md="3">
                <TimePicker
                    timeLabel= "*End Time"
                    :timeIcon = false
                    v-model ="inspectionChecklist.end_time"
                ></TimePicker>
            </v-col>
            <v-col cols="12" sm="6" md="6">
                <v-textarea 
                    auto-grow 
                    clearable 
                    v-model="inspectionChecklist.work_to_be_done" 
                    rows="1"
                    label="Work to be done">
                </v-textarea>
            </v-col>
            <v-col cols="12" sm="6" md="6">
                <v-textarea 
                    auto-grow 
                    clearable 
                    v-model="inspectionChecklist.location" 
                    rows="1"
                    label="Location">
                </v-textarea>
            </v-col>          
            <v-col cols="12">
                <ChecklistPullDown v-model="inspectionChecklist.checklist_id"></ChecklistPullDown>
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
                raised 
                color="warning darken-1" 
                dark 
                type="submit"
                :loading="loading"
                
            >Save</v-btn>
            <v-btn 
                v-show="generateBtn"
                raised 
                color="success darken-1" 
                dark 
                :loading="loading"
                @click="generate"
            >Save & Generate</v-btn>
        </v-card-actions>

    </v-card>
    </v-form>

</template>

<script>
import DatePicker from '@/js/components/DatePicker';
import Form from '@/js/core/form';
import ChecklistPullDown from '@/js/views/checklists/pulldown';
import ProjectPullDown from '@/js/views/projects/pulldown';
import TimePicker from '@/js/components/TimePicker';
import SubContractorPullDown from '@/js/views/project_subcontractors/subContractorPulldown';

export default {
    components: {
        DatePicker,
        ChecklistPullDown,
        ProjectPullDown,
        TimePicker,      
        SubContractorPullDown,
    },
    props: {
        inspectionChecklistDialog : Boolean,         
    },

    data: () => ({        
        checklistIds: [], 
        generateBtn: true,
        inspectionChecklist: {},       
        loading: false,
        valid: true,
    }),

    computed: {
        formTitle () {
            return this.inspectionChecklist.id == undefined ? 'New Inspection Checklist' : 'Edit  Inspection Checklist (#'+this.inspectionChecklist.id+')'
        },         
    },

    watch: {
        'ptw.project_id': {
            immediate: true,
            handler(newVal,oldVal) {
                if(newVal != oldVal && newVal == undefined) {
                    this.inspectionChecklist.sub_contractor_id = 0
                }
            }            
        },

    },

    created () {
        this.inspectionChecklist = Object.assign({},this.$store.getters.inspectionchecklist)
        
        if(this.inspectionChecklist.id == undefined) {
            this.inspectionChecklist.end_date = new Date().toISOString().slice(0,10)
            this.inspectionChecklist.end_time = ((new Date().getHours() + 1) < 10 ? '0' : '') + (new Date().getHours() + 1) + ":" + (new Date().getMinutes() < 10 ? '0' : '') + new Date().getMinutes()
            this.inspectionChecklist.start_date = new Date().toISOString().slice(0,10)
            this.inspectionChecklist.start_time = (new Date().getHours() < 10 ? '0' : '') + new Date().getHours() + ":" + (new Date().getMinutes() < 10 ? '0' : '') + new Date().getMinutes()
        } else {
            if(this.inspectionChecklist.inspectionchecklistitems.length > 0){
                this.generateBtn = false
            }
        }


    },

    methods: {
        resetForm() {
            this.$store.commit('RESET_INSPECTION_CHECKLIST')            
            this.$emit('update:inspectionChecklistDialog',false)            
        },

        generate() {          
               this.inspectionChecklist.generate = true;
               this.save()
        }, 
        
        save() {
            this.loading = true
            if(this.$refs.form.validate()) {
                
                var action = "createInspectionChecklist";                
                if(this.inspectionChecklist.id != undefined) {
                    action = "updateInspectionChecklist";    
                    
                    this.inspectionChecklist._method = 'PATCH'
                }

                this.$store.dispatch(action,this.inspectionChecklist)
                .then(response => {   
                    this.loading = false                          
                    this.resetForm()
                    this.$emit('refresh')
                    setTimeout(() => {                
                        this.$store.commit('closeSnackbar');
                    },2000);              
                }).catch(error=> {
                    this.loading = false 
                    console.log(error);
                });  
            
            } else {
                this.loading = false
            }
        },
    }
}
</script>