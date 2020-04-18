const state = {
    checklistStatus: '',
    checklists: [],
    checklist: {},
};

const getters = {
    checklists: state => state.checklists,
    checklist: state => state.checklist,
    checklistStatus: state => state.checklistStatus,
};

const actions = {
    fetchChecklists:({commit},payload) => {
        
        commit('CHECKLIST_STATUS','Fetching Data...');
        
        return payload.get('/api/checklists/')
                .then((response) => {
                    commit('CHECKLIST_LIST',response);
                }).catch((errors) => {});
    },
    fetchChecklistsByGroup: ({commit}, payload) => {
        commit('CHECKLIST_STATUS','Fetching Data...');
        
        return payload.get('/api/checklists/'+ payload.checklist_group_id+'/group')
                .then((response) => {
                    commit('CHECKLIST_LIST',response);
                }).catch((errors) => {});
    },
    fetchChecklist: ({commit}, payload) => {
        commit('CHECKLIST_STATUS', 'Fetching Checklist Record');

        return new Promise((resolve,reject) => {
            axios.get('/api/checklists/'+ payload.id)
                .then(response => {                             
                    commit('SET_CHECKLIST', response.data);            
                    
                    resolve(response.data);
            }).catch((errors) => {
                commit('CHECKLIST_STATUS','Error'); 
                
                reject(errors.response.data);
            });
        });
    },
    createChecklist:({commit}, payload) => {        
        
        commit('CHECKLIST_STATUS','Creating...');
        
        return payload.post('/api/checklists')
            .then(() => {
                var message = 'Checklist successfully created!';                                
                commit('CHECKLIST_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('CHECKLIST_STATUS','Error'); 
                
                throw errors;
            });
    },
    updateChecklist: ({commit}, payload) => {
        commit('CHECKLIST_STATUS','Updating...');
        
        return payload.patch('/api/checklists/'+payload.id)
            .then(() => {
                var message = 'Checklist successfully updated!';                                
                commit('CHECKLIST_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('CHECKLIST_STATUS','Error'); 
                
                throw errors;
            });
    },
    deleteChecklist: ({commit}, payload) => {
        commit('CHECKLIST_STATUS','Deleting...');
        
        return new Promise((resolve,reject) => {

            axios.delete('/api/checklists/'+payload.id+'/'+payload.delete_remark)
                .then(response => {
                    var message = 'Checklist successfully deleted!';                                
                    commit('CHECKLIST_STATUS', message);            
                    commit('setSnackbar',{text: message, visible: true, color: 'error'});
                    
                    resolve(response.data);
            })
            .catch((errors) => {
                commit('CHECKLIST_STATUS','Error'); 
                
                reject(errors.response.data);
            });
        });
    }
};

const mutations = {
    CHECKLIST_STATUS : (state,status) => {
        state.checklistStatus = status;
    },
    CHECKLIST_LIST : (state, checklists) => {
        state.checklists = checklists;   
    },
    RESET_CHECKLIST: (state) => {
        state.checklists = []
    },
    SET_CHECKLIST: (state, checklist) => {
        state.checklist = checklist
    }
    
};

export default {
    state,
    getters,
    actions,
    mutations,
}