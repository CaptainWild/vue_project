<template>
   <v-select
        :items="subContractorList"
        :loading="loading"
        :rules="[v => !!v || 'Sub-Contractor is required']"
        v-model="sub_contractor_id" 
        label="Sub-Contractor"        
        item-text="name"
        item-value="id"
        clearable
        required
       
    ></v-select>    
</template>

<script>
import Form from '@/js/core/form';

export default {
  
    props: ['value'],
    
    data: () => ({ 
        loading: false,
        subcontractor: new Form({ id:'', name: ''})
    }),

    computed: {
        subContractorList() {
          return this.$store.getters.subcontractors;
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

    created () {
      this.initialize()
    },

    methods: {
      
      initialize () { 
        this.loading = true
        this.$store.dispatch('fetchSubContractors',this.subcontractor)
          .then(()=> {
            this.loading = false
          });               
      },
    }
}
</script>