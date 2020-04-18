<template>
    <v-dialog v-model="deleteRemarkConfirmDialog" max-width="400" scrollable persistent>
    <v-form 
        ref="saveform"
        v-model="valid"
        @submit.prevent="confirm"
        lazy-validation      
    >
    <v-card>    
        <v-card-title class="headline">DELETE this Sub-Contractor?</v-card-title> 
        <v-card-text>           
            <v-container>
            <v-row>   
                <v-col cols="12">
                    Id: {{ subcontractor.id }} <br/>
                    Name: {{ subcontractor.name }} <br />
                    Location: {{ subcontractor.location }}
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
                raised 
                color="secondary darken-1" 
                dark 
                @click="close"
            >No</v-btn>
            <v-spacer></v-spacer>          
            <v-btn 
                color="error darken-1" 
                raised 
                @click="deleteSubcontractor"
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
        valid: true,
    }),

    props: {
        subcontractor: { type: Object, default: function () {return false}},
        deleteRemarkConfirmDialog: Boolean,
    },

    methods : {
        close() {            
            this.$emit('update:deleteRemarkConfirmDialog',false)
        },

        deleteSubcontractor() {

            if (this.$refs.saveform.validate()) {

                this.loading = true
                this.$store.dispatch('deleteSubContractor',{id: this.subcontractor.id, delete_remark: this.delete_remark})
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