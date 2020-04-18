<template>
    <v-data-table
        :headers="headers"
        :items="checkList"                
        class="elevation-1"
        :loading="loading"
        :search="search"
        show-select
        :disable-pagination=true
        :hide-default-footer=true
        v-model="checklists"
        @item-selected="rowSelected"
        @toggle-select-all="toggleAll"
    >
      <template v-slot:top>      
          <!-- <v-toolbar flat > 
            <v-toolbar-title>
                Checklist
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
                    label="Search"
                    single-line
                    hide-details
                    clearable
            ></v-text-field>      
        </v-toolbar> -->
      </template>

        <!-- <template v-slot:header.data-table-select>
            <span></span>
        </template> -->

        <template v-slot:loading>
            <span>Fetching Data...</span>
        </template>
    </v-data-table>
</template>

<script>
import Form from '@/js/core/form';

export default {
    props: [
        'value',
        'hrwChecklistIds',
    ],
    data: () => ({ 
        headers: [
            { text: 'Description', value: 'description' }
        ],
        loading: false,           
        search: '',       
        checklists: [],
        hrwChecklist: new Form()     
    }),
     
    computed: {
        checkList() {
          return this.$store.getters.hrwChecklists;
        },               
    },
     
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
            if(this.value != undefined) {
                this.loading = true
                this.hrwChecklist.hrw_id = this.value
                this.$store.dispatch('fetchHrwChecklist',this.hrwChecklist)
                .then(()=> {
                    this.loading = false
                    this.selectedHrwChecklists()
                });       
            }                  
        },

        rowSelected (row) {  

            if(row.value) {
                this.hrwChecklistIds.push(row.item.id)
            } else {
                this.hrwChecklistIds.splice(this.hrwChecklistIds.indexOf(row.item.id),1)
            }
            
        },

        selectedHrwChecklists() {
            if(this.$store.getters.ptw.id != undefined) {
                var hrwchecklists = this.$store.getters.ptw.ptwhrwchecklists

                if(hrwchecklists.length > 0){
                    for(var hrwchecklist of hrwchecklists) {
                        if(hrwchecklist.checked > 0){
                            this.checklists.push(hrwchecklist.hrwchecklists)
                            this.hrwChecklistIds.push(hrwchecklist.hrw_checklist_id)
                        }                                                                    
                    }
                }                
            } else if(!_.isEmpty(this.$store.getters.ptwChecklistItem)) {
                if(this.$store.getters.ptwChecklistItem.ptwchecklistitemdetails.length > 0) {
                    var ptwchecklistitemdetails = this.$store.getters.ptwChecklistItem.ptwchecklistitemdetails

                    for(var ptwchecklistitemdetail of ptwchecklistitemdetails) {
                        if(ptwchecklistitemdetail.checked > 0){
                            this.checklists.push(ptwchecklistitemdetail.hrwchecklist)
                            this.hrwChecklistIds.push(ptwchecklistitemdetail.hrw_checklist_id)
                        }                                                                    
                    }                   
                }
            }
        } , 
        
        toggleAll(items) {
            var checklists = this.checkList 
            if(items.value) {
                for(var checklist of checklists) {
                    if(!this.hrwChecklistIds.includes(checklist.id)) {
                        this.hrwChecklistIds.push(checklist.id)
                    }                    
                }                
            } else {
                this.hrwChecklistIds.splice(0,this.hrwChecklistIds.length)
            }
        }
    },
}
</script>