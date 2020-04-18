<template>
    <v-dialog v-model="deleteRemarkConfirmDialog" max-width="400" scrollable persistent>
    <v-form 
        ref="saveform"
        v-model="valid"
        @submit.prevent="confirm"
        lazy-validation      
    >
    <v-card>        
        <v-card-title class="headline">DELETE this Permit to Work?</v-card-title> 
        <v-card-text> 
            <v-container>
            <v-row>   
                <v-col cols="12">
                    Reference No.: {{ ptw.reference_no }} <br />
                    High-Risk Work: {{ ptw.hrw_name }} <br />
                    Start Date: {{ ptw.start_date }} <br />
                    End Date: {{ ptw.end_date }} <br />
                    Location: {{ ptw.location }} <br />
                    Work to perform: {{ ptw.work_to_be_done }}
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
                color="success darken-1" 
                raised 
                @click="deletePtw"
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
        ptw: { type: Object, 
            default: function () {
                return { 
                    reference_no: "",
                    hrw_name: "",
                    start_date:"",
                    end_date: "",
                    location: "",
                    work_to_be_done: ""
                }
        }},
        deleteRemarkConfirmDialog: Boolean,
    },

    methods : {
        deletePtw() {

            if (this.$refs.saveform.validate()) {

                this.loading = true
                this.$store.dispatch('deletePtw',{id: this.ptw.id, delete_remark: this.delete_remark})
                .then(response => {
                    this.loading = false;
                
                    this.$emit('update:deleteRemarkConfirmDialog',false)
                    
                    setTimeout(() => {                
                        this.$store.commit('closeSnackbar');
                    },2000);           
                }).catch(()=> {this.loading = false });
                
            }

        }

    }
}
</script>