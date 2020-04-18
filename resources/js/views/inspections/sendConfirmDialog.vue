<template>  
    <v-dialog
      v-model="sendDialog"
      max-width="1100"
    >
      <v-card>
        <v-card-title class="headline">Send this Inspection? (#{{inspectionId}})</v-card-title>
 
        <v-card-text>
            <DetailsDataTable
                :inspectionId = "inspectionId"
            ></DetailsDataTable>
        </v-card-text>

        <v-card-actions>
            <v-btn 
                raised 
                color="secondary darken-1" 
                dark 
                @click="close"
            >Close</v-btn>
            <v-spacer></v-spacer>                        
            <v-btn 
                raised 
                color="success darken-1" 
                dark 
                :loading="loading"
                @click="sendInspection"
            >Send</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
</template>
<script>
import DetailsDataTable from '@/js/views/inspections/detailsDataTable';

export default {
    components: {
        DetailsDataTable,       
    },
    props: [
        'inspectionId',
        'sendDialog',        
      ],
    data () {
      return {
        loading: false,
      }
    },
    created() {
        this.initializeDetails()
    },
    methods: {
        close() {
           this.$emit('update:sendDialog', false) 
           this.$emit('refresh')
        },
        initializeDetails() {
            this.$store.dispatch('fetchInspectionItemsByInspectionId',{inspection_id: this.inspectionId})
        },
        sendInspection() {
            this.$store.dispatch('incompleteInspection',{inspection_id: this.inspectionId})
            .then(() => {
                this.close()                
            })
        }
    }
}
</script>