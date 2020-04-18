<template>
    <v-dialog v-model="revokeDialog" max-width="380" persistent>
  <v-card>
      <v-card-title class="headline">REVOKE this Permit to Work?</v-card-title>      
      <v-card-text> 
        <v-container>
            <v-row>    
            <v-col cols="12">
                Id: {{ ptw.id }} <br />
                High-Risk Work: {{ ptw.hrw.name }} <br />
                Start Date: {{ ptw.start_date }} <br />
                End Date: {{ ptw.end_date }} <br />
                Location: {{ ptw.location }} <br />
                Work to perform: {{ ptw.work_to_be_done }}
            </v-col>
            <v-col cols="12">
                <v-textarea 
                    auto-grow 
                    clearable 
                    v-model="ptw.remarks" 
                    rows="1"
                    label="Remarks">
                </v-textarea>
            </v-col> 
            </v-row>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn 
          color="error darken-1" 
          raised 
          @click="close"
        >
        No
        </v-btn>
        <v-btn 
          color="success darken-1" 
          raised 
          @click="revokePtw"
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
        ptw: {},
    }),
    props: {
        revokeDialog: Boolean
    },
    created () {
        this.ptw = Object.assign({},this.$store.getters.ptw)      
    },
    methods: {
        close() {
            this.$store.commit('CLEAR_PTW');
            this.$emit('update:revokeDialog',false)
            this.$emit('refresh')
        },

        revokePtw() {
            this.loading = true
            
            
            this.$store.dispatch('revokePtw',this.ptw)
            .then(response => {
                this.loading = false;
                this.close()
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