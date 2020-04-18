<template>
    <v-data-table
        :headers="headers"
        :items="asmList"                
        class="elevation-1"
        :loading="loading"
        :search="search"
        show-select
        :disable-pagination=true
        :hide-default-footer=true
        v-model="asms"
        @item-selected="rowSelected"
        @toggle-select-all="toggleAll"
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

        <!-- <template v-slot:header.data-table-select>
            <span></span>
        </template> -->

        <template v-slot:loading>
            <span>Fetching Data...</span>
        </template>
    </v-data-table>
</template>

<script>
export default {
    props: [
        'value',
        'asmChecklistIds',
    ],
    data: () => ({ 
        headers: [
            { text: 'Description', value: 'description' }
        ],
        loading: false,           
        search: '',       
        asms: [],
    }),
     
    computed: {
        asmList() {
          return this.$store.getters.asms;
        },               
    },

    created() {
          this.initialize()
    },
     
    watch: {       
    },

    methods: {

        initialize () {             
            this.loading = true
            this.$store.dispatch('fetchAsms')
            .then(()=> {
                this.loading = false
                this.selectedAsmChecklist()
            });                
        },

        rowSelected (row) {  

            if(row.value) {
                this.asmChecklistIds.push(row.item.id)
            } else {
                this.asmChecklistIds.splice(this.asmChecklistIds.indexOf(row.item.id),1)
            }
            
        },

        selectedAsmChecklist() {
            if(this.$store.getters.ptw.id != undefined) {
                var asmchecklists = this.$store.getters.ptw.ptwasmchecklists

                if(asmchecklists.length > 0){
                    for(var asmchecklist of asmchecklists) {
                        if(asmchecklist.checked > 0){
                            this.asms.push(asmchecklist.asm)
                            this.asmChecklistIds.push(asmchecklist.asm_id)
                        }                                                                    
                    }
                }                
            }
        },
        
         toggleAll(items) {
            var asmlists = this.asmList 
            if(items.value) {
                for(var asmlist of asmlists) {
                    if(!this.asmChecklistIds.includes(asmlist.id)) {
                        this.asmChecklistIds.push(asmlist.id)
                    }                    
                }                
            } else {
                this.asmChecklistIds.splice(0,this.asmChecklistIds.length)
            }
        }
    },
}
</script>