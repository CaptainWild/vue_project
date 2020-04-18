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
        :items="checkList"        
        sort-by="id"
        sort-desc
        class="elevation-1"
        :loading="loading"
        :search="search"
    >
        <template v-slot:top>      
            <v-toolbar flat > 
            <v-toolbar-title>
                Checklists PTW
            </v-toolbar-title>
            <v-divider
                class="mx-4"
                inset
                vertical
            ></v-divider>
            
            <v-spacer></v-spacer> 
                            
            <v-dialog v-model="dialog" max-width="500px" persistent>
                <template v-slot:activator="{ on }">
                    <v-btn v-show="$can.permit('checklist_create')" color="primary" dark class="mb-2" v-on="on" >
                        New
                    </v-btn>
                </template>
                
                <v-card>
                <v-form @submit.prevent="save" ref="form" lazy-validation v-model="valid">
                <v-card-title>
                    <span class="headline">{{ formTitle }}</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field 
                                :rules="[v => !!v || 'This field is required']"
                                required                              
                                clearable 
                                v-model="checklist.name" 
                                label="*Name"
                                type="text"                           
                            ></v-text-field>
                        </v-col>                              
                        <v-col cols="12">
                            <v-textarea 
                                auto-grow 
                                clearable 
                                v-model="checklist.description" 
                                rows="1"
                                label="Remarks">
                            </v-textarea>
                        </v-col>
                        <v-col cols="12">
                              <ChecklistGroupPulldown
                                  v-model="checklist.checklist_group_id"
                              ></ChecklistGroupPulldown>
                        </v-col>
                        <!-- <v-col cols="12">                        
                            <v-checkbox 
                                v-model ="checklist.is_active" 
                                label="Active"
                            ></v-checkbox>  
                        </v-col>                         -->
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
                        :loading="loading"
                    >Save</v-btn>
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

        <!-- <template v-slot:item.is_active="{ item }">
            <span class ="green--text" v-if="item.is_active">Active</span>
            <span class ="red--text" v-else>Inactive</span>
        </template> -->

        <template v-slot:item.action="{ item }">
        <v-tooltip bottom>
            <template v-slot:activator="{ on }">
            <v-btn
                v-show="$can.permit('checklist_edit')" 
                v-on="on"
                text
                icon
                dark
                color="primary"
                @click="editChecklist(item)"
            >
                <v-icon> mdi-file-edit</v-icon>
            </v-btn>
        </template>
        <span>Edit</span>
        </v-tooltip>
        
        <v-tooltip bottom>
        <template v-slot:activator="{ on }">  
            <v-btn 
                v-show="$can.permit('checklist_delete')"
                v-on="on"
                text 
                icon 
                dark
                color="error"
                @click="setDeleteChecklist(item)"
            >
            <v-icon>mdi-delete</v-icon>
            </v-btn>
            </template>
            <span>Delete</span>
        </v-tooltip>

        <v-tooltip bottom>
        <template v-slot:activator="{ on }">  
            <v-btn 
                v-show="$can.permit('checklist_edit')" 
                v-on="on"
                text 
                icon 
                dark
                color="info"
                @click="checklistItems(item)"
                >
                <v-icon>mdi-format-list-checks</v-icon>
            </v-btn>
            </template>
            <span>Checklist Items</span>
        </v-tooltip>

        <v-tooltip bottom>
        <template v-slot:activator="{ on }">  
            <v-btn 
                v-show="$can.permit('')" 
                v-on="on"
                text 
                icon 
                dark
                color="secondary lighten-3"
                @click="mapLegends(item)"
                >
                <v-icon>mdi-map-legend</v-icon>
            </v-btn>
            </template>
            <span>Map Legends</span>
        </v-tooltip>
        </template>

        <template v-slot:item.name="{ item }">
            <span v-if="item.version_index > 0">{{ item.name }}.v{{item.version_index}}</span>
            <span v-else>{{ item.name }}</span>
        </template>

        <template v-slot:loading>
        <span>Fetching Data...</span>
        </template>
    </v-data-table>

    <LegendsDialog
        v-if="legendsDialog"
        :legendsDialog.sync = "legendsDialog"
        @refresh='initialize'
    ></LegendsDialog>

    <ItemsDialog
        v-if="itemsDialog"
        :itemsDialog.sync="itemsDialog"
        @refresh="initialize"
    ></ItemsDialog>

    <DeleteRemarkDialog 
      v-if="deleteRemarkConfirmDialog"  
      :deleteRemarkConfirmDialog.sync = "deleteRemarkConfirmDialog"
       @refresh= "closeDeleteRemarkConfirmDialog"
    ></DeleteRemarkDialog> 
  
  </div> 
</template>

<script>
import ChecklistGroupPulldown from '@/js/views/checklistgroups/pulldown';
import Form from '@/js/core/form';
import LegendsDialog from '@/js/views/legends/listDialog';
import ItemsDialog from '@/js/views/checklists/itemDialog';
import DeleteRemarkDialog from '@/js/views/checklists/deleteRemarkDialog';

export default {
    components: {
        ChecklistGroupPulldown,
        LegendsDialog,
        ItemsDialog,
        DeleteRemarkDialog,
    },

    data: () => ({ 
        checklists: [],
        checklistIndex: -1,
        deleteRemarkConfirmDialog: false,
        checklist: new Form({
            name: '',
            checklist_group_id: 0,
            description: '',
            is_active: 0,
        }),
        dialog: false,        
        headers: [
            { text: 'S/No.', value: 'id' },
            { text: 'Name', value: 'name',},            
            { text: 'Remarks', value: 'description', align: 'left' },
            { text: 'Group', value: 'checklistgroup.name'},
            // { text: 'Status', value: 'is_active' },
            { text: 'Actions', value: 'action', sortable: false, filterable: false },
        ],
        itemsDialog: false,
        legendsDialog: false,               
        loading: true,
        search: '',
        valid: true,
    }),

    computed: {
        formTitle () {
            return this.checklistIndex === -1 ? 'New Checklist PTW' : 'Edit Checklist PTW'
        },      
        checkList () {  
          this.checklists = this.$store.getters.checklists;
          return this.checklists;          
        }     
    },

    watch: {
        dialog (val) {                
            val || this.close()        
        },
    },

    created () {
        this.initialize()
    },

    methods: {

        initialize () { 
            this.loading = true
            this.$store.dispatch('fetchChecklists',this.checklist)
            .then(()=> {
                this.loading = false
            });               
        },

        editChecklist(item) {        
            this.checklistIndex       = this.checklists.indexOf(item);
            
            this.checklist.id         = item.id;
            this.checklist.name       = item.name;
            this.checklist.description= item.description;
            this.checklist.checklist_group_id= item.checklist_group_id;
            this.checklist.is_active  = item.is_active;
    
            this.dialog = true;
        },

        setDeleteChecklist (item) {
            this.$store.commit('SET_CHECKLIST', item)
            this.deleteRemarkConfirmDialog = true;
        },
        
        close () {
            this.dialog = false
            this.$refs.form.reset()
            this.checklist.reset()
            this.checklistIndex = -1        
        },

        closeDeleteRemarkConfirmDialog() {
            this.deleteRemarkConfirmDialog = false
            this.checklist.reset()
            this.checklistIndex = -1
            this.initialize()
        },

        save () { 
            if(this.$refs.form.validate()) {
                this.loading = true       
                var action = 'createChecklist';
                if (this.checklistIndex > -1) {
                    action = 'updateChecklist'
                } 

                this.$store.dispatch(action,this.checklist)
                    .then(response => {               
                        this.close()
                        this.initialize()            
                        setTimeout(() => {                
                            this.$store.commit('closeSnackbar');
                        },2000);              
                }).catch(()=> {this.loading = false});      
            }
            
        },
      
        checklistItems(item) { 
            this.$store.commit('SET_CHECKLIST', item)

            this.itemsDialog = true
        },
        
        mapLegends(item) {        
            this.$store.commit('SET_CHECKLIST_LEGENDS', item)
            
            this.legendsDialog = true
        }
    },
}
</script>