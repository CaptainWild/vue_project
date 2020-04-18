<template>
    <div>
    <v-card>
        <v-card-title>List of Positive Observation</v-card-title>
        <v-card-text>
            <v-data-table
                :headers="headers"
                :items="inspectionItemsPositiveComputed"
                :loading="tableLoader"
                v-model="selectedPos"
            >

            <template v-slot:item.site="{ item }">      
                <span>{{item.block}} / {{item.unit}} / {{item.storey}}</span> 
            </template>

             <template v-slot:item.action="{ item }">                    
                    <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                    <v-btn 
                        v-show="$can.permit('inspection_details_delete')"
                        v-on="on"
                        text 
                        icon 
                        dark
                        color="error"
                        @click="setDetailDelete(item,'positive')"
                    >
                        <v-icon>mdi-delete</v-icon>
                    </v-btn>
                    </template>
                    <span>Delete</span>
                    </v-tooltip>

                    <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                            <v-btn 
                                v-show="$can.permit('inspection_view')"
                                v-on="on"
                                text 
                                icon 
                                dark
                                color="info"
                            >
                                <v-icon>mdi-eye</v-icon>
                            </v-btn>
                        </template>
                    <span>View Detail</span>
                    </v-tooltip>

             </template>
            </v-data-table>
        </v-card-text>

        <v-card-title>List of Negative Observation</v-card-title>
        <v-card-text>
            <v-data-table
                :headers="headers"
                :items="inspectionItemsNegativeComputed"
                :loading="tableLoader"
                v-model="selectedNeg"
            >

            <template v-slot:item.site="{ item }"> 
                <span v-if="item.block =='' && item.unit == '' && item.storey == ''"></span>     
                <span v-else>{{item.block}} / {{item.unit}} / {{item.storey}}</span> 
            </template>

             <template v-slot:item.action="{ item }">                    
                    <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                    <v-btn 
                        v-show="$can.permit('inspection_details_delete')"
                        v-on="on"
                        text 
                        icon 
                        dark
                        @click="setDetailDelete(item,'negative')"
                        color="error"
                    >
                        <v-icon>mdi-delete</v-icon>
                    </v-btn>
                    </template>
                    <span>Delete</span>
                    </v-tooltip>

                    <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                            <v-btn
                                v-show="$can.permit('inspection_view')" 
                                v-on="on"
                                text 
                                icon 
                                dark
                                color="info"
                                @click="viewDetails(item)"
                            >
                                <v-icon>mdi-eye</v-icon>
                            </v-btn>
                        </template>
                    <span>View Detail</span>
                    </v-tooltip>

                     <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                            <v-btn 
                                v-show="$can.permit('inspection_rectify')" 
                                v-on="on"
                                text 
                                icon 
                                dark
                                color="indigo"                               
                            >
                                <v-icon>mdi-hammer-wrench</v-icon>
                            </v-btn>
                        </template>
                    <span>Rectify</span>
                    </v-tooltip>
             </template>
            </v-data-table>
        </v-card-text>
    </v-card>

    <DeleteConfirmDialog
        v-if = "deleteDialog"
        :inspectionDetail = "inspectiondetail"
        :deleteDialog.sync = "deleteDialog"
        :deleted.sync = "deleted" 
        @deleted = "removeItem"
    ></DeleteConfirmDialog>

    <ViewDialog
        v-if="viewDialog"
        :viewDialog.sync="viewDialog"
        :inspectionDetail = "inspectiondetail"
    ></ViewDialog>

    </div>
</template>

<script>
import DeleteConfirmDialog from '@/js/views/inspectiondetails/deleteConfirmDialog';
import ViewDialog from '@/js/views/inspectiondetails/viewDialog';

export default {
    components: {
        DeleteConfirmDialog,
        ViewDialog
    },
    props: [
        'inspectionId'
    ],
    data: () => ({         
        deleteDialog: false,
        deleted: false,
        headers: [
            { text: 'Id', value: 'id' },
            { text: 'Site', value: 'site',},            
            { text: 'Inspection Type', value: 'inspectiontype.name'},   
            { text: 'Sub Contractor', value: 'subcontractor.name'},
            { text: 'Response', value: 'response'},
            // { text: 'Remarks', value: 'photo_remarks'},
            { text: 'Actions', value: 'action', sortable: false ,filterable: false},
        ],
        inspectionDetailIndex: -1,
        inspectiondetail: {},
        loading: true,
        observation: '',
        rectifyDialog: false,
        search: '',
        selectedPos: [],
        selectedNeg: [],        
        tableLoader: false,
        viewDialog: false,
    }),
    computed: {     
        inspectionItemsPositiveComputed() {
            return this.$store.getters.posinspectionitems
        },
        inspectionItemsNegativeComputed() {
            return this.$store.getters.neginspectionitems
        }
    },

    watch: {    
        deleteDialog(val) {
            if(!val && this.deleted) {              
                this.removeItem()
                this.deleted = false   
                
            } else if(!val) {
                this.observation = ""
                this.inspectionDetailIndex = -1
            }            
        },  
    },

    methods: {

        rectify(item) {
            this.rectifyDialog = true
        },

        removeItem() {
            if(this.observation == 'positive') {
                this.inspectionItemsPositiveComputed.splice(this.inspectionDetailIndex, 1)
            } else {
                this.inspectionItemsNegativeComputed.splice(this.inspectionDetailIndex, 1)
            }                
        },

        setDetailDelete(item,observation) {
            this.observation = observation

            this.inspectionDetailIndex = this.inspectionItemsNegativeComputed.indexOf(item)
            if(observation == 'positive') {
                this.inspectionDetailIndex = this.inspectionItemsPositiveComputed.indexOf(item)
            }
            
            this.inspectiondetail = item

            this.deleteDialog = true
        },
        
        viewDetails(item) {
               
            this.inspectiondetail = item

            this.viewDialog = true
        }
    }
}
</script>