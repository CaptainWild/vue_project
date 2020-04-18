<template>
    <div>
    <v-card>
        <v-card-title>
            <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Search Personnel"
                single-line
                hide-details
                clearable
            ></v-text-field>             
        </v-card-title>
    </v-card>  
    <v-data-table
        :headers="headers"
        :items="workersList"        
        sort-by="name"
        sort-desc
        class="elevation-1"
        :loading="loading"
        :search="search"
        show-select
        v-model="workers"
        @item-selected="rowSelected"
        @toggle-select-all="toggleAll"
    >
      <template v-slot:top>      
          <v-toolbar flat > 
            <v-toolbar-title>
                Personnel Involve
            </v-toolbar-title>
            <v-divider
              class="mx-4"
              inset
              vertical
            ></v-divider>
            <v-spacer></v-spacer>
            <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                <v-btn 
                    v-show="$can.permit('manpower_upload')"
                    v-on="on"
                    class="mb-2 ml-1"
                    color="primary"
                    dark
                    @click="uploadTemp"
                    :loading="loading"
                >
                    <v-icon dark>mdi-attachment</v-icon>
                    <v-icon dark>mdi-worker</v-icon>
                </v-btn> 
                </template>
                <span>Upload / Remove Manpower Attachment</span>
            </v-tooltip>
               
        </v-toolbar>
      </template>

        <template v-slot:item.files="{ item }">
      
            <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                <v-btn 
                    v-show="$can.permit('manpower_upload') && selectedRecordComputed(item.id)"
                    v-on="on"
                    text 
                    icon 
                    dark
                    color="warning"
                    @click="attach(item)"
                >
                <v-icon>mdi-file-multiple</v-icon>
                </v-btn>
                </template>
                <span>Files</span>
            </v-tooltip>

            <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                    <v-btn 
                        v-show="$can.permit('manpower_delete')"
                        v-on="on"
                        text 
                        icon 
                        dark
                        color="error"
                        @click="setDeleteWorker(item)"
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

    <DesignationCertificateDialog
        v-if="dialogDesignationCertificate"
        v-model = "worker.id"
        :dialogDesignationCertificate.sync= "dialogDesignationCertificate"
        :showSelect.sync = "showSelect"
    ></DesignationCertificateDialog>

    <DeleteConfirmDialog 
      :worker = "worker"     
      :deleteRemarkConfirmDialog.sync = "deleteRemarkConfirmDialog"
    ></DeleteConfirmDialog>

    <TempAttachments 
        v-if="tempAttachmentDialog"       
        :tempAttachmentDialog.sync="tempAttachmentDialog"
        src_mod = "workers"
        reference_table = "ptws"
        :reference_id.sync = "refId"
        title = "Upload / Remove Personnel Attachment(s)"
    >
    </TempAttachments>

    </div>     
</template>

<script>
import Form from '@/js/core/form';
import DesignationCertificateDialog from '@/js/views/workers/designationCertificateDialog';
import DeleteConfirmDialog from '@/js/views/workers/deleteRemarkDialog';
import TempAttachments from '@/js/views/attachments/indexStoreDialog';

export default {
    props: [
        'value',
        'workerIds',
    ],

    components: {
        DesignationCertificateDialog,
        TempAttachments,
        DeleteConfirmDialog,
    },

    data: () => ({ 
        dialogDesignationCertificate: false,
        deleteRemarkConfirmDialog: false,
        headers: [
            { text: 'Name', value: 'name', align: 'left' },
            { text: 'NRIC/WP No.', value: 'emp_no'},
            { text: 'Remarks', value: 'remarks'},
            { text: 'Files', value: 'files'},       
        ],
        loading: false,     
        refId: 0,
        search: '',
        showSelect: true,
        tempAttachmentDialog: false,       
        workers: [],
        worker: new Form({}),
        workerIndex: - 1,
    }),
     
    computed: {
        workersList() {
          return this.$store.getters.subcontractorWorkers;
        },       
    },
     
    watch: {
        value: {
            immediate: true,
            handler(val,oldVal) {
                this.initialize()                
            }            
        },
        
        deleteRemarkConfirmDialog(val) {
            if(!val) {
                this.closeDeleteRemarkConfirmDialog()
                this.initialize()
            }
        }

    },

    created() {
        if(this.$store.getters.ptw.id != undefined) {
            this.refId = this.$store.getters.ptw.id                
        }
    },

    methods: {

        initialize () { 
            if(this.value > 0) {
                this.loading = true
                this.$store.dispatch('fetchSubContractorWorkers',{sub_contractor_id:this.value})
                .then(()=> {
                    this.loading = false
                    this.selectedWorkers()
                });       
            }                  
        },
        
        attach (item) {
            this.workerIndex       = this.workers.indexOf(item);
            
            this.worker.id         = item.id;

            this.dialogDesignationCertificate = true;
        },

        rowSelected (row) {
            if(row.value) {
                this.workerIds.push(row.item.id)
            } else {
                this.workerIds.splice(this.workerIds.indexOf(row.item.id),1)
            }

            this.$store.commit('SET_WORKER_ROW_SELECTED',{checked: row.value, workerid: row.item.id})
        },

        selectedWorkers() {
            if(this.$store.getters.ptw.id != undefined) {
                var workers = this.$store.getters.ptw.workers
                if(workers.length > 0 ){
                    for(var worker of workers) {
                        this.workers.push(worker)
                        this.workerIds.push(worker.id)
                    }
                }                
            }
        },

        setDeleteWorker (item) {                
            
            this.workerIndex = this.workers.indexOf(item);

            this.worker.id               = item.id;
            this.worker.name             = item.name;
            this.worker.emp_no           = item.emp_no;
            this.worker.sub_contractor_id= item.sub_contractor_id;
            this.worker.subcontractor    = item.subcontractor.name;
            this.worker.remarks          = item.remarks

            this.deleteRemarkConfirmDialog = true;

        },

        toggleAll(items) {
            var workers = this.workersList 
            if(items.value) {
                for(var worker of workers) {
                    if(!this.workerIds.includes(worker.id)) {
                        this.workerIds.push(worker.id)
                    }                    
                }                
            } else {
                this.workerIds.splice(0,this.workerIds.length)
            }
        },

        selectedRecordComputed(rowid) {
            if(this.$store.getters.ptw.id != undefined) {
                var workers = this.$store.getters.ptw.workers
                for(var worker of workers) {
                    if(worker.id == rowid){
                        return true
                    }
                }

            } else {
                var workerCerts = this.$store.getters.workercertificateIds
                
                if(workerCerts.hasOwnProperty(rowid)){
                    return true
                }
            }
         
            return false
        },

        uploadTemp() {
            this.tempAttachmentDialog = true
        },

        closeDeleteRemarkConfirmDialog() {
        this.DeleteConfirmDialog = false
        this.workerIndex = -1
        },

    },
}
</script>