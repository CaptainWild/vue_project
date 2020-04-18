<template>
   <v-select
        :items="userList"
        :loading="loading"
        :rules="[v => !!v || 'This field is required']"
        v-model="user_ids" 
        :label="label"        
        item-text="name"
        item-value="id"
        clearable
        required
        multiple
        :hint="hint"
        persistent-hint
    ></v-select>    
</template>

<script>
import Form from '@/js/core/form';

export default {
  
    props: ['value','label','hint','role'],
    
    data: () => ({ 
        loading: false,
    }),

    computed: {
        userList() {
          
           
          if(this.role =='am') {               
            return this.$store.getters.mainConManagers
          }    
          
          return this.$store.getters.mainConAssessors
        },
        user_ids: {
          get() { 
            return this.value
          },
          set(val) {
            this.$emit('input',val)
          }
        }  
    },

    created () {
      console.log(this.role)
      this.initialize()
    },

    methods: {
      
      initialize () { 
        var action = 'fetchMainContractorSafetyAssessors';
        if(this.role =='am') {
          action = 'fetchMainContractorAuthorizedManagers'
        }

        this.loading = true
        this.$store.dispatch(action)
          .then(()=> {
            this.loading = false
          });               
      },
    }
}
</script>