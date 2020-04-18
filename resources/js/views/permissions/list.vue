<template>
    <v-dialog v-model ="permissionsDialog" max-width="900px" persistent scrollable>
    <v-card>
        <v-card-title>
            {{role.name}} Permissions
            <v-spacer></v-spacer>    
            <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Search"
                single-line
                hide-details
                clearable
            ></v-text-field>                
        </v-card-title>
        <v-card-text>
            <v-data-table
                :headers="headers"
                :items="permissionList"        
                sort-by="id"
                sort-desc
                show-select
                :loading="loading"
                v-model="selected"
                :search="search"
                @item-selected="rowSelected"  
                @toggle-select-all="toggleAll"              
            >
                <template v-slot:loading>
                    <span>Fetching Data...</span>
                </template>
            </v-data-table>
        </v-card-text>
        <v-card-actions>
            <v-btn
                color="secondary darken-1" 
                raised 
                @click="close"
                >Close</v-btn>
         <v-spacer></v-spacer>
        </v-card-actions>
    </v-card>      
    </v-dialog>
</template>
<script>

export default {   
    props: [
        'permissionsDialog'
    ],
    data: () => ({ 
        search: '',       
        loading: true,
        dialog: false,
        headers: [
            { text: 'Id', value: 'id' },
            { text: 'Permission', value: 'name',},            
            { text: 'Code', value: 'code' },
            { text: 'Description', value: 'description'},
            { text: 'Action', value: 'action'},
            { text: 'Group', value: 'mod_group'},
        ],
        permissions: [],        
        role: {},
        selected: [],
    }),

    computed: {      
        permissionList () {  
            this.permissions = this.$store.getters.permissions;
            return this.permissions;          
        },  
    },

    created () {
        this.role = Object.assign({}, this.$store.getters.role)
        this.initialize()
    },

    methods: {
        close() {
            this.$store.commit('CLEAR_ROLE')
            this.$emit('update:permissionsDialog', false)
        },
      
        initialize () { 
            this.loading = true
            this.$store.dispatch('fetchPermissions')
            .then(()=> {
                this.loading = false
                this.rolePermissions()
            });               
        },

        rowSelected (row) {
            this.$store.dispatch('togglePermissionRole', {id:row.item.id, value: row.value, role_id: this.role.id})
            .then(response => {
                 setTimeout(() => {                
                        this.$store.commit('closeSnackbar');
                    },1000);   
            }).catch(error => {console.log(error)});
        },

        toggleAll(val) {            
             this.$store.dispatch('toggleAllPermissionRole', {value: val.value, role_id: this.role.id})
            .then(response => {
                 setTimeout(() => {                
                        this.$store.commit('closeSnackbar');
                    },2000);   
            }).catch(error => {console.log(error)});
        },

        rolePermissions() {
            var permissions =  this.$store.getters.permissions;
            
            for(var permission of permissions) {              
                var result = _.find(this.role.permissions, function (o) {
                    return o.id == permission.id
                });
                
                if(result != undefined) {
                    this.selected.push(permission);
                }
            }
        }
    },
  }
</script>