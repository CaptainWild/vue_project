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
                <v-col cols="12" md="6" sm="6">
                    <v-text-field 
                        required  
                        clearable
                        v-model="equip.name"
                        label="*Equipment Type"
                        type="text"
                        :rules="[v => !!v || 'Equipment Type is required']"                             
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="6" sm="6">
                    <v-text-field 
                        required  
                        clearable
                        v-model="equip.vrn"
                        label="*Vehicle Registration No."
                        type="text"
                        :rules="[v => !!v || 'Vehicle Registration No. is required']"                             
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="6" sm="6">
                    <SubContractorPulldown
                            v-model="equip.sub_contractor_id"
                    ></SubContractorPulldown> 
                </v-col>      
                 <v-col cols="12" md="6" sm="6">
                    <v-select                                            
                        :items="equipCategoryList"
                        label="Equipment Category"
                        item-value="id"
                        item-text="name"
                        clearable
                        v-model="equip.equip_category_id"
                    ></v-select>
                </v-col>   
                <v-col cols="12" md="6" sm="6">
                    <v-text-field 
                        required  
                        clearable
                        v-model="equip.lm_no"
                        label="LM No. / Serial No."
                        type="text"
                    ></v-text-field>
                </v-col>
                <v-col cols="12"  md="6" sm="6">                
                     <v-select                                            
                        :items="equipStatusList"
                        label="Equipment Status"
                        item-value="id"
                        item-text="name"
                        clearable
                        v-model="equip.equip_status_id"
                    ></v-select>
                </v-col>
                <v-col cols="12"  md="4">                
                     <v-text-field 
                        required  
                        clearable
                        v-model="equip.brand"
                        label="Brand"
                        type="text"
                    ></v-text-field>
                </v-col>
                <v-col cols="12"  md="4">                
                     <v-text-field 
                        required  
                        clearable
                        v-model="equip.model"
                        label="Model"
                        type="text"
                    ></v-text-field>
                </v-col>
                <v-col cols="12"  md="4">                
                     <v-text-field 
                        required  
                        clearable
                        v-model="equip.capacity"
                        label="Capacity"
                        type="text"
                    ></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-textarea 
                        auto-grow 
                        clearable 
                        v-model="equip.description" 
                        label="Description">
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
import Form from '@/js/core/form';
import SubContractorPulldown from '@/js/views/subcontractors/pulldown';

export default {
    components: {
        SubContractorPulldown
    },
    props: {
        equipFormDialog : Boolean,         
    },

    data: () => ({
        equip: {},
        loading: false,
        valid: true
    }),

    computed: {
        formTitle () {
            return this.equip.id == undefined ? 'New Equipment' : 'Edit Equipment (#'+this.equip.id+')'
        }, 
        equipStatusList () {
            return this.$store.getters.equipstatuses
        }, 
        equipCategoryList () {
            return this.$store.getters.equipcategories
        },  
    },

    created () {
        this.equip = Object.assign({},this.$store.getters.equip)
        this.$store.dispatch('fetchEquipCategories')
        this.$store.dispatch('fetchEquipStatuses')
    },

    methods: {
        resetForm() {
            this.$store.commit('RESET_EQUIP')
            this.$emit('update:equipFormDialog',false)            
        },

        save() {
            if(this.$refs.form.validate()) {
                var action = "createEquip";                
                if(this.equip.id != undefined) {
                    action = "updateEquip";                   
                    this.equip._method = 'PATCH';
                }

                this.loading = true

                this.$store.dispatch(action,this.equip)
                    .then(response => {
  
                        this.loading = false                          
                        this.resetForm()
                        this.$emit('refresh')
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