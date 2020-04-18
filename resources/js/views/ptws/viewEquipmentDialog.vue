<template>
    <v-dialog v-model="equipmentDialog" max-width="700" persistent scrollable>
        <v-card>
            <v-card-title class="headline"></v-card-title>      
            <v-card-text>        
                <v-data-table
                    :headers="headers"
                    :items="equipment"
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
                                Equipment
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

                    <template v-slot:item.files="{ item }">
      
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                            <v-btn 
                                v-show="$can.permit('equipment_upload')"
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
                    @click="$emit('update:equipmentDialog', false)"
                >
                Close
                </v-btn>
                <v-spacer></v-spacer>
                <v-tooltip bottom>
                <template v-slot:activator="{ on }">                   
                    <v-btn 
                        v-show="approvedPtwComputed"
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

        <AttachmentDialog
            v-if="dialogAttachment"         
            :reference_id = "equip.id"
            :attachmentDialog.sync = "dialogAttachment"            
        ></AttachmentDialog>
        
        <ApprovedAttachmentDialog
            v-if="attachmentDialog"
            :reference_id = "ptwIdComputed"
            :attachmentDialog.sync ="attachmentDialog"  
            src_mod = "equips"
        ></ApprovedAttachmentDialog> 
    </v-dialog> 
</template>

<script>
import AttachmentDialog from '@/js/views/equips/AttachmentDialog';
import ApprovedAttachmentDialog from '@/js/views/ptws/approvedAttachmentsDialog';

export default {
    props: {
        equipmentDialog: Boolean
    },

    components: {
        ApprovedAttachmentDialog,
        AttachmentDialog
    },

    data: () => ({
        attachmentDialog: false,
        dialogAttachment: false,
        headers: [
            { text: 'Id', value: 'id' },
            { text: 'Equipment Type', value: 'name',},            
            { text: 'Equipment Category', value: 'equipcategory.name' }, 
            { text: 'VRN', value: 'vrn' },
            { text: 'LM No.', value: 'lm_no'},
            { text: 'Files', value: 'files'},          
        ],
        loading: false,
        search: '',
        equip:{},
        equipmentIndex: - 1,
    }),

    computed: {
        equipment() {
          return this.$store.getters.ptw.equips;
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
            this.equipmentIndex       = this.equipment.indexOf(item);
            
            this.equip.id         = item.id;

            this.dialogAttachment = true;
        },
    }
}
</script>