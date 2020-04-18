<template>
<div>   
    <v-data-table
        :headers="headers"
        :items="inspectionChecklistItemsList"
        :loading="tableLoader"
        class="elevation-1"
        :items-per-page="5"
    >

    <template v-slot:item.inspection_checklist_item_status_id="{ item }">
        <span class ="blue--text" v-if="item.inspection_checklist_item_status_id==0">New</span>
        <span class ="green--text" v-else-if="item.inspection_checklist_item_status_id==1">{{item.inspectionchecklistitemstatus.name}}</span>
        <span class ="orange--text" v-else-if="item.inspection_checklist_item_status_id==2">{{item.inspectionchecklistitemstatus.name}}</span>
        <span class ="red--text" v-else-if="item.inspection_checklist_item_status_id==4">{{item.inspectionchecklistitemstatus.name}}</span>        
        <span v-else>{{item.inspectionchecklistitemstatus.name}}</span>
    </template>

    <template v-slot:item.inspection_date="{ item }">
        <span>{{new Date(item.inspection_date).toLocaleDateString()}}</span>
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
                @click="inspectionChecklistItem(item)"                 
            ><v-icon>mdi-checkbox-multiple-marked-circle-outline</v-icon></v-btn>
        </template>
        <span>Update Checklist</span>
        </v-tooltip>

        <v-tooltip bottom>
        <template v-slot:activator="{ on }">        
            <v-btn 
                v-show="item.inspection_checklist_item_status_id != 4 ? true : false"
                v-on="on"
                text 
                icon 
                dark
                color="error darken-1" 
                @click="markAsNoActivity(item)"               
            ><v-icon>mdi-cancel</v-icon></v-btn>
        </template>
        <span>Mark as No Activity</span>
        </v-tooltip>

        <!-- <v-tooltip bottom>
        <template v-slot:activator="{ on }">        
            <v-btn 
                v-on="on"
                text 
                icon 
                dark
                color="primary"                
            ><v-icon>mdi-file-edit</v-icon></v-btn>
        </template>
        <span>Edit</span>
        </v-tooltip> -->

    </template>
    </v-data-table>

    <InspectionChecklistItemsDialog
        v-if="inspectionChecklistItemDialog"
        :inspectionChecklistItemDialog.sync = "inspectionChecklistItemDialog"
        @refresh="reload"
    ></InspectionChecklistItemsDialog>

    <NoActivityConfirmDialog
        v-if="noActivityDialog"
        :checklistNoActivityDialog.sync = "noActivityDialog"
        @refresh="reload"
    ></NoActivityConfirmDialog>

    </div>
</template>

<script>
import Form from '@/js/core/form';
import InspectionChecklistItemsDialog from '@/js/views/inspectionchecklistitems/itemsDialog';
import NoActivityConfirmDialog from '@/js/views/inspectionchecklistitems/noactConfirmationDialog';

export default {
    components: {
        InspectionChecklistItemsDialog,
        NoActivityConfirmDialog        
    },
    props: ['value'],
    data () {
        return {
            headers: [
                { text: 'Id', value: 'id' },
                { text: 'Inspection Date', value: 'inspection_date' },               
                { text: 'Status', value: 'inspection_checklist_item_status_id' },
                { text: 'Remarks', value: 'remarks' },
                { text: 'Actions', value: 'action', sortable: false, filterable: false },
            ],            
            inspectionchecklistItems: [],
            inspectionChecklistItemDialog: false, 
            loading: false,
            noActivityDialog: false,              
            tableLoader:false,
        }
    },

    computed: {   
        inspectionChecklistItemsList () {  
            return this.inspectionchecklistItems;          
        },          
    },

    created() {
       this.inspectionchecklistItems = this.$store.getters.inspectionchecklist.inspectionchecklistitems;
    },
    
    methods: {        
        inspectionChecklistItem(item) {
            this.$store.commit('SET_INSPECTION_CHECKLIST_ITEM', item)            
            this.inspectionChecklistItemDialog = true
        },
        markAsNoActivity(item) {
            this.$store.commit('SET_INSPECTION_CHECKLIST_ITEM', item)            
            this.noActivityDialog = true
        },
        reload() {
            this.$emit('refresh')
        }
    }
}
</script>