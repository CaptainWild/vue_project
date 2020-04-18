<template>
    <v-data-table
        :headers="headers"
        :items="asmList"                
        class="elevation-1"
        :loading="loading"
        :disable-pagination=true
        :hide-default-footer=true
        v-model="asms"
    >
      <template v-slot:top>      
          <v-toolbar flat > 
            <v-toolbar-title>
                Safety Measures
            </v-toolbar-title>
            <v-divider
              class="mx-4"
              inset
              vertical
            ></v-divider>
          
        </v-toolbar>
      </template>

        <template v-slot:header.data-table-select>
            <span></span>
        </template>

         <template v-slot:item.checked="{ item }">            
            <v-icon v-if="item.checked" color="green">mdi-checkbox-marked-circle-outline</v-icon>
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
    data: () => ({ 
        headers: [
            { text: '', value: 'checked', width: 80, sortable:false, filterable:false },
            { text: 'Description', value: 'asm.description' }
        ],
        loading: false, 
        asms: [],
    }),
     
    computed: {
        asmList() {
            return this.$store.getters.ptw.ptwasmchecklists;
        },               
    },
}
</script>