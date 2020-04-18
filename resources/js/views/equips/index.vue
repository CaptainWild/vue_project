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
        :items="equipmentList"        
        sort-by="id"
        sort-desc
        class="elevation-1"
        :loading="loading"
        :search="search"
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
                            
            <v-dialog v-model="dialog" max-width="600px" persistent>
                <template v-slot:activator="{ on }">
                    <v-btn v-show="$can.permit('equipment_create')" color="primary" dark class="mb-2" v-on="on" >
                        New
                    </v-btn>
                </template>
                <EquipForm
                        v-if="dialog"
                        :equipFormDialog.sync="dialog"
                        @refresh="initialize"
                ></EquipForm>
            </v-dialog>
            <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                <v-btn 
                    v-on="on"
                    class="mb-2 ml-1" 
                    color="success darken-1"
                    fab 
                    dark 
                    small
                    @click="initialize" 
                    :loading="loading"
                ><v-icon dark>mdi-refresh</v-icon>
                </v-btn> 
                </template>
                <span>Refresh</span>
            </v-tooltip>
        </v-toolbar>
        </template>
     
        <!-- <template v-slot:item.equip_status_id="{ item }">
            <span class ="blue--text" v-if="item.equip_status_id==2">{{item.equipstatuses.name}}</span>
            <span class ="green--text" v-else-if="item.equip_status_id==1">{{item.equipstatuses.name}}</span>    
            <span class ="red--text" v-else-if="item.equip_status_id==4">{{item.equipstatuses.name}}</span>        
            <span v-else>{{item.equipstatuses.name}}</span>
        </template> -->

        <template v-slot:item.equip_category_id="{ item }">
            <span>{{item.equipcategory.name}}</span>
        </template>

        <template v-slot:item.action="{ item }">
            <v-tooltip bottom>
            <template v-slot:activator="{ on }">
                <v-btn
                v-show="$can.permit('equipment_edit')"
                v-on="on"
                text
                icon
                dark
                color="primary"
                @click="editEquip(item)"
                >
                <v-icon> mdi-file-edit</v-icon>
                </v-btn>
            </template>
            <span>Edit</span>
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
                @click="setDeleteEquip(item)"
            >
                <v-icon>mdi-delete</v-icon>
            </v-btn>
            </template>
            <span>Delete</span>
            </v-tooltip>

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

    <AttachmentDialog
        v-if="dialogAttachment"         
        :reference_id = "equip.id"
        :attachmentDialog.sync = "dialogAttachment"
        @close-dialog = "dialogAttachment = false"
    ></AttachmentDialog> 

    <DeleteRemarkDialog 
        v-if = "deleteRemarkConfirmDialog"
        :equip = "equip"
        :deleteRemarkConfirmDialog.sync = "deleteRemarkConfirmDialog"
        @refresh='initialize'
    ></DeleteRemarkDialog> 

    </div>
</template>
<script>
import EquipForm from '@/js/views/equips/form';
import Form from '@/js/core/form';
import AttachmentDialog from '@/js/views/equips/AttachmentDialog';
import DeleteRemarkDialog from '@/js/views/equips/deleteRemarkDialog';

  export default {
    components: {
        AttachmentDialog,
        DeleteRemarkDialog,
        EquipForm
    },
    data: () => ({ 
        search: '',       
        loading: true,
        dialog: false,
        dialogAttachment: false,
        deleteRemarkConfirmDialog: false,
        headers: [
            { text: 'Id', value: 'id' },
            { text: 'Equipment Type', value: 'name',},            
            { text: 'Equipment Category', value: 'equipcategory.name' },
            { text: 'VRN', value: 'vrn' },
            { text: 'LM No.', value: 'lm_no'},
            // { text: 'Status', value: 'equip_status_id'},            
            { text: 'Actions', value: 'action', sortable: false ,filterable: false},
        ],
        equipment: [],
        equipIndex: -1,
        equip: {}  
    }),

    computed: {
        formTitle () {
            return this.equipIndex === -1 ? 'New Equipment' : 'Edit Equipment'
        },
        equipmentList () {  
            this.equipment = this.$store.getters.equipment;
            return this.equipment;          
        },  
    },

    watch: {
      dialog (val) {                
        val || this.close()         
      },
      deleteRemarkConfirmDialog(val) {
          if(!val) {
              this.closeDeleteRemarkConfirmDialog()
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
            this.$store.dispatch('fetchEquipment')
            .then(()=> {
                this.loading = false
            });               
        },

        attach (item) {
            this.equipIndex       = this.equipment.indexOf(item);
            
            this.equip.id         = item.id;

            this.dialogAttachment = true;
        },

        editEquip (item) {        
            this.equipIndex = this.equipment.indexOf(item);
            
            this.$store.commit('SET_EQUIP', item)

            this.dialog = true;
        },

        setDeleteEquip (item) {                
            this.$store.commit('SET_EQUIP', item)

            this.deleteRemarkConfirmDialog = true;
        },

        close () {
            // this.dialog = false
            // this.equip = {}
            // this.equipIndex = -1 
            // this.initialize()  
            
            this.dialog = false
            //this.$refs.form.reset()
            //this.equip.reset()
            this.equipIndex = -1   
            this.loading = false
        },

        closeDeleteRemarkConfirmDialog() {
            this.deleteRemarkConfirmDialog = false
            //this.equip.reset()
            this.equipIndex = -1
        },
    },
  }
</script>