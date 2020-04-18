
  <template>
    <v-dialog v-model="resetPasswordDialog" max-width="290" persistent>
    <v-card>
      <v-card-title class="headline">RESET Password?</v-card-title>      
      <v-card-text>        
        Name: {{user.name}}  <br />
        Username: {{user.email}}
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn 
            color="secondary darken-1" 
            raised           
            @click="$emit('update:resetPasswordDialog', false)"
        >
        No
        </v-btn>
        <v-btn 
            color="success darken-1" 
            raised 
            :loading="loading"
            @click="resetPassword"
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
        user: { type: Object, default: function () {return {id:"",email: "",name:""}}},
        resetPasswordDialog: Boolean
    },
    methods: {
        resetPassword() {
            this.loading = true
            this.$store.dispatch('resetUserPassword',this.user)
            .then(response => {
               this.loading = false;
               this.$emit('update:resetPasswordDialog',false)
               this.$emit('success')          
          }).catch(()=> {this.loading = false });
        }
    }
  }
  </script>