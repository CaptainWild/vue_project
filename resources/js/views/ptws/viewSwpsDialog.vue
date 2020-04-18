<template>
 <v-dialog v-model="swpsDialog" max-width="700" persistent scrollable>
    <v-card>
        <v-card-title class="headline"></v-card-title>      
        <v-card-text>        
        <v-data-table
            :headers="headers"
            :items="swps"
            :search="search"        
            sort-by="ref_no"
            sort-desc
            class="elevation-1"
            :loading="loading"
            disable-pagination
            hide-default-footer
        >
            <template v-slot:top>      
                <v-toolbar flat > 
                    <v-toolbar-title>
                        Safe Work Procedures
                    </v-toolbar-title>
                    <v-divider
                    class="mx-3"
                    inset
                    vertical
                    ></v-divider>
                    
                    <v-spacer></v-spacer> 
                    <v-text-field
                        v-model="search"
                        append-icon="mdi-magnify"
                        label="Search"
                        single-line
                        hide-details
                        clearable
                    ></v-text-field>   
                </v-toolbar>
            </template>

            <template v-slot:loading>
                <span>Fetching Data...</span>
            </template>

            <template v-slot:item.swp_category_id="{ item }">
                <span>{{ item.swpcategory.name}}</span>
            </template>

            <template v-slot:item.action="{ item }">                  
                <v-btn 
                    text 
                    icon 
                    dark
                    color="info"
                    :loading="dlLoading && rowIndex === item.id"
                    @click="download(item)"
                >
                    <v-icon>mdi-download</v-icon>
                </v-btn>
            </template>

        </v-data-table>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn 
                color="secondary" 
                raised 
                @click="$emit('update:swpsDialog', false)"
            >
            Close
            </v-btn>
        </v-card-actions>
    </v-card>
</v-dialog> 
</template>

<script>
export default {
    props: {
        swpsDialog: Boolean
    },
    
    data: () => ({ 
        loading: true, 
        rowIndex: 0,
        dlLoading: false,          
        headers: [
            { text: 'Reference No.', value: 'ref_no', align: 'left' },
            { text: 'Activity', value: 'activity',},       
            { text: 'Category', value: 'swp_category_id',},
            { text: 'Download', value: 'action', sortable: false, filterable: false },          
        ],
        search: '',
    }),


    computed: {
        swps() {
            this.loading = false
          return this.$store.getters.ptw.swps;
        }    
    },
    
    methods: {

        download (item) {
            this.rowIndex = item.id;
            this.dlLoading = true;
            this.$store.dispatch('downloadFile', item)
            .then(response => {
                this.dlLoading = false;
                window.open(response);
            })
            .catch(error => {
                this.dlLoading = false;
            })
        },
    }
}
</script>

<style>

</style>