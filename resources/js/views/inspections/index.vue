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
        :items="inspectionList"        
        sort-by="id"
        sort-desc
        class="elevation-1"
        :loading="loading"
        :search="search"
    >
        <template v-slot:top>      
            <v-toolbar flat > 
            <v-toolbar-title>
                Inspections
            </v-toolbar-title>
            <v-divider
                class="mx-4"
                inset
                vertical
            ></v-divider>
            
            <v-spacer></v-spacer> 
                            
            <v-dialog v-model="dialog" max-width="400px" persistent scrollable>
                <template v-slot:activator="{ on }">
                    <v-btn v-show="$can.permit('inspection_create')" color="primary" dark class="mb-2" v-on="on" >
                        New
                    </v-btn>
                </template>
                <InspectionForm
                        v-if="dialog"
                        :inspectionFormDialog.sync="dialog"
                ></InspectionForm>
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

        <template v-slot:item.project_id="{ item }">
            <span>{{item.project.title}}</span>
        </template>

        <template v-slot:item.inspection_date="{ item }">
            <span>{{new Date(item.inspection_date).toLocaleDateString()}}</span>
        </template>

        <template v-slot:item.total="{ item }">
            <v-chip class="ma-2" color="success">{{getDetailCount(item.inspectiondetails,2)}}</v-chip>/
            <v-chip class="ma-2" color="error">{{getDetailCount(item.inspectiondetails,1)}}</v-chip>            
        </template>

        <template v-slot:item.responded="{ item }">
            <v-chip class="ma-2" color="info">{{getResponded(item.inspectiondetails)}}</v-chip>/
            <v-chip class="ma-2" color="error">{{getDetailCount(item.inspectiondetails,1)}}</v-chip>            
        </template>

        <template v-slot:item.action="{ item }">
            <v-tooltip bottom>
            <template v-slot:activator="{ on }">
                <v-btn
                v-show="$can.permit('inspection_edit')"
                v-on="on"
                text
                icon
                dark
                color="primary"
                @click="editInspection(item)"
                >
                <v-icon> mdi-file-edit</v-icon>
                </v-btn>
            </template>
            <span>Edit</span>
            </v-tooltip>

            <!-- <v-tooltip bottom>
            <template v-slot:activator="{ on }">
            <v-btn 
                v-on="on"
                text 
                icon 
                dark
                color="error"
                @click="setDeleteInspection(item)"
            >
                <v-icon>mdi-delete</v-icon>
            </v-btn>
            </template>
            <span>Delete</span>
            </v-tooltip> -->

            <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                <v-btn 
                    v-show="$can.permit('inspection_view')"
                    v-on="on"
                    text 
                    icon 
                    dark
                    color="pink"
                    @click="details(item)"
                >
                <v-icon>mdi-format-list-bulleted</v-icon>
                </v-btn>
                </template>
                <span>Inspection Details</span>
            </v-tooltip> 
            
            <v-tooltip bottom>
            <template v-slot:activator="{ on }">
                <v-btn
                v-show="$can.permit('project_view')"
                v-on="on"
                text
                icon
                dark
                color="info"
                @click="ptwLinks(item)"
                >
                <v-icon>mdi-link</v-icon>
                </v-btn>
            </template>
            <span>PTW Links</span>
            </v-tooltip>
            
            <v-tooltip bottom>
            <template v-slot:activator="{ on }">
                <v-btn
                    v-show="$can.permit('inspection_close') && item.status!='Closed'"
                    v-on="on"
                    text
                    icon
                    dark
                    color="success"
                    @click="closeInspection(item)"
                >
                <v-icon>mdi-check-outline</v-icon>
                </v-btn>
            </template>
            <span>Close</span>
            </v-tooltip>

            <v-tooltip bottom>
            <template v-slot:activator="{ on }">
                <v-btn
                v-show="$can.permit('inspection_view') && item.status=='Draft'"
                v-on="on"
                text
                icon
                dark
                color="amber darken-1"
                @click="sendInspection(item)"
                >
                <v-icon>mdi-send</v-icon>
                </v-btn>
            </template>
            <span>Send to Sub-Contractors</span>
            </v-tooltip>

        </template>
      
        <template v-slot:loading>
            <span>Fetching Data...</span>
        </template>
    </v-data-table>

    <CloseConfirmDialog
        v-if="closeConfirmDialog"
        :inspectionId = "inspection.id"
        :formSignDialog.sync = closeConfirmDialog
         @refresh = 'initialize'>
    </CloseConfirmDialog>

    <PtwListDialog
        v-if= "ptwsLinkDialog"
        :ptwsLinkDialog.sync = "ptwsLinkDialog"
        :projectId = "inspection.project_id"
        :projectName = "inspection.project_name"
        :inspectionDate = "inspection.inspection_date"
    ></PtwListDialog>

    <SendInspectionConfirmDialog
        v-if = "sendDialog"
        :inspectionId = "inspection.id"
        :sendDialog.sync = "sendDialog"
        @refresh = 'initialize' >
    </SendInspectionConfirmDialog>

    <InspectionDetailsDialog
        v-if = "dialogDetails"         
        :inspectionId = "inspection.id"
        :dialogDetails.sync = "dialogDetails"
        @close = "closeDetails"
    ></InspectionDetailsDialog> 

    <!-- <DeleteConfirmDialog 
        v-if = "deleteDialog"
        :deleteDialog.sync = "deleteDialog"
        @refresh = 'initialize'
    ></DeleteConfirmDialog>

    <DeleteRemarkDialog 
      :inspection = "inspection"      
      :deleteRemarkConfirmDialog.sync = "deleteRemarkConfirmDialog"
    ></DeleteRemarkDialog>  -->

    </div>
</template>
<script>
import CloseConfirmDialog from '@/js/views/inspections/closeConfirmDialog';
//import DeleteConfirmDialog from '@/js/views/inspections/deleteConfirmDialog';
import InspectionForm from '@/js/views/inspections/form';
import InspectionDetailsDialog from '@/js/views/inspectiondetails/index';
import PtwListDialog from '@/js/views/projects/ptwListDialog';
import SendInspectionConfirmDialog from '@/js/views/inspections/sendConfirmDialog';
// import DeleteRemarkDialog from '@/js/views/inspections/deleteRemarkDialog';

  export default {
    components: {
        CloseConfirmDialog,
        // DeleteConfirmDialog,
        InspectionDetailsDialog,        
        InspectionForm,
        PtwListDialog,
        SendInspectionConfirmDialog,
        // DeleteRemarkDialog,
    },
    data: () => ({ 
        search: '',       
        loading: true,
        closeConfirmDialog: false,
        dialog: false,
        dialogDetails: false,
        deleteDialog: false,
        deleteRemarkConfirmDialog: false,
        headers: [
            { text: 'Id', value: 'id' },
            { text: 'Project', value: 'project_id',},            
            { text: 'Inspection Date', value: 'inspection_date' },
            { text: 'Location', value: 'location'},
            { text: 'Status', value: 'status'},
            { text: 'Total Positive & Negative', value: 'total', sortable: false ,filterable: false},
            { text: 'Number of Response', value: 'responded', sortable: false ,filterable: false},
            { text: 'Actions', value: 'action', sortable: false ,filterable: false},
        ],
        inspections: [],
        inspectionIndex: -1,
        inspection: {},
        ptwsLinkDialog: false,
        sendDialog: false,
    }),

    computed: {
        formTitle () {            
            return this.inspectionIndex === -1 ? 'New Inspection' : 'Edit Inspection'
        },
        inspectionList () {  
            this.inspections = this.$store.getters.inspections;
            return this.inspections;          
        },  
    },

    watch: {
      dialog (val) {                
        val || this.close()         
      },
    //   deleteDialog(val) {
    //       if(!val) {
    //           this.closeDeleteDialog()
    //           this.initialize()
    //       }
    //   },
    //   deleteRemarkConfirmDialog(val) {
    //     if(!val) {
    //         this.closeDeleteRemarkConfirmDialog()
    //         this.initialize()
    //     }
    //   }

    },

    created () {
        this.initialize()
    },

    methods: {
      
        initialize () { 
            this.loading = true
            this.$store.dispatch('fetchInspections')
            .then(()=> {
                this.loading = false
            });               
        },

        details (item) {            
            this.inspectionIndex       = this.inspections.indexOf(item);
            
            this.inspection.id         = item.id;          
            
            this.dialogDetails = true;
        },

        sendInspection(item) {
            this.inspectionIndex       = this.inspections.indexOf(item);

            this.inspection.id         = item.id;

            this.sendDialog = true
        },

        closeInspection(item) {
            this.inspectionIndex       = this.inspections.indexOf(item);

            this.inspection.id         = item.id;

            this.closeConfirmDialog = true
        },


        editInspection (item) {        
            this.inspectionIndex = this.inspections.indexOf(item);
            
            this.$store.commit('SET_INSPECTION', item)

            this.dialog = true;
        },

        // setDeleteInspection (item) {    
        //     this.inspectionIndex = this.inspections.indexOf(item);

        //     this.$store.commit('SET_INSPECTION', item)

        //     this.deleteDialog = true;
        //     //this.deleteRemarkConfirmDialog = true;
        // },

        close () {
            this.dialog = false
            this.inspection = {}
            this.inspectionIndex = -1 
            this.initialize()       
        },
    
        // closeDeleteDialog() {
        //     this.deleteDialog = false
        //     this.inspection = {}
        //     this.inspectionIndex = -1
        // },

        closeDetails () {
            this.inspection = {}
            this.$store.commit('RESET_INSPECTION')
            this.inspectionIndex = -1 
            this.initialize()       
        },

        // closeDeleteRemarkConfirmDialog() {
        //     this.deleteRemarkConfirmDialog = false
        //     //this.inspection.reset()
        //     this.inspectionIndex = -1
        // },

        ptwLinks(item) {
            this.inspectionIndex = this.inspections.indexOf(item);

            this.inspection.project_id = item.project_id
            this.inspection.project_name = item.project.title
            this.inspection.inspection_date = item.inspection_date

            this.ptwsLinkDialog = true
        },

        getDetailCount(item, siteObservationId) {
            let result =  _.filter(item, function (o) {
                    return o.site_observation_id == siteObservationId
                });
        
            return result.length
        },

        getResponded(item){
            let result = _.filter(item, function (o) {
                    return o.site_observation_id == 1 && o.rectified_at != null
                });
        
            return result.length
        }
    },
  }
</script>