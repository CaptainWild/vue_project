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
        :items="projectList"        
        sort-by="id"
        sort-desc
        class="elevation-1"
        :loading="loading"
        :search="search"
    >
    <template v-slot:top>      
        <v-toolbar flat > 
          <v-toolbar-title>
              Projects
          </v-toolbar-title>
          <v-divider
            class="mx-4"
            inset
            vertical
          ></v-divider>
          
          <v-spacer></v-spacer> 
                         
          <v-dialog v-model="dialog" max-width="700px" persistent>
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
                      <v-col cols="12" md="8">
                        <v-text-field 
                            v-if="dialog" autofocus
                            ref="title"
                            required                              
                            clearable 
                            v-model="project.title" 
                            label="*Contract Title"
                            type="text"
                            :error-messages="project.errors.get('title')"
                            @keydown="project.errors.clear('title')"                              
                          ></v-text-field>
                      </v-col>
                      <v-col cols="12" md="4">
                          <v-text-field 
                            required                               
                            clearable 
                            v-model="project.code" 
                            label="*Code"
                            type="text"
                            :error-messages="project.errors.get('code')"
                            @keydown="project.errors.clear('code')"
                          ></v-text-field>
                      </v-col>
                      <v-col cols="12" md="3">
                          <DatePicker
                              dateLabel= "Start Date"
                              :dateIcon = false
                              v-model ="project.started_at"
                          ></DatePicker>
                      </v-col>
                      <v-col cols="12" md="3">
                          <DatePicker
                              dateLabel= "Target End Date"
                              :dateIcon = false
                              v-model ="project.ends_at"
                          ></DatePicker>
                      </v-col>                   
                      <v-col cols="12" md="6">
                          <v-textarea 
                            no-resize
                            rows = "1" 
                            clearable 
                            v-model="project.description" 
                            label="Description">
                          </v-textarea>
                      </v-col>
                      <v-col cols="12" md='6'>
                          <UsersMultipleSelectPulldown
                            v-model = "saIds"
                            label = "Safety Assessors"
                            hint = "Select Project Safety Assessors"
                            role = "sa">
                          </UsersMultipleSelectPulldown>
                      </v-col>
                      <v-col cols="12" md="6">
                           <UsersMultipleSelectPulldown
                            v-model = "amIds"
                            label = 'Authorize Managers'
                            hint = 'Select Project Authorize Managers'
                            role = "am">
                          </UsersMultipleSelectPulldown>
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
                    :disabled="project.errors.any()"                  
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
            >
              <v-icon dark>mdi-refresh</v-icon>
            </v-btn>
            </template>
            <span>Refresh</span>
          </v-tooltip>
      </v-toolbar>
    </template>

    <template v-slot:item.started_at="{ item }">
      <span v-if ='item.started_at == null || item.started_at == ""'>-</span>
      <span v-else>{{new Date(item.started_at).toLocaleDateString()}}</span>
    </template>

    <template v-slot:item.ends_at="{ item }">
      <span v-if ='item.ends_at == null || item.ends_at == ""'>-</span>
      <span v-else >{{new Date(item.ends_at).toLocaleDateString()}}</span>
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
            @click="editProject(item)"
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
          @click="setDeleteProject(item)"
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
          color="warning"
          @click="subcons(item)"
        >
          <v-icon>mdi-contacts</v-icon>
        </v-btn>
        </template>
        <span>Sub-Contractors</span>
      </v-tooltip>
    </template>
    <template v-slot:loading>
      <span>Fetching Data...</span>
    </template>
  </v-data-table>

  <SubContractorsDialog
    :key = "project.id"
    :project = "project"
    :projectSubConsDialog.sync="dialogSubCons"
  ></SubContractorsDialog>

  <DeleteRemarkDialog 
      v-if = "deleteRemarkConfirmDialog"
      :project = "project"      
      :deleteRemarkConfirmDialog.sync = "deleteRemarkConfirmDialog"
  ></DeleteRemarkDialog> 

  </div>
</template>
<script>
import DatePicker from '@/js/components/DatePicker';
import DeleteRemarkDialog from '@/js/views/projects/deleteRemarkDialog';
import Form from '@/js/core/form';
import SubContractorsDialog from '@/js/views/project_subcontractors/list';
import UsersMultipleSelectPulldown from '@/js/views/users/multipleSelectPulldown'; 

  export default {
    components: {
      DatePicker,
      DeleteRemarkDialog,
      SubContractorsDialog,      
      UsersMultipleSelectPulldown
    },

    data: () => ({ 
        amIds: [],
        search: '',       
        loading: true,
        dialog: false,
        dialogSubCons: false,
        deleteRemarkConfirmDialog: false,
        headers: [
            //{ text: 'Id', value: 'id' },
            { text: 'Code', value: 'code' },
            { text: 'Contract Title', value: 'title',},            
            { text: 'Description', value: 'description', align: 'left' },
            { text: 'Start Date', value: 'started_at',},            
            { text: 'Target End Date', value: 'ends_at',},            
            // { text: 'Status', value: 'is_active' },
            { text: 'Actions', value: 'action', sortable: false, filterable: false },
        ],
        projects: [],
        projectIndex: -1,
        project: new Form({
            code: '',
            title: '',
            description: '',
            started_at: '',
            ends_at: '',
            is_active: 0,
            amIds: [],
            saIds: []
        }),
        saIds: [],
    }),

    computed: {
        formTitle () {
            return this.projectIndex === -1 ? 'New Project' : 'Edit Project'
        },
        status() {
          return this.$store.getters.projectStatus;
        },
        projectList () {  
          this.projects = this.$store.getters.projects;
          return this.projects;          
        }     
    },

    watch: {
      dialog (val) {                
        val || this.close()        
      },
      dialogSubCons (val) {
        if(!val) {
          this.dialogSubCons = false
          this.project.reset()
          this.projectIndex = -1        
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
        this.$store.dispatch('fetchProjects',this.project)
          .then(()=> {
            this.loading = false
          });               
      },

      editProject (item) {        
        this.projectIndex       = this.projects.indexOf(item);
        
        this.project.id         = item.id;
        this.project.title      = item.title;
        this.project.code       = item.code;
        this.project.description= item.description;
        this.project.started_at = item.started_at;
        this.project.ends_at    = item.ends_at;
        this.project.is_active  = item.is_active;

        for(var user of item.users) {
          if(user.role_id == 3){
            this.saIds.push(user.id);
          } else if( user.role_id == 2) {
            this.amIds.push(user.id);
          }            
        }

        this.dialog = true;
      },

      setDeleteProject (item) {        
        this.projectIndex = this.projects.indexOf(item);

        this.project.id         = item.id;
        this.project.title      = item.title;
        this.project.code       = item.code;
        this.project.description= item.description;
        this.project.started_at = item.started_at;
        this.project.ends_at    = item.ends_at;

        this.deleteRemarkConfirmDialog = true;
      },
    
      close () {
        this.dialog = false
        this.$refs.form.reset()
        this.project.reset()
        this.projectIndex = -1        
      },

      subcons(item) {
        this.projectIndex = this.projects.indexOf(item);

        this.project.id         = item.id;
        this.project.title      = item.title;
        this.project.code       = item.code;
        this.project.description= item.description;

        this.dialogSubCons = true;
      },

      closeDeleteRemarkConfirmDialog() {
        this.deleteRemarkConfirmDialog = false
        this.project.reset()
        this.projectIndex = -1
      },

      save () { 
        this.loading = true       
        var action = 'createProject';
        if (this.projectIndex > -1) {
          action = 'updateProject'
        } 

        this.project.amIds = JSON.stringify(this.amIds);
        this.project.saIds = JSON.stringify(this.saIds);

        this.$store.dispatch(action,this.project)
          .then(response => {     
            this.loading = false          
            this.close()
            this.initialize()            
            setTimeout(() => {                
                this.$store.commit('closeSnackbar');
            },2000);              
          })
          .catch(()=> {
            
          });      
      },
    },
  }
</script>