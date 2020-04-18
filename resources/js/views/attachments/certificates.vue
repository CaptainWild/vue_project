<template>
    <div>
    <v-form @submit.prevent="save" ref="form" v-model="valid">
        <v-container fluid>
            <v-row>
                <v-col cols="12" md="8">
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
                <v-col cols="12" md="4">
                     <DatePicker
                        :dateLabel= "dateLabel"
                        :dateIcon = true
                        v-model ="expiry_at"
                        :readonly = false
                    ></DatePicker>
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
        class="elevation-1"
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
import DatePicker from '@/js/components/DatePicker';
import DeleteConfirmDialog from '@/js/views/attachments/DeleteConfirmDialog';

export default {
    components: {
        DatePicker,
        DeleteConfirmDialog
    },
    props: {
        reference_id: Number,
        reference_table: String,
        folder_name: String,
        reload: Boolean,
        src_mod: { type: String, default: "" }
    },
    data () {
      return {          
        attachments: [],
        attachmentIndex: - 1,
        attachment: new Form({
            reference_id: this.reference_id,
            reference_table: this.reference_table,
            folder_name: this.folder_name
        }),
        dateLabel: "Valid Until",       
        description:'',
        dialog: false, 
        dlLoading: false,        
        expiry_at: null,
        headers: [
            { text: 'Id', value: 'id' },
            { text: 'Description', value: 'description' },
            { text: 'Valid Until', value: 'expiry_at' },
            { text: 'Date Uploaded ', value: 'created_at' },
            { text: 'Actions', value: 'action', sortable: false, filterable: false },
        ],
        full_path: [],
        full_pathRules: [
            v => !!v || 'An Attachment is required',
            v => (v != null && v.size > 0) || 'An Attachment is required',   
        ],
        loading: false,     
        rowIndex: 0,
        selected: [],    
        tableLoader:false,    
        valid: true,        
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
            })
            .catch( error => {
                this.tableLoader = false;
                console.log(error);
            });
        },

        reset () {
            this.full_path = []
            this.$refs.form.reset()
        },

        save () {    
            this.loading = true       
            if (this.$refs.form.validate()) {
                let attachmentForm = new FormData();

                attachmentForm.append('description',this.description);
                attachmentForm.append('expiry_at',this.expiry_at);
                attachmentForm.append('folder_name',this.folder_name);
                attachmentForm.append('full_path',this.full_path);
                attachmentForm.append('reference_id',this.attachment.originalData.reference_id);
                attachmentForm.append('reference_table',this.attachment.originalData.reference_table);
                attachmentForm.append('src_mod',this.src_mod);
            
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

    }
}
</script>