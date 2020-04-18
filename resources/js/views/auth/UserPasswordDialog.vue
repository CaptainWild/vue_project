
  <template>
    <v-dialog :value="userPasswordDialog" max-width="390" persistent>
  <v-card>
      <v-card-title class="headline">Please copy the auto-generated password.</v-card-title>      
      <v-card-text>        
        Username: {{user.email}} <br />
        Password: {{user.password}}
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>        
        <v-btn 
          color="success darken-1" 
          raised 
          @click="$emit('close-dialog')"
        >
        Ok
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
  </template>
  
  <script>
  export default {
      props: {
        user: { type: Object, default: function () {return {email: "",password:""}}},
        userPasswordDialog: Boolean
      },
     
  }
  </script>