<template>
  <v-dialog v-model="legendsDialog" max-width="550" persistent scrollable>
    <v-card>
      <v-card-title class="headline">Legends for {{checklist.name}}</v-card-title>      
        <v-card-text> 
            <v-data-table
                :headers="headers"
                :items="legends"
                :items-per-page="5"
                :loading="loading"
                show-select
                @item-selected="rowSelected"
                @toggle-select-all="toggleAll"
                class="elevation-1"
                v-model="selected"
            >
            </v-data-table>
        </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn 
            color="error darken-1" 
            raised 
            @click="$emit('update:legendsDialog',false)"
        >
        Close
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>  
</template>

<script>
export default {
    props: {
        legendsDialog: Boolean,        
    },
    data () {
      return {
        loading: false,        
        selected: [],
        headers: [
            { text: 'Id', value: 'id' },
            { text: 'Code', value: 'code'},
            { text: 'Name', value: 'name'}
        ],
        checklist: {},    
      }
    },

    computed: {   
        legends () {  
            return this.$store.getters.legends;
        },         
    },

    created() {        
        this.checklist = this.$store.getters.checklistLegends;
        this.initialize()
    },

    methods: {
        initialize() {
            //get legends data
            this.$store.dispatch('fetchLegends').then(()=> {this.checklistLegends()})
        },

        rowSelected (row) {
            this.$store.dispatch('toggleChecklistLegend', {id:row.item.id, value: row.value, checklist_id: this.checklist.id})
                .then(response => {
                    setTimeout(() => {                
                            this.$store.commit('closeSnackbar');
                            this.$emit('refresh');
                        },1000);   
                }).catch(error => {console.log(error)});
        },

        toggleAll(val) {            
             this.$store.dispatch('toggleAllChecklistLegend', {value: val.value, checklist_id: this.checklist.id})
            .then(response => {
                 setTimeout(() => {                
                        this.$store.commit('closeSnackbar');
                        this.$emit('refresh');
                    },2000);   
            }).catch(error => {console.log(error)});
        },

        checklistLegends() {
            if(this.checklist.legends.length > 0) {
                for(var legend of this.checklist.legends) {
                    this.selected.push(legend);                
                }
            }
        }
    }
}
</script>