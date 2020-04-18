<template>
  <v-app id="inspire">
      
    <v-snackbar        
      v-model="snackbar.visible"
      :color="snackbar.color"
      :timeout="5000"
      top          
    >
      {{ authErrors.get('invalid_credentials') }}    
      <v-btn
        text
        @click="snackbar.visible = false"
      >
        <v-icon>mdi-close-circle</v-icon>
      </v-btn>

    </v-snackbar>

    <v-content>
      <v-container class="fill-height" fluid>
        <v-row align="center" justify="center" >
          <v-col cols="12" sm="8" md="4">
            <v-card class="elevation-12">
                <v-form @submit.prevent="login">
                <v-toolbar color="amber darken-2" flat>
                    <v-toolbar-title>intelliSAFE</v-toolbar-title>
                    <v-spacer></v-spacer>                             
                </v-toolbar>
                <v-card-text>                
                    <v-text-field 
                        label="E-mail" 
                        v-model="email" 
                        prepend-icon="mdi-account"                     
                        type="text"                        
                        clearable
                        autofocus
                        required
                        :error-messages="authErrors.get('email')"
                    >
                    
                    </v-text-field>
                    <v-text-field 
                        label="Password" 
                        v-model="password" 
                        prepend-icon="mdi-lock" 
                        type="password"                         
                        clearable
                        required
                        :error-messages="authErrors.get('password')"
                    >
                    </v-text-field>
                    <v-checkbox 
                        v-model ="remember" 
                        label="Remember Me" 
                    >
                    </v-checkbox>                
              </v-card-text>
              <v-card-actions>                
                <v-btn text @click="forgotPassword">
                    Forgot Password
                </v-btn>
                <v-spacer></v-spacer>                
                <v-btn type="submit" color="amber darken-2" :loading="loading" >
                    Login
                </v-btn>
              </v-card-actions>
              </v-form>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
  export default { 
    data: () => ({
        loading: false,        
        'snackbar': {
          visible: false,
          color: 'info'
        },
        'email':'',        
        'password':'',
        'remember':false      
    }),
    computed: {
        authErrors(){            
          return this.$store.getters.authErrors;
        }
    },
    methods: {
        forgotPassword: function () {
          this.loading = true;
          const action = 'password-reset'
          this.$store.dispatch('authRequest', {action})
          .then(() => {
            this.loading = false;
          }).catch(err => {
            if(err.response.status == 401) {              
              this.snackbar.visible = true
              this.snackbar.color = "error"
            }       
            this.loading = false;
          })
        },

        login: function () {    
          this.loading = true;        
          const { email, password, remember } = this;
          this.$store.dispatch('authRequest', { email, password, remember 
          }).then(() => {
            this.loading = false;            
            //this.$router.push('/ptws')
            location.reload(true)
          }).catch(err => {  
            if(err.response.status == 401) {              
              this.snackbar.visible = true
              this.snackbar.color = "error"
            }       
            this.loading = false;     
          });
        }           
    }
  }
</script>