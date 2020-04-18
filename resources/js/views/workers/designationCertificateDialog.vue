<template>
    <v-dialog v-model="dialogDesignationCertificate" max-width="900" persistent scrollable>           
    <v-card>
      <v-card-title class="headline"><span>{{workerName}}</span>&nbsp;&nbsp;{{workerEmpno}}&nbsp;&nbsp;Designations</v-card-title>
      <v-card-text>
          <v-data-table
              :headers="headers"
              :items="designationList"        
              sort-by="id"
              sort-desc
              class="elevation-1"
              :loading="loading"
              :search="search"
              v-model="designationsComputed"
              :show-select="showSelect"
              @item-selected="rowSelected"
          >

            <template v-slot:header.data-table-select>
                <span></span>
            </template>

            <template v-slot:item.data-table-select="{isSelected, select ,item}">
                <span v-if="item.full_path == null || item.full_path == ''"><v-icon>mdi-close</v-icon></span>                
                <v-simple-checkbox :value="isSelected" @input="select($event)" v-else></v-simple-checkbox>
            </template>

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
        v-model="workerCertificate.id"
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
    props: ['value','dialogDesignationCertificate','showSelect', 'workerName','workerEmpno'],
    data: () => ({ 
        valid: true,
        search: '',       
        loading: true,
        designations: [],
        workers: [],
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
        workerCertificates: [],
        workerCertificateIndex: -1,
        workerCertificate: {}  
    }),
    computed: {
        workerList () {  
          this.workers = this.$store.getters.workers;
            return this.workers
        }, 
        designationList() {
          this.workerCertificates = this.$store.getters.workercertificates;
          return this.workerCertificates;
        },
        designationsComputed : {
            get() {        
                return this.$store.getters.workercertificateIds[this.value]
            }, 
            set(newVal) {
                return newVal
            }
        }
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
            this.workerCertificate = {}
            this.workerCertificateIndex = -1
            this.$store.commit('RESET_WORKER_CERTIFICATE')
        },
        initialize() {
            this.loading = true
            
            this.$store.dispatch('fetchWorkerCertificates', {id:this.value})
              .then(() => { this.loading = false})
        },
        setDeleteDesignation(item) {
          this.$store.commit('SET_WORKER_CERTIFICATE',item)

          this.deleteDialog = true;
        },
        upload(item) {
          this.workerCertificateIndex = this.workerCertificates.indexOf(item)
          
          this.workerCertificate.id = item.id

          this.$store.commit('SET_WORKER_CERTIFICATE',item)
          
          this.dialogUpload = true
        },
        download(item) {
            this.rowIndex = item.id;
            this.dlLoading = true;

            this.$store.dispatch('downloadWorkerCertificateFile', item)
            .then(response => {
                //console.log(response)
                this.dlLoading = false;
                window.open(response);
            })
            .catch(error => {
                this.dlLoading = false;
            })
        },
        
        rowSelected (row) {
            this.$store.commit('SET_WORKER_CERTIFICATE_ID',{
              'checked':row.value, 
              'workerid':this.value, 
              'workercertificateid':row.item}
            )        
        }
    }
}
</script>