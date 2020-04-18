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
        :items="swpList"        
        sort-by="id"
        sort-desc
        class="elevation-1"
        :loading="loading"
        :search="search"
    >
      <template v-slot:top>      
          <v-toolbar flat > 
            <v-toolbar-title>
                Safe Work Procedures
            </v-toolbar-title>
            <v-divider
              class="mx-4"
              inset
              vertical
            ></v-divider>
            
            <v-spacer></v-spacer> 
                          
            <v-dialog v-model="dialog" max-width="500px" persistent>
              <template v-slot:activator="{ on }">
                  <v-btn color="primary" dark class="mb-2" v-on="on" >
                      New
                  </v-btn>
              </template>
              
              <v-card>
                <v-form @submit.prevent="save" ref="form"  >
                <v-card-title>
                  <span class="headline">{{ formTitle }}</span>
                </v-card-title>
                <v-card-text>
                  <v-container>
                      <v-row>
                        <v-col cols="12">
                          <v-text-field 
                              v-if="dialog" autofocus
                              required                              
                              clearable 
                              v-model="swp.activity" 
                              label="*Activity"
                              type="text"
                              :error-messages="swp.errors.get('activity')"
                              @keydown="swp.errors.clear('activity')"                              
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-select
                                :items="categoryList"
                                v-model="swp.swp_category_id" 
                                label="*Category"
                                clearable
                                item-text="name"
                                item-value="id"
                                :error-messages="swp.errors.get('swp_category_id')"
                                @change="swp.errors.clear('swp_category_id')"          
                                :loading="loading"
                            ></v-select>                          
                        </v-col>                   
                        <v-col cols="12">
                           <v-text-field 
                              v-if="dialog" autofocus
                              required                              
                              clearable 
                              v-model="swp.ref_no" 
                              label="*Reference No."
                              type="text"
                              :error-messages="swp.errors.get('ref_no')"
                              @keydown="swp.errors.clear('ref_no')"                              
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">                        
                            <v-checkbox 
                              v-show="notApproved"
                              v-model ="swp.swp_status_id" 
                              label="For Approval"
                            ></v-checkbox>  
                        </v-col>
                      
                      </v-row>
                  </v-container>
                </v-card-text>

                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn raised color="error darken-1" dark @click="close">
                      Cancel
                    </v-btn>
                    <v-btn 
                      raised 
                      color="success darken-1" 
                      dark 
                      type="submit"
                      :disabled="swp.errors.any()"                  
                      :loading="loading"
                    >
                      Save
                    </v-btn>
                  </v-card-actions>
                </v-form>
              </v-card>
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

      <template v-slot:item.swp_category_id="{ item }">
        <span>{{ item.swpcategory.name }}</span>
      </template>

      <template v-slot:item.swp_status_id="{ item }">
        <span v-if="item.swp_status_id == 0">Draft</span>
        <span v-else>{{item.swpstatus.name}}</span>       
      </template>
     
      <template v-slot:item.action="{ item }">
        <v-tooltip bottom>
          <template v-slot:activator="{ on }">
            <v-btn
              v-on="on"
              text
              icon
              dark
              color="primary"
              @click="editSwp(item)"
            >
              <v-icon> mdi-file-edit</v-icon>
            </v-btn>
          </template>
          <span>Edit</span>
        </v-tooltip>
        <v-tooltip bottom>
          <template v-slot:activator="{ on }">
          <v-btn 
            v-on="on"
            text 
            icon 
            dark
            color="error"
            @click="setDeleteSwp(item)"
          >
            <v-icon>mdi-delete</v-icon>
          </v-btn>
          </template>
          <span>Delete</span>
        </v-tooltip>
        <v-tooltip bottom>
          <template v-slot:activator="{ on }">
          <v-btn 
            v-on="on"
            text 
            icon 
            dark
            color="info"
            @click="attach(item)"
          >
            <v-icon>mdi-file-upload</v-icon>
          </v-btn>
          </template>
          <span>Upload File</span>
        </v-tooltip>
        <v-tooltip bottom>
          <template v-slot:activator="{ on }">
          <v-btn 
            v-on="on"
            text 
            icon 
            dark
            color="warning"
            v-show="item.procedure_path != null"
            :loading="dlLoading && rowIndex === item.id"
            @click="download(item)"
          >
            <v-icon>mdi-eye-circle</v-icon>
          </v-btn>
          </template>
          <span>View File</span>
        </v-tooltip>
        <v-tooltip bottom>
          <template v-slot:activator="{ on }">
          <v-btn 
            v-on="on"
            text 
            icon 
            dark
            color="info"
            @click="history(item)"
          >
            <v-icon>mdi-history</v-icon>
          </v-btn>
          </template>
          <span>History</span>
        </v-tooltip>

        <v-tooltip bottom>
          <template v-slot:activator="{ on }">
          <v-btn
            v-show="item.swp_status_id != 1 ? true : false"
            v-on="on"
            text 
            icon 
            dark
            color="success"
            :loading="dlLoading && rowIndex === item.id"
            @click="createSwpStatusHistory(item,1)"
          >
            <v-icon>mdi-check-outline</v-icon>
          </v-btn>
          </template>
          <span>Approve</span>
        </v-tooltip>

        <v-tooltip bottom>
          <template v-slot:activator="{ on }">
          <v-btn 
            v-show="item.swp_status_id != 3 ? true : false"
            v-on="on"
            text 
            icon 
            dark
            color="error"
            :loading="dlLoading && rowIndex === item.id"
            @click="createSwpStatusHistory(item,3)"
          >
            <v-icon>mdi-close-outline</v-icon>
          </v-btn>
          </template>
          <span>Reject</span>
        </v-tooltip>        

      </template>
      <template v-slot:loading>
        <span>Fetching Data...</span>
      </template>
    </v-data-table>  

    <ProcedureDialog
        v-model = "swp.id"
        :swp_ref_no ="swp.ref_no"
        :swp_act ="swp.activity"
        :dialogAttachment.sync = "dialogAttachment"
    ></ProcedureDialog>

    <HistoryDialog
      :key="swp.id"
      :swp = "swp"
      :historyDialog.sync = "historyDialog"
    ></HistoryDialog>

    <SwpStatusHistoryForm      
      :formDialog.sync = "formDialog"
      :formTitle = "historyFormTitle"
      :swpStatusHistory = "swpStatusHistory"
      :swp = "swp"        
    ></SwpStatusHistoryForm>

    <DeleteRemarkDialog 
      :swp = "swp"      
      :deleteRemarkConfirmDialog.sync = "deleteRemarkConfirmDialog"
    ></DeleteRemarkDialog> 

</div>
</template>

<script>
import Form from '@/js/core/form';
import HistoryDialog from '@/js/views/swps/historyDialog';
import ProcedureDialog from '@/js/views/swps/procedureDialog';
import SwpStatusHistoryForm from '@/js/views/swpstatushistory/form';
import DeleteRemarkDialog from '@/js/views/swps/deleteRemarkDialog';

export default {
    components: {
      HistoryDialog,
      ProcedureDialog,
      SwpStatusHistoryForm,
      DeleteRemarkDialog,
    },
    data: () => ({ 
        search: '',       
        loading: true,
        dialog: false,
        dialogAttachment: false,
        deleteDialog: false,
        formDialog: false,
        dlLoading: false,    
        deleteRemarkConfirmDialog: false,    
        headers: [
            { text: 'Id', value: 'id' },            
            { text: 'Reference No.', value: 'ref_no', align: 'left' },
            { text: 'Activity', value: 'activity',},                        
            { text: 'Category', value: 'swp_category_id'},
            { text: 'Status', value: 'swp_status_id' },
            { text: 'Actions', value: 'action', sortable: false ,filterable: false},
        ],
        historyDialog: false,
        swps: [],
        swpIndex: -1,
        swp: new Form({
          activity: '',
          ref_no: '',
          swp_category_id: 0,
          swp_status_id: 0,
        }),
        swpStatusHistory: new Form({
          comments: "",
          swp_id: 0,
          swp_status_id: 0
        }),  
        category: new Form({ id:'', activity: ''}),
    }),

    computed: {
        categoryList() {
          return this.$store.getters.categories;
        },
        formTitle () {
            return this.swpIndex === -1 ? 'New Safe Work Procedure' : 'Edit Safe Work Procedure'
        },
        historyFormTitle () {
          if(this.swpStatusHistory.swp_status_id == 1)
            return "Approve"
          else if (this.swpStatusHistory.swp_status_id == 3)  
            return "Reject"
        }, 
        notApproved() {
          if(this.swp.swp_status_id === 1) {
            return false;
          }                    
          return true;
        },     
        swpList () {  
          this.swps = this.$store.getters.swps;
          return this.swps;          
        }
    },

    watch: {
        dialog (val) {                
          val || this.close()
          if(val) {
              this.getCategories();
          }        
        },      
        dialogAttachment(val) {
            if(!val) {
                this.swp.reset()
                this.swpIndex = -1
                this.initialize()
            }
        },
        formDialog(val) {
            if(!val) {
              this.swpIndex = -1
              this.swp.reset()
              this.swpStatusHistory.reset()
              this.initialize()
            }
        },
        historyDialog(val) {
            if(!val) {
              this.swpIndex = -1
              this.swp.reset()
              this.swpStatusHistory.reset()
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

    created () {
      this.initialize()
    },

    methods: {
        
        initialize () { 
          this.loading = true
          this.$store.dispatch('fetchSwps',this.swp)
          .then(()=> {
              this.loading = false
          });               
        },

        history(item) {
          this.swpIndex     = this.swps.indexOf(item);
            
          this.swp.id             = item.id;
          this.swp.ref_no         = item.ref_no;
          this.swp.activity       = item.activity;
          
          this.historyDialog = true;
        },
 
        getCategories() {
            this.loading = true
            this.$store.dispatch('fetchCategories',this.category)
            .then(()=> {
                this.loading = false
            }); 
        },

        createSwpStatusHistory(item, status) {
            this.swp.ref_no = item.ref_no
            this.swp.activity = item.activity

            this.swpStatusHistory.swp_id       = item.id
            this.swpStatusHistory.swp_status_id= status
            
            this.formDialog = true
        },

        editSwp (item) {        
            this.swpIndex     = this.swps.indexOf(item);
            
            this.swp.id             = item.id;
            this.swp.activity       = item.activity;
            this.swp.ref_no         = item.ref_no;
            this.swp.swp_category_id= item.swp_category_id;
            this.swp.swp_status_id  = item.swp_status_id;

            this.dialog = true;
        },

        setDeleteSwp (item) {        
            this.swpIndex = this.swps.indexOf(item);

            this.swp.id       = item.id;
            this.swp.activity = item.activity;
            this.swp.ref_no   = item.ref_no;

            // this.deleteDialog = true;
            this.deleteRemarkConfirmDialog = true;
        },

        attach (item) {
            this.swpIndex     = this.swps.indexOf(item);
            
            this.swp.id       = item.id;
            this.swp.ref_no   = item.ref_no;
            this.swp.activity = item.activity;

            this.dialogAttachment = true;
        },

        download(item) {
            this.rowIndex = item.id;
            this.dlLoading = true;

            this.$store.dispatch('downloadProcedureFile', item)
            .then(response => {
                this.dlLoading = false;
                window.open(response);
            })
            .catch(error => {
                this.dlLoading = false;
            })
        },
        
        close () {
            this.dialog = false
            this.$refs.form.reset()
            this.swp.reset()
            this.swpIndex = -1        
        },

        closeDeleteRemarkConfirmDialog() {
            this.deleteRemarkConfirmDialog = false
            this.swp.reset()
            this.swpIndex = -1
        },

        save () { 
            this.loading = true       
            var action = 'createSwp';
            if (this.swpIndex > -1) {
                action = 'updateSwp'
            }

            this.$store.dispatch(action,this.swp)
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
        }
    },

}
</script>