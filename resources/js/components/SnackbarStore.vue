<template>
  <v-snackbar
    top
    :value="snackbar.visible"
    :timeout="snackbar.timeout"
    :color="snackbar.color"
    :multi-line="snackbar.multiline === true">
        
      {{ snackbar.text }}
        
      <v-btn text dark @click="closeSnackbar">Close</v-btn>
    
  </v-snackbar>
</template>
<script>
import { mapMutations } from 'vuex'
export default {
computed: {
    snackbar() {
      return this.$store.getters.snackbar
    }    
  },
  methods: {
    ...mapMutations(["closeSnackbar"])
  }
}
</script>