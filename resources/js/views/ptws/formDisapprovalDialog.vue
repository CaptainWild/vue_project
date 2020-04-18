<template>
    <v-dialog v-model="ptwFormDisapprovalDialog" max-width="400" scrollable persistent>
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
                        :rules="[v => !!v || 'This field is required']"
                        v-model="remarks" 
                        rows="1"
                        label="*Remarks"> 
                    </v-textarea>
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
            >Close</v-btn>
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
export default {
    props : {
        ptwFormDisapprovalDialog: Boolean,
        ptwStatus: Number
    },

    data: () => ({  
        loading: false,
        remarks: '',
        valid: true,
    }),
     
    computed : {
        title () {
            if(this.ptwStatus == 2) {
                return "Cancel Application"
            }else if (this.ptwStatus == 9) {
                return "Reject Application"
            }else if (this.ptwStatus== 11) {
                return "Halt Permit to Work"
            } 
        },
    },

    methods : {
        closeFormSigning() {            
            this.$emit('update:ptwFormDisapprovalDialog',false)
        },

        confirm() {           
            if (this.$refs.saveform.validate()) {
                var confirmdata = {
                    'remarks': this.remarks,
                    'ptw_status_id': this.ptwStatus
                }
                
                this.$emit('save',confirmdata)
                this.closeFormSigning()
            }
        }
    }
}
</script>

<style>

</style>