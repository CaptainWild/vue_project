<template>
    <v-form 
        ref="form"
        v-model="valid"                
        lazy-validation
        @submit.prevent="save"      
    >
    <v-card>        
        <v-card-title>
            <span class="headline">{{ formTitle }}</span>
        </v-card-title>
        <v-card-text>          
            <v-container>
            <v-row>
                <v-col cols="12">
                    <v-text-field 
                        v-model="permission.name" 
                        label = "*Permission Name"
                        required
                        clearable
                        :rules="[v => !!v || 'This field is required']"
                    ></v-text-field>
                </v-col>                                            
                <v-col cols="12">
                     <v-text-field 
                        v-model="permission.code" 
                        label = "*Permission Code"
                        required
                        clearable
                        :rules="[v => !!v || 'This field is required']"
                    ></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-textarea
                        auto-grow
                        no-resizing                            
                        clearable 
                        v-model="permission.description" 
                        label="Description">
                    </v-textarea>
                </v-col>
                <v-col cols="12">
                     <v-text-field 
                        v-model="permission.mod_group" 
                        label = "Group"
                        required
                        clearable
                    ></v-text-field>
                </v-col> 
                 <v-col cols="12">
                    <v-select
                        v-model = "permission.action"
                        :items="actionList"
                        label="Action"
                        clearable
                    ></v-select>
                </v-col>                                                                 
            </v-row>
            </v-container> 
        
        </v-card-text>

        <v-card-actions>
            <v-btn 
                raised 
                color="secondary darken-1" 
                dark 
                @click="resetForm"
            >Close</v-btn>
            <v-spacer></v-spacer>                        
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

</template>

<script>
export default {
    props: {
        permissionFormDialog : Boolean,         
    },

    data: () => ({      
        actionList: ['create','read','update','delete'],
        permission: {},
        loading: false,        
        valid: true,        
    }),

    computed: {
        formTitle () {
            return this.permission.id == undefined ? 'New Permission' : 'Edit Permission (#'+this.permission.id+')'
        },      
    },

    created () {
        this.permission = Object.assign({},this.$store.getters.permission)        
    },

    methods: {
        resetForm() {
            this.$store.commit('CLEAR_PERMISSION')
            this.$emit('update:permissionFormDialog',false)            
        },

        save() {
            if(this.$refs.form.validate()) {
                this.loading = true
                
                var action = "createPermission";                
                if(this.permission.id != undefined) {
                    action = "updatePermission";                   
                    this.permission._method = 'PATCH';
                }

                this.$store.dispatch(action,this.permission)
                    .then(response => {   
                        this.loading = false                          
                        this.resetForm()
                        setTimeout(() => {                
                            this.$store.commit('closeSnackbar');
                        },2000);              
                    })
                    .catch(error=> {
                        this.loading = false 
                        console.log(error);
                    });  

            }            
        },
    }
}
</script>