<template>
   <v-select
        :items="hrwList"
        :loading="loading"
        :rules="[v => !!v || 'Permit to Work is required']"
        v-model="hrw_id" 
        label="*Permit to Work"
        :prepend-icon="computedHrwIcon"        
        item-text="name"
        item-value="id"
        :disabled="disable"
        clearable
        required 
        @click:clear="clearCheckList"       
    ></v-select>    
</template>

<script>
import Form from '@/js/core/form';

export default {
  
    props: ['value','hrwIcon','disable','checklistGroupId'],
    
    data: () => ({ 
        loading: false,
        hrw: new Form({ id:'', name: ''}),
    }),

    computed: {
        hrwChecklistGroup() {
            return this.$store.getters.hrwchecklistroups
        },
        hrwList() {  
          return this.$store.getters.hrws;
        },
        hrw_id: {
          get() { 
            return this.value
          },
          set(val) {
            this.$emit('input',val)            
            this.$emit('update:checklistGroupId', this.hrwChecklistGroup[val]);
          }
        },
        computedHrwIcon () {
          if(this.hrwIcon)
            return 'mdi-asterisk';

          return '';
        }
        
    },

    created () {
      this.initialize()
    },

    methods: {
        clearCheckList() {
            this.$store.commit('RESET_HRW_CHECKLIST');
            this.$store.commit('RESET_CHECKLIST');
        },
       
        initialize () {          
            this.loading = true
            this.$store.dispatch('fetchHrws',this.hrw)
              .then(()=> {
                this.loading = false
              });               
        },
    }
}
</script>