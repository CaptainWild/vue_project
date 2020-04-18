<template>
    <v-dialog v-model="projectSubConsDialog" max-width="550" persistent scrollable>
    <v-card>
      <v-card-title class="headline">Sub-Contractors</v-card-title>      
        <v-card-text> 
            <v-data-table
                :headers="headers"
                :items="projectSubContractorList"
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
            @click="$emit('update:projectSubConsDialog',false)"
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
        projectSubConsDialog: Boolean,        
        project: {type: Object,default: function (){id:0}}
    },
    data () {
      return {
        loading: false,        
        selected: [],
        headers: [
            { text: 'Id', value: 'id' },
            { text: 'Sub-Contractor', value: 'name'}
        ],    
      }
    },

    computed: {   
        projectSubContractorList () {  
            return this.$store.getters.subcontractors;
        }, 
        
    },

    watch: {        
        projectSubConsDialog:{
            immediate: true,
            handler(val, oldVal) {
                if(val) {
                    this.initializeProjectSubContractors()
                    
                }
            }            
        },      
    },
    
    methods: {
        
        initializeProjectSubContractors() {
            this.loading = true;
            this.$store.dispatch('fetchSubContractors',this.project)
            .then(() => {
                this.loading = false;
                this.projectSubContractors()
            })
            .catch( error => {
                this.loading = false;
                console.log(error);
            });
        },

        rowSelected (row) {
            this.$store.dispatch('toggleProjectSubCons', {id:row.item.id, value: row.value, project_id: this.project.id})
            .then(response => {
                 setTimeout(() => {                
                        this.$store.commit('closeSnackbar');
                    },1000);   
            }).catch(error => {console.log(error)});
        },

        toggleAll(val) {            
             this.$store.dispatch('toggleAllProjectSubCons', {value: val.value, project_id: this.project.id})
            .then(response => {
                 setTimeout(() => {                
                        this.$store.commit('closeSnackbar');
                    },2000);   
            }).catch(error => {console.log(error)});
        },

        projectSubContractors() {
            var subcons =  this.$store.getters.subcontractors;
            
            for(var subcon of subcons) {
                if(subcon.projects.length > 0) {
                    for(var project of subcon.projects) {
                        if(project.id == this.project.id) {
                           this.selected.push(subcon);
                        }
                    }
                }
            }
        }


    }
}
</script>