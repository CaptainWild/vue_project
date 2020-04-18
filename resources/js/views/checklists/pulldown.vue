<template>
   <v-select
        :items="checklistList"
        :loading="loading"
        :rules="[v => !!v || 'This is field is required']"
        v-model="checklist_id" 
        label="*Checklist"
        item-text="name"
        item-value="id"
        :disabled="disable"
        clearable
        required 
    ></v-select>    
</template>

<script>
import Form from '@/js/core/form';

export default {
  
    props: ['value','disable'],
    
    data: () => ({ 
        loading: false,
        checklists: new Form({ id:'', name: ''})
    }),

    computed: {
        checklistList() {
          return this.$store.getters.checklists;
        },
        checklist_id: {
          get() { 
            return this.value
          },
          set(val) {
            this.$emit('input',val)
          }
        },
    },

    created () {      
      this.initialize()
    },

    methods: {
        
        initialize () { 
            this.loading = true
            this.$store.dispatch('fetchChecklists',this.checklists)
              .then(()=> {
                this.loading = false
              });               
        },
    }
}
</script>