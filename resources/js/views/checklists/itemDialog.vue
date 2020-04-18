<template>
  <v-dialog v-model="itemsDialog" max-width="1000" persistent scrollable>
    <v-card>
      <v-card-title class="headline">{{checklist.name}} Items </v-card-title>      
      <v-card-text>    
          <ChecklistItem
          v-model="checklist.id">
          </ChecklistItem>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn 
            color="secondary" 
            raised 
            @click="closeDialog"
        >
        Close
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import ChecklistItem from '@/js/views/checklistitems/index';
export default {
    components : {
      ChecklistItem
    },
    data () {
        return {    
          checklist: {},
        }
     },
    props: {   
        itemsDialog: Boolean
    },
    created() {
        this.checklist = this.$store.getters.checklist;
    },
    methods: {
        closeDialog() {
            this.$emit('update:itemsDialog',false)
            this.$emit('refresh')
        }
    }
}
</script>