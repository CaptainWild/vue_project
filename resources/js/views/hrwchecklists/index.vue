<template>
    <div>
    <v-form @submit.prevent="save" ref="form" v-model="valid">
        <v-container fluid>
            <v-row>
                <v-col cols="12" md="8" sm="12">
                    <v-textarea
                        autofocus
                        auto-grow
                        clearable
                        rows="1"
                        label="Description"
                        v-model="hrwChecklist.description"
                    ></v-textarea>
                </v-col>
                <v-col cols="12" md='2' sm="12">
                    <v-text-field                              
                        clearable 
                        v-model="hrwChecklist.seq_no" 
                        label="Seq. No."
                        type="number"
                        min=0
                    ></v-text-field>
                </v-col>
                <v-col cols=12 md='2' sm="12" >
                    <v-btn 
                        type ="submit" 
                        color="success darken-1" 
                        raised                                          
                        :loading="loading"
                        :disabled="!valid"
                    >Save</v-btn>
                </v-col>
            </v-row>   
                 
        </v-container>       
    </v-form>
    <v-data-table
        :headers="headers"
        :items="hrwChecklistItems"
        :loading="tableLoader"
        single-select        
        show-select
        class="elevation-1"
        @item-selected="updateRowSelected"
        v-model="selected"
    >
    <template v-slot:header.data-table-select>
        <span>Edit</span>
    </template>

    <template v-slot:item.action="{ item }">
        <v-tooltip bottom>
        <template v-slot:activator="{ on }">        
            <v-btn 
                v-on="on"
                text 
                icon 
                dark
                color="error"
                @click="setDeletion(item)"
            ><v-icon>mdi-delete</v-icon></v-btn>
        </template>
        <span>Delete</span>
        </v-tooltip>

    </template>
    </v-data-table>

    <DeleteConfirmDialog 
        :hrwChecklist = "hrwChecklist"
        :deleteDialog.sync = "deleteDialog"
    ></DeleteConfirmDialog>

    </div>
</template>

<script>
import Form from '@/js/core/form';
import DeleteConfirmDialog from '@/js/views/hrwchecklists/deleteConfirmDialog';

export default {
    components: {
        DeleteConfirmDialog
    },
    props: {        
        hrw: { type: Object, default: function () {return {name: "",description:""}}},
    },
    data () {
      return {
        valid: true,
        rowIndex: 0,
        deleteDialog: false, 
        tableLoader:false,
        loading: false,        
        selected: [],
        headers: [
            { text: 'Id', value: 'id' },
            { text: 'Description', value: 'description' },
            { text: 'Sequence No.', value: 'seq_no' },
            { text: 'Actions', value: 'action', sortable: false, filterable: false },
        ],
        hrwChecklists: [],
        hrwChecklistIndex: - 1,
        hrwChecklist: new Form({
            description: "",
            seq_no: 0,
        })       
      }
    },

    computed: {   
        hrwChecklistItems () {  
          this.hrwChecklists = this.$store.getters.hrwChecklists;
          return this.hrwChecklists;          
        },          
    },

    watch: {
        value:{
            immediate: true,
            handler(val, oldVal) {
                this.initialize()                
            }            
        },
        deleteDialog(val) {
            if(!val) {
                this.reset()
                this.initialize()
            }
        }
      
    },
    
    methods: {
        
        initialize() {
            this.tableLoader = true;
            this.hrwChecklist.hrw_id = this.hrw.id

            this.$store.dispatch('fetchHrwChecklist',this.hrwChecklist)
            .then(() => {
                this.tableLoader = false;
            })
            .catch( error => {
                this.tableLoader = false;
                console.log(error);
            });
        },

        reset () {
            this.selected = []
            this.hrwChecklistIndex = -1
            this.$refs.form.reset()
        },

        save () {    
            this.loading = true       
            if (this.$refs.form.validate()) { 
                var action = "createHrwChecklist"
                if(this.hrwChecklistIndex > -1) {
                    action = "updateHrwChecklist"
                }
                this.hrwChecklist.hrw_id = this.hrw.id
                
                this.$store.dispatch(action,this.hrwChecklist)
                    .then(response => {  
                        this.loading = false   
                        this.reset()                       
                        this.initialize()
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

        setDeletion (item) {        
            this.hrwChecklistIndex       = this.hrwChecklists.indexOf(item);
            
            this.hrwChecklist.id         = item.id;
            this.hrwChecklist.description= item.description;
            this.hrwChecklist.seq_no     = item.seq_no;

            this.deleteDialog = true;
        },

        updateRowSelected (row) {
            //load the checked record into the description and seq_no fields

            if(row.value) {
                this.hrwChecklistIndex = this.hrwChecklists.indexOf(row.item);
            
                this.hrwChecklist.id         = row.item.id;
                this.hrwChecklist.description= row.item.description;
                this.hrwChecklist.seq_no     = row.item.seq_no;
            } else {
                this.reset();
            }            
        },


    }
}
</script>