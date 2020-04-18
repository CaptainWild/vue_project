<template>
    <v-dialog v-model="dialogAttachment" max-width="350" persistent scrollable>
    <v-form @submit.prevent="upload" ref="form" v-model="valid">
    <v-card>
        <v-card-title class="headline">*{{swp_ref_no}} File</v-card-title>
        <v-card-subtitle>
            Activity: {{swp_act}} <br/>
            <strong>*any existing attachment will be overwitten.</strong>
        </v-card-subtitle>
        <v-card-text>      
            <v-file-input                                                
                clearable
                v-model="procedure_path"
                counter
                placeholder="Select a file"
                prepend-icon="mdi-paperclip"            
                :show-size="1000"
                :rules="procedure_pathRules"
            ></v-file-input>
        </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>        
        <v-btn 
            color="error darken-1" 
            raised 
            @click="$emit('update:dialogAttachment',false)"
        >
        Close
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
export default {
    props: {      
      value: Number,
      swp_ref_no: String,
      swp_act: String,
      dialogAttachment: Boolean
    },
    data () {
      return {
            loading: false,
            valid: true,
            procedure_path:[],
            procedure_pathRules: [
                v => !!v || 'File is required',
                v => (v != null && v.size > 0) || 'An File is required',   
            ],
      }
    },
    methods: {
        upload () { 
            this.loading = true       
         
            let swpForm = new FormData();

            swpForm.append('id',this.value);
            swpForm.append('_method', 'PATCH'); //method spoof
            swpForm.append('procedure_path',this.procedure_path);

            this.$store.dispatch("uploadSwp",swpForm)
                .then(response => {    
                    this.loading = false     
                    this.$refs.form.reset()      
                    this.$emit('update:dialogAttachment',false)
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