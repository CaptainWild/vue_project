<template>
<v-card>
    <v-card-title>Checklist Dates for PTW: (#{{ptwId}})</v-card-title> 
         <v-card-text>
        <v-data-table
            :headers="headers"
            :items="ptwChecklistItemsList"
            :loading="tableLoader"
            class="elevation-1"
            :items-per-page="5"
        >

        <template v-slot:item.ptw_checklist_status_id="{ item }">
            <span class ="blue--text" v-if="item.ptw_checklist_status_id==0">New</span>
            <span class ="green--text" v-else-if="item.ptw_checklist_status_id==1">{{item.ptwcheckliststatus.name}}</span>
            <span class ="orange--text" v-else-if="item.ptw_checklist_status_id==2">{{item.ptwcheckliststatus.name}}</span>
            <span class ="red--text" v-else-if="item.ptw_checklist_status_id==3">{{item.ptwcheckliststatus.name}}</span>        
            <span v-else>{{item.ptwcheckliststatus.name}}</span>
        </template>

        <template v-slot:item.checklist_date="{ item }">
            <span>{{new Date(item.checklist_date).toLocaleDateString()}}</span>
        </template>

        <template v-slot:item.supervisor_id="{ item }">
            <span v-if="item.supervisor_id != 0">{{item.supervisor.name}}</span>            
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
                    @click="ptwChecklistItem(item)"                 
                ><v-icon>mdi-checkbox-multiple-marked-circle-outline</v-icon></v-btn>
            </template>
            <span>Update Checklist</span>
            </v-tooltip>

            <v-tooltip bottom>
            <template v-slot:activator="{ on }">        
                <v-btn 
                    v-show="item.ptw_checklist_status_id != 3 ? true : false"
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

        </template>
        </v-data-table>
          
        <ConfirmationForm
            v-if="ptwFormSignDialog"
            :ptwFormSignDialog.sync = "ptwFormSignDialog"
            :ptw_status_id = 4
            @save="save"
        ></ConfirmationForm>
     
        <PtwChecklistItemDetailsDialog
            v-if="ptwChecklistItemDialog"
            :ptwChecklistItemDialog.sync = "ptwChecklistItemDialog"  
            @refresh="initialize"          
        ></PtwChecklistItemDetailsDialog>

       <NoActivityConfirmDialog
            v-if="noActivityDialog"
            :checklistNoActivityDialog.sync = "noActivityDialog"
            @refresh="initialize"
        ></NoActivityConfirmDialog>

        </v-card-text>
        <v-card-actions>
            <v-btn 
                color="secondary" 
                raised 
                @click="$emit('update:ptwchecklistDialog',false)"
            >
            Close            
            </v-btn>
         
            <v-spacer></v-spacer>
            <v-btn 
                v-show="new Date(lastDate).toLocaleDateString() <= new Date().toLocaleDateString() ? true : false"
                color="success darken-1" 
                raised
                @click="complete"               
            >
            Works Completed
            </v-btn>
        </v-card-actions>
</v-card>
</template>

<script>
import ConfirmationForm from '@/js/views/ptws/formSigningDialog';
import NoActivityConfirmDialog from '@/js/views/ptwchecklistitems/noactConfirmationDialog';
import PtwChecklistItemDetailsDialog from '@/js/views/ptwchecklistitemdetails/indexDialog';

export default {
    components: {
        ConfirmationForm,
        NoActivityConfirmDialog,
        PtwChecklistItemDetailsDialog,                
    },
    props: ['ptwId','ptwchecklistDialog'],
    data () {
        return {
            lastDate: '',
            headers: [
                { text: 'Id', value: 'id' },
                { text: 'Checklist Date', value: 'checklist_date' },               
                { text: 'Status', value: 'ptw_checklist_status_id' },
                { text: 'Supervisor', value: 'supervisor_id' },
                { text: 'Remarks', value: 'remarks' },
                { text: 'Actions', value: 'action', sortable: false, filterable: false },
            ],
            ptw: {},  
            ptwFormSignDialog: false,          
            ptwchecklistItems: [],
            ptwChecklistItemDialog: false, 
            loading: false,
            noActivityDialog: false,              
            tableLoader:true,
        }
    },

    computed: {   
        ptwChecklistItemsList () {  
            return this.$store.getters.ptwChecklistItems;          
        },          
    },

    created() {
        //this.ptw = Object.assign({}, this.$store.getters.ptw)
        this.initialize()
    },
    
    methods: {  
        complete() {
            this.ptwFormSignDialog = true
        },
        initialize() {
            this.$store.dispatch('fetchPtwChecklistItems',{ptw_id: this.ptwId})
            .then((response) =>  {
                this.lastDate = response[0].ptw.end_date
                this.tableLoader = false
            });
        },      
        ptwChecklistItem(item) {
            this.$store.commit('SET_PTW_CHECKLIST_ITEM', item)            
            this.ptwChecklistItemDialog = true
        },
        markAsNoActivity(item) {
            this.$store.commit('SET_PTW_CHECKLIST_ITEM', item)            
            this.noActivityDialog = true
        }, 
         
        save(confimation_data) {
            this.loading = true
            var remarks = '';

            if(confimation_data != undefined) {
               remarks =  confimation_data.remarks;                      
            }
           
            this.$store.dispatch('completePtw',{id: this.ptwId, remarks: remarks})
            .then(response => {
                this.loading = false;
                this.$emit('update:ptwchecklistDialog', false)
                this.$emit('refresh')
                setTimeout(() => {                
                    this.$store.commit('closeSnackbar');
                },2000);           
            }).catch(()=> {this.loading = false });
        },    
    }
}
</script>