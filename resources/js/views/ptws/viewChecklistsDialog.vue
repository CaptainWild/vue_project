<template>
<v-dialog v-model="checklistsDialog" max-width="700" persistent scrollable>
     <v-card>
        <v-card-title class="headline"></v-card-title>      
        <v-card-text>   
        <v-data-table
            :headers="headers"
            :items="checklists"
            disable-pagination
            hide-default-footer        
            sort-by="id"
            sort-desc
            class="elevation-1"
            :loading="loading"
            :search="search"       
        >
            <template v-slot:top>      
            <v-toolbar flat > 
                <v-toolbar-title>
                    Checklists
                </v-toolbar-title>
                <v-divider
                    class="mx-4"
                    inset
                    vertical
                ></v-divider>
                
                <v-spacer></v-spacer> 
                
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Search Checklists"
                    single-line
                    hide-details
                    clearable
                ></v-text-field>  
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
                        color="info"
                        @click="checklistItems(item)"
                        >
                        <v-icon>mdi-format-list-checks</v-icon>
                    </v-btn>
                    </template>
                    <span>Checklist Items</span>
                </v-tooltip>

            </template>

            <template v-slot:loading>
            <span>Fetching Data...</span>
            </template>
        </v-data-table>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn 
                color="secondary" 
                raised 
                @click="$emit('update:checklistsDialog', false)"
            >
            Close
            </v-btn>
        </v-card-actions>
    
        <ItemsDialog
            v-if="itemsDialog"
            :itemsDialog.sync="itemsDialog"            
        ></ItemsDialog>
  
     </v-card>
     
</v-dialog> 
</template>

<script>
import Form from '@/js/core/form';
import ItemsDialog from '@/js/views/checklists/itemDialog';

export default {
    components: {
        ItemsDialog,
    },
    props: {checklistsDialog : Boolean},
    data: () => ({         
        headers: [
            { text: 'Id', value: 'id' },
            { text: 'Name', value: 'name',},            
            { text: 'Description', value: 'description', align: 'left' },
            { text: 'Actions', value: 'action', sortable: false, filterable: false },
        ],
        inspectionchecklists: [],
        itemsDialog: false,        
        loading: true,
        search: '',
        
    }),

    computed: {         
        checklists () {  
            var ptwinspectionchecklists = this.$store.getters.ptw.inspectionchecklists

            for(var ptwinspectionchecklist of ptwinspectionchecklists) {
                this.inspectionchecklists.push(ptwinspectionchecklist.checklist);
            }
            this.loading = false
            
            return this.inspectionchecklists;          
        }     
    },

    methods: {
        checklistItems(item) { 
            this.$store.commit('SET_CHECKLIST', item)

            this.itemsDialog = true
        },
     
    },
}
</script>