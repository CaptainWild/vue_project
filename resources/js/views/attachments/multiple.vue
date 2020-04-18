<template>
    <div>
    <v-form @submit.prevent="save" ref="form" v-model="valid">
        <v-container fluid>
            <v-row>
                <v-col cols="12" md="10" sm="12">
                    <v-file-input                        
                        v-model="full_path"
                        counter
                        small-chips
                        label="Attachments"
                        multiple
                        placeholder="Select files"
                        :show-size="1000"   
                    >
                    <template v-slot:selection="{ index, text }">
                        <v-chip
                            v-if="index < 2"
                            dark
                            label
                            small
                        >
                            {{ text }}
                        </v-chip>

                        <span
                            v-else-if="index === 2"
                            class="overline grey--text text--darken-3 mx-2"
                        >
                            +{{ full_path.length - 2 }} File(s)
                        </span>
                    </template>
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
        reload: Boolean
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

                attachmentForm.append('folder_name',this.folder_name);
                
                for( var i = 0; i < this.full_path.length; i++ ){
                    let file = this.full_path[i];
                    attachmentForm.append('full_path[' + i + ']', file);
                }    

                attachmentForm.append('reference_id',this.attachment.originalData.reference_id);
                attachmentForm.append('reference_table',this.attachment.originalData.reference_table);            
            
                this.$store.dispatch('createAttachments',attachmentForm)
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
                    this.loading = false
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