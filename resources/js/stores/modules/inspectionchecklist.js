const state = {
    inspectionChecklistStatus: '',
    inspectionchecklists: [],
    inspectionchecklist: {},
};

const getters = {
    inspectionchecklists: state => state.inspectionchecklists,
    inspectionchecklist: state => state.inspectionchecklist,
    inspectionChecklistStatus: state => state.inspectionChecklistStatus,
};

const actions = {
    fetchInspectionChecklists:({commit},payload) => {
        
        commit('INSPECTION_CHECKLIST_STATUS','Fetching Data...');
        
        return payload.get('/api/inspectionchecklists')
                .then((response) => {
                    commit('INSPECTION_CHECK_LIST',response);
                }).catch((errors) => {});
    },
    fetchInspectionChecklist:({commit}, payload) => {
        commit('INSPECTION_CHECKLIST_STATUS', 'Fetching Checklist Record');

        return new Promise((resolve,reject) => {
            axios.get('/api/inspectionchecklists/'+ payload.id)
                .then(response => {                             
                    commit('SET_INSPECION_CHECKLIST', response.data);            
                    
                    resolve(response.data);
            }).catch((errors) => {
                commit('INSPECTION_CHECKLIST_STATUS','Error'); 
                
                reject(errors.response.data);
            });
        });
    },
    createInspectionChecklist:({commit}, payload) => {        
        
        commit('INSPECTION_CHECKLIST_STATUS','Creating...');
        
        return new Promise((resolve, reject) => {
            axios.post('/api/inspectionchecklists', payload)
            .then(() => {
                var message = 'Inspection Checklist successfully created!';                                
                commit('INSPECTION_CHECKLIST_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                resolve();
            })
            .catch((errors) => {
                commit('INSPECTION_CHECKLIST_STATUS','Error'); 
                
                reject(errors);
            });
        });
    },
    updateInspectionChecklist: ({commit}, payload) => {
        commit('INSPECTION_CHECKLIST_STATUS','Updating...');
        
        return new Promise((resolve,reject) => {
            axios.post('/api/inspectionchecklists/'+payload.id, payload)
            .then(() => {
                var message = 'Inspection Checklist successfully updated!';                                
                commit('INSPECTION_CHECKLIST_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                resolve();
            })
            .catch((errors) => {
                commit('INSPECTION_CHECKLIST_STATUS','Error'); 
             
                reject(errors);
            });
        }); 
    },
    deleteInspectionChecklist: ({commit}, payload) => {
        commit('INSPECTION_CHECKLIST_STATUS','Deleting...');
        
        return new Promise((resolve,reject) => {
            axios.delete('/api/inspectionchecklists/'+payload.id)
            .then(() => {
                var message = 'Inspection Checklist successfully deleted!';                                
                commit('INSPECTION_CHECKLIST_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'error'});

                resolve();
            })
            .catch((errors) => {
                commit('INSPECTION_CHECKLIST_STATUS','Error'); 
                
                reject(errors);
            });
        });
    }
};

const mutations = {
    INSPECTION_CHECKLIST_STATUS : (state,status) => {
        state.inspectionChecklistStatus = status;
    },
    INSPECTION_CHECK_LIST : (state, inspectionchecklists) => {
        state.inspectionchecklists = inspectionchecklists;   
    },
    RESET_INSPECTION_CHECKLISTS: (state) => {
        state.inspectionchecklists = []
    },
    RESET_INSPECTION_CHECKLIST: (state) => {
        state.inspectionchecklist = []
    },
    SET_INSPECION_CHECKLIST: (state, inspectionchecklist) => {
        state.inspectionchecklist = inspectionchecklist
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
}