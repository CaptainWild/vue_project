<template>
<div>
   <v-data-table
        :headers="headers"
        :items="signatures"
        :items-per-page="5"
        sort-by="created_at"
        sort-desc
        class="elevation-1"
        :loading="loading"
        v-model="signees"
    >
        <template v-slot:top>      
            <v-toolbar flat > 
                <v-toolbar-title>
                    Signatures
                </v-toolbar-title>
                <v-divider
                class="mx-4"
                inset
                vertical
                ></v-divider>
                
                <v-spacer></v-spacer> 
            
            </v-toolbar>
        </template>

        <template v-slot:loading>
            <span>Fetching Data...</span>
        </template>

        <template v-slot:item.ptw_status_id="{ item }">
            <span>{{ item.ptwstatus.name }}</span>
        </template>

        <template v-slot:item.signed_by="{ item }">
            <span>{{ item.signatory.name }}</span>
        </template>
          
        <template v-slot:item.signed_path="{ item }">
            <v-tooltip bottom>
            <template v-slot:activator="{ on }">
                <v-btn
                v-if="item.signed_path != null && item.signed_path != '' "
                v-on="on"                
                icon
                dark
                color="success"
                @click="viewSigned(item)"
                >
                <v-icon>mdi-signature-freehand</v-icon>
                </v-btn>
                <v-icon v-else >mdi-minus</v-icon>
            </template>
            <span>Signature</span>
            </v-tooltip>
        </template>

    </v-data-table>

    <SignatureDialog :signatureDialog.sync="signature" :signedPath="path" :signatory="signatory"></SignatureDialog>
</div>
</template>

<script>
import SignatureDialog from '@/js/views/ptws/viewSignatureDialog';

export default {
    components: {
        SignatureDialog
    },
    data: () => ({ 
        loading: true,           
        headers: [
            { text: 'Signed By', value: 'signed_by'},
            { text: 'Status', value: 'ptw_status_id'},
            { text: 'Signed At', value: 'created_at'},
            { text: 'Remarks', value: 'remarks'},          
            { text: 'Signature', value: 'signed_path', sortable: false, filterable: false}
        ],
        path: '',
        signatory: '',
        signature: false,
        signees: []        
    }),

    computed: {
        signatures() {
            this.loading = false
            return this.$store.getters.ptw.ptwsignees;
        }      
    },

    methods : {
        viewSigned(item){
            this.path = 'https://intellisafe-bucket.s3-ap-southeast-1.amazonaws.com'+item.signed_path
            //this.path = 'https://intelli-safe-bucket.s3-ap-southeast-1.amazonaws.com'+item.signed_path
            this.signatory = item.signatory.name
            this.signature = true
        }
    }
}
</script>