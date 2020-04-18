<template>
  <v-dialog v-model="deleteDialog" max-width="340" persistent>
  <v-card>
      <v-card-title class="headline">DELETE this Attachment?</v-card-title>      
      <v-card-text>        
        Description: {{attachment.description}} <br />
        File Name: {{attachment.file_name}}
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
          @click="deleteAttachment"
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
        attachment: { type: Object, default: function () {return {file_name: "",description:""}}},
        deleteDialog: Boolean
    },
    methods: {
        deleteAttachment() {
            this.loading = true
            this.$store.dispatch('deleteAttachment',this.attachment)
            .then(response => {
                this.loading = false;
                this.$emit('close-dialog')
                this.$emit('reload-attachments')
                setTimeout(() => {                
                    this.$store.commit('closeSnackbar');
                },2000);           
            }).catch(()=> {this.loading = false });
        }
    }     
}
</script>