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
        :items="roleList"        
        sort-by="id"
        sort-desc
        class="elevation-1"
        :loading="loading"
        :search="search"
    >
    <template v-slot:top>      
        <v-toolbar flat > 
          <v-toolbar-title>
              Roles
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
                            v-model="role.name" 
                            label="*Name"
                            type="text"
                            :error-messages="role.errors.get('name')"
                            @keydown="role.errors.clear('name')"                              
                          ></v-text-field>
                      </v-col>                             
                      <v-col cols="12">
                          <v-textarea 
                            auto-grow 
                            clearable 
                            v-model="role.description" 
                            label="Description">
                          </v-textarea>
                      </v-col>
                      <!-- <v-col cols="12">                        
                          <v-checkbox 
                            v-model ="role.is_active" 
                            label="Active"
                          ></v-checkbox>  
                      </v-col> -->
                    
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
                    raised 
                    color="success darken-1" 
                    dark 
                    type="submit"
                    :disabled="role.errors.any()"                  
                    :loading="loading"
                  >Save</v-btn>
                </v-card-actions>
              </v-form>
            </v-card>
          </v-dialog>
          <v-btn 
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
      </v-toolbar>
    </template>

    <template v-slot:item.action="{ item }">

      <v-tooltip bottom>
          <template v-slot:activator="{ on }">
            <v-btn
              v-on = "on"
              text
              icon
              dark
              color="primary"
              @click="editRole(item)"
            >
              <v-icon> mdi-file-edit</v-icon>
            </v-btn>
          </template>
          <span>Edit</span>
      </v-tooltip>
      
      <v-tooltip bottom>
          <template v-slot:activator="{ on }">
            <v-btn 
              v-on = "on"
              text 
              icon 
              dark
              color="error"
              @click="setDeleteRole(item)"
            >
              <v-icon>mdi-delete</v-icon>
            </v-btn>
          </template>
          <span>Delete</span>
      </v-tooltip>

      <v-tooltip bottom>
        <template v-slot:activator="{ on }">
          <v-btn 
            v-on = "on"
            text 
            icon 
            dark
            color="info"
            @click="permissions(item)"
          >
            <v-icon>mdi-format-list-checks</v-icon>
          </v-btn>
        </template>
        <span>Permissions</span>
      </v-tooltip>

    </template>
    <template v-slot:loading>
      <span>Fetching Data...</span>
    </template>
  </v-data-table>

  <PermissionsListDialog       
      v-if = "permissionsDialog"
      :permissionsDialog.sync = "permissionsDialog"
      
  ></PermissionsListDialog> 

  <DeleteRemarkDialog
      v-if = "deleteRemarkConfirmDialog"
      :deleteRemarkConfirmDialog.sync = "deleteRemarkConfirmDialog"
      :role="role"
  ></DeleteRemarkDialog>
  </div>
</template>
<script>
import DeleteRemarkDialog from '@/js/views/roles/deleteRemarkDialog';
import Form from '@/js/core/form';
import PermissionsListDialog from '@/js/views/permissions/list';

export default {
    components: {
      DeleteRemarkDialog,
      PermissionsListDialog,      
    },

    data: () => ({ 
        search: '',       
        loading: true,
        dialog: false,
        deleteRemarkConfirmDialog: false,
        headers: [
            { text: 'Id', value: 'id' },
            { text: 'Name', value: 'name',},            
            { text: 'Description', value: 'description', align: 'left' },
            // { text: 'Status', value: 'is_active' },
            { text: 'Actions', value: 'action', sortable: false ,filterable: false},
        ],
        permissionsDialog: false,
        roles: [],
        roleIndex: -1,
        role: new Form({
            name: '',
            description: '',
            is_active: 0,
        }),  
    }),

    computed: {
        formTitle () {
            return this.roleIndex === -1 ? 'New Role' : 'Edit Role'
        },
        status() {
          return this.$store.getters.roleStatus;
        },
        roleList () {  
          this.roles = this.$store.getters.roles;
          return this.roles;          
        }     
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
      },
      permissionsDialog(val) {
        val || this.initialize()
      }      
    },

    created () {
      this.initialize()
    },

    methods: {

      initialize () { 
        this.loading = true
        this.$store.dispatch('fetchRoles',this.role)
          .then(()=> {
            this.loading = false
          });               
      },

      editRole (item) {        
        this.roleIndex       = this.roles.indexOf(item);
        
        this.role.id       = item.id;
        this.role.name     = item.name;
        this.role.description = item.description;
        // this.role.is_active= item.is_active;

        this.dialog = true;
      },

      permissions(item) {
        
        this.$store.commit('SET_ROLE',item)

        this.permissionsDialog = true;
      },

      setDeleteRole (item) {        
        this.roleIndex = this.roles.indexOf(item);

        this.role.id         = item.id;
        this.role.name       = item.name;
        this.role.description= item.description;

        this.deleteRemarkConfirmDialog = true;
      },

      closeDeleteRemarkConfirmDialog() {
        this.deleteRemarkConfirmDialog = false
        this.role.reset()
        this.roleIndex = -1
      },
    
      close () {
        this.dialog = false
        this.$refs.form.reset()
        this.role.reset()
        this.roleIndex = -1        
      },

      save () { 
        this.loading = true       
        var action = 'createRole';
        if (this.roleIndex > -1) {
          action = 'updateRole'
        } 

        this.$store.dispatch(action,this.role)
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

    },
  }
</script>