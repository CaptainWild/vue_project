<template>
    <v-dialog v-model="deleteRemarkConfirmDialog" max-width="400" scrollable persistent>
    <v-form 
        ref="saveform"
        v-model="valid"
        @submit.prevent="confirm"
        lazy-validation      
    >
    <v-card>
        <!-- <v-card-title>
            <span class="headline">{{title}}</span>
        </v-card-title> -->

        <v-card-title class="headline">Are you sure you want to delete &nbsp; &nbsp; this Inspection?</v-card-title> 

        <v-card-text> 
            Id: {{inspection.id}} <br/>
            <!-- Project: {{ inspection.project.title }} <br /> -->
            Location: {{ inspection.location }} <br />
            Inspection Date: {{ inspection.inspection_date}}<br />

            <v-container>
            <v-row>   
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
                @click="closeForm"
            >Close</v-btn>
            <v-spacer></v-spacer>          
            <v-btn 
                color="error darken-1" 
                raised 
                @click="deleteInspection"
                :loading="loading"
            >
            Delete
            </v-btn>
        </v-card-actions>

        
    </v-card>
    </v-form>
    </v-dialog>
</template>

<script>
export default {
    props : {
        deleteRemarkConfirmDialog: Boolean,
        ptwStatus: Number
    },

    data: () => ({  
        loading: false,
        delete_remark: '',
        valid: true,
    }),

    props: {
        inspection: { type: Object, default: function () {return false}},
        deleteRemarkConfirmDialog: Boolean,
        deleted: {type: Boolean, default: function () {return false}}
    },
     
    computed : {
        title () {
            
        },
    },

    methods : {
        closeForm() {            
            this.$emit('update:deleteRemarkConfirmDialog',false)
        },

        confirm() {           
            if (this.$refs.saveform.validate()) {
                var confirmdata = {
                    'delete_remark': this.delete_remark,
                }
                
                this.$emit('save',confirmdata)
                this.closeForm()
            }
        },

        deleteInspection() {

            if (this.$refs.saveform.validate()) {

                this.loading = true
                this.$store.dispatch('deleteInspection',{id: this.inspection.id, delete_remark: this.delete_remark})
                .then(response => {
                    this.loading = false;
                
                    console.log(this.delete_remark);

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

<style>

</style>