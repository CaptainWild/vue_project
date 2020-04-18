<template>
  <v-dialog v-model="attachmentDialog" max-width="900" persistent scrollable>
    <v-card>
      <v-card-title class="headline">Certificates</v-card-title>      
      <v-card-text>        
          <Certificates
            :key = "reference_id"
            :reference_id = "reference_id"
            reference_table = "equips"
            folder_name = "/attachments/equips"
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
      attachmentDialog: Boolean
    }
}
</script>