<template>
    <v-dialog v-model="deleteRemarkConfirmDialog" max-width="400" scrollable persistent>
    <v-form 
        ref="saveform"
        v-model="valid"
        @submit.prevent="confirm"
        lazy-validation      
    >
    <v-card>
        <v-card-title class="headline">DELETE this Role?</v-card-title> 
        <v-card-text>           
            <v-container>                
            <v-row>   
                <v-col cols="12">
                    Id: {{role.id}} <br/>
                    Name: {{role.name}} <br />
                    Description: {{role.description}} <br />
                </v-col>
                <v-col cols="12">
                    <v-textarea 
                        auto-grow 
                        clearable 
                        :rules="[v => !!v || 'This field is required']"
                        v-model="delete_remark" 
                        rows="1"
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
                @click="deleteRole"
                :loading="loading"
            >Yes</v-btn>
        </v-card-actions>
    </v-card>
    </v-form>
    </v-dialog>
</template>

<script>
export default {
    props : {
        deleteRemarkConfirmDialog: Boolean,
        role: { type: Object, default: function () {return false}},
    },

    data: () => ({  
        loading: false,
        delete_remark: '',
        valid: true,
    }),
     
    methods : {
        close() { 
            this.$emit('update:deleteRemarkConfirmDialog',false)
        },

        deleteRole() {

            if (this.$refs.saveform.validate()) {

                this.loading = true
                this.$store.dispatch('deleteRole',{id: this.role.id, delete_remark: this.delete_remark})
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