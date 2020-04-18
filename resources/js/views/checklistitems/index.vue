<template>
<div>
    <v-form @submit.prevent="save" ref="form" v-model="valid">
        <v-container fluid>
            <v-row>
                <v-col cols="12" md="6" sm="12">
                    <v-textarea
                        autofocus
                        auto-grow
                        clearable
                        rows="1"
                        label="Header"
                        v-model="checklistItem.header"
                    ></v-textarea>
                </v-col>
                <v-col cols="12" md="6" sm="12">
                    <v-textarea
                        autofocus
                        auto-grow
                        clearable
                        rows="1"
                        label="Sub-Header"
                        v-model="checklistItem.sub_header"
                    ></v-textarea>
                </v-col>
                <v-col cols="12" md="8" sm="12">
                    <v-textarea
                        autofocus
                        auto-grow
                        clearable
                        rows="1"
                        label="Description"
                        v-model="checklistItem.description"
                    ></v-textarea>
                </v-col>
                <v-col cols="12" md='2' sm="12">
                    <v-text-field                              
                        clearable 
                        v-model="checklistItem.seq_no" 
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
        :items="checklistItemsList"
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
        :checklistItem = "checklistItem"
        :deleteDialog.sync = "deleteDialog"
        @refresh="reinitialize"
    ></DeleteConfirmDialog>

    </div>
</template>

<script>
import Form from '@/js/core/form';
import DeleteConfirmDialog from '@/js/views/checklistitems/deleteConfirmDialog';

export default {
    components: {
        DeleteConfirmDialog
    },
    props: ['value'],
    data () {
        return {            
            valid: true,
            rowIndex: 0,
            deleteDialog: false, 
            tableLoader:false,
            loading: false,        
            selected: [],
            headers: [
                { text: 'Sequence No.', value: 'seq_no' },
                { text: 'Description', value: 'description' },               
                { text: 'Sub-Header', value: 'sub_header' },
                { text: 'Header', value: 'header' },
                { text: '', value: 'action', sortable: false, filterable: false },
            ],
            checklistItems: [],
            checklistItemIndex: - 1,
            checklistItem: new Form({                                
                description: "",
                header: "",
                seq_no: 0,
                sub_header: "",
            }),
            checklist: new Form({
                name: '',
                description: '',
                is_active: 0,
            }),          
        }
    },

    computed: {   
        checklistItemsList () {  
          this.checklistItems = this.$store.getters.checklist.items;
          return this.checklistItems;          
        },          
    },

    watch: {
        deleteDialog(val) {
            if(!val) {
                this.reset()
            }
        }
      
    },

    created() {
        console.log(this.value)
    },
    
    methods: {
    
        reset () {
            this.selected = []
            this.checklistItemIndex = -1
            this.$refs.form.reset()
        },

        reinitialize() {
            this.$store.dispatch('fetchChecklist',{id: this.value})
        },

        save () {    
            this.loading = true       
            if (this.$refs.form.validate()) { 
                var action = "createChecklistItem"
                if(this.checklistItemIndex > -1) {
                    action = "updateChecklistItem"
                }

                this.checklistItem.checklist_id = this.value                
                
                this.$store.dispatch(action,this.checklistItem)
                    .then(response => {  
                        this.loading = false
                        
                        this.reset()
                        this.reinitialize()
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
            this.checklistItemIndex       = this.checklistItems.indexOf(item);
            
            this.checklistItem.id         = item.id;
            this.checklistItem.description= item.description;
            this.checklistItem.seq_no     = item.seq_no;

            this.deleteDialog = true;
        },

        updateRowSelected (row) {
            //load the checked record into the description and seq_no fields

            if(row.value) {
                this.checklistItemIndex = this.checklistItems.indexOf(row.item);
            
                this.checklistItem.id           = row.item.id;
                this.checklistItem.description  = row.item.description;
                this.checklistItem.header       = row.item.header;
                this.checklistItem.sub_header   = row.item.sub_header;
                this.checklistItem.seq_no       = row.item.seq_no;
            } else {
                this.reset();
            }            
        },


    }
}
</script>