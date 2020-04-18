<template>
<div>
     <v-card>
        <v-card-title>
            <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Search Checklists"
                single-line
                hide-details
                clearable
            ></v-text-field>             
        </v-card-title>
    </v-card>     
    <v-data-table
        :headers="headers"
        :items="checkList"
        disable-pagination
        hide-default-footer        
        sort-by="id"
        sort-desc
        show-select
        class="elevation-1"
        :loading="loading"
        :search="search"
        v-model ="checklists"
        @item-selected="rowSelected"
        @toggle-select-all="toggleAll"
    >
        <template v-slot:top>      
        <v-toolbar flat > 
            <v-toolbar-title>
                Checklists
            </v-toolbar-title>
            <!-- <v-divider
                class="mx-4"
                inset
                vertical
            ></v-divider> -->
            
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
 
    <ItemsDialog
        v-if="itemsDialog"
        :itemsDialog.sync="itemsDialog"
        @refresh="initialize"
    ></ItemsDialog>
  
  </div> 
</template>

<script>
import Form from '@/js/core/form';
import ItemsDialog from '@/js/views/checklists/itemDialog';

export default {
    components: {
        ItemsDialog,
    },
    props: [
        'value',
        'checklistIds',
    ],
    data: () => ({ 
        checklists: [],
        checklist: new Form({
            name: '',
            description: '',
        }),       
        dialog: false,        
        headers: [
            { text: 'Id', value: 'id' },
            { text: 'Name', value: 'name',},            
            { text: 'Description', value: 'description', align: 'left' },
            { text: 'Actions', value: 'action', sortable: false, filterable: false },
        ],
        itemsDialog: false,
        loading: false,
        search: '',
    }),

    computed: {         
        checkList () {  
          return this.$store.getters.checklists;          
        }     
    },

    // created () {
    //     this.initialize()
    // },

    watch: {
        value: {
            immediate: true,
            handler(val) {            
                this.initialize()
            }
        }
        
    },

    methods: {

        initialize () {             
            if(this.value > 0 ) {
                this.loading = true
                this.checklist.checklist_group_id = this.value
                this.$store.dispatch('fetchChecklistsByGroup',this.checklist)
                .then(()=> {
                    this.loading = false
                    this.selectedChecklists()
                });      
            }
        },

        checklistItems(item) { 
            this.$store.commit('SET_CHECKLIST', item)

            this.itemsDialog = true
        },

        rowSelected (row) {     
            if(row.value){
                this.checklistIds.push(row.item.id)
            } else {
                this.checklistIds.splice(this.checklistIds.indexOf(row.item.id),1)
            }      
           
        },

        selectedChecklists() {
            if(this.$store.getters.ptw.id != undefined) {
                var checklists = this.$store.getters.ptw.inspectionchecklists;
                if(checklists.length > 0 ) {
                    for(var checklist of checklists) {
                        this.checklists.push(checklist.checklist)
                        this.checklistIds.push(checklist.checklist_id)
                    }
                }                
            }
        },
           
        toggleAll(items) {
            var checklists = this.checkList 
            if(items.value) {
                for(var checklist of checklists) {
                    if(!this.checklistIds.includes(checklist.id)) {
                        this.checklistIds.push(checklist.id)
                    }                    
                }                
            } else {
                this.checklistIds.splice(0,this.checklistIds.length)
            }
        }
     
    },
}
</script>