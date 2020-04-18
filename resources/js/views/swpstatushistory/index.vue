<template>
  <div>
    <v-data-table
        :headers="headers"
        :items="swpStatusHistoryItems"
        :loading="tableLoader"
        class="elevation-1"
    >

    <template v-slot:item.swp_status_id="{ item }">
        <span>{{item.swpstatuses.name}}</span>       
    </template>

    <template v-slot:item.created_by="{ item }">
        <span>{{item.creator.name}}</span>       
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
              @click="editHistory(item)"
            >
              <v-icon> mdi-file-edit</v-icon>
            </v-btn>
          </template>
          <span>Edit</span>
        </v-tooltip>

        <v-tooltip bottom>
        <template v-slot:activator="{ on }">        
            <v-btn 
                text 
                icon 
                dark
                color="error"
                @click="setDeletion(item)"
            ><v-icon>mdi-delete</v-icon></v-btn>
        </template>
        <span>Delete</span>
        </v-tooltip>

    </template>
    </v-data-table>

    <DeleteConfirmDialog 
        :swpStatusHistory = "swpStatusHistory"
        :deleteDialog.sync = "deleteDialog"
    ></DeleteConfirmDialog>

    <SwpStatusHistoryForm
        :swp = "swp"
        :swpStatusHistory = "swpStatusHistory"
        :formDialog.sync = "formDialog"
        formTitle =  "Edit Comment"
    ></SwpStatusHistoryForm>

    </div>
</template>

<script>
import Form from '@/js/core/form';
import DeleteConfirmDialog from '@/js/views/swpstatushistory/deleteConfirmDialog';
import SwpStatusHistoryForm from '@/js/views/swpstatushistory/form';

export default {
    components: {
        DeleteConfirmDialog,
        SwpStatusHistoryForm
    },
    
    props: {        
        swp: Object,
    },
    
    data () {
      return {
        deleteDialog: false, 
        formDialog: false,
        tableLoader:false,
        headers: [
            { text: 'Id', value: 'id' },
            { text: 'Comments', value: 'comments' },
            { text: 'Status', value: 'swp_status_id' },
            { text: 'Created By', value: 'created_by' },
            { text: 'Created At', value: 'created_at' },
            { text: 'Actions', value: 'action', sortable: false, filterable: false },
        ],
        swpStatusHistories: [],
        swpStatusHistoryIndex: - 1,
        swpStatusHistory: new Form({
            comments: "",
            swp_status_id: 0,
        })       
      }
    },

    computed: {   
        swpStatusHistoryItems () {  
            this.swpStatusHistories = this.$store.getters.swpStatusHistories;
            return this.swpStatusHistories;          
        },          
    },
    
    watch: {      
        deleteDialog(val) {
            if(!val) {
                this.reset()
                this.initializeHistory()
            }
        },
        formDialog(val){
            if(!val) {
                this.reset()
                this.initializeHistory()
            }
        }            
    },

    created() {
        this.initializeHistory()
    },

    methods: {
        reset () {        
            this.swpStatusHistoryIndex = -1
            this.swpStatusHistory.reset()
        },
        
        initializeHistory() {
            this.tableLoader = true;
            this.swpStatusHistory.swp_id = this.swp.id

            this.$store.dispatch('fetchSwpStatusHistory',this.swpStatusHistory)
            .then(() => {
                this.tableLoader = false;
            })
            .catch( error => {
                this.tableLoader = false;
                console.log(error);
            });
        },

         editHistory (item) {        
            this.swpStatusHistoryIndex     = this.swpStatusHistories.indexOf(item);
            
            this.swpStatusHistory.id             = item.id;
            this.swpStatusHistory.comments       = item.comments;
            this.swpStatusHistory.swp_status_id  = item.swp_status_id;
            this.swpStatusHistory.swp_status     = item.swpstatuses.name;

            this.formDialog = true;
        },

        setDeletion (item) {        
            this.swpStatusHistoryIndex     = this.swpStatusHistories.indexOf(item);
            
            this.swpStatusHistory.id       = item.id;
            this.swpStatusHistory.comments = item.comments;
            this.swpStatusHistory.swp_status   = item.swpstatuses.name;

            this.deleteDialog = true;
        },
    }
}
</script>