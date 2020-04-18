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
                :items="inspectioncheckList"        
                sort-by="id"
                sort-desc
                class="elevation-1"
                :loading="loading"
                :search="search"
            >
            <template v-slot:top>      
                <v-toolbar flat > 
                <v-toolbar-title>
                    Inspection Checklists
                </v-toolbar-title>
                <v-divider
                    class="mx-4"
                    inset
                    vertical
                ></v-divider>
                
                <v-spacer></v-spacer> 
                                
                <v-dialog v-model="dialog" max-width="700px" persistent scrollable>
                    <template v-slot:activator="{ on }">
                        <v-btn color="primary" dark class="mb-2" v-on="on" >
                            New
                        </v-btn>
                    </template>
                        <InspectionChecklistForm
                            v-if="dialog"
                            :inspectionChecklistDialog.sync="dialog"
                            @refresh="initialize"
                        ></InspectionChecklistForm>
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

            <template v-slot:item.start_date="{ item }">
                <span>{{new Date(item.start_date).toLocaleDateString()}}</span>
            </template>

            <template v-slot:item.end_date="{ item }">
                <span>{{new Date(item.end_date).toLocaleDateString()}}</span>
            </template>

            <template v-slot:item.checklist_id="{item}">
                <span>{{ item.checklist.name}} </span>
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
                    @click="editInspectionChecklist(item)"
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
                @click="setDeleteInspectionChecklist(item)"
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
                @click="inspectionChecklistItems(item)"
                >
                <v-icon>mdi-format-list-checkbox</v-icon>
                </v-btn>
                </template>
                <span>Inspection Dates</span>
            </v-tooltip>
            </template>
            <template v-slot:loading>
            <span>Fetching Data...</span>
            </template>
        </v-data-table>
  
    <DeleteConfirmDialog 
        v-if="deleteDialog"
        :deleteDialog.sync = "deleteDialog"
        @refresh = "initialize"
    ></DeleteConfirmDialog>

    <InspectionChecklistItemDialog
        v-if="itemDialog"
        :itemsDialog.sync="itemDialog"
        @refresh = "initialize"
    ></InspectionChecklistItemDialog>
  
  </div> 
</template>

<script>
import Form from '@/js/core/form';
import InspectionChecklistForm from '@/js/views/inspectionchecklists/form';
import DeleteConfirmDialog from '@/js/views/inspectionchecklists/deleteConfirmDialog';
import InspectionChecklistItemDialog from '@/js/views/inspectionchecklists/itemDialog';

export default {
    components: {        
        DeleteConfirmDialog,        
        InspectionChecklistForm,
        InspectionChecklistItemDialog
    },

    data: () => ({ 
        deleteDialog: false,
        dialog: false,        
        headers: [
            { text: 'Id', value: 'id' },
            { text: 'Inspection Checklist', value: 'checklist_id',},            
            { text: 'Location', value: 'location'},
            { text: 'Work to be done', value: 'work_to_be_done'},
            { text: 'Start Date', value: 'start_date' },
            { text: 'End Date', value: 'end_date' },
            { text: 'Actions', value: 'action', sortable: false, filterable: false },
        ],
        inspectionChecklists: [],
        inspectionChecklistIndex: -1,
        inspectionChecklist: new Form({
            checklist_id: 0,
            project_id: 0,
            sub_contractor_id: 0,
            start_date: null,
            start_time: null,
            end_date: null,
            end_time: null,
            location: '',
            work_to_be_done: '',
            remarks:'',
            supervisor_only: 0,
        }),
        itemDialog: false,      
        loading: true,
        search: '',         
    }),

    computed: {
        formTitle () {
            return this.inspectionChecklistIndex === -1 ? 'New Inspection Checklist' : 'Edit Inspection Checklist'
        },      
        inspectioncheckList () {  
          this.inspectionChecklists = this.$store.getters.inspectionchecklists;
          return this.inspectionChecklists;          
        }     
    },

    watch: {
        dialog (val) {                
            val || this.close()        
        },
        itemDialog (val) {                
            val || this.close()        
        }    
    },

    created () {
      this.initialize()
    },

    methods: {

      initialize () { 
        this.loading = true
        this.$store.dispatch('fetchInspectionChecklists',this.inspectionChecklist)
          .then(()=> {
            this.loading = false
          });               
      },

      editInspectionChecklist (item) {        
        this.inspectionChecklistIndex = this.inspectionChecklists.indexOf(item);
       
        this.$store.commit('SET_INSPECION_CHECKLIST', item)
        
        this.dialog = true;
      },

      setDeleteInspectionChecklist (item) {  
        this.inspectionChecklistIndex = this.inspectionChecklists.indexOf(item);
        
        this.$store.commit('SET_INSPECION_CHECKLIST', item)
        
        this.deleteDialog = true;
      },
    
      close () {
        this.$store.commit('RESET_INSPECTION_CHECKLIST')
        this.inspectionChecklistIndex = -1        
      },
      
      inspectionChecklistItems(item) {
        this.$store.commit('SET_INSPECION_CHECKLIST', item)
        
        this.itemDialog = true
      },

    },
}
</script>