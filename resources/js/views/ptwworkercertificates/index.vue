<template>
    <v-dialog v-model="dialogDesignationCertificate" max-width="900" persistent scrollable>           
    <v-card>
      <v-card-title>Designations</v-card-title>
      <v-card-text>
          <v-data-table
              :headers="headers"
              :items="designationList"        
              sort-by="id"
              sort-desc
              class="elevation-1"
              :loading="loading"
              :search="search"
              v-model="designations"
          >

            <template v-slot:item.role_id="{ item }">
                <span>{{ item.role.name }}</span>
            </template>
            
            <template v-slot:item.updated_at="{ item }">
                <span v-if="item.full_path != null && item.full_path != ''">{{new Date(item.updated_at).toLocaleDateString()}}</span>
            </template>

            <template v-slot:item.expiry_at="{ item }">
                <span v-if="item.expiry_at != null && item.full_path != ''">{{new Date(item.expiry_at).toLocaleDateString()}}</span>
            </template>

            <template v-slot:item.action="{ item }">
              
              <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                      <v-btn 
                        v-on="on"
                        text 
                        icon 
                        dark
                        color="info"
                        @click="upload(item)"
                      >
                        <v-icon>mdi-file-upload</v-icon>
                      </v-btn>
                  </template>
                  <span>Upload File</span>
              </v-tooltip>

              <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                      <v-btn 
                        v-on="on"
                        text 
                        icon 
                        dark
                        color="warning"
                        v-show="item.full_path != null"
                        :loading="dlLoading && rowIndex === item.id"
                        @click="download(item)"
                      >
                          <v-icon>mdi-download</v-icon>
                      </v-btn>
                  </template>
                  <span>View File</span>
              </v-tooltip>

              <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                      <v-btn 
                        v-on="on"
                        text 
                        icon 
                        dark
                        color="error"
                        @click="setDeleteDesignation(item)"
                      >
                          <v-icon>mdi-delete</v-icon>
                      </v-btn>
                  </template>
                  <span>Delete</span>
              </v-tooltip>

            </template>
            
            <template v-slot:loading>
              <span>Fetching Data...</span>
            </template>
          </v-data-table>
      </v-card-text>
      <v-card-actions>
        <v-btn 
            color="secondary" 
            raised 
            @click="$emit('update:dialogDesignationCertificate',false)"
        >Close</v-btn>
        <v-spacer></v-spacer>        
      </v-card-actions>

      <DeleteConfirmDialog 
          v-if="deleteDialog"
          :deleteDialog.sync = "deleteDialog"
          @refresh="initialize"
      ></DeleteConfirmDialog>

      <UploadCertificateFormDialog
        v-model="ptwWorkerCertificate.id"
        :dialogUpload.sync = "dialogUpload"
        @refresh="initialize"
      ></UploadCertificateFormDialog>

    </v-card>
  </v-dialog>
</template>

<script>
import DeleteConfirmDialog from '@/js/views/workers/deleteDesignationCertificateConfirmDialog';
import UploadCertificateFormDialog from '@/js/views/workers/uploadCertificateFormDialog';
export default {
    components : {
      DeleteConfirmDialog,
      UploadCertificateFormDialog
    },
    props: ['value','dialogDesignationCertificate','ptwId'],
    data: () => ({ 
        valid: true,
        search: '',       
        loading: true,
        designations: [],
        dialog: false,
        dialogUpload: false,
        deleteDialog: false,
        dlLoading: false,
        headers: [
            { text: 'Id', value: 'id' },
            { text: 'Designation', value: 'role_id',},                        
            { text: 'Description', value: 'description'},            
            { text: 'Upload Date', value: 'updated_at' },
            { text: 'Valid Until', value: 'expiry_at' },
            { text: 'Actions', value: 'action', sortable: false ,filterable: false},
        ],
        rowIndex: 0,        
        ptwWorkerCertificates: [],
        ptwWorkerCertificateIndex: -1,
        ptwWorkerCertificate: {}  
    }),
    computed: {
        designationList() {
          this.ptwWorkerCertificates = this.$store.getters.ptwworkercertificates;
          return this.ptwWorkerCertificates;
        },    
    },
    created(){
        this.initialize()
    },
     watch: {
        dialogUpload (val) {                
          val || this.close()
        },
        deleteDialog(val) {
            val || this.close()
        }   
    },
    methods : {
        close() {
            this.ptwWorkerCertificate = {}
            this.ptwWorkerCertificateIndex = -1
            this.$store.commit('RESET_PTW_WORKER_CERTIFICATE')
        },
        initialize() {
            this.loading = true
            
            this.$store.dispatch('fetchPtwWorkerCertificates', {worker_id: this.value,ptw_id: this.ptwId})
              .then(() => { this.loading = false})
        },
        setDeleteDesignation(item) {
          this.$store.commit('SET_PTW_WORKER_CERTIFICATE',item)

          this.deleteDialog = true;
        },
        upload(item) {
          this.ptwWorkerCertificateIndex = this.ptwWorkerCertificateIndex.indexOf(item)
          
          this.ptwWorkerCertificate.id = item.id

          this.$store.commit('SET_PTW_WORKER_CERTIFICATE',item)
          
          this.dialogUpload = true
        },
        download(item) {
            this.rowIndex = item.id;
            this.dlLoading = true;

            this.$store.dispatch('downloadPtwWorkerCertificateFile', item)
            .then(response => {
                //console.log(response)
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