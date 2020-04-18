const state = {
    hrwChecklistStatus: '',
    hrwChecklists: [],
    hrwChecklist: {},
};

const getters = {
    hrwChecklists: state => state.hrwChecklists,
    hrwChecklist: state => state.hrwChecklist,
    hrwChecklistStatus: state => state.hrwChecklistStatus,
};

const actions = {
    fetchHrwChecklist:({commit},payload) => {
        
        commit('HRW_CHECKLIST_STATUS','Fetching Data...');
        
        return payload.get('/api/hrws/'+payload.hrw_id+'/checklists')
                .then((response) => {
                    commit('HRW_CHECKLIST',response);
                }).catch((errors) => {});
    },
    createHrwChecklist:({commit}, payload) => {        
        commit('HRW_CHECKLIST_STATUS','Creating...');
        return payload.post('/api/hrws/'+payload.hrw_id+'/checklists')
            .then(() => {
                var message = 'Checklist item successfully created!';                                
                commit('HRW_CHECKLIST_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('HRW_CHECKLIST_STATUS','Error'); 
                
                throw errors;
            });
    },
    updateHrwChecklist: ({commit}, payload) => {
        commit('HRW_CHECKLIST_STATUS','Updating...');

        return payload.patch('/api/hrwchecklists/'+payload.id)
            .then(() => {
                var message = 'Checklist item successfully updated!';                                
                commit('HRW_CHECKLIST_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('HRW_CHECKLIST_STATUS','Error'); 
                
                throw errors;
            });
    },
    deleteHrwChecklist: ({commit}, payload) => {
        commit('HRW_CHECKLIST_STATUS','Deleting...');
        
        return payload.delete('/api/hrwchecklists/'+payload.id)
            .then(() => {
                var message = 'Checklist item successfully deleted!';                                
                commit('HRW_CHECKLIST_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'error'});
            })
            .catch((errors) => {
                commit('HRW_CHECKLIST_STATUS','Error'); 
                
                throw errors;
            });
    }
};

const mutations = {
    HRW_CHECKLIST_STATUS : (state,status) => {
        state.hrwChecklistStatus = status;
    },
    HRW_CHECKLIST : (state, hrwChecklists) => {
        state.hrwChecklists = hrwChecklists;   
    },
    RESET_HRW_CHECKLIST: (state) => {
        state.hrwChecklists = [];
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
}