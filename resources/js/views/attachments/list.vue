<template>
    <v-dialog v-model="attachmentDialog" max-width="900" persistent scrollable>
    <v-card>
      <v-card-title class="headline">Attachments</v-card-title>      
        <v-card-text> 
            <v-data-table
                :headers="headers"
                :items="attachmentList"
                :items-per-page="5"
                :loading="tableLoader"
                class="elevation-1"
                v-model="selected"
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

                <v-btn 
                    text 
                    icon 
                    dark
                    color="error"
                    @click="setAttachmentDeletion(item)"
                >
                    <v-icon>mdi-delete</v-icon>
                </v-btn>

            </template>
            </v-data-table>

            <DeleteConfirmDialog 
                :attachment = "attachment"
                :deleteDialog = "dialog"
                @close-dialog = "dialog = false"
                @reload-attachments = 'initializeAttachments'
            ></DeleteConfirmDialog>
        </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn 
            color="error darken-1" 
            raised 
            @click="$emit('update:attachmentDialog',false)"
        >
        Close
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>  
</template>

<script>
import Form from '@/js/core/form';
import DeleteConfirmDialog from '@/js/views/attachments/DeleteConfirmDialog';

export default {
    components: {
        DeleteConfirmDialog
    },
    props: {
        attachmentDialog: Boolean,        
        folder_name: String,
        reference_id: Number,
        reference_table: String        
    },
    data () {
      return {
        valid: true,
        rowIndex: 0,
        dlLoading: false,
        dialog: false, 
        tableLoader:false,
        loading: false,        
        selected: [],
        headers: [
            { text: 'Id', value: 'id' },
            { text: 'File Name', value: 'file_name'},
            { text: 'Uploaded At', value: 'created_at' },
            { text: 'Uploaded By', value: 'created_by' },
            { text: 'Actions', value: 'action', sortable: false, filterable: false },
        ],
        attachments: [],
        attachmentIndex: - 1,
        attachment: new Form({
            reference_id: this.reference_id,
            reference_table: this.reference_table,
            folder_name: this.folder_name
        })       
      }
    },

    computed: {   
        attachmentList () {  
          return this.$store.getters.attachments;
        },          
    },

    watch: {
        reference_id:{
            immediate: true,
            handler(val, oldVal) {
                this.initializeAttachments()                
            }            
        },      
    },
    
    methods: {
        
        initializeAttachments() {
            this.tableLoader = true;
            this.$store.dispatch('fetchAttachments',this.attachment)
            .then(() => {
                this.tableLoader = false;
            })
            .catch( error => {
                this.tableLoader = false;
                console.log(error);
            });
        },

        setAttachmentDeletion (item) {        
            this.attachmentIndex       = this.attachments.indexOf(item);
            
            this.attachment.id         = item.id
            this.attachment.description= item.description
            this.attachment.file_name  = item.file_name

            this.dialog = true;
        },

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