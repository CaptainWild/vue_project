<template>
  <v-dialog v-model="checklistDialog" max-width="900" persistent scrollable>
    <v-card>
      <v-card-title class="headline">{{hrw.name}} Checklist</v-card-title>      
      <v-card-text>    
          <HrwChecklist
            :key = "hrw.id"
            :hrw = "hrw"
          >
          </HrwChecklist>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn 
            color="error darken-1" 
            raised 
            @click="$emit('update:checklistDialog',false)"
        >
        Close
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import HrwChecklist from '@/js/views/hrwchecklists/index';
export default {
    components : {
      HrwChecklist
    },
    props: {      
      hrw: { type: Object, default: function () {return {name: "",description:""}}},
      checklistDialog: Boolean
    }
}
</script>