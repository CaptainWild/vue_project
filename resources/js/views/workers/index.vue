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
        :items="workerList"        
        sort-by="id"
        sort-desc
        class="elevation-1"
        :loading="loading"
        :search="search"
    >
      <template v-slot:top>      
          <v-toolbar flat > 
            <v-toolbar-title>
                Manpower
            </v-toolbar-title>
            <v-divider
              class="mx-4"
              inset
              vertical
            ></v-divider>
            
            <v-spacer></v-spacer> 
                          
            <v-dialog v-model="dialog" max-width="500px" persistent scrollable>
              <template v-slot:activator="{ on }">
                  <v-btn v-show="$can.permit('manpower_create')" color="primary" dark class="mb-2" v-on="on" >
                      New
                  </v-btn>
              </template>
               <v-form @submit.prevent="save" 
                    ref="form"
                    v-model="valid" 
                    lazy-validation
                >
              <v-card>
               
                <v-card-title>
                  <span class="headline">{{ formTitle }}</span>
                </v-card-title>
                <v-card-text>
                  <v-container>
                      <v-row>
                        <v-col cols="12">
                          <v-text-field 
                              v-if="dialog" autofocus
                              ref="name"
                              required                              
                              clearable 
                              v-model="worker.name" 
                              label="*Name"
                              type="text"
                              :rules="[v => !!v || 'Name is required']"                             
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                          <v-text-field 
                              required                              
                              clearable 
                              v-model="worker.emp_no" 
                              label="*NRIC / WP No."
                              type="text"
                              :rules="[v => !!v || 'NRIC / WP No. is required']"                            
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <SubContractorPulldown
                                 v-model="worker.sub_contractor_id"
                            ></SubContractorPulldown>                       
                        </v-col>                   
                        <v-col cols="12">                            
                            <RoleMultipleSelectPulldown v-model="roleIds" >
                            </RoleMultipleSelectPulldown>
                        </v-col>   
                        <v-col>
                            <v-textarea 
                                auto-grow 
                                clearable 
                                v-model="worker.remarks" 
                                label="Remarks">
                            </v-textarea>
                        </v-col>         
                      </v-row>
                  </v-container>
                </v-card-text>
                  <v-card-actions>
                    <v-btn raised color="secondary" dark @click="close">
                      Cancel
                    </v-btn>
                    <v-spacer></v-spacer>                    
                    <v-btn 
                      raised 
                      color="success darken-1" 
                      dark 
                      type="submit"
                      :disabled="worker.errors.any()"                  
                      :loading="loading"
                    >
                      Save
                    </v-btn>
                  </v-card-actions>                
              </v-card>
              </v-form>
            </v-dialog>
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
      
      <template v-slot:item.action="{ item }">
        <v-tooltip bottom>
          <template v-slot:activator="{ on }">
            <v-btn
              v-show="$can.permit('manpower_edit')"
              v-on="on"
              text
              icon
              dark
              color="primary"
              @click="editWorker(item)"
            >
              <v-icon> mdi-file-edit</v-icon>
            </v-btn>
          </template>
          <span>Edit</span>
        </v-tooltip>
        <v-tooltip bottom>
          <template v-slot:activator="{ on }">
          <v-btn 
            v-show="$can.permit('manpower_delete')"
            v-on="on"
            text 
            icon 
            dark
            color="error"
            @click="setDeleteWorker(item)"
          >
            <v-icon>mdi-delete</v-icon>
          </v-btn>
          </template>
          <span>Delete</span>
        </v-tooltip>

        <v-tooltip bottom>
            <template v-slot:activator="{ on }">
            <v-btn 
                v-show="$can.permit('manpower_upload')"
                v-on="on"
                text 
                icon 
                dark
                color="warning"
                @click="attach(item)"
            >
            <v-icon>mdi-certificate</v-icon>
            </v-btn>
            </template>
            <span>Files</span>
        </v-tooltip> 
      </template>
      
      <template v-slot:loading>
        <span>Fetching Data...</span>
      </template>
    </v-data-table>

    <DesignationCertificateDialog   
        v-if="dialogDesignationCertificate"      
        v-model = "worker.id"
        :dialogDesignationCertificate.sync = "dialogDesignationCertificate"
        :showSelect.sync="showSelect"
        :workerName="worker.name"
        :workerEmpno="worker.emp_no"
        @refresh = "initialize"
    ></DesignationCertificateDialog> 

    <DeleteRemarkDialog 
        v-if = "deleteRemarkConfirmDialog"  
        :worker = "worker"       
        :deleteRemarkConfirmDialog.sync = "deleteRemarkConfirmDialog"
    ></DeleteRemarkDialog> 

  </div>
</template>
<script>
import Form from '@/js/core/form';
import DesignationCertificateDialog from '@/js/views/workers/designationCertificateDialog';
import RoleMultipleSelectPulldown from '@/js/views/roles/multipleSelectPulldown';
import SubContractorPulldown from '@/js/views/subcontractors/pulldown';
import DeleteRemarkDialog from '@/js/views/workers/deleteRemarkDialog';

  export default {
    components: {
      DesignationCertificateDialog,
      DeleteRemarkDialog,
      RoleMultipleSelectPulldown,
      SubContractorPulldown      
    },
    data: () => ({ 
        valid: true,
        search: '',       
        loading: true,
        dialog: false,
        dialogDesignationCertificate: false,
        deleteRemarkConfirmDialog: false,
        headers: [
            { text: 'Id', value: 'id' },
            { text: 'Name', value: 'name',},            
            { text: 'NRIC / WP No.', value: 'emp_no' },
            { text: 'Sub-Contractor', value: 'subcontractor.name'},            
            // { text: 'Status', value: 'is_active' },
            { text: 'Remarks', value: 'remarks'},            
            { text: 'Actions', value: 'action', sortable: false ,filterable: false},
        ],
        roleIds:[],
        showSelect: false,
        workers: [],
        workerIndex: -1,
        worker: new Form({
            name: '',
            emp_no: '',
            sub_contractor_id: 0,            
            is_active: 0,
            roleIds: '',
            remarks: '',
        }),  
    }),

    computed: {
        formTitle () {
            return this.workerIndex === -1 ? 'New Personnel' : 'Edit Personnel'
        },
        workerList () {  
          this.workers = this.$store.getters.workers;
          return this.workers;          
        },  
    },

    watch: {
      dialog (val) {                
        val || this.close()         
      },     
      deleteRemarkConfirmDialog(val) {
          if(!val) {
              this.closeDeleteRemarkConfirmDialog()
              this.initialize()
          }
      }    
    },

    created () {
      this.initialize()
    },

    methods: {
      
      initialize () { 
        this.loading = true
        this.$store.dispatch('fetchWorkers',this.worker)
          .then(()=> {
            this.loading = false
          });               
      },

      attach (item) {
        this.workerIndex       = this.workers.indexOf(item)
        
        this.worker.id         = item.id
        this.worker.name       = item.name
        this.worker.emp_no       = item.emp_no
        this.dialogDesignationCertificate = true

      },

      editWorker (item) {        
        this.workerIndex     = this.workers.indexOf(item);
        
        this.worker.id               = item.id;
        this.worker.name             = item.name;
        this.worker.emp_no           = item.emp_no;
        this.worker.sub_contractor_id= item.sub_contractor_id;
        this.worker.is_active        = item.is_active;
        this.worker.remarks          = item.remarks

        for(var workercertificate of item.workercertificates) {
          this.roleIds.push(workercertificate.role_id);
        }

        this.dialog = true;
      },

      setDeleteWorker (item) {        
        this.workerIndex = this.workers.indexOf(item);

        this.worker.id               = item.id;
        this.worker.name             = item.name;
        this.worker.emp_no           = item.emp_no;
        this.worker.sub_contractor_id= item.sub_contractor_id;
        this.worker.subcontractor    = item.subcontractor.name;
        this.worker.remarks          = item.remarks

        this.deleteRemarkConfirmDialog = true;
      },
    
      close () {
        this.dialog = false
        this.$refs.form.reset()
        this.worker.reset()
        this.workerIndex = -1   
        this.loading = false
        this.roleIds = []
      },

      closeDeleteRemarkConfirmDialog() {
        this.deleteRemarkConfirmDialog = false
        this.worker.reset()
        this.workerIndex = -1
      },

      save () { 
        this.loading = true       
        var action = 'createWorker';
        if (this.workerIndex > -1) {
          action = 'updateWorker'
        }
        
        this.worker.roleIds = JSON.stringify(this.roleIds)

        if (this.$refs.form.validate()) {
            this.$store.dispatch(action,this.worker)
                .then(response => {               
                    this.close()
                    this.initialize()            
                    setTimeout(() => {                
                        this.$store.commit('closeSnackbar');
                    },2000);              
                })
                .catch(()=> {
                    this.loading = false  
                });   
        } else {
            this.loading = false   
        }      
        
      },
    },
  }
</script>