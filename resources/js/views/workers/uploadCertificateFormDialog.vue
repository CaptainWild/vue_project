<template>
    <v-dialog v-model="dialogUpload" max-width="350" persistent scrollable>
    <v-form @submit.prevent="upload" ref="form" v-model="valid">
    <v-card>
        <v-card-title class="headline">*<span v-if="workerCertificate.role">{{workerCertificate.role.name}}</span>&nbsp;File</v-card-title>
        <v-card-subtitle>
            <strong>*any existing attachment / file will be overwitten.</strong>
        </v-card-subtitle>
        <v-card-text>      
                <v-col cols="12">
                    <v-textarea
                        autofocus
                        auto-grow
                        prepend-icon="mdi-comment"
                        clearable
                        rows="1"
                        label="Remark"
                        v-model="description"
                    ></v-textarea>
                </v-col>

                <v-col cols="12">
                    <v-checkbox v-model="disabled" class="mx-2" label="N.A"></v-checkbox>

                     <DatePicker
                        :dateLabel= "dateLabel"
                        :dateIcon = true
                        v-model ="expiry_at"
                        :readonly = false
                    ></DatePicker>
                </v-col>
                <v-col cols="12">
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
        </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>        
        <v-btn 
            color="error darken-1" 
            raised 
            @click="$emit('update:dialogUpload',false)"
        >
        Cancel
        </v-btn>
        <v-btn 
            type = "submit" 
            color = "success darken-1" 
            raised                                          
            :loading="loading"
            :disabled="!valid"
        >
        Upload
        </v-btn>
      </v-card-actions>
    </v-card>
    </v-form>
  </v-dialog>
</template>

<script>
import DatePicker from '@/js/components/DatePicker';

export default {
    components: {
        DatePicker        
    },
    props: {      
      value: Number,
      dialogUpload: Boolean
    },
    data () {
      return {
            dateLabel:"Valid Until",
            description: '',
            expiry_at:'',
            loading: false,
            valid: true,
            full_path:[],
            full_pathRules: [
                v => !!v || 'File is required',
                v => (v != null && v.size > 0) || 'A File is required',   
            ],
      }
    },
    computed: {
        workerCertificate() {
            return this.$store.getters.workercertificate
        },      
    },
    methods: {
        upload () { 
            this.loading = true       
         
            let workerCertificateForm = new FormData();

            workerCertificateForm.append('id',this.value);
            workerCertificateForm.append('_method', 'PATCH'); //method spoof
            workerCertificateForm.append('full_path',this.full_path);
            workerCertificateForm.append('description',this.description);
            workerCertificateForm.append('expiry_at',this.expiry_at);

            this.$store.dispatch("updateWorkerCertificate",workerCertificateForm)
                .then(response => {    
                    this.loading = false     
                    this.$refs.form.reset()      
                    this.$emit('update:dialogUpload',false)
                    this.$emit('refresh')
                    setTimeout(() => {                
                        this.$store.commit('closeSnackbar');
                    },2000);              
                })
                .catch(()=> {
                    this.loading = false  
                });      
        },
    }
}
</script>