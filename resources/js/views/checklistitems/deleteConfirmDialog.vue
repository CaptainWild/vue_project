<template>
  <v-dialog v-model="deleteDialog" max-width="340" persistent>
  <v-card>
      <v-card-title class="headline">DELETE this Checklist Item?</v-card-title>      
      <v-card-text> 
            Id: {{ checklistItem.id }} <br />
            Sequence No.: {{ checklistItem.seq_no }} <br />
            Description: {{ checklistItem.description }}
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
          @click="deleteChecklistItem"
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
        checklistItem: { type: Object, default: function () {return {seq_no: "",description:""}}},
        deleteDialog: Boolean
    },
    methods: {
        deleteChecklistItem() {
            this.loading = true
            this.$store.dispatch('deleteChecklistItem',this.checklistItem)
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