<template>
  <v-dialog v-model="deleteDialog" max-width="340" persistent>
  <v-card>
      <v-card-title class="headline">DELETE this high-risk work checklist item?</v-card-title>      
      <v-card-text> 
            Sequence No.: {{ hrwChecklist.seq_no }} <br />
            Description: {{ hrwChecklist.description }}
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
          @click="deleteHrwChecklist"
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
        hrwChecklist: { type: Object, default: function () {return {seq_no: "",description:""}}},
        deleteDialog: Boolean
    },
    methods: {
        deleteHrwChecklist() {
            this.loading = true
            this.$store.dispatch('deleteHrwChecklist',this.hrwChecklist)
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