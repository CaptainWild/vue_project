<template>
    <v-dialog v-model="deleteRemarkConfirmDialog" max-width="400" scrollable persistent>
    <v-form 
        ref="saveform"
        v-model="valid"
        @submit.prevent="confirm"
        lazy-validation      
    >
    <v-card>
        <v-card-title class="headline">DELETE this Equipment?</v-card-title> 
        <v-card-text> 
            <v-container>
            <v-row>   
                <v-col cols="12">
                    Id: {{ equip.id }} <br />
                    Equipment Name.: {{ equip.name }} <br />
                    Vehicle Registration No.: {{ equip.vrn }} <br />
                    LM No. / Serial No.: {{ equip.lm_no }} <br />
                    Model: {{ equip.model }}
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
                @click="deleteEquip"
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
        deleteRemarkConfirmDialog: Boolean,
    },

    computed: {
        equip() {
            return this.$store.getters.equip
        },      
    },

    methods : {
        close() {    
            this.$store.commit('RESET_EQUIP')        
            this.$emit('update:deleteRemarkConfirmDialog',false)
        },

        deleteEquip() {

            if (this.$refs.saveform.validate()) {

                this.loading = true
                this.$store.dispatch('deleteEquip',{id: this.equip.id, delete_remark: this.delete_remark})
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