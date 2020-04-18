<template>
  <v-dialog v-model="attachmentDialog" max-width="900" persistent scrollable>
    <v-card>
      <v-card-title class="headline">Additional Attachments</v-card-title>      
      <v-card-text>        
          <Certificates
            :key = "reference_id"
            :reference_id = "reference_id"
            reference_table = "ptws"
            folder_name = "/attachments/ptws"
            :src_mod = "src_mod"
          >
          </Certificates>
      </v-card-text>
      <v-card-actions>
        <v-btn 
            color="secondary" 
            raised 
            @click="$emit('update:attachmentDialog',false)"
        >Close</v-btn>
        <v-spacer></v-spacer>        
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import Certificates from '@/js/views/attachments/certificates';
export default {
    components : {
      Certificates
    },
    props: {      
      reference_id: Number,
      attachmentDialog: Boolean,
      src_mod: String
    }
}
</script>