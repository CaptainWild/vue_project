<template>
    <v-dialog v-model="dialogDetails" max-width="1100px" persistent scrollable>
    <v-form 
        ref="form"
        v-model="valid"                
        lazy-validation
        @submit.prevent="saveDetail"         
    >   
    <v-card>    
        <v-card-title>
            <span class="headline">Inspection Details (#{{ inspection.id }}) - {{inspection.status}}</span>
        </v-card-title>       
        <v-card-text>
            <v-container>
                <v-row>
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-if="inspection.project"
                            type="text"
                            disabled                            
                            v-model="inspection.project.title" 
                            label="Project">
                        </v-text-field>
                    </v-col>
                    <v-col cols="12" md="2">
                        <v-text-field
                            type="text"
                            disabled
                            v-model="inspection.inspection_date" 
                            label="Inspection Date">
                        </v-text-field>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field
                            type="text"
                            disabled
                            v-model="inspection.location" 
                            label="Location">
                        </v-text-field>
                    </v-col>
                    <v-col cols="12" v-if="$can.permit('inspection_edit') && inspection.status != 'Closed'"> 
                    <v-card>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12" md="6" sm="6">
                                    <SubContractorPullDown                    
                                        v-model="inspection_detail.sub_contractor_id"
                                        :projectId='inspection.project_id'
                                    ></SubContractorPullDown>
                                </v-col>
                                <v-col cols="12" md="2">
                                    <v-text-field 
                                        clearable
                                        v-model="inspection_detail.block"
                                        label="Block"
                                        type="text"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" md="2">
                                    <v-text-field 
                                        clearable
                                        v-model="inspection_detail.storey"
                                        label="Storey"
                                        type="text"
                                    ></v-text-field>
                                </v-col>  
                                <v-col cols="12" md="2">
                                    <v-text-field 
                                        clearable
                                        v-model="inspection_detail.unit"
                                        label="Unit"
                                        type="text"
                                    ></v-text-field>
                                </v-col>                                
                                <v-col cols="12" md="3">
                                    <v-select                                            
                                        :items="inspectionTypesComputed"
                                        label="*Inspection Type"
                                        item-value="id"
                                        item-text="name"
                                        clearable
                                        :rules="[v => !!v || 'This field is required']"
                                        required
                                        v-model="inspection_detail.inspection_type_id"
                                    ></v-select>
                                </v-col> 
                                <v-col cols="12" md="3">
                                    <v-select                                            
                                        :items="inspectionTypeItemsComputed"
                                        label="*Inspection Type Item"
                                        item-value="id"
                                        item-text="description"
                                        clearable
                                        :rules="[v => !!v || 'This field is required']"
                                        required
                                        v-model="inspection_detail.inspection_type_item_id"
                                    ></v-select>
                                </v-col> 
                                <v-col cols="12" md="3">
                                    <v-select                                            
                                        :items="siteObservationComputed"
                                        label="*Site Observation"
                                        item-value="id"
                                        item-text="name"
                                        clearable
                                        :rules="[v => !!v || 'This field is required']"
                                        required
                                        v-model="inspection_detail.site_observation_id"
                                    ></v-select>
                                </v-col> 
                                <v-col cols="12" md="3">
                                    <v-select                                            
                                        :items="hazardCategoryComputed"
                                        item-value="id"
                                        item-text="name"
                                        label="*Hazards Category"
                                        clearable
                                        :rules="[v => !!v || 'This field is required']"
                                        required
                                        v-model="inspection_detail.hazard_category_id"
                                    ></v-select>
                                </v-col>                       
                                <v-col cols="12" md="2">
                                    <v-select                                          
                                        :items="responseList"
                                        label="Response Time"
                                        clearable
                                        v-model="inspection_detail.response"
                                    ></v-select>
                                </v-col>   
                                <v-col cols="12" md="2">                                    
                                    <v-select      
                                        :items="severityLevelList"
                                        label="Severity Level"
                                        clearable
                                        v-model="inspection_detail.severity_level"
                                    ></v-select>
                                </v-col>  
                                <v-col cols="12" md="4">
                                    <v-file-input                
                                        v-model="photo"
                                        outlined
                                        prepend-icon="mdi-camera"                   
                                        placeholder="Photo"
                                        :show-size="1000"
                                        accept="image/*"  
                                        small-chips
                                    >               
                                    </v-file-input>
                                </v-col>
                                <v-col cols="12" md="4">
                                    <v-textarea
                                        auto-grow
                                        no-resize
                                        clearable
                                        v-model="inspection_detail.photo_remarks"
                                        placeholder="Remarks"                         
                                        outlined            
                                    ></v-textarea>
                                </v-col>                              
                            </v-row>
                        </v-card-text>
                    </v-card>
                    </v-col>
                    <v-col cols="12" v-show="$can.permit('inspection_view')">
                        <DetailsDataTable
                        :inspectionId = "inspectionId"
                        ></DetailsDataTable>
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
        >Close</v-btn>
        <v-spacer></v-spacer>                        
        <v-btn 
            v-if="$can.permit('inspection_edit') && inspection.status != 'Closed'"
            raised 
            color="success darken-1" 
            dark 
            :loading="loading"
            type="submit"
        >Add & Clear Form</v-btn>
    </v-card-actions>      
    </v-card>
    </v-form>
    </v-dialog>
</template>

<script>
import DetailsDataTable from '@/js/views/inspections/detailsDataTable';
import SubContractorPullDown from '@/js/views/project_subcontractors/subContractorPulldown';

export default {
    components: {
        DetailsDataTable,       
        SubContractorPullDown,
    },
    props: [
        'inspectionId',
        'dialogDetails',
    ],
    data () {
        return {
            inspection: {},
            inspection_detail: {},            
            loading: false,
            photo: [],
            responseList: ['NA','Immediate','7 Days'],
            severityLevelList: ['NA','High','Medium','Low'],
            valid: true
        }
    },
    computed: {
        inspectionDetailsComputed () {
            return []
        }, 
        inspectionTypesComputed () {
            return this.$store.getters.inspectiontypes
        },
        inspectionTypeItemsComputed () {
            return this.$store.getters.inspectiontypeitems
        },
        siteObservationComputed() {
            return this.$store.getters.siteobservations
        },
        hazardCategoryComputed() {
            return this.$store.getters.hazardcategories
        }
    },
      
    watch: {
        "inspection_detail.inspection_type_id": {
            immediate: true,
            handler(newVal,oldVal) {
                if(newVal != oldVal && newVal != undefined) {
                    this.getInspectionItems(newVal)
                }
            }     
        },
    },
  
    created() {     
        this.initialize()
        this.initializeDetails()

        this.inspection_detail.severity_level = 'NA'
        this.inspection_detail.response = 'NA'

        this.$store.dispatch('fetchInspectionTypes')
        this.$store.dispatch('fetchSiteObservations')
        this.$store.dispatch('fetchHazardCategories')
        
    },
    methods: {       
        resetForm() {
            this.inspection_detail = {}
            this.inspection_detail.severity_level = 'NA'
            this.inspection_detail.response = 'NA'
        },
        
        initialize() {
            this.$store.dispatch('fetchInspection',{ id:this.inspectionId })
                .then(() => {
                    this.inspection = Object.assign({},this.$store.getters.inspection)       
                })
        },

        getInspectionItems(inspectionTypeId) {
            this.$store.dispatch('fetchInspectionItemsByType',{inspection_type_id: inspectionTypeId})
        },

        initializeDetails() {
            this.$store.dispatch('fetchInspectionItemsByInspectionId',{inspection_id: this.inspectionId})
        },
       
       close() {
           this.$emit('update:dialogDetails',false)
           this.$emit('close')
       },

       saveDetail() {          
            if(this.$refs.form.validate()) {
                this.loading = true
                let inspectionDetailForm = new FormData();

                var action = "createInspectionDetail"            
                if(this.inspection_detail.id != undefined) {
                    action = "updateInspectionDetail";
                    inspectionDetailForm.append('id', this.inspection_detail.id);                   
                    inspectionDetailForm.append('_method', 'PATCH');
                }

                inspectionDetailForm.append('inspection_id',this.inspection.id);
            
                inspectionDetailForm.append('sub_contractor_id',this.inspection_detail.sub_contractor_id);                        
                inspectionDetailForm.append('block',this.inspection_detail.block);
                inspectionDetailForm.append('storey',this.inspection_detail.storey);            
                inspectionDetailForm.append('unit',this.inspection_detail.unit);

                inspectionDetailForm.append('inspection_type_id',this.inspection_detail.inspection_type_id); 
                inspectionDetailForm.append('inspection_type_item_id',this.inspection_detail.inspection_type_item_id); 
                inspectionDetailForm.append('site_observation_id',this.inspection_detail.site_observation_id); 
                inspectionDetailForm.append('hazard_category_id',this.inspection_detail.hazard_category_id);
                                        
                inspectionDetailForm.append('response',this.inspection_detail.response);
                inspectionDetailForm.append('severity_level',this.inspection_detail.severity_level);
                inspectionDetailForm.append('photo',this.photo);
                inspectionDetailForm.append('photo_remarks',this.inspection_detail.photo_remarks);
                
                this.$store.dispatch(action, inspectionDetailForm)
                    .then(response => {   
                    this.loading = false                          
                    this.resetForm()
                    this.photo = []
                    this.initializeDetails()
                        
                    setTimeout(() => {                
                        this.$store.commit('closeSnackbar');
                    },2000);              
                })
                .catch(error=> {
                    this.loading = false 
                    console.log(error);
                });  
            }
       }
    }
}
</script>