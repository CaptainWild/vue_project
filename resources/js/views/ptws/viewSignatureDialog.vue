<template>
<v-dialog v-model="signatureDialog" max-width="400" persistent scrollable>
  <v-card class="d-inline-block mx-auto">
    <v-container>
      <v-row justify="space-between">
        <v-col cols="auto">
          <v-img
            :src="signedPath"
          ></v-img>
        </v-col>
        </v-row>
    </v-container>
    <v-card-actions>
        Signature by: {{ signatory }}
        <v-spacer></v-spacer>
        <v-btn 
            color="secondary" 
            raised 
            @click="$emit('update:signatureDialog', false)"
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
        signatureDialog: Boolean,
        signedPath: String,
        signatory: String
    }
}
</script>