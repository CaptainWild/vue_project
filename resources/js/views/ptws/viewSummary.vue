<template>
    <v-card>
        <v-card-text>
            <v-container>
            <v-row>
                <v-col cols="12" md="6">
                    <div class="overline">
                        Project
                    </div>
                    <div class="body-2">
                        {{summary.project}}
                    </div>                
                </v-col>
                <v-col cols="12" md="6">
                    <div class="overline">
                        Verifier / Coordinator
                    </div>
                    <div class="body-2">
                        {{summary.verifier}}
                    </div>                
                </v-col>
                <v-col cols="12" md="6">
                    <div class="overline">
                        Start Date / Time
                    </div>
                    <div class="body-2">
                        {{new Date(summary.start_date).toLocaleDateString()}} ({{summary.start_time}})
                    </div>                
                </v-col>
                <v-col cols="12" md="6">
                    <div class="overline">
                        End Date / Time
                    </div>
                    <div class="body-2">
                        {{new Date(summary.end_date).toLocaleDateString()}} ({{summary.end_time}})
                    </div>                
                </v-col>
                <v-col cols="12" md="6">
                    <div class="overline">
                       Work to Perform
                    </div>
                    <div class="body-2">
                        {{summary.work}}
                    </div>                
                </v-col>
                <v-col cols="12" md="6">
                    <div class="overline">
                       Location
                    </div>
                    <div class="body-2">
                        {{summary.location}}
                    </div>                
                </v-col>
            </v-row>
            </v-container>
        </v-card-text>       
    </v-card>
</template>

<script>

export default {
    props : {       
        summarized: Object,
    },

    data: () => ({     
        summary:{}        
    }),

    mounted() {       
        this.summary = Object.assign({}, this.summarized)
    },

    methods: {       
    }
}
</script>