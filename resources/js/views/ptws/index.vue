<template>
<div>
    <v-card>
        <v-card-title>
            <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Search"
                single-line
                hide-details
                clearable
            ></v-text-field>             
        </v-card-title>
    </v-card>      
    <v-data-table
        :headers="headers"
        :items="ptwList"        
        sort-by="created_at"
        sort-desc
        class="elevation-1"
        :loading="loading"
        :search="search"
        show-select
        @item-selected="rowSelected"
        @toggle-select-all="toggleAll"
    >
      <template v-slot:top>      
          <v-toolbar flat > 
              <v-toolbar-title>
               Permit To Works
              </v-toolbar-title>
              <v-divider
                class="mx-4"
                inset
                vertical
              ></v-divider>
              
              <v-spacer></v-spacer> 

              <v-dialog v-model="dialog"  max-width="900px" persistent scrollable>              
                <template v-slot:activator="{ on: dialog }">
                    <v-tooltip bottom>
                    <template v-slot:activator="{ on: tooltip }">
                    <v-btn 
                        v-show="$can.permit('ptw_create')"
                        color="primary darken-2" 
                        dark                         
                        class="mb-2 ml-1" 
                        @click="ptwType = 'Night'"
                        v-on = "{ ...tooltip, ...dialog}"
                      >
                        New <v-icon>mdi-moon-new</v-icon>
                    </v-btn>
                    </template>
                    <span>New PTW Night</span> 
                    </v-tooltip>
                    
                    <v-tooltip bottom>
                    <template v-slot:activator="{ on: tooltip }"> 
                    <v-btn 
                        v-show="$can.permit('ptw_create')"
                        color="amber darken-2" 
                        dark                         
                        class="mb-2"
                        @click="ptwType = 'Day'" 
                        v-on="{...dialog,...tooltip}" >
                        New <v-icon>mdi-white-balance-sunny</v-icon>
                    </v-btn>   
                       </template>
                    <span>New PTW Day</span> 
                    </v-tooltip>                 
                </template>
                  <PtwForm
                      v-if="dialog"
                      :ptwDialog.sync="dialog"
                      :ptwType = "ptwType"
                      @refresh="initialize"
                  ></PtwForm>
              </v-dialog>
              <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                      <v-btn 
                        v-show="$can.permit('ptw_approve')"
                        v-on="on"
                        class="mb-2 ml-1" 
                        color="primary darken-1"
                        fab 
                        dark 
                        small
                        @click="batch" 
                        :loading="batchLoading"
                      ><v-icon dark>mdi-thumb-up-outline</v-icon>
                      </v-btn> 
                  </template>
                <span>Batch PTW Approval</span>
              </v-tooltip>
              <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                      <v-btn 
                        v-on="on"
                        class="mb-2 ml-1" 
                        color="success darken-1"
                        fab 
                        dark 
                        small
                        @click="initialize" 
                        :loading="loading"
                      ><v-icon dark>mdi-refresh</v-icon>
                      </v-btn> 
                  </template>
                  <span>Refresh</span>
              </v-tooltip>
        </v-toolbar>
      </template>

          <template v-slot:header.data-table-select="{on,props}">          
              <v-simple-checkbox v-if="$can.permit('ptw_approve')" v-bind="props" v-on="on"></v-simple-checkbox>
              <span v-else></span>     
          </template>

          <template v-slot:item.data-table-select="{isSelected, select, item}">
              <v-simple-checkbox v-if="$can.permit('ptw_approve') && item.ptw_status_id == 6" :value="isSelected" @input="select($event)"></v-simple-checkbox>
              <span v-else></span>
          </template>


          <template v-slot:item.ptwstatus.name="{ item }">
           <v-badge
              :content="item.attachments.length"
              :value="(item.ptw_status_id == 1 || item.ptw_status_id == 12) && item.attachments.length > 0"
              color="amber darken-1"              
            >
              <span class ="blue--text" v-if="item.ptw_status_id==8">{{item.ptwstatus.name}}</span>
              <span class ="green--text" v-else-if="item.ptw_status_id==1 || item.ptw_status_id==12 || item.ptw_status_id==6">{{item.ptwstatus.name}}</span>
              <span class ="orange--text" v-else-if="item.ptw_status_id==5">{{item.ptwstatus.name}}</span>
              <span class ="red--text" v-else-if="item.ptw_status_id==2 || item.ptw_status_id==7 || item.ptw_status_id==11 || item.ptw_status_id== 9 || item.ptw_status_id==10">{{item.ptwstatus.name}}</span>        
              <span v-else>{{item.ptwstatus.name}}</span>
            </v-badge>
        </template>

      <template v-slot:item.reference_no="{ item }">
        <span v-if="item.version_index > 0">{{ item.reference_no }}.{{item.version_index}}</span>
        <span v-else>{{ item.reference_no }}</span>
      </template>

      <template v-slot:item.project_id="{ item }">
        <span>{{ item.project.name }}</span>
      </template>

      <template v-slot:item.sub_contractor_id="{ item }">
        <span>{{ item.subcontractor.name }}</span>
      </template>

      <template v-slot:item.start_date="{ item }">
        <span>{{new Date(item.start_date).toLocaleDateString()}}</span>
      </template>

      <template v-slot:item.end_date="{ item }">
        <span>{{new Date(item.end_date).toLocaleDateString()}}</span>
      </template>

      <template v-slot:item.updated_at="{ item }">
        <span>{{new Date(item.updated_at).toLocaleDateString()}}</span>
      </template>
     
      <template v-slot:item.action="{ item }">
        
        <v-tooltip bottom>
          <template v-slot:activator="{ on }">
            <v-btn
              v-show="$can.permit('ptw_edit') && (item.ptw_status_id == 5 || item.ptw_status_id == 9 || item.ptw_status_id == 11)"
              v-on="on"
              text
              icon
              dark
              color="primary"
              @click="editPtw(item)"
            >
              <v-icon>mdi-file-edit</v-icon>
            </v-btn>
          </template>
          <span>Edit</span>
        </v-tooltip>
        
        <v-tooltip bottom>
          <template v-slot:activator="{ on }">
          <v-btn 
            v-show="$can.permit('ptw_delete')"
            v-on="on"
            text 
            icon 
            dark
            color="error"
            @click="setDeletePtw(item)"
          >
            <v-icon>mdi-delete</v-icon>
          </v-btn>
          </template>
          <span>Delete</span>
        </v-tooltip>
        
        <v-tooltip bottom>
          <template v-slot:activator="{ on }">
          <v-btn 
            v-show="$can.permit('ptw_upload') && (item.ptw_status_id == 5 || item.ptw_status_id == 9)"
            v-on="on"
            text 
            icon 
            dark
            color="warning"
            @click="attach(item)"            
          >
          <v-icon>mdi-attachment</v-icon>
          </v-btn>
          </template>
          <span>Uploaded File(s)</span>
        </v-tooltip>
        
        <v-tooltip bottom>
          <template v-slot:activator="{ on }">
          <v-btn 
            v-show="($can.permit('ptw_verify') || $can.permit('ptw_approve')) && (item.ptw_status_id == 1 || item.ptw_status_id == 6 ||  item.ptw_status_id == 8 || item.ptw_status_id == 3 || item.ptw_status_id == 11 || item.ptw_status_id == 12)"
            v-on="on"
            text 
            icon 
            dark
            color="info"
            :loading="viewLoading && rowIndex === item.id"
            @click="verifyPtw(item)"
          >
            <v-icon>mdi-clipboard-check</v-icon>
          </v-btn>
          </template>
          <span>Verify Permit</span>
        </v-tooltip>
        
        <v-tooltip bottom>
            <template v-slot:activator="{ on }">
                <v-btn 
                    v-show="$can.permit('ptw_revoke') && item.ptw_status_id == 1"
                    v-on="on"
                    text 
                    icon 
                    dark
                    color="error darken-2"
                    @click="setRevokePtw(item)"
                >
                    <v-icon>mdi-cancel</v-icon>
                </v-btn>
            </template>
            <span>Revoke</span>
        </v-tooltip>
        
        <v-tooltip bottom>
            <template v-slot:activator="{ on }">
                <v-btn 
                    v-show="$can.permit('ptw_copy')"
                    v-on="on"
                    text 
                    icon 
                    dark
                    color="pink"
                    @click="copyPtw(item)"
                >
                    <v-icon>mdi-content-duplicate</v-icon>
                </v-btn>
            </template>
            <span>Copy PTW</span>
        </v-tooltip>

        <v-tooltip bottom>
            <template v-slot:activator="{ on }">
                <v-btn 
                    v-show="$can.permit('ptw_checklist') && (item.ptw_status_id == 1 || item.ptw_status_id == 4 || item.ptw_status_id == 12)"
                    v-on="on"
                    text 
                    icon 
                    dark
                    color="info darken-1"
                    @click="openPtwChecklistItemDialog(item)"                    
                >
                    <v-icon>mdi-format-list-checks</v-icon>
                </v-btn>
            </template>
            <span>PTW Checklists</span>
        </v-tooltip>

         <v-tooltip bottom>
            <template v-slot:activator="{ on }">
                <v-btn 
                    v-show="$can.permit('ptw_report')"
                    v-on="on"
                    text 
                    icon 
                    dark
                    color="indigo"
                >
                    <v-icon>mdi-pdf-box</v-icon>
                </v-btn>
            </template>
            <span>Generate Report</span>
        </v-tooltip>

      </template>
      <template v-slot:loading>
        <span>Fetching Data...</span>
      </template>
    </v-data-table>  

    <AttachmentsDialog         
        :reference_id = "ptw.id"
        :reference_no = "ptw.reference_no"
        :attachmentDialog = "dialogAttachment"
        @close-dialog = "dialogAttachment = false"
    ></AttachmentsDialog>

    <BatchApprovalForm
      :ptwFormBatchSignDialog.sync="batchApprovalDialog"
      :ptwIds="ptwIds"
      @refresh="initialize"
    ></BatchApprovalForm>

    <CopyPtwFormDialog
        v-if="copyDialog"
        :copyDialog.sync="copyDialog"
        @refresh="initialize"
    ></CopyPtwFormDialog>

    <DeleteRemarkDialog 
      :ptw = "ptw"      
      :deleteRemarkConfirmDialog.sync = "deleteRemarkConfirmDialog"
    ></DeleteRemarkDialog> 

    <v-dialog v-model="viewDialog"  max-width="900px" persistent scrollable>    
      <PtwView
          v-if="viewDialog"
          :ptwViewDialog.sync="viewDialog"
          @refresh="initialize"
      ></PtwView>
    </v-dialog>

    <RevokeConfirmDialog
        v-if="revokeDialog"
        :revokeDialog.sync = "revokeDialog"        
        @refresh="initialize"
    ></RevokeConfirmDialog>
    
    <v-dialog v-model="ptwchecklistDialog"  max-width="1000px" persistent scrollable>    
      <PtwChecklistItemsDialog
          v-if="ptwchecklistDialog"
          :ptwId= "ptwId"
          :ptwchecklistDialog.sync="ptwchecklistDialog"
          @refresh="initialize"
      ></PtwChecklistItemsDialog>
    </v-dialog>

</div>
</template>

<script>
import AttachmentsDialog from '@/js/views/ptws/attachmentsDialog';
import BatchApprovalForm from '@/js/views/ptws/formBatchApprovalDialog';
import CopyPtwFormDialog from '@/js/views/ptws/copyFormDialog';
import PtwChecklistItemsDialog from '@/js/views/ptwchecklistitems/index';
import PtwForm from '@/js/views/ptws/form';
import PtwView from '@/js/views/ptws/view';
import RevokeConfirmDialog from '@/js/views/ptws/revokeConfirmDialog';
import DeleteRemarkDialog from '@/js/views/ptws/deleteRemarkDialog';

export default {
    components: {
        AttachmentsDialog,
        BatchApprovalForm,
        CopyPtwFormDialog,
        PtwChecklistItemsDialog,
        PtwForm,
        PtwView,
        RevokeConfirmDialog,
        DeleteRemarkDialog,
    },
    data: () => ({
        batchLoading: false,
        batchApprovalDialog: false, 
        checkDialog: false,
        copyDialog: false,  
        deleteDialog: false,
        dialog: false,
        dialogAttachment: false,
        deleteRemarkConfirmDialog: false,
        headers: [
            { text: 'Ref. #', value: 'reference_no',},            
            { text: 'Permit to Work', value: 'hrw.name'},
            { text: 'Location', value: 'location'},
            // { text: 'Work to perform', value: 'work_to_be_done'},            
            { text: 'Status', value: 'ptwstatus.name'},
            { text: 'Start Date', value: 'start_date', filterable: true},
            { text: 'End Date', value: 'end_date'},
            { text: 'Status Date', value: 'updated_at'},
            { text: 'Actions', value: 'action', sortable: false, filterable: false },
        ],
        loading: true,
        ptwType: 'Day',
        ptw: {},
        ptwchecklistDialog: false,
        ptws: [],
        ptwIds: [], 
        ptwIndex: -1,
        revokeDialog: false,               
        search: '',
        viewDialog: false,
        viewLoading: false,
    }),

    computed: {      
        ptwList () {  
          this.ptws = this.$store.getters.ptws;
          return this.ptws;          
        },         
    },

    created () {
      this.initialize()
    },

    watch : {
        dialog(val) {
            if(!val) {
                this.ptw = {}
            }
        },
        deleteDialog (val) {
            if(!val) {
                this.ptw = {}
                this.ptwIndex = -1
                this.initialize()
            }
        },  
        deleteRemarkConfirmDialog(val) {
          if(!val) {
              this.closeDeleteRemarkConfirmDialog()
              this.initialize()
          }
        }

    },

    methods: {           
        attach (item) {
            this.ptwIndex       = this.ptws.indexOf(item);
            
            this.ptw.id         = item.id;
            this.ptw.reference_no = item.reference_no;

            this.dialogAttachment = true;
        },

        batch() {
          this.batchLoading = true
          if(this.ptwIds.length > 0) {
              this.batchLoading = false
              this.batchApprovalDialog = true
          } else {
              const message = "No Permit Selected"
              this.$store.commit('setSnackbar',{text: message, visible: true, color: 'error'});
              setTimeout(() => {                
                    this.$store.commit('closeSnackbar');
              },2000);  
              this.batchLoading = false 
          }
          
        },

        copyPtw(item) {
            this.$store.commit('RESET_WORKER_CERTIFICATE_ID');

            this.ptwIndex       = this.ptws.indexOf(item);
           
            this.$store.commit('SET_PTW', item) 
            
            if(item.ptwworkercertificates.length > 0) {
              for(var ptwworkercertificate of item.ptwworkercertificates)
              this.$store.commit('SET_WORKER_CERTIFICATE_ID',{
                'checked': true, 
                'workerid': ptwworkercertificate.worker_id, 
                'workercertificateid': ptwworkercertificate.workercertificate}
              )   
            }

            this.copyDialog = true
        },
        
        editPtw(item) {
            this.$store.commit('RESET_WORKER_CERTIFICATE_ID');
            
            this.ptwIndex       = this.ptws.indexOf(item);

            this.$store.commit('SET_PTW', item)
            
            if(item.ptwworkercertificates.length > 0) {
              for(var ptwworkercertificate of item.ptwworkercertificates)
              this.$store.commit('SET_WORKER_CERTIFICATE_ID',{
                'checked': true, 
                'workerid': ptwworkercertificate.worker_id, 
                'workercertificateid': ptwworkercertificate.workercertificate}
              )   
            }
              
            this.dialog = true
        },

        initialize () {         
            this.loading = true
            this.$store.dispatch('fetchPtws').then(() => {this.loading = false});               
        },

        openPtwChecklistItemDialog(item) {
          this.ptwIndex = this.ptws.indexOf(item);

          this.ptwId = item.id

          this.ptwchecklistDialog = true
        },

        rowSelected(row){   
                 
            if(row.value) {
                this.ptwIds.push(row.item.id)
            } else {
               this.ptwIds.splice(this.ptwIds.indexOf(row.item.id),1)
            }

        },

        setRevokePtw(item) {
            this.$store.commit('SET_PTW', item)            
            this.revokeDialog = true
        },

        setDeletePtw(item) {
            this.ptwIndex = this.ptws.indexOf(item);

            this.ptw.id             = item.id;
            this.ptw.reference_no   = item.reference_no
            this.ptw.hrw_name       = item.hrw.name
            this.ptw.start_date     = item.start_date
            this.ptw.end_date       = item.end_date
            this.ptw.location       = item.location
            this.ptw.work_to_be_done= item.work_to_be_done

            // this.deleteDialog = true;
            this.deleteRemarkConfirmDialog = true;
        },
        
        toggleAll(items) {
            if(items.value) {
                for(var ptwObj of this.ptws){
                    if(!this.ptwIds.includes(ptwObj.id) && ptwObj.ptw_status_id == 6){
                        this.ptwIds.push(ptwObj.id)
                    }                
                }
            } else {
                this.ptwIds.splice(0,this.ptwIds.length) // empty array
            }

            console.log(this.ptwIds)
        },

        verifyPtw(item) {
            this.ptwIndex       = this.ptws.indexOf(item);

            this.$store.commit('SET_PTW', item)               
            this.$store.commit('SET_PTW_VERIFIED_CHECKLIST', item)    
            this.viewDialog = true
        },

        attachmentCount(item) {
            return item.attachments.length
        },

        closeDeleteRemarkConfirmDialog() {
        this.deleteRemarkConfirmDialog = false
        //this.ptw.reset()
        this.ptwIndex = -1
        },

    }
    

}
</script>