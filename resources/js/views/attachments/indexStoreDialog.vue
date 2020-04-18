<template>
    <v-dialog v-model="tempAttachmentDialog" max-width="800" persistent scrollable>
        <v-form @submit.prevent="saveTemp" ref="form" v-model="valid">
        <v-card>
            <v-card-title class="headline">{{title}}</v-card-title>      
            <v-card-text> 
                <v-container fluid>
                <v-row>
                    <v-col cols="12" md="5">
                        <v-textarea
                            autofocus
                            no-resize
                            prepend-icon="mdi-comment"
                            clearable
                            rows="1"
                            label="Description"
                            v-model="description"
                        ></v-textarea>
                    </v-col>
                    <v-col cols="12" md="5">
                        <v-file-input                                                
                            clearable
                            v-model="full_path"
                            counter
                            label="*File"            
                            placeholder="Select a file"
                            prepend-icon="mdi-paperclip"            
                            :show-size="1000"
                            :rules="full_pathRules"
                        >                  
                        </v-file-input>
                    </v-col>
                    <v-col cols=12  md="2">
                        <v-btn                            
                            color="success" 
                            raised                                          
                            :loading="loading"
                            type="submit"
                        >
                        <v-icon dark>mdi-plus</v-icon>
                        </v-btn>
                    </v-col>
                    <v-col cols="12">
                         <v-data-table
                            :headers="headers"
                            :items="tempAttachments"
                            :loading="tableLoader"
                            class="elevation-1"
                            v-model="selected"
                        >

                        <template v-slot:item.file_name="{ item }">
                            <span v-if="item.file_name.name != undefined">{{item.file_name.name}}</span>
                            <span v-else>{{item.file_name}}</span>
                        </template>

                        <template v-slot:item.action="{ item }">      
                        
                            <v-btn 
                                text 
                                icon 
                                dark
                                color="error"
                                @click="tempFileDestory(item)"
                            >
                                <v-icon>mdi-close</v-icon>
                            </v-btn>

                        </template>
                        </v-data-table>
                    </v-col>
            </v-row>                    
            </v-container>  
            </v-card-text>
            <v-card-actions>
                <v-btn 
                color="secondary" 
                raised 
                @click="$emit('update:tempAttachmentDialog',false)"
                >Close</v-btn>
            </v-card-actions>
        </v-card>
        </v-form>
    </v-dialog>
</template>

<script>

export default {
    props: {
        reference_table: {type: String, default:''},
        reference_id: {type: Number, default: 0},
        src_mod: {type: String, default: ''},
        tempAttachmentDialog: Boolean,
        title: String,
    },
    data () {
      return {
        rowIndex: 0,
        dlLoading: false,
        dialog: false, 
        tableLoader:false,
        loading: false,        
        selected: [],
        full_path: [],
        full_pathRules: [
            v => !!v || 'An Attachment is required',
            v => (v != null && v.size > 0) || 'An Attachment is required',   
        ],
        description:'',
        headers: [
            { text: 'File Name', value: 'file_name'},
            { text: 'Description', value: 'description' },
            { text: 'Remove', value: 'action', sortable: false, filterable: false },
        ],
        tempAttachments: [],
        valid: true,
      }
    },

    computed: {            
    },

    watch: {
    },

    created(){        
        this.loadAttachments()       
    },
    
    methods: {
        clearFields() {
            this.description = ''
            this.full_path = []
        },
        
        initializeTempAttachments() {            
            this.tempAttachments = this.$store.getters.tempAttachments[this.src_mod]
        },

        saveTemp () {    
            this.loading = true   
            if (this.$refs.form.validate()) {
                let attachmentTempForm = new FormData();            
            
                attachmentTempForm.append('description',this.description);
                attachmentTempForm.append('file_name',this.full_path);
                attachmentTempForm.append('src_mod',this.src_mod);
                
                this.$store.commit('STORE_TEMP_ATTACHMENT',attachmentTempForm)  
                
                this.initializeTempAttachments() 
                this.clearFields()

                this.loading = false
            } else {
                this.loading = false
            }
        },

        tempFileDestory (item) {        
            var index = this.tempAttachments.indexOf(item);

            this.$store.commit('DESTORY_TEMP_ATTACHMENT_BY_INDEX', {idx: index, src_mod:this.src_mod})            
        },

        loadAttachments() {  
            if(this.reference_id > 0) {
                this.tableLoader = true
                this.$store.dispatch('fetchAttachmentsWithSrc',
                { 
                    reference_id: this.reference_id, 
                    reference_table: this.reference_table,
                    src_mod: this.src_mod
                }).then(() => {
                    this.tableLoader = false
                    this.initializeTempAttachments()
                    this.$emit('update:reference_id',0)
                })
            } else {
                this.initializeTempAttachments()
            }
        }
    }
}
</script>