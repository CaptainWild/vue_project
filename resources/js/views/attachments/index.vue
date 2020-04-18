<template>
    <div>
    <v-form @submit.prevent="save" ref="form" v-model="valid">
        <v-container fluid>
            <v-row>
                <v-col cols="12">
                    <v-textarea
                        autofocus
                        auto-grow
                        prepend-icon="mdi-comment"
                        clearable
                        rows="1"
                        label="Description"
                        v-model="description"
                    ></v-textarea>
                </v-col>
                <v-col cols="12" md='10' sm="12">
                    <v-file-input                                                
                        clearable
                        v-model="full_path"
                        counter
                        label="*File"            
                        placeholder="Select a file"
                        prepend-icon="mdi-paperclip"            
                        :show-size="1000"
                        :rules="full_pathRules"
                    >                  
                    </v-file-input>
                </v-col>
                <v-col cols=12  md='2' sm="12" >
                    <v-btn 
                        type ="submit" 
                        color="success darken-1" 
                        raised                                          
                        :loading="loading"
                        :disabled="!valid"
                    >
                    Upload
                    </v-btn>
                </v-col>
            </v-row>   
                 
        </v-container>       
    </v-form>
    <v-data-table
        :headers="headers"
        :items="attachmentList"
        :items-per-page="5"
        :loading="tableLoader"
        single-select        
        :show-select="showSelect"
        class="elevation-1"
        @item-selected="rowSelected"
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

    </div>
</template>

<script>
import Form from '@/js/core/form';
import DeleteConfirmDialog from '@/js/views/attachments/DeleteConfirmDialog';

export default {
    components: {
        DeleteConfirmDialog
    },
    props: {
        reference_id: Number,
        reference_table: String,
        folder_name: String,
        reload: Boolean,
        showSelect: {type:Boolean, default: true}
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
        full_path: [],
        full_pathRules: [
            v => !!v || 'An Attachment is required',
            v => (v != null && v.size > 0) || 'An Attachment is required',   
        ],
        description:'',
        headers: [
            { text: 'Id', value: 'id' },
            { text: 'File Name', value: 'file_name'},
            { text: 'Description', value: 'description' },
            { text: 'Date Uploaded ', value: 'created_at' },
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
          this.attachments = this.$store.getters.attachments;
          return this.attachments;          
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
                this.setPrimary()
            })
            .catch( error => {
                this.tableLoader = false;
                console.log(error);
            });
        },

        reset () {
            this.$refs.form.reset()
        },

        save () {    
            this.loading = true       
            if (this.$refs.form.validate()) {
                let attachmentForm = new FormData();

                attachmentForm.append('description',this.description);
                attachmentForm.append('folder_name',this.folder_name);
                attachmentForm.append('full_path',this.full_path);
                attachmentForm.append('reference_id',this.attachment.originalData.reference_id);
                attachmentForm.append('reference_table',this.attachment.originalData.reference_table);            
            
                this.$store.dispatch('createAttachment',attachmentForm)
                .then(response => {  
                    this.loading = false   
                    this.reset()                       
                    this.initializeAttachments();
                    setTimeout(() => {                
                        this.$store.commit('closeSnackbar');
                    },2000);              
                })
                .catch(error=> {
                    console.log(error);
                });      
            } else {
                this.loading = false   
            }           
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

        rowSelected (row) {
            this.attachment = new Form({
                id: row.item.id,
                reference_id: row.item.reference_id,
                reference_table: row.item.reference_table,
                folder_name: row.item.folder_name,
                is_primary: 1
            });     

            this.$store.dispatch('primaryAttachment', this.attachment)
            .then(() => {
                 setTimeout(() => {                
                        this.$store.commit('closeSnackbar');
                    },2000);   
            }).catch(error => {console.log(error)});
        },

        setPrimary() {
            for(var attachment of this.attachments){
                if(attachment.is_primary) {
                    this.selected.push(attachment);
                }
            }
        }

    }
}
</script>