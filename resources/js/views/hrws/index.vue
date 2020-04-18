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
            :items="hrwList"        
            sort-by="id"
            sort-desc
            class="elevation-1"
            :loading="loading"
            :search="search"
        >
        <template v-slot:top>      
            <v-toolbar flat > 
            <v-toolbar-title>
                High-Risk Works
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
                                v-model="hrw.name" 
                                label="*Name"
                                type="text"
                                :error-messages="hrw.errors.get('name')"
                                @keydown="hrw.errors.clear('name')"                              
                            ></v-text-field>
                        </v-col>                              
                        <v-col cols="12">
                            <v-textarea 
                                auto-grow 
                                clearable 
                                v-model="hrw.description" 
                                rows="1"
                                label="Description">
                            </v-textarea>
                        </v-col>
                        <v-col cols="12">
                              <ChecklistGroupPulldown
                                  v-model="hrw.checklist_group_id"
                              ></ChecklistGroupPulldown>
                        </v-col>
                        <v-col cols="12">                        
                            <v-checkbox 
                                v-model ="hrw.is_active" 
                                label="Active"
                            ></v-checkbox>  
                        </v-col>
                        
                        </v-row>
                    </v-container>
                </v-card-text>

                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn raised color="error darken-1" dark @click="close">
                        <!-- <v-icon left>mdi-cancel</v-icon> -->
                        Cancel
                    </v-btn>
                    <v-btn 
                        raised 
                        color="success darken-1" 
                        dark 
                        type="submit"
                        :disabled="hrw.errors.any()"                  
                        :loading="loading"
                    >
                        <!-- <v-icon left>mdi-content-save</v-icon> -->
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
                >
                <v-icon dark>mdi-refresh</v-icon>
                </v-btn>
                </template>
                <span>Refresh</span>
            </v-tooltip>
        </v-toolbar>
        </template>

        <template v-slot:item.is_active="{ item }">
        <v-chip :color="getStatus('color',item.is_active)" dark>{{ getStatus('text',item.is_active) }}</v-chip>
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
                @click="editHrw(item)"
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
            @click="setDeleteHrw(item)"
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
            @click="checklist(item)"
            >
            <v-icon>mdi-clipboard-list-outline</v-icon>
            </v-btn>
            </template>
            <span>Checklists</span>
        </v-tooltip>
        </template>
        <template v-slot:loading>
        <span>Fetching Data...</span>
        </template>
    </v-data-table>
  
    <DeleteConfirmDialog 
        :hrw = "hrw"
        :deleteDialog.sync = "deleteDialog"
    ></DeleteConfirmDialog>

    <HrwChecklistDialog
        :hrw="hrw"
        :checklistDialog.sync="checklistDialog"
    ></HrwChecklistDialog>
  
  </div> 
</template>

<script>
import ChecklistGroupPulldown from '@/js/views/checklistgroups/pulldown';
import DeleteConfirmDialog from '@/js/views/hrws/deleteConfirmDialog';
import Form from '@/js/core/form';
import HrwChecklistDialog from '@/js/views/hrws/checklistDialog';

export default {
    components: {
        ChecklistGroupPulldown,
        DeleteConfirmDialog,
        HrwChecklistDialog
    },

    data: () => ({ 
        search: '',       
        loading: true,
        checklistDialog: false,
        deleteDialog: false,
        dialog: false,        
        headers: [
            { text: 'Id', value: 'id' },
            { text: 'Name', value: 'name',},            
            { text: 'Description', value: 'description', align: 'left' },
            { text: 'Group', value: 'checklistgroup.name', align: 'left' },
            { text: 'Status', value: 'is_active' },
            { text: 'Actions', value: 'action', sortable: false, filterable: false },
        ],
        hrws: [],
        hrwIndex: -1,
        hrw: new Form({
            name: '',
            checklist_group_id: 0,
            description: '',
            is_active: 0,
        })       
    }),

    computed: {
        formTitle () {
            return this.hrwIndex === -1 ? 'New High-Risk Work' : 'Edit High-Risk Work'
        },      
        hrwList () {  
          this.hrws = this.$store.getters.hrws;
          return this.hrws;          
        }     
    },

    watch: {
      dialog (val) {                
        val || this.close()        
      },
      deleteDialog (val) {
          if(!val) {
            this.closeRm() 
            this.initialize()
          }
      },  
      checklistDialog (val) {
        if(!val) {
            this.closeRm() 
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
        this.$store.dispatch('fetchHrws',this.hrw)
          .then(()=> {
            this.loading = false
          });               
      },

      editHrw (item) {        
        this.hrwIndex       = this.hrws.indexOf(item);
        
        this.hrw.id         = item.id;
        this.hrw.name       = item.name;
        this.hrw.description= item.description;
        this.hrw.checklist_group_id= item.checklist_group_id;
        this.hrw.is_active  = item.is_active;
 
        this.dialog = true;
      },

      setDeleteHrw (item) {  
        this.hrwIndex = this.hrws.indexOf(item);
        
        this.hrw.id         = item.id;
        this.hrw.name       = item.name;
        this.hrw.checklist_group_id= item.checklist_group_id;
        this.hrw.description= item.description;
        
        this.deleteDialog = true;
      },
    
      close () {
        this.deleteDialog =
        this.dialog = false
        this.$refs.form.reset()
        this.hrw.reset()
        this.hrwIndex = -1        
      },

      closeRm() {
        this.deleteDialog = false
        this.hrw.reset()
        this.hrwIndex = -1
      },

      save () { 
        this.loading = true       
        var action = 'createHrw';
        if (this.hrwIndex > -1) {
          action = 'updateHrw'
        } 

        this.$store.dispatch(action,this.hrw)
          .then(response => {               
            this.close()
            this.initialize()            
            setTimeout(() => {                
                this.$store.commit('closeSnackbar');
            },2000);              
          })
          .catch(()=> {
            
          });      
      },
      
      checklist(item) {
        this.hrwIndex = this.hrws.indexOf(item)
        
        this.hrw.id         = item.id
        this.hrw.name       = item.name
        this.hrw.description= item.description
        
        this.checklistDialog = true
      },

      getStatus (attr,status) {
          if(attr == 'color') {
            return status ? 'success' : 'error';  
          } else if ( attr == 'text') {
            return status ? 'Active' : 'Inactive';
          }
        }  
    },
}
</script>