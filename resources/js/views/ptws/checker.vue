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
        :items="checkerList"        
        sort-by="name"
        class="elevation-1"
        :loading="loading"
        :search="search"
    >
    <template v-slot:top>      
        <v-toolbar flat > 
          <v-toolbar-title>
              PTW Checkers
          </v-toolbar-title>
          <v-divider
            class="mx-4"
            inset
            vertical
          ></v-divider>
          
          <v-spacer></v-spacer> 
                         
          <v-dialog v-model="dialog" max-width="500px" persistent>
            <template v-slot:activator="{ on }">
                    <v-btn color="primary" 
                        dark class="mb-2" v-on="on" >
                        <v-icon dark>mdi-plus-minus</v-icon>
                        Add / Remove Checkers
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
                             <v-select
                                :items="userList"
                                :loading="loading"                                
                                v-model="checkerIds" 
                                label="Users"        
                                item-text="name"
                                item-value="id"
                                clearable
                                required
                                multiple
                                hint="Select Users for PTW Checkers"
                                persistent-hint
                            ></v-select>             
                        </v-col>                                         
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
                        :loading="loading"
                    >
                        Save
                    </v-btn>
                </v-card-actions>
                </v-form>
            </v-card>
          </v-dialog>        
      </v-toolbar>
    </template>

    <template v-slot:item.action="{ item }">
        <v-tooltip bottom>
        <template v-slot:activator="{ on }">
            <v-btn 
                v-on="on"
                text 
                icon 
                dark
                color="error"
                @click="setDeleteChecker(item)"
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

    <DeleteCheckerConfirmDialog 
        v-if="deleteDialog"
        :deleteDialog.sync = "deleteDialog"
        @refresh = "initialize"
    ></DeleteCheckerConfirmDialog>
</div>
</template>
<script>
import DeleteCheckerConfirmDialog from '@/js/views/ptws/deleteCheckerConfirmDialog';
import Form from '@/js/core/form'

  export default {
    components: {
        DeleteCheckerConfirmDialog
    },
    data: () => ({
        checkerIds: [], 
        search: '',       
        loading: true,
        deleteDialog: false,
        dialog: false,        
        headers: [
            { text: 'Id', value: 'id' },
            { text: 'Name', value: 'user.name',},            
            { text: 'E-mail', value: 'user.email'},
            { text: 'Mobile No.', value: 'user.mobile_no'},
            { text: 'Actions', value: 'action', sortable: false ,filterable: false},
        ],
        checkers: [],
        checkerIndex: -1,
        checker: {},
         user: new Form({
            name: '',
            email: '',
            mobile_no: '',
            is_active: 0,
        })        
    }),

    computed: {
        formTitle () {
            return "Add / Remove PTW Checker"
        },      
        checkerList () {  
          this.checkers = this.$store.getters.checkers;
          return this.checkers;          
        }, 
        userList () {  
          return this.$store.getters.users
        },   
    },

    watch: {

      dialog (val) {                
        val || this.close()      
      },

    },

    created () {
      this.initialize()
      this.users()
    },

    methods: {
      
        initialize () { 
            
            this.loading = true
            this.$store.dispatch('fetchPtwCheckers')
                .then(()=> {
                    this.selectedCheckers()
                    this.loading = false
            });               
        },

        users(){
            this.loading = true
                this.$store.dispatch('fetchUsers',this.user)
                .then(()=> {
                    this.loading = false
            });         
        },

        setDeleteChecker (item) {        
            this.checkerIndex = this.checkers.indexOf(item);
            
            this.$store.commit('SET_PTW_CHECKER',item)

            this.deleteDialog = true;
        },
    
        close () {
            this.checkers = []
            this.dialog = false
            this.$store.commit('RESET_PTW_CHECKER_LIST')
            this.$store.commit('RESET_PTW_CHECKER')
            this.checkerIndex = -1        
            this.initialize()
        },

        save () { 
            this.loading = true       
            var action = 'updatePtwChecker';

            var checker_ids = JSON.stringify(this.checkerIds)

            this.$store.dispatch(action,{'checker_ids': checker_ids})
                .then(() => { 
                    this.loading = false
                    this.close()                    
            
                    setTimeout(() => {                
                        this.$store.commit('closeSnackbar');
                    },2000);              
                }).catch(()=> { this.loading = false });      
        },

        selectedCheckers() {
            this.checkerIds = []
            var checkers = this.checkers
            for(var checker of checkers) {
                this.checkerIds.push(checker.user_id)
            }
        },
    },
  }
</script>