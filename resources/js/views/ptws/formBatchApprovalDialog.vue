<template>
  
    <v-dialog v-model="ptwFormBatchSignDialog" max-width="400" scrollable persistent>
    <v-form 
        ref="saveform"
        v-model="valid"
        @submit.prevent="approve"
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
                   <DrawingPad
                    v-model="signed_path"
                    :height='200'
                    :width="342"
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
                @click="closeFormBatchSigning"
            >Cancel</v-btn>
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

export default {
    components: {
        DrawingPad
    },
    
    props : {        
        ptwFormBatchSignDialog: Boolean,
        ptwIds: Array
    },

    data: () => ({  
        loading: false,
        remarks: '',
        signatory_id: 0,
        signed_path: '',
        valid: true,        
    }),

    computed: {       
        title() { return "Batch Approval PTW" },
    },

    methods: {
      
        closeFormBatchSigning() {            
            //this.$refs.drawingPad.resetCanvas()
            this.$emit('update:ptwFormBatchSignDialog',false)
            this.$emit('refresh')
        },

        approve() { 
            //check canvas for empty value                      
            if(this.signed_path == '') {
                this.valid = false;
                this.$store.commit('setSnackbar',{text: 'Signature is Required', visible: true, color: 'error'});         
                setTimeout(() => {                
                    this.$store.commit('closeSnackbar');
                },2000); 
            } else {
                if (this.$refs.saveform.validate()) {
                    this.loading = true

                    var batchData = {
                        'remarks'   : this.remarks,
                        'signed_path' : this.signed_path,
                        'ptw_status_id': 1, //approve status
                        'ptw_ids'   : JSON.stringify(this.ptwIds)
                    }

                    this.$store.dispatch('batchApprovalPtw',batchData)
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

                    this.closeFormBatchSigning()
                }
            }

        }
    }
}
</script>