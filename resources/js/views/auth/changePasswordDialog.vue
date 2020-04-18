<template>
    <v-dialog v-model="changePasswordDialog" max-width="340" persistent>
        <v-form @submit.prevent="change" ref="form"  >
        <v-card>
            <v-card-title>
                <span class="headline">Change Password</span>
            </v-card-title>
            <v-card-subtitle>
                Password Rules: <br/>
                    * Must be at least 9 characters.<br/>
                    * May only contain letters and numbers.
            </v-card-subtitle>
            <v-card-text>        
                <v-container>
                    <v-row>
                      <v-col cols="12">
                        <v-text-field 
                            autofocus
                            required                              
                            clearable 
                            v-model="password" 
                            label="*Password"
                            :type="showPassword ? 'text' : 'password'"
                            :error-messages="passwordErrors"
                            :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                            @click:append="() => (showPassword = !showPassword)"
                            :rules=passwordRules
                          ></v-text-field>
                      </v-col>
                      <v-col cols="12">
                          <v-text-field                                                            
                            clearable 
                            v-model="password_confirmation" 
                            label="*Confirm Password"
                            :type="showPasswordConfirmation ? 'text' : 'password'"
                            :error-messages="passwordErrors" 
                            :append-icon="showPasswordConfirmation ? 'mdi-eye' : 'mdi-eye-off'"
                            @click:append="() => (showPasswordConfirmation = !showPasswordConfirmation)"                        
                          ></v-text-field>
                      </v-col>                    
                    </v-row>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>        
                <v-btn 
                color="error darken-1" 
                raised 
                @click="$emit('update:changePasswordDialog', false)"
                >Cancel</v-btn>
                <v-btn 
                color="success darken-1" 
                raised 
                type="submit"
                >Save</v-btn>
            </v-card-actions>
        </v-card>
        </v-form>         
    </v-dialog>
</template>

<script>
export default {
    props: {
        changePasswordDialog: Boolean,
        primaryDrawer: Boolean
    },
    computed: {
        user(){
            return this.$store.getters.getProfile;
        },
        passwordErrors() {
            return this.$store.getters.userErrors.password;
        }
    },
    data: () => ({ 
        showPassword: false,
        showPasswordConfirmation: false,
        password: "",
        password_confirmation: "",

        passwordRules: [
            v => !!v || 'Password is required',
            v => (v && v.length >= 9) || 'Password must have at least 9 characters',
            v => /(?=.*[a-z])/.test(v) || 'Must have one character',
            v => /(?=.*\d)/.test(v) || 'Must have one number',
            // v => /([!@$%])/.test(v) || 'Must have one special character [!@#$%]'
        ]

        
    }),
    methods: {
        change: function () {   
            if (this.$refs.form.validate()){
              
                const {password, password_confirmation} = this
                this.$store.dispatch('updateUserPassword', {
                    password, password_confirmation,
                    id : this.user.id
                })
                .then( response => {
                    if(response.data) {
                        
                        this.$emit('update:changePasswordDialog', false);

                        setTimeout(() => {                
                            this.$store.dispatch('authLogout')
                                .then( ()=>{                           
                                this.$router.push('/')
                            });
                        },2000); 
                    
                    }                 
                })
                .catch( (error) => {
                    //console.log(error)
                });

            }

        }
    }
}
</script>