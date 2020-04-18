<template>
    <v-dialog v-model="workersDialog" max-width="700" persistent scrollable>
        <v-card>
            <v-card-title class="headline"></v-card-title>      
            <v-card-text>        
                <v-data-table
                    :headers="headers"
                    :items="workers"
                    :items-per-page="5"
                    :loading="loading"
                    :search="search"
                    class="elevation-1"
                    sort-by="name"
                    sort-desc
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
                            <v-text-field
                                    v-model="search"
                                    append-icon="mdi-magnify"
                                    label="Search"
                                    single-line
                                    hide-details
                                    clearable
                            ></v-text-field>      
                        </v-toolbar>
                    </template>

                    <template v-slot:item.designations="{ item }">
                        <span v-for="(element, index) in item.workercertificates" v-bind:key="index">{{ element.role.name }} <br/></span>
                    </template>

                    <template v-slot:item.files="{ item }">
      
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                            <v-btn 
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
                    @click="$emit('update:workersDialog', false)"
                >
                Close
                </v-btn>
                 <v-spacer></v-spacer>
                 <v-tooltip bottom>
                <template v-slot:activator="{ on }">                   
                    <v-btn 
                        v-show="$can.permit('manpower_upload') && approvedPtwComputed"
                        v-on="on"
                        raised
                        color="info" 
                        dark 
                        @click="attachmentDialog = true"                   
                    ><v-icon>mdi-attachment</v-icon></v-btn>
                </template>
                <span>Attachments</span>
                </v-tooltip>
            </v-card-actions>
        </v-card>
         
        <ApprovedAttachmentDialog
            v-if="attachmentDialog"
            :reference_id = "ptwIdComputed"
            :attachmentDialog.sync ="attachmentDialog"
            src_mod = "workers"
        ></ApprovedAttachmentDialog> 

        <DesignationCertificateDialog     
            v-if="dialogDesignationCertificate"
            v-model = "worker.id"
            :ptwId = "ptwIdComputed"
            :dialogDesignationCertificate.sync = "dialogDesignationCertificate"
        ></DesignationCertificateDialog>  
    </v-dialog> 
</template>

<script>
import DesignationCertificateDialog from '@/js/views/ptwworkercertificates/index';
import ApprovedAttachmentDialog from '@/js/views/ptws/approvedAttachmentsDialog';


export default {
    props: {
        workersDialog: Boolean
    },

    components: {
        ApprovedAttachmentDialog,
        DesignationCertificateDialog
    },

    data: () => ({
        attachmentDialog: false,
        dialogDesignationCertificate: false,
        headers: [
            { text: 'Name', value: 'name', align: 'left' },
            { text: 'NRIC/WP No.', value: 'emp_no'},
            { text: 'Designations', value: 'designations'},
            { text: 'Remarks', value: 'remarks'},
            { text: 'Files', value: 'files'},          
        ],
        loading: false,        
        search: '',
        worker:{},
        workerIndex: - 1,
    }),

    computed: {
        workers() {
          return this.$store.getters.ptw.workers;
        },
        ptwIdComputed() {
            return this.$store.getters.ptw.id
        },
        approvedPtwComputed() {
            if(this.$store.getters.ptw.ptw_status_id == 1 || this.$store.getters.ptw.ptw_status_id == 1 ) {
                return true
            }

            return false
        }        
    },

    methods: {
        attach (item) {
            this.workerIndex       = this.workers.indexOf(item);
            
            this.worker.id          = item.id;

            this.dialogDesignationCertificate = true;
        },
    }
}
</script>