const state = {
    hrwStatus: '',
    hrws: [],
    hrw: {},
    hrwchecklistroups: []
};

const getters = {
    hrws: state => state.hrws,
    hrw: state => state.hrw,
    hrwStatus: state => state.hrwStatus,
    hrwchecklistroups: state =>state.hrwchecklistroups
};

const actions = {
    fetchHrws:({commit},payload) => {
        
        commit('HRW_STATUS','Fetching Data...');
        
        return payload.get('/api/hrws')
                .then((response) => {
                    commit('HRW_LIST',response);
                    commit('HRW_GROUPING', response)
                }).catch((errors) => {});
    },
    createHrw:({commit}, payload) => {        
        
        commit('HRW_STATUS','Creating...');
        
        return payload.post('/api/hrws')
            .then(() => {
                var message = 'High-Risk Work successfully created!';                                
                commit('HRW_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('HRW_STATUS','Error'); 
                
                throw errors;
            });
    },
    updateHrw: ({commit}, payload) => {
        commit('HRW_STATUS','Updating...');
        
        return payload.patch('/api/hrws/'+payload.id)
            .then(() => {
                var message = 'High-risk Work successfully updated!';                                
                commit('HRW_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('HRW_STATUS','Error'); 
                
                throw errors;
            });
    },
    deleteHrw: ({commit}, payload) => {
        commit('HRW_STATUS','Deleting...');
        
        return payload.delete('/api/hrws/'+payload.id)
            .then(() => {
                var message = 'High-Risk Work successfully deleted!';                                
                commit('HRW_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'error'});
            })
            .catch((errors) => {
                commit('HRW_STATUS','Error'); 
                
                throw errors;
            });
    }
};

const mutations = {
    HRW_STATUS : (state,status) => {
        state.hrwStatus = status;
    },
    HRW_LIST : (state, hrws) => {
        state.hrws = hrws;   
    },
    HRW_GROUPING : (state,hrws) => {
        for(var hrw of hrws) {
            state.hrwchecklistroups[hrw.id] = hrw.checklist_group_id
        }
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
}