<template>
   <v-select
        :items="subContractorList"
        :loading="loading"
        :rules="[v => !!v || 'Sub-Contractor is required']"
        v-model="sub_contractor_id" 
        label="*Sub-Contractor"        
        item-text="name"
        item-value="id"
        :clearable="clearable"
        :disabled="disable"
        required
        @click:clear="clearList"       
    ></v-select>
</template>

<script>
import Form from '@/js/core/form';

export default {
  
    props: [
        'value',
        'projectId',
        'clearable',
        'disable'        
    ],
    
    data: () => ({ 
        loading: false,
        project_subcontractor: new Form({sub_contractor_id: '',project_id: 0})
    }),

    computed: {
        subContractorList() {
            return this.$store.getters.projectSubcontractors;         
        },
        sub_contractor_id: {
            get() { 
                return this.value
            },
            set(val) {   
                this.$emit('input',val)
            }
        }  
    },

    watch: {
        projectId: {
            immediate:true,
            handler(val,oldVal) {
                if(val != undefined) {
                   
                    this.initialize() 
                    this.$store.commit('RESET_PROJECT_SUBCONTRACTORS')             
                }

                this.clearList()
            }          
        },
    },

    methods: {
        clearList() {            
            this.$store.commit('RESET_SUBCONTRACTOR_WORKERS_LIST');
        },

        initialize () {
          this.project_subcontractor.project_id = this.projectId 
          this.loading = true
          this.$store.dispatch('fetchProjectSubContractors',this.project_subcontractor)
            .then(()=> {
              this.loading = false
            });               
        },
    }
}
</script>