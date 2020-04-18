<template>
    <div>
      <v-card>
        <v-card-title>
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search"
            single-line
            hide-details
            clearable
          ></v-text-field>                
        </v-card-title>
      </v-card>      
    <v-data-table
        :headers="headers"
        :items="archiveList"        
        sort-by="name"
        sort-desc
        class="elevation-1"
        :loading="loading"
        :search="search"
    >
    <template v-slot:top>      
        <v-toolbar flat > 
          <v-toolbar-title>
              Archives
          </v-toolbar-title>
          <v-divider
            class="mx-4"
            inset
            vertical
          ></v-divider>
          
          <v-spacer></v-spacer> 
                         
          <v-dialog v-model="dialog" max-width="500px" persistent>
            <template v-slot:activator="{ on }">
                <v-btn color="primary" dark class="mb-2" v-on="on" >
                    New
                </v-btn>
            </template>
            
            <v-card>
              <v-form @submit.prevent="save" ref="form"  >
              <v-card-title>
                <span class="headline">{{ formTitle }}</span>
              </v-card-title>
              <v-card-text>
                <v-container>
                    <v-row>
                      <v-col cols="12">
                        <v-text-field 
                            v-if="dialog" autofocus
                            ref="title"
                            required                              
                            clearable 
                            v-model="archive.name" 
                            label="*Name"
                            type="text"
                            :error-messages="archive.errors.get('name')"
                            @keydown="archive.errors.clear('name')"                              
                          ></v-text-field>
                      </v-col>                             
                      <v-col cols="12">
                          <v-textarea 
                            auto-grow 
                            clearable 
                            v-model="archive.description" 
                            label="Description">
                          </v-textarea>
                      </v-col>                    
                    </v-row>
                </v-container>
              </v-card-text>

                <v-card-actions>
                  <v-btn raised color="secondary darken-1" dark @click="close">
                    Cancel
                  </v-btn>
                  <v-spacer></v-spacer>                  
                  <v-btn 
                    raised 
                    color="success darken-1" 
                    dark 
                    type="submit"
                    :disabled="archive.errors.any()"                  
                    :loading="loading"
                  >
                    Save
                  </v-btn>
                </v-card-actions>
              </v-form>
            </v-card>
          </v-dialog>
          <v-btn 
            class="mb-2 ml-1" 
            color="success darken-1"
            fab 
            dark 
            small
            @click="initialize" 
            :loading="loading"
          >
            <v-icon dark>mdi-refresh</v-icon>
          </v-btn> 
      </v-toolbar>
    </template>


    <template v-slot:item.action="{ item }">
        <v-btn
            text
            icon
            dark
            color="primary"
            @click="editArchive(item)"
        >
        <v-icon> mdi-file-edit</v-icon>
        </v-btn>
      
        <v-btn 
            text 
            icon 
            dark
            color="error"
            @click="setDeleteArchive(item)"
        >
        <v-icon>mdi-delete</v-icon>
        </v-btn>

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
            color="warning"
            @click="attach(item)"
        >
            <v-icon>mdi-file-multiple</v-icon>
        </v-btn> 
    
    </template>
    <template v-slot:loading>
      <span>Fetching Data...</span>
    </template>
  </v-data-table>

    <DeleteConfirmDialog 
        :archive = "archive"
        :deleteDialog = "dialogRm"
        @close-dialog = "dialogRm = false"
        @reload-archives = 'initialize'
    ></DeleteConfirmDialog>

     <AttachmentDialog       
        v-if="dialogAttachment"  
        :reference_id = "archive.id"
        :attachmentDialog = "dialogAttachment"
        @close-dialog = "dialogAttachment = false"
    ></AttachmentDialog>

  </div>
</template>
<script>
import Form from '@/js/core/form';
import DeleteConfirmDialog from '@/js/views/archives/DeleteConfirmDialog';
import AttachmentDialog from '@/js/views/archives/AttachmentDialog';

  export default {
    components: {
        AttachmentDialog,
        DeleteConfirmDialog
    },
    data: () => ({ 
        search: '',
        rowIndex: 0,
        dlLoading: false,       
        loading: true,        
        dialog: false,
        dialogAttachment: false,
        dialogRm: false,        
        headers: [
            { text: 'Id', value: 'id' },
            { text: 'Name', value: 'name',},            
            { text: 'Description', value: 'description', align: 'left' },
            { text: 'Date Created', value: 'created_at'},
            { text: 'Actions', value: 'action', sortable: false, filterable: false },
        ],
        archives: [],
        archiveIndex: -1,
        archive: new Form({
            name: '',
            description: '',
        })       
    }),

    computed: {
        formTitle () {
            return this.archiveIndex === -1 ? 'New Archive' : 'Edit Archive'
        },       
        archiveList () {  
          this.archives = this.$store.getters.archives;
          return this.archives;          
        }     
    },

    watch: {
      dialog (val) {                
        val || this.close()        
      },
      dialogAttachment (val) {
        if(!val) {
          this.archiveIndex = -1
          this.archive.reset()
          this.initialize()
        }
      }
    },

    created () {
      this.initialize()
    },

    methods: {

      initialize () { 
        this.loading = true
        this.$store.dispatch('fetchArchives',this.archive)
          .then(()=> {
            this.loading = false
          });               
      },
      
      attach (item) {
        this.archiveIndex       = this.archives.indexOf(item);
        
        this.archive.id         = item.id;

        this.dialogAttachment = true;
      },

      editArchive (item) {        
        this.archiveIndex       = this.archives.indexOf(item);
        
        this.archive.id         = item.id;
        this.archive.name       = item.name;
        this.archive.description= item.description;

        this.dialog = true;
      },

      setDeleteArchive (item) {        
        this.archiveIndex = this.archives.indexOf(item);

        this.archive.id         = item.id;
        this.archive.name       = item.name;
        this.archive.description= item.description;

        this.dialogRm = true;
      },
    
      close () {
        this.dialog = false
        this.$refs.form.reset()
        this.archive.reset()
        this.archiveIndex = -1        
      },

      closeRm() {
        this.dialogRm = false
        this.archive.reset()
        this.archiveIndex = -1
      },

      closeSnackBar() {
        setTimeout(() => {                
          this.$store.commit('closeSnackbar');
        },2000); 
      },

      save () { 
        this.loading = true       
        
        var action = 'createArchive';
        if (this.archiveIndex > -1) {
          action = 'updateArchive'
        } 

        this.$store.dispatch(action,this.archive)
          .then(response => {               
            this.close()
            this.initialize()            
            this.closeSnackBar()
          })
          .catch(()=> {
            
          });
               
      },
      
      download (item) {
        var rowItem = item.attachments[0];
                      
        this.rowIndex = item.id;
        this.dlLoading = true;

        this.$store.dispatch('downloadFile', rowItem)
          .then(response => {            
              this.dlLoading = false;
              if(response != undefined) {
                window.open(response);
              }              
          })
          .catch(error => {
              this.dlLoading = false;                  
          });

        this.closeSnackBar()
      },

    },
  }
</script>