const state = {
    snackbar: {
        visible: false,
        text: null,
        timeout: 6000,
        multiline: false,
    }
};

const getters = {
    snackbar : state => state.snackbar
}

const mutations = {
    setSnackbar: (state, payload) => {
        state.snackbar.text = payload.text
        state.snackbar.multiline = (payload.text.length > 50) ? true : false
        
        if (payload.multiline) {
          state.snackbar.multiline = payload.multiline
        }

        if (payload.color) {
            state.snackbar.color = payload.color
        }
        
        if (payload.timeout) {
          state.snackbar.timeout = payload.timeout
        }
  
        state.snackbar.visible = payload.visible
    },
 
    closeSnackbar: (state) => {
        state.snackbar.visible = false
        state.snackbar.multiline = false
        state.snackbar.timeout = 6000
        state.snackbar.text = null
    }
};

export default {
    state,
    getters,
    mutations,
}