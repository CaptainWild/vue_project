<template>
  
    <v-dialog v-model="inspectionChecklistItemFormSignDialog" max-width="400" scrollable persistent>
    <v-form 
        ref="saveform"
        v-model="valid"
        @submit.prevent="confirm"
        lazy-validation      
    >
    <v-card>
        <v-card-title>
            <span class="headline">{{title}}</span>
        </v-card-title>
        <v-card-text>
            <v-container>
            <v-row>              
                <v-col cols="12">
                    <v-textarea 
                        auto-grow 
                        clearable 
                        v-model="remarks" 
                        rows="1"
                        label="Remarks">
                    </v-textarea>
                </v-col>
                <v-col cols="12">
                    <WorkersPulldown 
                        v-model ="operator_id" 
                        :subContractorId="subContractorId"
                    ></WorkersPulldown>  
                </v-col>
                <v-col cols="12">
                    <DrawingPad
                        v-model="operator_signed_path"
                        title='Operator Signature'
                        :height='200'
                        :width="342"
                        ref='drawingPad'
                    ></DrawingPad>                  
                </v-col>
                <v-col cols="12">
                   <DrawingPad
                    v-model="supervisor_signed_path"
                    title='Supervisor Signature'
                    :height='200'
                    :width="342"
                    ref='drawingPad'
                   ></DrawingPad>                  
                </v-col>
            </v-row>
            </v-container>
        </v-card-text>
        <v-card-actions>
              <v-btn 
                raised 
                color="secondary darken-1" 
                dark 
                @click="closeFormSigning"
            >Cancel</v-btn>
            <v-spacer></v-spacer>          
            <v-btn 
                raised 
                color="success darken-1" 
                dark 
                :loading="loading"
                type="submit"
            >Save</v-btn>
        </v-card-actions>
    </v-card>
    </v-form>
    </v-dialog>
</template>

<script>
import DrawingPad from '@/js/components/DrawingPad';
import WorkersPulldown from '@/js/views/subcontractors/workersPulldown';

export default {
    components: {
        DrawingPad,
        WorkersPulldown
    },
    
    props : {
        inspectionChecklistItemFormSignDialog: Boolean
    },

    data: () => ({
        loading: false,
        operator_id: 0,
        operator_signed_path: '',
        remarks: '',        
        status: 1,
        supervisor_signed_path: '',
        valid: true,        
    }),

    computed: {
        title() {
            return "Submit Checklist"             
        },
        subContractorId() {
            return this.$store.getters.inspectionchecklist.sub_contractor_id
        }
    },

    methods: {
        closeFormSigning() {            
            this.$emit('update:inspectionChecklistItemFormSignDialog',false)
        },

        confirm() { 
            //check canvas for empty value                      
            if(this.supervisor_signed_path == '' && this.operator_signed_path == '') {
                this.valid = false;
                this.$store.commit('setSnackbar',{text: 'Both Signatures is Required', visible: true, color: 'error'});         
                setTimeout(() => {                
                    this.$store.commit('closeSnackbar');
                },2000); 
            } else {
                if (this.$refs.saveform.validate()) {
                    //this.loading = true

                    var confirmdata = {
                        'operator_id' : this.operator_id,
                        'operator_signed_path' : this.operator_signed_path,
                        'remarks' : this.remarks,                        
                        'status' : this.status,
                        'supervisor_signed_path' : this.supervisor_signed_path,
                    }
                                        
                    this.$emit('save',confirmdata)
                    this.closeFormSigning()
                }
            }

        }
    }
}
</script>