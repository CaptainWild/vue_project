<template>
    <v-dialog v-model="deleteRemarkConfirmDialog" max-width="400" scrollable persistent>   
    <v-form 
        ref="saveform"
        v-model="valid"
        @submit.prevent="confirm"
        lazy-validation      
    >
    <v-card>    
        <v-card-title class="headline">DELETE this Worker?</v-card-title> 
        <v-card-text> 
            <v-container>
            <v-row>
                <!-- <v-col cols="12" v-if="ptwworker.id!=null">
                    Id: {{ ptwworker.id }} <br />
                    Name: {{ ptwworker.name }} <br />
                    NRIC / WP No.: {{ ptwworker.emp_no }} <br />
                    Remarks.: {{ ptwworker.remarks }} <br />
                </v-col> -->
                <v-col cols="12">
                    Id: {{ worker.id }} <br />
                    Name: {{ worker.name }} <br />
                    NRIC / WP No.: {{ worker.emp_no }} <br />
                    Sub-Contractor: {{ worker.subcontractor}} <br />
                    Remarks.: {{ worker.remarks }} <br />
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
                @click="$emit('update:deleteRemarkConfirmDialog',false)"
            >No</v-btn>
            <v-spacer></v-spacer>            
            <v-btn 
                color="error darken-1" 
                raised 
                @click="deleteWorker"
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
        worker: { type: Object, default: function () {return {name: "",emp_no:"",subcontractor:"",remarks:"",delete_remark:""}}},
        deleteRemarkConfirmDialog: Boolean,
        deleted: {type: Boolean, default: function () {return false}}
    },

    // computed: {
    //     ptwworker() {
    //         return this.$store.getters.worker
    //     },      
    // },
     
    methods : {
        close() {     
            this.$store.commit('RESET_WORKER')       
            this.$emit('update:deleteRemarkConfirmDialog',false)
        },

        deleteWorker() {

            if (this.$refs.saveform.validate()) {

                this.loading = true
                this.$store.dispatch('deleteWorker',{id: this.worker.id, delete_remark: this.delete_remark})
                .then(response => {
                    this.loading = false;
                    this.close()
                    this.$emit('update:deleted', true)

                    setTimeout(() => {                
                        this.$store.commit('closeSnackbar');
                    },2000);           
                }).catch(()=> {this.loading = false });
            
            }

        }

    }
}
</script>

<style>

</style>