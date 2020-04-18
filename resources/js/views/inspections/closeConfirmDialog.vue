<template>
  
    <v-dialog v-model="formSignDialog" max-width="400" scrollable persistent>
    <v-form 
        ref = "saveform"
        v-model="valid"
        @submit.prevent="save"
        lazy-validation      
    >
    <v-card>
        <v-card-title>
            <span class="headline">{{title}} (#{{inspectionId}})</span>
        </v-card-title>
        <v-card-text>
            <v-container>
            <v-row>
                <!-- <v-col cols="12">
                    <v-textarea 
                        auto-grow 
                        clearable 
                        v-model="remarks" 
                        rows="1"
                        label="Remarks">
                    </v-textarea>
                </v-col> -->
                <v-col cols="12">
                   <v-select
                        :items="forwardToList"
                        :loading="loading"
                        :rules="[v => !!v || 'This field is required']"
                        v-model="verifier_id" 
                        label="*Forward To Verifying Officer"
                        item-text="name"
                        item-value="id"
                        clearable
                        required 
                    ></v-select>
                </v-col>
                <v-col cols="12">
                   <DrawingPad
                    v-model="inspector_sign_path"
                    :height='200'
                    :width="342"
                    ref='drawingPad'
                   ></DrawingPad>                  
                </v-col>
            </v-row>
            </v-container>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn 
                raised 
                color="secondary darken-1" 
                dark 
                @click="closeFormSigning"
            >Cancel</v-btn>
            <v-btn 
                raised 
                color="success darken-1" 
                dark 
                :loading="loading"
                type="submit"
            >Save</v-btn>
        </v-card-actions>
    </v-card>
    </v-form>
    </v-dialog>
</template>

<script>
import DrawingPad from '@/js/components/DrawingPad';

export default {
    components: {
        DrawingPad
    },
      
    props : [ 
        'inspectionId',
        'formSignDialog'
    ],

    data: () => ({  
        loading: false,
        // remarks: '',
        inspector_sign_path: '',
        verifier_id: 0,
        valid: true,    
    }),

    computed: {
        forwardToList () {
           return this.$store.getters.mainConManagers
        },
    
        title() {
            return "Close Inspection"
        },
    },

    created() {
        this.forwardTo()
    },

    methods: {
        forwardTo() {                      
            this.$store.dispatch('fetchMainContractorAuthorizedManagers')
                .catch(error=> {
                    this.loading = false 
                    console.log(error);
                });
        },

        closeFormSigning() {            
            this.$emit('update:formSignDialog',false)
            this.$emit('refresh')
        },

        save() { 
            //check canvas for empty value                      
            if(this.inspector_sign_path == '') {
                this.valid = false;
                this.$store.commit('setSnackbar',{text: 'Signature is Required', visible: true, color: 'error'});         
                setTimeout(() => {
                    this.$store.commit('closeSnackbar');
                },2000); 
            } else {
                if (this.$refs.saveform.validate()) {
                    const { inspector_sign_path, verifier_id } = this;            
                    
                    this.$store.dispatch('closeInspection',{inspector_sign_path, verifier_id, inspection_id: this.inspectionId})
                        .then((response) => {
                            this.closeFormSigning()                        
                    })                    
                }
            }

        }
    }
}
</script>