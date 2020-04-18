<template>
    <v-dialog v-model="deleteRemarkConfirmDialog" max-width="400" scrollable persistent>
    <v-form 
        ref="saveform"
        v-model="valid"
        @submit.prevent="confirm"
        lazy-validation      
    >
    <v-card>
        <v-card-title class="headline">DELETE this Checklist?</v-card-title> 

        <v-card-text> 
            <v-container>
            <v-row>   
                <v-col cols = "12"> 
                    Id: {{ checklist.id }} <br />
                    Name: {{ checklist.name }} <br />
                    Description: {{ checklist.description }}
                </v-col>                
                <v-col cols="12">
                    <v-textarea 
                        auto-grow 
                        clearable 
                        outlined
                        :rules="[v => !!v || 'This field is required']"
                        v-model="delete_remark" 
                        label="*Delete Remarks"> 
                    </v-textarea>
                </v-col>                
            </v-row>
            </v-container>
        </v-card-text>

        <v-card-actions>
             <v-btn 
                color="secondary darken-1" 
                raised 
                @click = "close"
            >No</v-btn>
            <v-spacer></v-spacer>
            <v-btn 
                color="error darken-1" 
                raised 
                @click="deleteChecklist"
                :loading="loading"
            >Yes</v-btn>
        </v-card-actions>
    </v-card>
    </v-form>
    </v-dialog>
</template>

<script>
export default {
    data: () => ({  
        loading: false,
        delete_remark: '',
        checklist: {},
        valid: true,
    }),

    props: {
        deleteRemarkConfirmDialog: Boolean,
    },
     
    created () {
         this.checklist = Object.assign({},this.$store.getters.checklist);
    },

    methods : {
        close() {
            this.$store.commit('RESET_CHECKLIST')            
            this.$emit('update:deleteRemarkConfirmDialog',false)
        },

        deleteChecklist() {

            if (this.$refs.saveform.validate()) {

                this.loading = true
                this.$store.dispatch('deleteChecklist',{id: this.checklist.id, delete_remark: this.delete_remark})
                .then(response => {
                    this.loading = false;
                    this.close()
                    
                    setTimeout(() => {                
                        this.$store.commit('closeSnackbar');
                    },2000);           
                }).catch(()=> {this.loading = false });

            }

        }
        
    }
}
</script>