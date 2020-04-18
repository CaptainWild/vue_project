<template>
  <v-dialog v-model="deleteDialog" max-width="420" persistent>
  <v-card>
      <v-card-title class="headline">DELETE this Inspection Checklist?</v-card-title>      
      <v-card-text> 
            Id: {{ inspectionChecklist.id }} <br />
            Checklist: {{ inspectionChecklist.checklist.name }} <br />
            Work to be done: {{ inspectionChecklist.work_to_be_done }} <br />
            Location: {{ inspectionChecklist.location }}
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
          @click="deleteInspectionChecklist"
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
        inspectionChecklist: {},
        loading: false,
    }),
    props: {
        deleteDialog: Boolean
    },
    created() {
      this.inspectionChecklist = this.$store.getters.inspectionchecklist;
    },
    methods: {
        deleteInspectionChecklist() {
            this.loading = true
            this.$store.dispatch('deleteInspectionChecklist',this.inspectionChecklist)
            .then(response => {
                this.$store.commit('RESET_INSPECTION_CHECKLIST');
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