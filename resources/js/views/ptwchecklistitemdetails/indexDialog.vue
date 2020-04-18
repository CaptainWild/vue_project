<template>
   <v-dialog v-model="ptwChecklistItemDialog"  max-width="900px" persistent scrollable>    
      <v-card>        
        <v-card-title>
            <span class="headline">PTW Checklist: {{ ptw.hrw.name }} (#{{ptwchecklistitem.id}})</span>
            <v-spacer></v-spacer>
            Date: {{new Date(ptwchecklistitem.checklist_date).toLocaleDateString()}}
        </v-card-title>
     
        <v-card-text>                     
            <HrwChecklist
                v-model="ptw.hrw_id"
                :hrwChecklistIds.sync="hrwChecklistIds"
            ></HrwChecklist>
        </v-card-text>
        <v-card-actions>
           <v-btn 
                color="secondary" 
                raised 
                @click="closeDialog"
            >
            Close
            </v-btn>
            <v-spacer></v-spacer>
             <v-btn 
                raised 
                color="warning darken-1" 
                dark 
                @click="incomplete"
                :loading="loading"
            >Save</v-btn>
            <v-btn 
                raised 
                color="success darken-1" 
                dark 
                :loading="loading"
                @click="formSubmit"
            >Submit</v-btn>
        </v-card-actions>
         <ConfirmationForm
            v-if="ptwChecklistItemFormSignDialog"
            :ptwChecklistItemFormSignDialog.sync = "ptwChecklistItemFormSignDialog"
            @save="save"
        ></ConfirmationForm>
      </v-card>      
    </v-dialog>
</template>

<script>
import ConfirmationForm from '@/js/views/ptwchecklistitemdetails/formSigningDialog';
import HrwChecklist from '@/js/views/hrws/checklistDataTable';
export default {
    components: {        
        ConfirmationForm,        
        HrwChecklist,
    },
    props: {
        ptwChecklistItemDialog : Boolean,         
    },
    data: () => ({  
        hrwChecklistIds: [],
        loading: false, 
        ptw: {},
        ptwchecklistitem: {},
        ptwchecklistitemdetail: {},
        ptwChecklistItemFormSignDialog: false,
    }),
    created () {
        this.ptw = Object.assign({}, this.$store.getters.ptwChecklistItem.ptw)
        this.ptwchecklistitem = Object.assign({}, this.$store.getters.ptwChecklistItem)
    },
    methods: {
        closeDialog() {
            this.$emit('update:ptwChecklistItemDialog',false)
            this.$emit('refresh')
            this.$store.commit('RESET_PTW_CHECKLIST_ITEM')
        },
         formSubmit() {
            this.ptwChecklistItemFormSignDialog = true
        },
        incomplete() {
            this.loading = true            
            this.ptwchecklistitem.ptw_checklist_status_id = 2 // incomplete
            
            this.save()
        },
        save(confirm_data) {
            this.loading = true
            
            this.ptwchecklistitem._method = 'PATCH';
            
            if(confirm_data != undefined) {
                this.ptwchecklistitem.ptw_checklist_status_id = confirm_data.status
                this.ptwchecklistitem.remarks = confirm_data.remarks
                this.ptwchecklistitem.supervisor_signed_path = confirm_data.supervisor_signed_path
            }
            
            this.ptwchecklistitem.hrw_checklist_ids = JSON.stringify(this.hrwChecklistIds)
            
            this.$store.dispatch('updatePtwChecklistItem',this.ptwchecklistitem)
                .then(response => {
                    this.loading = false
                    
                    this.closeDialog()
                    setTimeout(() => {                
                        this.$store.commit('closeSnackbar');
                        
                    },2000);   
                }).catch(error=> {
                    this.loading = false 
                    console.log(error);
                });  
        },       
    }
}
</script>

<style>

</style>