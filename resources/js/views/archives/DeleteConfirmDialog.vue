<template>
  <v-dialog v-model="deleteDialog" max-width="290" persistent>
  <v-card>
      <v-card-title class="headline">DELETE this Archive?</v-card-title>      
      <v-card-text>        
        Name: {{archive.name}} <br />
        Description: {{archive.description}}
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn 
          color="error darken-1" 
          raised 
          @click="$emit('close-dialog')"
        >
        No
        </v-btn>
        <v-btn 
          color="success darken-1" 
          raised 
          @click="deleteArchive"
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
        archive: { type: Object, default: function () {return {name: "",description:""}}},
        deleteDialog: Boolean
    },
    methods: {
        deleteArchive() {
            this.loading = true
            this.$store.dispatch('deleteArchive',this.archive)
            .then(response => {
                this.loading = false;
                this.$emit('close-dialog')
                this.$emit('reload-archives')
                setTimeout(() => {                
                    this.$store.commit('closeSnackbar');
                },2000);           
            }).catch(()=> {this.loading = false });
        }
    }     
}
</script>