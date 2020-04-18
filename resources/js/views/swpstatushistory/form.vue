<template>
<v-dialog v-model="formDialog" max-width="500px" persistent>
    <v-card>
        <v-form @submit.prevent="save" ref="form"  >
        <v-card-title>
            <span class="headline">{{formTitle}} {{swp.ref_no}}</span>
        </v-card-title>
        <v-card-subtitle>
            <span>{{swp.activity}}</span>
        </v-card-subtitle>
        <v-card-text>
            <v-textarea 
                rows = 2
                auto-grow 
                clearable 
                v-model="swpStatusHistory.comments" 
                label="Comments"
            ></v-textarea>
        </v-card-text>

        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn raised color="error darken-1" dark @click="$emit('update:formDialog',false)">
                Cancel
            </v-btn>
            <v-btn 
                raised 
                color="success darken-1" 
                dark 
                type="submit"
                :loading="loading"
            >
                Save
            </v-btn>
        </v-card-actions>
        </v-form>
    </v-card>
</v-dialog>
</template>

<script>
export default {
    props: {        
        formDialog: Boolean,
        formTitle: String,
        swp : { type: Object, default: function () { return {ref_no:"", activity:""}} },
        swpStatusHistory: { type: Object, default: function () { return {comments:""}} }
    },

    data: () => ({
        loading: false,
    }),

    methods: {
        save() {
            this.loading = true
            var action = 'updateSwpStatusHistory'
            if(this.swpStatusHistory.id == undefined) {
                action = 'createSwpStatusHistory'
            }
            console.log(this.swpStatusHistory)
            this.$store.dispatch(action,this.swpStatusHistory)
            .then(response => {    
                this.loading = false           
                this.$emit('update:formDialog',false)
                setTimeout(() => {                
                    this.$store.commit('closeSnackbar');
                },2000);              
            })
            .catch(()=> {
                this.loading = false  
            });      
        }
    }
}
</script>