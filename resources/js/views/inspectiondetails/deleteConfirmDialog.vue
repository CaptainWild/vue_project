<template>
    <v-dialog v-model="deleteDialog" max-width="370" persistent>
  <v-card>
      <v-card-title class="headline">DELETE this Inspection Item?</v-card-title>      
        <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12">
                  Id: {{ inspectionDetailData.id }} <br />
                  Site: {{ inspectionDetailData.block }} / {{inspectionDetailData.site}} / {{inspectionDetailData.unit}} <br />
                  Sub-Contractor: {{ inspectionDetailData.subcontractor.name }} <br />
                  Inspection Type: {{ inspectionDetailData.inspectiontype.name }} <br />
                  Inspection Type Item: {{ inspectionDetailData.inspectiontypeitem.description }} <br />
                  Response: {{ inspectionDetailData.response}}<br />
                </v-col>                       
              </v-row>
            </v-container>
        </v-card-text>    
      <v-card-actions>
         <v-btn 
          color="secondary darken-1" 
          raised 
          @click="close"
        >No</v-btn>
        <v-spacer></v-spacer>       
        <v-btn 
          color="success darken-1" 
          raised 
          @click="deleteInspectionDetail"
          :loading="loading"
        >Yes</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
    data: () => ({
        inspectionDetailData: {},
        loading: false,
    }),
    created() {      
      this.inspectionDetailData = Object.assign({}, this.inspectionDetail)      
    },
    props: {
        deleteDialog: Boolean,
        inspectionDetail: Object,
        deleted: {type: Boolean, default: function () {return false}}
    },
    methods: {

      close() {            
        this.$emit('update:deleteDialog',false)        
      },

      deleteInspectionDetail() {

        this.loading = true
        this.$store.dispatch('deleteInspectionDetail',{id: this.inspectionDetailData.id})
        .then(response => {
            this.loading = false;          
            this.close()
            this.$emit('update:deleted', true)
            setTimeout(() => {                
                this.$store.commit('closeSnackbar');
            },2000);           
        }).catch(()=> {this.loading = false });

      }
    }  
}
</script>