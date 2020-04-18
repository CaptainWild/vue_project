<template>
    <v-dialog v-model="deleteDialog" max-width="380" persistent>
  <v-card>
      <v-card-title class="headline">DELETE this Permit to Work?</v-card-title>      
      <v-card-text> 
            Id: {{ ptw.id }} <br />
            High-Risk Work: {{ ptw.hrw_name }} <br />
            Start Date: {{ ptw.start_date }} <br />
            End Date: {{ ptw.end_date }} <br />
            Location: {{ ptw.location }} <br />
            Work to perform: {{ ptw.work_to_be_done }}
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
          @click="deletePtw"
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
        ptw: { 
            type: Object, 
            default: function () {
                return { 
                    reference_no: "",
                    hrw_name: "",
                    start_date:"",
                    end_date: "",
                    location: "",
                    work_to_be_done: ""
                }
            }
        },
        deleteDialog: Boolean
    },
    methods: {
        deletePtw() {
            this.loading = true
            this.$store.dispatch('deletePtw',this.ptw)
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

<style>

</style>