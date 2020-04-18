<template>
<div>
    <v-card>
        <v-card-title>
             <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Search SWPS"
                single-line
                hide-details
                clearable
            ></v-text-field>             
        </v-card-title>
    </v-card>  
    <v-data-table
        :headers="headers"
        :items="swpList"
        :search="search"        
        sort-by="ref_no"
        sort-desc
        class="elevation-1"
        :loading="loading"
        show-select
        v-model="swps"
        @item-selected="rowSelected"
        @toggle-select-all="toggleAll"
        disable-pagination
        hide-default-footer
    >
      <template v-slot:top>      
          <v-toolbar flat > 
            <v-toolbar-title>
                Safe Work Procedures
            </v-toolbar-title>
            <!-- <v-divider
              class="mx-4"
              inset
              vertical
            ></v-divider>            -->
        </v-toolbar>
      </template>

        <template v-slot:item.file="{ item }">
            <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                <v-btn 
                    v-on="on"
                    text 
                    icon 
                    dark
                    color="warning"
                    v-show="item.procedure_path != null"
                    :loading="dlLoading && rowIndex === item.id"
                    @click="download(item)"
                >
                    <v-icon>mdi-file</v-icon>
                </v-btn>
                </template>
                <span>View File</span>
           </v-tooltip>
       </template>

      <template v-slot:loading>
        <span>Fetching Data...</span>
      </template>

      <template v-slot:item.swp_category_id="{ item }">
        <span>{{ item.swpcategory.name}}</span>
      </template>

    </v-data-table>
</div>
</template>

<script>
import Form from '@/js/core/form';

export default {
    props: [
        'value',
        'swpIds',
    ],
    data: () => ({ 
        dlLoading: false,
        loading: true,           
        headers: [
            { text: 'Reference No.', value: 'ref_no', align: 'left' },
            { text: 'Activity', value: 'activity',},       
            { text: 'Category', value: 'swp_category_id',},
            { text: 'File', value: 'file',},          
        ],
        search: '',
        swps: [], 
        swp: new Form({ id:'', activity: ''}),    
    }),
    
    computed: {            
        swpList () {  
            return this.$store.getters.approvedSwps;
        },        
    },
  
    created () {
        this.initialize()
    },

    methods: {
     
        initialize () { 
            this.loading = true
            this.$store.dispatch('fetchSwps',this.swp)
            .then(()=> {
                this.loading = false
                this.selectedSwps()
            });              
        },

        download(item) {
            this.rowIndex = item.id;
            this.dlLoading = true;

            this.$store.dispatch('downloadProcedureFile', item)
            .then(response => {
                this.dlLoading = false;
                window.open(response);
            })
            .catch(error => {
                this.dlLoading = false;
            })
        },

        rowSelected (row) {     
            if(row.value){
                this.swpIds.push(row.item.id)
            } else {
                this.swpIds.splice(this.swpIds.indexOf(row.item.id),1)
            }      
           
        },

        selectedSwps() {
            if(this.$store.getters.ptw.id != undefined) {
                var swps = this.$store.getters.ptw.swps
                if(swps.length > 0 ) {
                    for(var swp of swps) {
                        this.swps.push(swp)
                        this.swpIds.push(swp.id)
                    }
                }                
            }
        },
           
        toggleAll(items) {
            var swps = this.swpList 
            if(items.value) {
                for(var swp of swps) {
                    if(!this.swpIds.includes(swp.id)) {
                        this.swpIds.push(swp.id)
                    }                    
                }                
            } else {
                this.swpIds.splice(0,this.swpIds.length)
            }
        }
    },
}
</script>
