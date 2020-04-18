<template>
  <v-dialog v-model="deleteDialog" max-width="380" persistent>
  <v-card>
      <v-card-title class="headline">DELETE this High-Risk Work?</v-card-title>      
      <v-card-text> 
            Name: {{ hrw.name }} <br />
            Description: {{ hrw.description }}
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
          @click="deleteHrw"
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
        hrw: { type: Object, default: function () {return {name: "",description:""}}},
        deleteDialog: Boolean
    },
    methods: {
        deleteHrw() {
            this.loading = true
            this.$store.dispatch('deleteHrw',this.hrw)
            .then(response => {
                this.loading = false;
                this.$emit('update:deleteDialog',false)
                setTimeout(() => {                
                    this.$store.commit('closeSnackbar');
                },2000);           
            }).catch(()=> {this.loading = false });
        }
    }     
}
</script>