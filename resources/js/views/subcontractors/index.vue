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
        :items="subContractorList"        
        sort-by="name"
        sort-asc
        class="elevation-1"
        :loading="loading"
        :search="search"
    >
      <template v-slot:top>      
          <v-toolbar flat > 
            <v-toolbar-title>
                Sub-Contractors
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
                              ref="title"
                              required                              
                              clearable 
                              v-model="subcontractor.name" 
                              label="*Name"
                              type="text"
                              :error-messages="subcontractor.errors.get('name')"
                              @keydown="subcontractor.errors.clear('name')"                              
                            ></v-text-field>
                        </v-col>
                        <!-- <v-col cols="12">
                            <v-select
                              :items="tradeList"
                              v-model="subcontractor.trade_id" 
                              label="Trade"
                              clearable
                              item-text="name"
                              item-value="id"
                              :loading="loading"
                            ></v-select>                          
                        </v-col>                    -->
                        <v-col cols="12">
                            <v-textarea 
                              auto-grow 
                              clearable 
                              v-model="subcontractor.location" 
                              label="Address">
                            </v-textarea>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field                              
                              clearable 
                              v-model="subcontractor.main_contact" 
                              label="Main Contact Person"
                              type="text"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field                              
                              clearable 
                              v-model="subcontractor.main_contact_email" 
                              label="Main Contact Email 1"
                              type="email"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field                              
                              clearable 
                              v-model="subcontractor.main_contact_email2" 
                              label="Main Contact Email 2"
                              type="email"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field                              
                              clearable 
                              v-model="subcontractor.main_contact_email3" 
                              label="Main Contact Email 3"
                              type="email"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field                              
                              clearable 
                              v-model="subcontractor.main_contact_email4" 
                              label="Main Contact Email 4"
                              type="email"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                              <v-textarea 
                                auto-grow 
                                clearable 
                                v-model="subcontractor.remarks" 
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
                        :disabled="subcontractor.errors.any()"                  
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

      <!-- <template v-slot:item.trade_id="{ item }">
        <span>{{ item.trade.name }}</span>
      </template> -->
      
      <template v-slot:item.action="{ item }">
        <v-tooltip bottom>
          <template v-slot:activator="{ on }">
            <v-btn
              v-on="on"
              text
              icon
              dark
              color="primary"
              @click="editSubContractor(item)"
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
            @click="setDeleteSubContractor(item)"
          >
            <v-icon>mdi-delete</v-icon>
          </v-btn>
          </template>
          <span>Delete</span>
        </v-tooltip>

      </template>
      <template v-slot:loading>
        <span>Fetching Data...</span>
      </template>
    </v-data-table>

    <DeleteRemarkDialog 
        v-if = "deleteRemarkConfirmDialog"
        :subcontractor = "subcontractor"      
        :deleteRemarkConfirmDialog.sync = "deleteRemarkConfirmDialog"
    ></DeleteRemarkDialog> 

  </div>
</template>
<script>
import Form from '@/js/core/form';
import DeleteRemarkDialog from '@/js/views/subcontractors/deleteRemarkDialog';

  export default {
    components: {
      DeleteRemarkDialog,
    },
    data: () => ({ 
        search: '',       
        loading: true,
        dialog: false,
        deleteRemarkConfirmDialog: false,
        headers: [
            //{ text: 'Id', value: 'id' },
            { text: 'Sub-Contractor Name', value: 'name',},            
            { text: 'Address', value: 'location', align: 'left' },
            { text: 'Main Contact', value: 'main_contact', align: 'left' },
            { text: 'E-mail', value: 'main_contact_email', align: 'left' },
            { text: 'E-mail 2', value: 'main_contact_email2', align: 'left' },
            { text: 'E-mail 3', value: 'main_contact_email3', align: 'left' },
            { text: 'E-mail 4', value: 'main_contact_email4', align: 'left' },
            { text: 'Remarks', value: 'remarks', align: 'left' },
            // { text: 'Trade', value: 'trade_id'},
            // { text: 'Status', value: 'is_active' },
            { text: 'Actions', value: 'action', sortable: false ,filterable: false},
        ],
        subcontractors: [],
        subcontractorIndex: -1,
        subcontractor: new Form({
            main_contact: '',
            main_contact_email: '',
            main_contact_email2: '',
            main_contact_email3: '',
            main_contact_email4: '',
            name: '',            
            location: '',
            remarks: '',
            trade_id: 0,
            is_active: 0,
        }),  
        trades: new Form({ id:'', name: ''}),
    }),

    computed: {
        formTitle () {
            return this.subcontractorIndex === -1 ? 'New Sub-Contractor' : 'Edit Sub-Contractor'
        },
        status() {
          return this.$store.getters.subcontractorStatus;
        },
        subContractorList () {  
          this.subcontractors = this.$store.getters.subcontractors;
          return this.subcontractors;          
        },
        tradeList() {
          return this.$store.getters.trades;
        }     
    },

    watch: {
      dialog (val) {                
        val || this.close()
        if(val) {
          this.getTrades();
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
        this.$store.dispatch('fetchSubContractors',this.subcontractor)
          .then(()=> {
            this.loading = false
          });               
      },
      
      getTrades() {
        this.loading = true
          this.$store.dispatch('fetchTrades',this.trades)
          .then(()=> {
              this.loading = false
          }); 
      },

      editSubContractor (item) {        
        this.subcontractorIndex     = this.subcontractors.indexOf(item);
        
        this.subcontractor.id       = item.id;
        this.subcontractor.name     = item.name;
        this.subcontractor.location = item.location;
        this.subcontractor.trade_id = item.trade_id;
        this.subcontractor.main_contact = item.main_contact;
        this.subcontractor.main_contact_email = item.main_contact_email;
        this.subcontractor.main_contact_email2 = item.main_contact_email2;
        this.subcontractor.main_contact_email3 = item.main_contact_email3;
        this.subcontractor.main_contact_email4 = item.main_contact_email4;
        this.subcontractor.remarks = item.remarks;
        this.subcontractor.is_active= item.is_active;

        this.dialog = true;
      },

      setDeleteSubContractor (item) {        
        this.subcontractorIndex = this.subcontractors.indexOf(item);

        this.subcontractor.id       = item.id;
        this.subcontractor.name     = item.name;
        this.subcontractor.location = item.location;

        this.deleteRemarkConfirmDialog = true;
      },
    
      close () {
        this.dialog = false
        this.$refs.form.reset()
        this.subcontractor.reset()
        this.subcontractorIndex = -1        
      },

      closeDeleteRemarkConfirmDialog() {
        this.deleteRemarkConfirmDialog = false
        this.subcontractor.reset()
        this.subcontractorIndex = -1
      },

      save () { 
        this.loading = true       
        var action = 'createSubContractor';
        if (this.subcontractorIndex > -1) {
          action = 'updateSubContractor'
        }

        this.$store.dispatch(action,this.subcontractor)
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
      },

      // getStatus (attr,status) {
      //     if(attr == 'color') {
      //       return status ? 'success' : 'error';  
      //     } else if ( attr == 'text') {
      //       return status ? 'Active' : 'Inactive';
      //     }
      // }  
    },
  }
</script>