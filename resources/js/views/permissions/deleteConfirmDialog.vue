<template>
    <v-dialog v-model="deleteDialog" max-width="390" persistent>
  <v-card>
      <v-card-title class="headline">Are you sure you want to delete this Permission?</v-card-title>      
      <v-card-text>
        Id: {{permission.id}} <br/>
        Permission Name: {{ permission.name }} <br />
        Code: {{ permission.code}}<br />
        Description: {{ permission.description }} <br />        
      </v-card-text>

      <v-card-actions>       
        <v-btn
          color="secondary darken-1" 
          raised 
          @click="$emit('update:deleteDialog',false)"
        >No
        </v-btn>
         <v-spacer></v-spacer>
        <v-btn 
          color="success darken-1" 
          raised 
          @click="deletePermission"
          :loading="loading"
        >Yes
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
    data: () => ({
        permission: {},
        loading: false,
    }),
    created() {      
      this.permission = Object.assign({}, this.$store.getters.permission)      
    },
    props: {
        deleteDialog: Boolean
    },
    methods: {

      closeForm() {            
        this.$emit('update:deleteDialog',false)
      },

      deletePermission() {

        this.loading = true
        this.$store.dispatch('deletePermission', this.permission)
        .then(response => {
            this.loading = false;
          
            this.$emit('update:deleteDialog',false)
            this.$emit('refresh')
            
            setTimeout(() => {                
                this.$store.commit('closeSnackbar');
            },2000);           
        }).catch(()=> {this.loading = false });

      }
    }  
}
</script>