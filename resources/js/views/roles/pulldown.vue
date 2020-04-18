<template>
   <v-select
        :items="roleList"
        :loading="loading"
        :rules="[v => !!v || 'Role is required']"
        v-model="role_id" 
        label="Role"        
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
        role: new Form({ id:'', name: ''})
    }),

    computed: {
        roleList() {
          return this.$store.getters.roles;
        },
        role_id: {
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
        this.$store.dispatch('fetchRoles',this.role)
          .then(()=> {
            this.loading = false
          });               
      },
    }
}
</script>