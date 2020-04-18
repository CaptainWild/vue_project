<template>
    <v-dialog v-model="deleteDialog" max-width="400" persistent>
  <v-card>
      <v-card-title class="headline">DELETE this Worker Certificate?</v-card-title>      
      <v-card-text> 
          
            Id: {{workerCertificate.id}} <br/>
            Designation: <span v-if="workerCertificate.role">{{workerCertificate.role.name}}</span> <br />
            Description: {{ workerCertificate.description }} <br />
            File Name: {{ workerCertificate.file_name }} <br />
            Valid Until:  <span v-if="workerCertificate.expiry_at != null">{{new Date(workerCertificate.expiry_at).toLocaleDateString() }}</span>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn 
          color="error darken-1" 
          raised 
          @click="$emit('update:deleteDialog',false)"
        >
        No
        </v-btn>
        <v-btn 
          color="success darken-1" 
          raised 
          @click="deleteWorkerCertificate"
          :loading="loading"
        >
        Yes
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
    data: () => ({
        loading: false,
    }),
    props: {
        deleteDialog: Boolean
    },
    computed: {
        workerCertificate() {
            return this.$store.getters.workercertificate
        },      
    },
    methods: {
        deleteWorkerCertificate() {
            this.loading = true
            this.$store.dispatch('deleteWorkerCertificate',this.workerCertificate)
            .then(response => {
                
                this.loading = false;
                this.$emit('update:deleteDialog',false)
                this.$emit('refresh')
                setTimeout(() => {                
                    this.$store.commit('closeSnackbar');
                },2000);           
            }).catch(()=> {
                this.loading = false });
        }
    }  
}
</script>