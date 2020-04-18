<template>
   <v-select
        :items="projectList"
        :loading="loading"
        :rules="[v => !!v || 'Project is required']"
        v-model="project_id" 
        label="*Project"
        :prepend-icon="computedProjectIcon"        
        item-text="title"
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
  
    props: ['value','projectIcon','disable','clearable'],
    
    data: () => ({ 
        loading: false,
        project: new Form({ id:'', title: ''})
    }),

    computed: {
        projectList() {
          return this.$store.getters.projects;
        },
        project_id: {
          get() { 
            return this.value
          },
          set(val) {
            this.$emit('input',val)
          }
        },
        computedProjectIcon () {
          if(this.projectIcon)
            return 'mdi-asterisk';

          return '';
        }        
    },

    created () {
      this.initialize()
    },

    methods: {
        clear() {
            this.$store.commit('RESET_PROJECT_SUBCONTRACTORS')
            //this.$store.commit('RESET_PROJECTS');
        },
      
        initialize () { 
          this.loading = true
          this.$store.dispatch('fetchProjects',this.project)
            .then(()=> {
              this.loading = false
            });               
        },
    }
}
</script>