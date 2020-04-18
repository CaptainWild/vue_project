<template>
    <v-dialog v-model="deleteRemarkConfirmDialog" max-width="440" scrollable persistent>
    <v-form 
        ref="saveform"
        v-model="valid"
        @submit.prevent="confirm"
        lazy-validation      
    >
    <v-card>     
        <v-card-title class="headline">DELETE this Safe Work Procedure?</v-card-title> 
        <v-card-text>            
            <v-container>
            <v-row>   
                <v-col cols="12">
                    Activity: {{ swp.activity }} <br />
                    Reference No.: {{ swp.ref_no }} <br />
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
                @click="deleteSwp"
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
        swp: { type: Object, default: function () {return {activity: "",ref_no:""}}},
        deleteRemarkConfirmDialog: Boolean,
    },
  
    methods : {
        deleteSwp() {

            if (this.$refs.saveform.validate()) {

                this.loading = true
                this.$store.dispatch('deleteSwp',{id: this.swp.id, delete_remark: this.delete_remark})
                .then(response => {
                    this.loading = false            
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