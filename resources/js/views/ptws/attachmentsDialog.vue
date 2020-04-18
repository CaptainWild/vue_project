<template>
  <v-dialog v-model="attachmentDialog" max-width="900" persistent scrollable>
    <v-card>
      <v-card-title class="headline">{{title}}</v-card-title>      
      <v-card-text>        
          <Attachments
            :key = "reference_id"
            :reference_id = "reference_id"
            reference_table = "ptws"
            folder_name = "/attachments/ptw"
            :showSelect="false"
          >
          </Attachments>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn 
            color="error darken-1" 
            raised 
            @click="$emit('close-dialog')"
        >
        Close
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import Attachments from '@/js/views/attachments/index';
export default {
    components : {
      Attachments
    },
    props: {      
      reference_id: Number,
      reference_no: String,
      attachmentDialog: Boolean
    },
    computed: {
        title() {
          return "Attachments ("+ this.reference_no+")"
        }
    }
}
</script>