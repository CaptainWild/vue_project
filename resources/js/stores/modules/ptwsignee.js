const state = {
    ptwSigneeStatus: '',
    ptwSignee: {},
}

const getters = {
    ptwSignee: state => state.ptwSignee,
    ptwSigneeStatus: state => state.ptwSigneeStatus,
};

const actions = {
    createPtwSignee: ({commit}, payload) => {
           
        commit('PTW_SIGNEE_STATUS','Creating...');
        
        return payload.post('/api/ptwsignees/'+payload.ptw_id)
            .then(() => {
                var message = 'Permit to work successfully updated!';                                
                commit('PTW_SIGNEE_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('PTW_SIGNEE_STATUS','Error'); 
                
                throw errors;
            });
    },

    updatePtwSignee:({commit}, payload) => {
        commit('PTW_SIGNEE_STATUS','Updating...');

        return payload.patch('/api/ptwsignees/'+payload.id)
            .then(() => {
                var message = 'Permit to work successfully updated!';                                
                commit('PTW_SIGNEE_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('PTW_SIGNEE_STATUS','Error'); 
                
                throw errors;
            });
    },

    deletePtwSignee: ({commit}, payload) => {
        commit('PTW_SIGNEE_STATUS','Deleting...');
        
        return payload.delete('/api/ptwsignees/'+payload.id)
            .then(() => {
                var message = 'Permit to work successfully deleted!';                                
                commit('PTW_SIGNEE_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'error'});
            })
            .catch((errors) => {
                commit('PTW_SIGNEE_STATUS','Error'); 
                
                throw errors;
            });
    },
}

const mutations = {
    PTW_SIGNEE_STATUS : (state,status) => {
        state.ptwSigneeStatus = status;
    },
    CLEAR_PTW_SIGNEE: (state) => {
        state.ptwSignee = {}
    },
    SET_PTW_SIGNEE: (state, ptwSignee) => {
        state.ptwSignee = ptwSignee
    }

};

export default {
    state,
    getters,
    actions,
    mutations,
}