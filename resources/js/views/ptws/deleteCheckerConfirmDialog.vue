<template>
    <v-dialog v-model="deleteDialog" max-width="380" persistent>
  <v-card>
      <v-card-title class="headline">DELETE this PTW Checker?</v-card-title>      
      <v-card-text> 
            Id: {{ ptwchecker.id }} <br />
            Name: {{ ptwchecker.user.name }} <br />
            E-mail: {{ ptwchecker.user.email }} <br />
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn 
          color="secondary" 
          raised 
          @click="$emit('update:deleteDialog',false)"
        >
        No
        </v-btn>
        <v-btn 
          color="success darken-1" 
          raised 
          @click="deletePtwChecker"
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
        ptwchecker: {}
    }),
    props: {    
        deleteDialog: Boolean
    },
    created() {
        this.ptwchecker = Object.assign({},this.$store.getters.checker)
    },
    methods: {
        deletePtwChecker() {
            this.loading = true
            this.$store.dispatch('deletePtwChecker',this.ptwchecker)
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