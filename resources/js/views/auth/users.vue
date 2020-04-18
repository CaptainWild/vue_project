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
        :items="userList"        
        sort-by="name"
        class="elevation-1"
        :loading="loading"
        :search="search"
    >
    <template v-slot:top>      
        <v-toolbar flat > 
          <v-toolbar-title>
              Users
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
                            v-model="user.name"
                            prepend-icon="mdi-account" 
                            label="*Name"
                            type="text"
                            :error-messages="user.errors.get('name')"
                            @keydown="user.errors.clear('name')"                              
                          ></v-text-field>
                      </v-col>
                      <v-col cols="12">
                          <v-text-field 
                            required                              
                            clearable 
                            v-model="user.email"
                            prepend-icon="mdi-email"
                            label="*Email"
                            type="text"
                            :error-messages="user.errors.get('email')"
                            @keydown="user.errors.clear('email')"                              
                          ></v-text-field>                        
                      </v-col>                   
                      <v-col cols="12">
                         <v-text-field 
                            required                              
                            clearable 
                            v-model="user.mobile_no" 
                            prepend-icon="mdi-cellphone"
                            label="*Mobile No."
                            type="text"
                            :error-messages="user.errors.get('mobile_no')"
                            @keydown="user.errors.clear('mobile_no')"                              
                          ></v-text-field>       
                      </v-col>
                      <!-- <v-col cols="12">                        
                          <v-checkbox 
                            v-model ="user.is_active" 
                            label="Active"
                          ></v-checkbox>  
                      </v-col> -->
                    
                    </v-row>
                </v-container>
              </v-card-text>

                <v-card-actions>
                   <v-btn raised color="secondary" dark @click="close">
                    Close
                  </v-btn>
                  <v-spacer></v-spacer>
                 
                  <v-btn 
                    raised 
                    color="success darken-1" 
                    dark 
                    type="submit"
                    :disabled="user.errors.any()"                  
                    :loading="loading"
                  >
                    Save
                  </v-btn>
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
      <v-btn
        text
        icon
        dark
        color="primary"
        @click="editUser(item)"
      >
        <v-icon> mdi-file-edit</v-icon>
      </v-btn>
      
      <v-btn 
        text 
        icon 
        dark
        color="error"
        @click="setDeleteUser(item)"
      >
        <v-icon>mdi-delete</v-icon>
      </v-btn>       
       
       <v-btn 
        text 
        icon 
        dark
        color="warning"
        @click="setResetUserPassword(item)"
      >
        <v-icon>mdi-lock-reset</v-icon>
      </v-btn>    

    </template>
    <template v-slot:loading>
      <span>Fetching Data...</span>
    </template>
  </v-data-table>

    <ResetPasswordConfirmDialog 
        :user = "user"
        :resetPasswordDialog.sync = "dialogResetPass"
        @success = "dialogUserPass = true"
    ></ResetPasswordConfirmDialog>

    <UserPasswordDialog 
        :user = "userPass"
        :userPasswordDialog="dialogUserPass"
        @close-dialog = "dialogUserPass = false"
    ></UserPasswordDialog>

    <DeleteRemarkDialog 
      v-if = "deleteRemarkConfirmDialog"
      :user = "user"      
      :deleteRemarkConfirmDialog.sync = "deleteRemarkConfirmDialog"
    ></DeleteRemarkDialog> 

  </div>
</template>
<script>
import Form from '@/js/core/form'
import UserPasswordDialog from '@/js/views/auth/UserPasswordDialog';
import ResetPasswordConfirmDialog from '@/js/views/auth/ResetPasswordConfirmDialog';
import DeleteRemarkDialog from '@/js/views/auth/deleteRemarkDialog';

  export default {
    components: {
        UserPasswordDialog,
        ResetPasswordConfirmDialog,
        DeleteRemarkDialog,
    },
    data: () => ({ 
        search: '',       
        loading: true,
        dialogResetPass: false,
        dialogUserPass: false,
        dialog: false,
        deleteRemarkConfirmDialog: false,
        headers: [
            { text: 'Id', value: 'id' },
            { text: 'Name', value: 'name',},            
            { text: 'E-mail', value: 'email'},
            { text: 'Mobile No.', value: 'mobile_no'},
            // { text: 'Status', value: 'is_active' },
            { text: 'Actions', value: 'action', sortable: false ,filterable: false},
        ],
        users: [],
        userIndex: -1,
        user: new Form({
            name: '',
            email: '',
            mobile_no: '',
            is_active: 0,
        })      
    }),

    computed: {
        formTitle () {
            return this.userIndex === -1 ? 'New User' : 'Edit User'
        },
        status() {
          return this.$store.getters.userStatus;
        },
        userList () {  
          this.users = this.$store.getters.users;
          return this.users;          
        },
        userPass() {                       
            return this.$store.getters.userPass;
        }
    },

    watch: {

      dialog (val) {                
        val || this.close()      
      },

      dialogResetPass (val) {        
        if(!val) {
            this.userIndex = -1
            this.user.reset()
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
        this.$store.dispatch('fetchUsers',this.user)
          .then(()=> {
            this.loading = false
          });               
      },
      
      editUser (item) {        
        this.userIndex     = this.users.indexOf(item);
        
        this.user.id        = item.id;
        this.user.name      = item.name;
        this.user.email     = item.email;
        this.user.mobile_no = item.mobile_no;
        // this.user.is_active = item.is_active;

        this.dialog = true;
      },

      setDeleteUser (item) {        
        this.userIndex = this.users.indexOf(item);

        this.user.id        = item.id;
        this.user.name      = item.name;
        this.user.email     = item.email;
        this.user.mobile_no = item.mobile_no;

        this.deleteRemarkConfirmDialog = true;
      },

      setResetUserPassword (item) {
        this.userIndex = this.users.indexOf(item);

        this.user.id        = item.id;
        this.user.name      = item.name;
        this.user.email     = item.email;

        this.dialogResetPass = true;
      }
      ,
    
      close () {
        this.dialog = false
        this.$refs.form.reset()
        this.user.reset()
        this.userIndex = -1        
      },

      closeDeleteRemarkConfirmDialog() {
        this.deleteRemarkConfirmDialog = false
        this.user.reset()
        this.userIndex = -1
      },

      save () { 
        this.loading = true       
        var action = 'createUser';
        if (this.userIndex > -1) {
          action = 'updateUser'
        }

        this.$store.dispatch(action,this.user)
          .then(() => { 
            this.close()
            this.initialize()
            if(action == 'createUser') {
                this.dialogUserPass = true;
            }
            setTimeout(() => {                
                this.$store.commit('closeSnackbar');
            },2000);              
          }).catch(()=> { this.loading = false });      
      },
    },
  }
</script>