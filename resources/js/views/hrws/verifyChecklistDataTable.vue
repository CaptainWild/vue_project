<template>
    <v-data-table
        :headers="headers"
        :items="checkList"                
        class="elevation-1"
        :loading="loading"
        :search="search"
        disable-pagination
        hide-default-footer
        v-model="checklists"
        @item-selected="rowSelected"
    >
      <template v-slot:top>      
          <v-toolbar flat > 
            <v-toolbar-title>
                Verify Checklist
            </v-toolbar-title>
            <v-divider
              class="mx-3"
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
        </v-toolbar>
      </template>

        <template v-slot:header.data-table-select>
            <span></span>
        </template>

        <template v-slot:item.original="{ item }">            
            <v-icon v-if="item.original" color="green">mdi-checkbox-marked-circle-outline</v-icon>
            <v-chip
                color="pink"
                label
                text-color="white" v-else
            >N.A.</v-chip>
        </template>

        <template v-slot:loading>
            <span>Fetching Data...</span>
        </template>
    </v-data-table>
</template>

<script>

export default {
    props: [
        'value',
        'hrwChecklistIds',
    ],
    data: () => ({         
        headers: [
            { text: 'Original', value: 'original', width: 80, sortable:false, filterable:false },
            { text: 'Description', value: 'description' }
        ],
        loading: false,           
        search: '',       
        checklists: [],
    }),
     
    computed: {
        checkList() {
          return this.$store.getters.ptwVerifiedChecklist;
        },          
    },

    methods: {

        rowSelected (row) {  
            if(row.value) {
                this.hrwChecklistIds.push(row.item.id)
            } else {
                this.hrwChecklistIds.splice(this.hrwChecklistIds.indexOf(row.item.id),1)
            }
            
        },
    },
}
</script>