<template>
    <v-dialog v-model="inspectionChecklistItemDialog" max-width="1000" persistent scrollable>
        <v-card>
        <v-card-title>{{inspectionchecklist.checklist.name }} (#{{inspectionchecklistitem.id}})</v-card-title>
        <v-card-subtitle class="ml-2 pt-2">
            <v-row>
                <v-col cols="12" sm="2">
                    <v-text-field
                        :value="inspectionchecklistitem.inspection_date"
                        label="Inspection Date"
                        readonly
                        dense
                    ></v-text-field>
                </v-col>             
                  <v-col cols="12" sm="5">
                    <v-text-field
                        :value="inspectionchecklist.location"
                        label="Area"
                        readonly
                        dense
                    ></v-text-field>
                </v-col>
                  <v-col cols="12" sm="5">
                    <v-text-field
                    :value="inspectionchecklist.work_to_be_done"
                    label="Work to be done"
                    readonly
                    dense
                    ></v-text-field>
                </v-col>
            </v-row>         
        </v-card-subtitle>
        
        <v-card-text>
            <v-data-table
                :headers="headers"
                :items="checklistItemsList"
                :loading="tableLoader"
                class="elevation-1"
                group-by="sub_header"
                sort-by="seq_no"   
                :sort-desc="false"
                v-model="selected"
                disable-pagination
                hide-default-footer
            >

                <template v-slot:group.header="{ group, headers }"> 
                    <td :colspan="headers.length"> 
                        <span style="font-weight:bold;"> {{ group.toUpperCase() }} </span> 
                    </td> 
                </template>

                <template v-slot:item.legend_id="{ item }">
                    <div class='pt-5 mt-2 pl-5 pb-5'>
                    <v-select
                        :items="legendList"
                        v-model="legend_ids[item.id]"
                        placeholder="select..."                               
                        clearable
                        item-text="name"
                        item-value="id"
                        dense
                    ></v-select>
                    </div>
                </template>

                <template v-slot:item.remarks="{ item }"> 
                    <div class='pt-5 mt-2 pl-5'>
                    <v-textarea
                        clearable
                        dense
                        rows="2"
                        v-model="remarks[item.id]"
                        placeholder="remarks here..."     
                        no-resize  
                                    
                        ></v-textarea>
                    </div>
                </template>

            </v-data-table>
        </v-card-text>
        <v-card-actions>
           
            <v-btn 
                color="secondary" 
                raised 
                @click="closeDialog"
            >
            Close
            </v-btn>
            <v-spacer></v-spacer>
             <v-btn 
                raised 
                color="warning darken-1" 
                dark 
                @click="incomplete"
                :loading="loading"
            >Save</v-btn>
            <v-btn 
                raised 
                color="success darken-1" 
                dark 
                :loading="loading"
                @click="formSubmit"
            >Submit</v-btn>
        </v-card-actions>
        <ConfirmationForm
            v-if="inspectionChecklistItemFormSignDialog"
            :inspectionChecklistItemFormSignDialog.sync = "inspectionChecklistItemFormSignDialog"
            :supervisor_only = "inspectionchecklist.supervisor_only"
            @save="save"
        ></ConfirmationForm>
    </v-card>
    </v-dialog>
</template>

<script>
import ConfirmationForm from '@/js/views/inspectionchecklistitems/formSigningDialog';
 
export default {
    components: {
        ConfirmationForm
    },
    data () {
        return {
            checklistitems: {},            
            headers: [                
                { text: 'Description', value: 'description', align: 'left',sortable: false, filterable: false, },               
                { text: 'Sub-Header', value: 'sub_header' },
                { text: 'Status', value: 'legend_id', align: 'right',sortable: false, filterable: false, width:200},
                { text: 'Remarks', value: 'remarks' , align: 'right', sortable: false, filterable: false},
                { text: '', value: 'action', sortable: false, filterable: false },
            ],
            inspectionchecklist: {},
            inspectionchecklistitem: {},
            inspectionChecklistItemFormSignDialog: false,
            inspectionchecklistitemresult: {},
            legend_ids: {},
            loading: false,
            remarks: {},
            selected: [],
            status: 2, //incomplete
            tableLoader:false,
        }
     },
    props: {
        inspectionChecklistItemDialog: Boolean
    },
    computed: {   
        checklistItemsList () {  
          this.checklistitems = this.$store.getters.inspectionchecklist.checklist.items;
          return this.checklistitems;          
        },  
        legendList() {
            return this.$store.getters.inspectionchecklist.checklist.legends
        }        
    },
  
    created() {        
        this.inspectionchecklist = this.$store.getters.inspectionchecklist;
        this.inspectionchecklistitem = this.$store.getters.inspectionchecklistitem
        if(this.inspectionchecklistitem.inspectionchecklistitemresults.length > 0 ){
            this.setChecklistValues()
        }
    },
    methods: {        
        closeDialog() {
            this.$emit('update:inspectionChecklistItemDialog',false)
            this.$emit('refresh')
            this.$store.commit('RESET_INSPECTION_CHECKLIST_ITEM')
        },
        formSubmit() {
            this.inspectionChecklistItemFormSignDialog = true
        },
        incomplete() {
            this.loading = true            
            this.inspectionchecklistitemresult.inspection_checklist_item_status_id = 2 // incomplete
            
            this.save()
        },
        save(confirm_data) {
            this.loading = true
            
            var action = 'createInspectionChecklistItemResult';

            if(this.inspectionchecklistitem.inspectionchecklistitemresults.length > 0 ){
                action  = 'updateInspectionChecklistItemResult'                
                this.inspectionchecklistitemresult._method = 'PATCH';
            }

            //inspection checklist items tbl            
            if(confirm_data != undefined) {
                this.inspectionchecklistitemresult.inspection_checklist_item_status_id = confirm_data.status
                this.inspectionchecklistitemresult.operator_signed_path = confirm_data.operator_signed_path
                this.inspectionchecklistitemresult.operator_id = confirm_data.operator_id
                this.inspectionchecklistitemresult.remark = confirm_data.remarks
                this.inspectionchecklistitemresult.supervisor_signed_path = confirm_data.supervisor_signed_path
            }
            
            //inspection checklist item results tbl
            this.inspectionchecklistitemresult.inspection_checklist_item_id= this.inspectionchecklistitem.id
            this.inspectionchecklistitemresult.checklist_item_ids          = JSON.stringify(this.inspectionchecklist.checklist.items)
            this.inspectionchecklistitemresult.legend_ids                  = JSON.stringify(this.legend_ids)
            this.inspectionchecklistitemresult.remarks                     = JSON.stringify(this.remarks)

            this.$store.dispatch(action,this.inspectionchecklistitemresult)
                .then(response => {
                    this.loading = false
                    
                    this.closeDialog()
                    setTimeout(() => {                
                        this.$store.commit('closeSnackbar');
                        
                    },2000);   
                }).catch(error=> {
                    this.loading = false 
                    console.log(error);
                });  
        },
        setChecklistValues() {
            var results = this.inspectionchecklistitem.inspectionchecklistitemresults

            for(var result of results) {
                
                if(!this.legend_ids.hasOwnProperty(result.checklist_item_id)){
                    this.legend_ids[result.checklist_item_id] = result.legend_id
                }
                
                if(!this.remarks.hasOwnProperty(result.checklist_item_id)){
                    this.remarks[result.checklist_item_id] = result.remarks
                }
            }
        },
    }
}
</script>