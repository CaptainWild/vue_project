<template>
  <v-dialog v-model="value" max-width="340" persistent>
  <v-card>
      <v-card-title class="headline">CANCEL this Event?</v-card-title>      
      <v-card-text>
        Title: {{event.title}} <br />
        Date: {{event.start_date}} - {{event.end_date}} <br />
        Time: {{event.start_time}} - {{event.end_time}} <br />
        Description: {{event.description}} <br />
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn 
          color="error darken-1" 
          raised 
          @click="$emit('reinitialize-events')"
        >
        No
        </v-btn>
        <v-btn 
          color="success darken-1" 
          raised 
          @click="cancelEvent"
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
        event: { type: Object, default: function () { 
            return {
                    title: "",
                    start_date: "", end_date: "",
                    start_time: "", end_time: "",
                    description:""
                }   
            }
        },
        value: Boolean
    },
    methods: {
        cancelEvent() {
            this.loading = true
            this.$store.dispatch('cancelEvent',this.event)
            .then(response => {
                this.loading = false;
                this.$emit('reinitialize-events')
                setTimeout(() => {                
                    this.$store.commit('closeSnackbar');
                },2000);           
            }).catch(()=> {this.loading = false });
        }
    }     
}
</script>