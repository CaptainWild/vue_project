<template>
 <v-dialog v-model="attachmentsDialog" max-width="900" persistent scrollable>
    <v-card>
        <v-card-title class="headline">Attachments</v-card-title>      
        <v-card-text>        
            <v-data-table
                :headers="headers"
                :items="attachments"
                :items-per-page="5"
                class="elevation-1"        
                sort-by="created_at"
                sort-desc
            >

                <template v-slot:item.action="{ item }">      
            
                <v-btn 
                    text 
                    icon 
                    dark
                    color="info"
                    :loading="dlLoading && rowIndex === item.id"
                    @click="download(item)"
                >
                    <v-icon>mdi-download</v-icon>
                </v-btn>   

                </template>
            </v-data-table>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn 
                    color="secondary" 
                    raised 
                    @click="$emit('update:attachmentsDialog', false)"
                >
                Close
                </v-btn>
            </v-card-actions>
    </v-card>
</v-dialog>
</template>

<script>
export default {
    props: {
        attachmentsDialog: Boolean
    },
    
    data () {
      return {
        rowIndex: 0,
        dlLoading: false,
        headers: [
            { text: 'File Name', value: 'file_name'},
            { text: 'Description', value: 'description'},
            { text: 'Date Uploaded ', value: 'created_at' },
            { text: 'Download', value: 'action', sortable: false, filterable: false },
        ],         
      }
    },

    computed: {
        attachments () { 
          return this.$store.getters.ptw.attachments;       
        },   
    },
    
    methods: {

        download (item) {
            this.rowIndex = item.id;
            this.dlLoading = true;
            this.$store.dispatch('downloadFile', item)
            .then(response => {
                this.dlLoading = false;
                window.open(response);
            })
            .catch(error => {
                this.dlLoading = false;
            })
        },
    }

}
</script>