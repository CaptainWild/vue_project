<template>
  
    <v-dialog v-model="ptwFormSignDialog" max-width="450" scrollable persistent>
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
         <v-card-subtitle><span class="primary--text">{{subtitle}}</span></v-card-subtitle>
        <v-card-text>
            <v-container>
            <v-row>
                <v-col cols="12">
                    <SummaryCard
                        :summarized = "summarized"
                    >
                    </SummaryCard>
                </v-col>                      
                <v-col cols="12">
                    <v-textarea 
                        auto-grow 
                        clearable 
                        v-model="remarks" 
                        outlined
                        dense
                        no-resize
                        label="Remarks">
                    </v-textarea>
                </v-col>
                <v-col v-if="!successStatuses.includes(ptw_status_id)" cols="12">
                   <v-select
                        outlined
                        dense
                        :items="forwardToList"
                        :loading="loading"
                        :rules="[v => !!v || 'This field is required']"
                        v-model="signatory_id" 
                        label="*Forward To"
                        item-text="name"
                        item-value="id"
                        clearable
                        required 
                    ></v-select>
                </v-col>
                <v-col cols="12">
                   <DrawingPad
                    v-model="signed_path"
                    :height='200'
                    :width="442"
                    ref='drawingPad'
                   ></DrawingPad>                  
                </v-col>
            </v-row>
            </v-container>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn 
                raised 
                color="secondary darken-1" 
                dark 
                @click="closeFormSigning"
            >Cancel</v-btn>
            <v-btn 
                raised 
                color="success darken-1" 
                dark 
                :loading="loading"
                type="submit"
            >{{title}}</v-btn>
        </v-card-actions>
    </v-card>
    </v-form>
    </v-dialog>
</template>

<script>
import DrawingPad from '@/js/components/DrawingPad';
import SummaryCard from '@/js/views/ptws/viewSummary';

export default {
    components: {
        DrawingPad,
        SummaryCard
    },
    
    props : {
        draft: {type: Boolean, default: false},
        hrw_checklist_ids: { type: Array, default: () => [] },
        isVerifier : {type: Boolean, default: false},                
        ptwFormSignDialog: Boolean,
        ptwId: {type: Number, default: 0},
        ptw_status_id: Number,        
        resubmission: {type: Boolean, default: false},
        signatoryId: {type: Number, default: 0},
        summarized: Object,        
    },

    mounted() {
        
        this.forwardTo()
        this.summary = Object.assign({}, this.summarized)
        this.signatory_id = this.signatoryId
    },

    data: () => ({  
        loading: false,
        remarks: '',
        successStatuses: [1,4,12],
        signatory_id: 0,
        signed_path: '',
        valid: true,
        summary: {}        
    }),

    computed: {
        user(){
            return this.$store.getters.getProfile;
        },
        forwardToList () {
            // (6) endorse //submission to safety officer / assessor
            if(this.ptw_status_id == 6) {
                return this.$store.getters.mainConManagers
            } else {
                return this.$store.getters.mainConAssessors
            }
        },
        
        subtitle() {
            if(this.ptw_status_id == 8 && this.ptwId == 0) { //pending                
                return "You have checked "+ this.hrw_checklist_ids.length +" items in the checklist"
            }        
        },

        title() {

            if(this.ptw_status_id == 6  || (this.ptw_status_id == 8 && !this.isVerifier && !this.draft && !this.resubmission)){
                return "Endorse Application" 
            }

            if(this.ptw_status_id == 12) {
                return "Resume Permit to Work"
            }

            if(this.ptw_status_id == 1) {
                return "Approve Application"
            }

            if(this.ptw_status_id == 4) {
                return "Works Completion"
            }

            if(this.ptw_status_id == 8 && this.isVerifier) {
                return 'Verify Application'
            }
            
            return "Confirm Application"

        },

    },

    methods: {
        forwardTo() {
            var action = 'fetchMainContractorSafetyAssessors' //default is the assessor for now
            if(this.ptw_status_id == 6 || (this.ptw_status_id == 8 && !this.isVerifier && !this.draft && !this.resubmission)) { // endorsed
                action = 'fetchMainContractorAuthorizedManagers' // gets all the authorized managers (PM)
            }

            this.$store.dispatch(action)
            .catch(error=> {
                this.loading = false 
                console.log(error);
            });
        },

        closeFormSigning() {            
            //this.$refs.drawingPad.resetCanvas()
            this.$emit('update:ptwFormSignDialog',false)
        },

        confirm() { 
            //check canvas for empty value
            if(this.signed_path == '') {
                this.valid = false;
                this.$store.commit('setSnackbar',{text: 'Signature is Required', visible: true, color: 'error'});         
                setTimeout(() => {
                    this.$store.commit('closeSnackbar');
                },2000); 
            } else if(this.hrw_checklist_ids.length == 0 && this.ptw_status_id == 8 && this.ptwId == 0) {
                this.valid = false;
                this.$store.commit('setSnackbar',{text: 'No item(s) checked in the PTW Checklist.', visible: true, color: 'error'});         
                setTimeout(() => {
                    this.$store.commit('closeSnackbar');
                },2000); 
            } else {
                if (this.$refs.saveform.validate()) {

                    var confirmdata = {
                        'ptw_status_id': this.ptw_status_id,
                        'remarks'   : this.remarks,
                        'signatory_id': this.signatory_id,
                        'signed_path' : this.signed_path,
                    }
                    
                    this.$emit('save',confirmdata)
                    this.closeFormSigning()
                }
            }

        }
    }
}
</script>