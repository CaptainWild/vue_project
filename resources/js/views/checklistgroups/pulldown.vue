<template>
   <v-select
        :items="checklistgroupList"
        :loading="loading"
        :rules="[v => !!v || 'This field is required']"
        v-model="checklist_group_id" 
        label="*Checklist Group"
        item-text="name"
        item-value="id"
        :clearable="clearable"
        :disabled="disable"
        required
        @click:clear="clear"       
    ></v-select>    
</template>

<script>
import Form from '@/js/core/form';

export default {
  
    props: ['value','disable','clearable'],
    
    data: () => ({ 
        loading: false,
        checklistgroup: new Form({ id:'', name: ''})
    }),

    computed: {
        checklistgroupList() {
            return this.$store.getters.checklistgroups;
        },
        checklist_group_id: {
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
        clear() {
            this.$store.commit('RESET_CHECKLIST_GROUP')
        },
      
        initialize () { 
          this.loading = true
          this.$store.dispatch('fetchChecklistGroups',this.checklistgroup)
            .then(()=> {
              this.loading = false
            });               
        },
    }
}
</script>