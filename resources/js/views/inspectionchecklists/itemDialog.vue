<template>
  <v-dialog v-model="itemsDialog" max-width="1000" persistent scrollable>
    
    <v-card>
        <v-card-title>Inspection Dates for {{inspectionchecklist.checklist.name }} (#{{inspectionchecklist.id}})</v-card-title>
        <v-card-subtitle class="ml-2 pt-2">
            <v-row>
                <v-col cols="12" sm="6">
                    <v-text-field
                        :value="inspectionchecklist.project.title"
                        label="Project"
                        readonly
                        dense
                    ></v-text-field>
                </v-col>
                  <v-col cols="12" sm="6">
                    <v-text-field
                        :value="inspectionchecklist.subcontractor.name"
                        label="Sub-Contractor"
                        readonly
                        dense
                    ></v-text-field>
                </v-col>
                  <v-col cols="12" sm="6">
                    <v-text-field
                        :value="inspectionchecklist.location"
                        label="Area"
                        readonly
                        dense
                    ></v-text-field>
                </v-col>
                  <v-col cols="12" sm="6">
                    <v-text-field
                    :value="inspectionchecklist.work_to_be_done"
                    label="Work to be done"
                    readonly
                    dense
                    ></v-text-field>
                </v-col>
            </v-row>         
        </v-card-subtitle>
        
        <v-card-text>
            <InspectionChecklistItem
                :inspectionchecklist="inspectionchecklist"
                @refresh='closeDialog'
                v-model="inspectionchecklist.id"
            ></InspectionChecklistItem>
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
import InspectionChecklistItem from '@/js/views/inspectionchecklistitems/index';
export default {
    components : {
        InspectionChecklistItem
    },
    data () {
        return {    
          inspectionchecklist: {},
        }
     },
    props: {   
        itemsDialog: Boolean
    },
    created() {       
        this.inspectionchecklist = this.$store.getters.inspectionchecklist;
    },
    methods: {
        closeDialog() {
            this.$emit('update:itemsDialog',false)
            this.$emit('refresh')
        }
    }
}
</script>