<template>
    <v-dialog v-model="checklistNoActivityDialog" max-width="400" scrollable persistent>
    <v-form 
        ref="updateform"
        v-model="valid"
        @submit.prevent="noactivity"
        lazy-validation      
    >
    <v-card>
        <v-card-title>
            <span class="headline">{{title}} (#{{ptwChecklistItem.id}})</span>
        </v-card-title>
        <v-card-subtitle> Inspection Date: {{new Date(ptwChecklistItem.checklist_date).toLocaleDateString()}}</v-card-subtitle>
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
        checklistNoActivityDialog: Boolean,
    },

    data: () => ({  
        loading: false,
        remarks: '',
        valid: true,
    }),
     
    computed : {
        title () {
          return 'Mark as NO ACTIVITY'
        },       
        ptwChecklistItem() {
            return this.$store.getters.ptwChecklistItem
        }
    },

    methods : {
        closeFormSigning() {               
            this.$emit('refresh')         
            this.$emit('update:checklistNoActivityDialog',false)
            this.$store.commit('RESET_INSPECTION_CHECKLIST_ITEM')
        },

        noactivity() {           
           this.$store.dispatch('noactPtwChecklistItem',
                { id : this.ptwChecklistItem.id,
                    remarks : this.remarks
           }).then( () => {
               this.closeFormSigning()
                setTimeout(() => {                
                    this.$store.commit('closeSnackbar');
                },2000);    
           })
                
        }
    }
}
</script>

<style>

</style>