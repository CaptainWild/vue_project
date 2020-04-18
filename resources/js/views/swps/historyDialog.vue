<template>
  <v-dialog v-model="historyDialog" max-width="900" persistent scrollable>
    <v-card>
      <v-card-title class="headline">{{historyDialogTitle}} History</v-card-title>      
      <v-card-text>        
          <SwpStatusHistory
            :key = "swp.id"
            :swp = "swp"
          ></SwpStatusHistory>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn 
            color="error darken-1" 
            raised 
            @click="$emit('update:historyDialog',false)"
        >Close</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import SwpStatusHistory from '@/js/views/swpstatushistory/index';
export default {
    components : {
      SwpStatusHistory
    },
    computed: {
      historyDialogTitle() {
        return this.swp.ref_no + ' (' + this.swp.activity +')';
      }
    },
    props: {      
      historyDialog: Boolean,
      swp: Object
    }
}
</script>