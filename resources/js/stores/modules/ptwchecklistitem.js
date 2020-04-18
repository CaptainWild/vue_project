const state = {
    ptwChecklistItemsStatus: '',
    ptwChecklistItems: [],
    ptwChecklistItem: {},
}

const getters = {
    ptwChecklistItemsStatus: state => state.ptwChecklistItemsStatus,
    ptwChecklistItems: state => state.ptwChecklistItems,
    ptwChecklistItem: state => state.ptwChecklistItem,
};

const actions = {
    fetchPtwChecklistItems: ({commit}, payload) => {
        commit('PTW_CHECKLIST_ITEMS_STATUS','Fetching Data...');

        return new Promise((resolve,reject) => {
            axios.get('/api/ptwchecklistitems/'+payload.ptw_id)
            .then(response => {    
                
                commit('PTW_CHECKLIST_ITEMS_STATUS','Fetched');
                commit('PTW_CHECKLIST_ITEMS',response.data);
                resolve(response.data);
            })
            .catch(error => {
                commit('PTW_CHECKLIST_ITEMS_STATUS','Error');
                reject(error.response.data);
            });
        });
    },
    updatePtwChecklistItem: ({commit}, payload) => {
        commit('PTW_CHECKLIST_ITEMS_STATUS','Updating...');
           
        return new Promise((resolve,reject) => {
            axios.post('/api/ptwchecklistitems/'+payload.id, payload)
            .then(() => {
                var message = 'PTW Checklist Item successfully updated!';                                
                commit('PTW_CHECKLIST_ITEMS_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                resolve();
            })
            .catch((errors) => {
                commit('PTW_CHECKLIST_ITEMS_STATUS','Error');              
                reject(errors);
            });
        }); 
    },
    noactPtwChecklistItem: ({commit}, payload) => {
        commit('PTW_CHECKLIST_ITEMS_STATUS','Mark as No Activity...');

        return new Promise((resolve,reject) => {
            axios.post('/api/ptwchecklistitems/'+payload.id+'/noact', payload)
            .then(() => {
                var message = 'PTW Checklist Item successfully updated!';                                
                commit('PTW_CHECKLIST_ITEMS_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                resolve();
            })
            .catch((errors) => {
                commit('PTW_CHECKLIST_ITEMS_STATUS','Error'); 
             
                reject(errors);
            });
        }); 
    }
}

const mutations = {
    PTW_CHECKLIST_ITEMS_STATUS : (state,status) => {
        state.ptwChecklistItemsStatus = status;
    },
    PTW_CHECKLIST_ITEMS : (state, ptwchecklistitems) => {
        state.ptwChecklistItems = ptwchecklistitems
    },
    RESET_PTW_CHECKLIST_ITEMS: (state) => {
        state.ptwChecklistItems = []
    },
    RESET_PTW_CHECKLIST_ITEM: (state) => {
        state.ptwChecklistItem = []
    },
    SET_PTW_CHECKLIST_ITEM: (state, ptwchecklistitem) => {
        state.ptwChecklistItem = ptwchecklistitem
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
}