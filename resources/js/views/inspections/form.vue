<template>
    <v-form 
        ref="form"
        v-model="valid"                
        lazy-validation
        @submit.prevent="save"      
    >
    <v-card>        
        <v-card-title>
            <span class="headline">{{ formTitle }}</span>
        </v-card-title>
        <v-card-text>          
            <v-container>
            <v-row>
                <v-col cols="12">
                    <ProjectPullDown
                        v-model="inspection.project_id"
                        :projectIcon = false
                    ></ProjectPullDown>
                </v-col>                                            
                <v-col cols="12">
                    <DatePicker
                        dateLabel= "*Inspection Date"
                        :dateIcon = false
                        v-model ="inspection.inspection_date"
                        :readonly = false
                    ></DatePicker>
                </v-col>
                <v-col cols="12">
                    <v-textarea
                        auto-grow
                        no-resizing                            
                        clearable 
                        v-model="inspection.location" 
                        label="*Location">
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
                @click="resetForm"
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

</template>

<script>
import DatePicker from '@/js/components/DatePicker';
import ProjectPullDown from '@/js/views/projects/pulldown';

export default {
    components: {
        DatePicker,
        ProjectPullDown,    
    },
    props: {
        inspectionFormDialog : Boolean,         
    },

    data: () => ({      
        inspection: {},
        loading: false,        
        valid: true,        
    }),

    computed: {
        formTitle () {
            return this.inspection.id == undefined ? 'New Inspection' : 'Edit Inspection (#'+this.inspection.id+')'
        },      
    },

    created () {
        this.inspection = Object.assign({},this.$store.getters.inspection)
        
        if(this.inspection.id == undefined) {
            this.inspection.inspection_date = new Date().toISOString().slice(0,10)
        }      
    },

    methods: {
        resetForm() {
            this.$store.commit('RESET_INSPECTION')
            this.$emit('update:inspectionFormDialog',false)            
        },

        save() {
            if(this.$refs.form.validate()) {
                this.loading = true
                
                var action = "createInspection";                
                if(this.inspection.id != undefined) {
                    action = "updateInspection";                   
                    this.inspection._method = 'PATCH';
                }

                this.$store.dispatch(action,this.inspection)
                    .then(response => {   
                        this.loading = false                          
                        this.resetForm()
                        setTimeout(() => {                
                            this.$store.commit('closeSnackbar');
                        },2000);              
                    })
                    .catch(error=> {
                        this.loading = false 
                        console.log(error);
                    });  

            }            
        },
    }
}
</script>