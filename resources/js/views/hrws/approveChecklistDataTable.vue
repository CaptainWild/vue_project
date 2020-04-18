<template>
    <v-data-table
        :headers="headers"
        :items="checkList"                
        class="elevation-1"
        :loading="loading"
        :search="search"
        v-model="checklists"
        disable-pagination
        hide-default-footer
    >
      <template v-slot:top>      
          <v-toolbar flat > 
            <v-toolbar-title>
                Checklist
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

         <!-- <template v-slot:item.verified="{ item }">            
             <v-icon v-if="item.verified" color="green">mdi-check-decagram</v-icon>
             <v-icon v-else >mdi-checkbox-blank</v-icon>
        </template> -->

        <template v-slot:loading>
            <span>Fetching Data...</span>
        </template>
    </v-data-table>
</template>

<script>

export default {
    data: () => ({         
        headers: [            
            // { text: 'Verified', value: 'verified', width: 80, sortable:false, filterable:false },
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
        }            
    },
}
</script>