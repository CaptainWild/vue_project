<template>
    <v-dialog v-model="deleteRemarkConfirmDialog" max-width="400" scrollable persistent>
    <v-form 
        ref="saveform"
        v-model="valid"
        @submit.prevent="confirm"
        lazy-validation      
    >
    <v-card>
        <v-card-title class="headline">DELETE this User?</v-card-title> 
        <v-card-text> 
            <v-container>
            <v-row>   
                <v-col cols="12">
                    Id: {{user.id}} <br />
                    Name: {{user.name}} <br />
                    E-mail: {{user.email}} <br />
                    Mobile No: {{user.mobile_no}}
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
                @click="deleteUser"
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
        user: { type: Object, default: function () {return false}},
        deleteRemarkConfirmDialog: Boolean,
    },
     
    methods : {
        close() {            
            this.$emit('update:deleteRemarkConfirmDialog',false)
        },

        deleteUser() {

            if (this.$refs.saveform.validate()) {
                
                this.loading = true
                this.$store.dispatch('deleteUser',{id: this.user.id, delete_remark: this.delete_remark})
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

<style>

</style>