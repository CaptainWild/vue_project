<template>
   <v-select
        :items="workersList"
        :loading="loading"        
        v-model="operator_id" 
        :label="fieldLabel"        
        item-text="name"
        item-value="id"
        :clearable="clearable"
        :disabled="disable"      
    ></v-select>
</template>

<script>
import Form from '@/js/core/form';

export default {
  
    props: {
        value: Number,
        subContractorId: Number,
        clearable: { type: Boolean, default: false},
        disable: { type: Boolean, default: false},
        fieldLabel:{ type:String, default: "Personnel / Operator"}
    },
    
    data: () => ({ 
        loading: false,
    }),

    computed: {
        workersList() {
          return this.$store.getters.subcontractorWorkers;
        }, 
        operator_id: {
            get() { 
                return this.value
            },
            set(val) {
                this.$emit('input',val)
            }
        }, 
    },

     watch: {
        subContractorId: {
            immediate: true,
            handler(val,oldVal) {
                this.initialize()                
            }            
        }
    },

    methods: {
        initialize () { 
            if(this.subContractorId > 0) {
                this.loading = true
                this.$store.dispatch('fetchSubContractorWorkers',{sub_contractor_id:this.subContractorId})
                .then(()=> {
                    this.loading = false                    
                });       
            }                  
        },
    }
}
</script>