const state = {
    swpStatusHistoryStatus: '',
    swpStatusHistories: [],
    swpStatusHistory: {},
    swpStatuses: []    
};

const getters = {
    swpStatusHistoryStatus: state => state.swpStatusHistoryStatus,
    swpStatusHistories: state => state.swpStatusHistories,
    swpStatusHistory: state => state.swpStatusHistory,
    swpStatuses : state => state.swpStatuses
}


const actions = {
    fetchSwpStatusHistory:({commit},payload) => {
        commit('SWP_STATUS_HISTORY_STATUS','Fetching Data...');
        
        return payload.get('/api/swpstatushistories/'+payload.swp_id)
                .then((response) => {
                    commit('SWP_STATUS_HISTORY_LIST',response);
                }).catch((errors) => {throw errors});
    },  
    fetchSwpStatus: ({commit},payload) => {        
        return payload.get('/api/swpstatuses')
                .then((response) => {
                    commit('SWP_STATUS_LIST',response);
                }).catch((errors) => {throw errors});
    },
    createSwpStatusHistory:({commit}, payload) => {        
        
        commit('SWP_STATUS_HISTORY_STATUS','Creating...');
        
        return payload.post('/api/swpstatushistories/'+payload.swp_id)
            .then(() => {
                var message = 'SWP status history successfully updated!';                                
                commit('SWP_STATUS_HISTORY_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('SWP_STATUS_HISTORY_STATUS','Error'); 
                
                throw errors;
            });
    },
    updateSwpStatusHistory: ({commit}, payload) => {
        commit('SWP_STATUS_HISTORY_STATUS','Updating...');
        
        return payload.patch('/api/swpstatushistories/'+payload.id)
            .then(() => {
                var message = 'SWP status history successfully updated!';                                
                commit('SWP_STATUS_HISTORY_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('SWP_STATUS_HISTORY_STATUS','Error'); 
                
                throw errors;
            });
    },  
    deleteSwpStatusHistory: ({commit}, payload) => {
        commit('SWP_STATUS_HISTORY_STATUS','Deleting...');
        
        return payload.delete('/api/swpstatushistories/'+payload.id)
            .then(() => {
                var message = 'SWP status history successfully deleted!';                                
                commit('SWP_STATUS_HISTORY_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'error'});
            })
            .catch((errors) => {
                commit('SWP_STATUS_HISTORY_STATUS','Error'); 
                
                throw errors;
            });
    }
};

const mutations = {
    SWP_STATUS_HISTORY_STATUS : (state,status) => {
        state.swpStatusHistoryStatus = status;
    },
    SWP_STATUS_HISTORY_LIST : (state, swpStatusHistories) => {
       state.swpStatusHistories = swpStatusHistories;   
    },
    SWP_STATUS_LIST : (state, swpStatuses) => {
        state.swpStatuses = swpStatuses;
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
}