<template>
  <v-dialog v-model="attachmentDialog" max-width="900" persistent scrollable>
    <v-card>
      <v-card-title class="headline">Attachments</v-card-title>      
      <v-card-text>        
          <Attachment
            :key = "reference_id"
            :reference_id = "reference_id"
            reference_table = "archives"
            folder_name = "/attachments/archives"
          >
          </Attachment>
      </v-card-text>
      <v-card-actions>
        
        <v-btn 
            color="secondary" 
            raised 
            @click="$emit('close-dialog')"
        >
        Close
        </v-btn>
        <v-spacer></v-spacer>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import Attachment from '@/js/views/attachments/index';
export default {
    components : {
      Attachment
    },
    props: {      
      reference_id: Number,
      attachmentDialog: Boolean
    }
}
</script>