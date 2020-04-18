const state = {
    checklistitemStatus: '',
    checklistitems: [],
    checklistitem: {},
};

const getters = {
    checklistitems: state => state.checklistitems,
    checklistitem: state => state.checklistitem,
    checklistitemStatus: state => state.checklistitemStatus,
};

const actions = {
    fetchChecklistItems:({commit},payload) => {
        
        commit('CHECKLIST_ITEM_STATUS','Fetching Data...');
        
        return payload.get('/api/checklists/'+payload.checklist_id+'/items')
                .then((response) => {
                    commit('CHECKLIST_ITEM_LIST',response);
                }).catch((errors) => {});
    },
    createChecklistItem:({commit}, payload) => {        
        
        commit('CHECKLIST_ITEM_STATUS','Creating...');
        
        return payload.post('/api/checklists/'+payload.checklist_id+'/items')
            .then(() => {
                var message = 'Checklist Item successfully created!';                                
                commit('CHECKLIST_ITEM_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('CHECKLIST_ITEM_STATUS','Error'); 
                
                throw errors;
            });
    },
    updateChecklistItem: ({commit}, payload) => {
        commit('CHECKLIST_ITEM_STATUS','Updating...');
        
        return payload.patch('/api/checklistitems/'+payload.id)
            .then(() => {
                var message = 'Checklist Item successfully updated!';                                
                commit('CHECKLIST_ITEM_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('CHECKLIST_ITEM_STATUS','Error'); 
                
                throw errors;
            });
    },
    deleteChecklistItem: ({commit}, payload) => {
        commit('CHECKLIST_ITEM_STATUS','Deleting...');
        
        return new Promise((resolve,reject) => {
            axios.delete('/api/checklistitems/'+payload.id)
                .then(response => {
                    var message = 'Checklist Item successfully deleted!';                                
                    commit('CHECKLIST_ITEM_STATUS', message);            
                    commit('setSnackbar',{text: message, visible: true, color: 'error'});
                    
                    resolve(response.data);
            })
            .catch((errors) => {
                commit('CHECKLIST_ITEM_STATUS','Error'); 
                
                reject(error.response.data);
            });
        });
    }
};

const mutations = {
    CHECKLIST_ITEM_STATUS : (state,status) => {
        state.checklistitemStatus = status;
    },
    CHECKLIST_ITEM_LIST : (state, checklistitems) => {
        state.checklistitems = checklistitems;   
    },
    SET_CHECKLIST_ITEM: (state, checklistitem) => {
        state.checklistitem = checklistitem
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
}