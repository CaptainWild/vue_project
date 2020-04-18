<template>
    <div>
    <v-card>
        <v-card-title>
            <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Search Equipment"
                single-line
                hide-details
                clearable
            ></v-text-field>           
        </v-card-title>
    </v-card>  
    <v-data-table
        :headers="headers"
        :items="equipmentList"        
        sort-by="name"
        sort-desc
        class="elevation-1"
        :loading="loading"
        :search="search"
        show-select
        v-model="equipment"
        @item-selected="rowSelected"
        @toggle-select-all="toggleAll"
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
            <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                <v-btn 
                    v-on="on"
                    class="mb-2 ml-1" 
                    color="primary"
                    @click="uploadTemp"
                    dark 
                    :loading="loading"
                >
                    <v-icon dark>mdi-attachment</v-icon>
                    <v-icon dark>mdi-excavator</v-icon>
                </v-btn> 
                </template>
                <span>Upload / Remove Equipment Attachment</span>
            </v-tooltip>
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

            <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                    <v-btn 
                        v-show="$can.permit('equipment_delete')"
                        v-on="on"
                        text 
                        icon 
                        dark
                        color="error"
                        @click="setDeleteEquipment(item)"
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

    <AttachmentDialog
        v-if="dialogAttachment"
        :reference_id = "equip.id"
        :attachmentDialog.sync= "dialogAttachment"
    ></AttachmentDialog>

    <TempAttachments 
        v-if="tempAttachmentDialog"       
        :tempAttachmentDialog.sync="tempAttachmentDialog"
        src_mod = "equips"
        reference_table = "ptws"
        :reference_id.sync = "refId"
        title = "Upload / Remove Equipment Attachment(s)"
    >
    </TempAttachments>

    <DeleteConfirmDialog 
      :equip = "equip"     
      :deleteRemarkConfirmDialog.sync = "deleteRemarkConfirmDialog"
      :deleted.sync = "deleted"
    ></DeleteConfirmDialog>

    </div>     
</template>

<script>
import Form from '@/js/core/form';
import AttachmentDialog from '@/js/views/equips/AttachmentDialog';
import TempAttachments from '@/js/views/attachments/indexStoreDialog';
import DeleteConfirmDialog from '@/js/views/equips/deleteRemarkDialog';

export default {
     props: [
        'value',
        'equipmentIds',
    ],

    components: {
      AttachmentDialog,
      TempAttachments,
      DeleteConfirmDialog,
    },

    data: () => ({ 
        dialogAttachment: false,
        deleted: false,
        deleteRemarkConfirmDialog: false,
        headers: [
            { text: 'Equipment Name', value: 'name', align: 'left' },
            { text: 'LM No./Serial No.', value: 'lm_no'},
            { text: 'Model', value: 'model'},   
            { text: 'Equipment Category', value: 'equipcategory.name'},   
            { text: 'Files', value: 'files'},       
        ],
        loading: false,           
        search: '',       
        equipment: [],
        equip: {},
        equipmentIndex: - 1,        
        refId: 0,
        tempAttachmentDialog: false,
    }),
     
    computed: {
        equipmentList() {
          return this.$store.getters.subcontractorEquipment;
        }            
    },

    created() {
        if(this.$store.getters.ptw.id != undefined) {
            this.refId = this.$store.getters.ptw.id                
        }
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

    methods: {

        initialize () { 
            if(this.value > 0) {
                this.loading = true
                this.$store.dispatch('fetchSubContractorEquipment',{sub_contractor_id:this.value})
                .then((response)=> {
                    this.loading = false
                    this.selectedEquipment()
                });       
            }                  
        },
        
        attach (item) {
            this.equipmentIndex = this.equipment.indexOf(item);
            
            this.equip.id  = item.id;

            this.dialogAttachment = true;
        },

        rowSelected (row) {
           if(row.value) {
                this.equipmentIds.push(row.item.id)
           } else {
                this.equipmentIds.splice(this.equipmentIds.indexOf(row.item.id),1)
           }
        },

        selectedEquipment() {
            if(this.$store.getters.ptw.id != undefined) {
                var equipment = this.$store.getters.ptw.equips
                if(equipment.length > 0 ){
                    for(var equip of equipment) {
                        this.equipment.push(equip)
                        this.equipmentIds.push(equip.id)
                    }
                }                
            }
        },

        setDeleteEquipment (item) {                
            this.$store.commit('SET_EQUIP', item)
            this.deleteRemarkConfirmDialog = true;
        },

        toggleAll(items) {
            var equipment = this.equipmentList 
            if(items.value) {
                for(var equip of equipment) {
                    if(!this.equipmentIds.includes(equip.id)) {
                        this.equipmentIds.push(equip.id)
                    }                    
                }                
            } else {
                this.equipmentIds.splice(0,this.equipmentIds.length)
            }
        },
    
        uploadTemp() {
            this.tempAttachmentDialog = true
        },

        closeDeleteRemarkConfirmDialog() {
        this.deleteDialog = false
        this.equipIndex = -1
        },

    },
}
</script>