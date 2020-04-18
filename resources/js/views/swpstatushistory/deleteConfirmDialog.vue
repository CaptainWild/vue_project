<template>
    <v-dialog v-model="deleteDialog" max-width="350" persistent>
  <v-card>
      <v-card-title class="headline">DELETE this SWP History?</v-card-title>      
      <v-card-text> 
            Status: {{ swpStatusHistory.swp_status }} <br />
            Comments: {{ swpStatusHistory.comments }} <br />
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
          @click="deleteSwpStatusHistory"
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
        swpStatusHistory: { type: Object, default: function () {return {swp_status: "",comments:""}}},
        deleteDialog: Boolean
    },
    methods: {
        deleteSwpStatusHistory() {
            this.loading = true
            this.$store.dispatch('deleteSwpStatusHistory',this.swpStatusHistory)
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