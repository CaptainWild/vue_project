<template>
  <v-dialog v-model="viewDialog" max-width="700" persistent>
  <v-card>
      <v-card-title class="headline">View Inspection Detail (#{{inspectionDetailData.id}})</v-card-title>      
        <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12" md="6">
                    <v-text-field
                        type="text"
                        disabled                            
                        v-model="inspectionDetailData.siteobservation.name" 
                        label="Site Observation">
                    </v-text-field>                    
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field
                        type="text"
                        disabled                            
                        v-model="inspectionDetailData.subcontractor.name" 
                        label="Sub-Contractor">
                    </v-text-field>                    
                </v-col>                
                <v-col cols="12" md="4">
                    <v-text-field
                        type="text"
                        disabled                            
                        v-model="inspectionDetailData.inspectiontype.name" 
                        label="Inspection Type">
                    </v-text-field>                    
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field
                        type="text"
                        disabled                            
                        v-model="inspectionDetailData.inspectiontypeitem.description" 
                        label="Inspection Type Item">
                    </v-text-field>                    
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field
                        type="text"
                        disabled                            
                        v-model="inspectionDetailData.hazardcategory.name" 
                        label="Hazard Category">
                    </v-text-field>                    
                </v-col>
                <v-col cols="12" md="2">
                    <v-text-field
                        type="text"
                        disabled                            
                        v-model="inspectionDetailData.block" 
                        label="Block">
                    </v-text-field>                    
                </v-col>
                <v-col cols="12" md="2">
                    <v-text-field
                        type="text"
                        disabled                            
                        v-model="inspectionDetailData.storey" 
                        label="Storey">
                    </v-text-field>                    
                </v-col>
                <v-col cols="12" md="2">
                    <v-text-field
                        type="text"
                        disabled                            
                        v-model="inspectionDetailData.unit" 
                        label="Unit">
                    </v-text-field>                    
                </v-col>
                <v-col cols="12" md="3">
                    <v-text-field
                        type="text"
                        disabled                            
                        v-model="inspectionDetailData.severity_level" 
                        label="Severity Level">
                    </v-text-field>                    
                </v-col>
                <v-col cols="12" md="3">
                    <v-text-field
                        type="text"
                        disabled                            
                        v-model="inspectionDetailData.response" 
                        label="Response">
                    </v-text-field>                    
                </v-col>
                <v-col cols="12" md="6">
                    <v-textarea
                        disabled
                        no-resize                            
                        v-model="inspectionDetailData.photo_remarks" 
                        label="Remarks">
                    </v-textarea>                    
                </v-col>
                <v-col cols="12" md="6">
                  
                    <v-img 
                        :src="'https://intelli-safe-bucket.s3-ap-southeast-1.amazonaws.com/'+inspectionDetailData.photo" 
                        aspect-ratio="1.7" 
                        contain
                    ></v-img>              
                </v-col>
              </v-row>
            </v-container>
        </v-card-text>    
      <v-card-actions>
        <v-btn 
          color="secondary darken-1" 
          raised 
          @click="close"
        >Close</v-btn>       
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
        viewDialog: Boolean,
        inspectionDetail: Object,
    },
    methods: {

        close() {            
            this.$emit('update:viewDialog',false)        
        },
    }
}
</script>