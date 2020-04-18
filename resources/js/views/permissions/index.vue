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
        :items="permissionList"        
        sort-by="id"
        sort-desc
        class="elevation-1"
        :loading="loading"
        :search="search"
    >
        <template v-slot:top>      
            <v-toolbar flat > 
            <v-toolbar-title>
                Permissions
            </v-toolbar-title>
            <v-divider
                class="mx-4"
                inset
                vertical
            ></v-divider>
            
            <v-spacer></v-spacer> 
                            
            <v-dialog v-model="dialog" max-width="400px" persistent scrollable>
                <template v-slot:activator="{ on }">
                    <v-btn color="primary" dark class="mb-2" v-on="on" >
                        New
                    </v-btn>
                </template>
                <PermissionForm
                        v-if="dialog"
                        :permissionFormDialog.sync="dialog"
                ></PermissionForm>
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

        <template v-slot:item.buttons="{ item }">
            <v-tooltip bottom>
            <template v-slot:activator="{ on }">
                <v-btn
                    v-on="on"
                    text
                    icon
                    dark
                    color="primary"
                    @click="editPermission(item)"
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
                        @click="setDeletePermission(item)"
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

    <DeleteConfirmDialog 
        v-if = "deleteDialog"
        :deleteDialog.sync = "deleteDialog"
        @refresh = 'initialize'
    ></DeleteConfirmDialog>

    </div>
</template>
<script>
import DeleteConfirmDialog from '@/js/views/permissions/deleteConfirmDialog';
import PermissionForm from '@/js/views/permissions/form';

export default {
    components: {
        DeleteConfirmDialog,
        PermissionForm,        
    },
    data: () => ({ 
        search: '',       
        loading: true,
        dialog: false,
        deleteDialog: false,
        headers: [
            { text: 'Id', value: 'id' },
            { text: 'Permission', value: 'name',},            
            { text: 'Code', value: 'code' },
            { text: 'Description', value: 'description'},
            { text: 'Action', value: 'action'},
            { text: 'Actions', value: 'buttons', sortable: false ,filterable: false},
        ],
        permissions: [],
        permissionIndex: -1,
        permission: {},
    }),

    computed: {
        formTitle () {            
            return this.permissionIndex === -1 ? 'New Permission' : 'Edit Permission'
        },
        permissionList () {  
            this.permissions = this.$store.getters.permissions;
            return this.permissions;          
        },  
    },

    watch: {
        dialog (val) {                
            val || this.close()         
        },
        deleteDialog(val) {
            if(!val) {
                this.closeDeleteDialog()
                this.initialize()
            }
        },

    },

    created () {
        this.initialize()
    },

    methods: {
      
        initialize () { 
            this.loading = true
            this.$store.dispatch('fetchPermissions')
            .then(()=> {
                this.loading = false
            });               
        },

        editPermission (item) {        
            this.permissionIndex       = this.permissions.indexOf(item);
                        
            this.$store.commit('SET_PERMISSION', item)

            this.dialog = true;
        },

        setDeletePermission (item) {    
            this.permissionIndex = this.permissions.indexOf(item);

            this.$store.commit('SET_PERMISSION', item)

            this.deleteDialog = true;
        },

        close () {
            this.dialog = false
            this.permission = {}
            this.$store.commit('CLEAR_PERMISSION')
            this.permissionIndex = -1 
            this.initialize()       
        },
    
        closeDeleteDialog() {
            this.deleteDialog = false
            this.permission = {}
            this.$store.commit('CLEAR_PERMISSION')
            this.permissionIndex = -1
        },
    },
  }
</script>