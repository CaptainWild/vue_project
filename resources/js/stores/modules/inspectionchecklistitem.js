const state = {
    inspectionchecklistitemStatus: '',
    inspectionchecklistitem: {},
};

const getters = {
    inspectionchecklistitem: state => state.inspectionchecklistitem,
    inspectionchecklistitemStatus: state => state.inspectionchecklistitemStatus,
};

const actions = {        
    updateInspectionChecklistItem: ({commit}, payload) => {
        commit('INSPECTION_CHECK_ITEM_STATUS','Updating...');
        
        return new Promise((resolve,reject) => {
            axios.post('/api/inspectionchecklistitem/'+payload.id, payload)
            .then(() => {
                var message = 'Inspection Checklist Item successfully updated!';                                
                commit('INSPECTION_CHECK_ITEM_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                resolve();
            })
            .catch((errors) => {
                commit('INSPECTION_CHECK_ITEM_STATUS','Error'); 
             
                reject(errors);
            });
        }); 
    },

    noactInspectionChecklistItem: ({commit}, payload) => {
        commit('INSPECTION_CHECK_ITEM_STATUS','Mark as No Activity...');

        return new Promise((resolve,reject) => {
            axios.post('/api/inspectionchecklistitems/'+payload.id+'/noact', payload)
            .then(() => {
                var message = 'Inspection Checklist Item successfully updated!';                                
                commit('INSPECTION_CHECK_ITEM_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                resolve();
            })
            .catch((errors) => {
                commit('INSPECTION_CHECK_ITEM_STATUS','Error'); 
             
                reject(errors);
            });
        }); 
    }
};

const mutations = {
    INSPECTION_CHECK_ITEM_STATUS : (state,status) => {
        state.inspectionchecklistitemStatus = status;
    }, 
    RESET_INSPECTION_CHECKLIST_ITEM: (state) => {
        state.inspectionchecklistitem = []
    },
    SET_INSPECTION_CHECKLIST_ITEM: (state, inspectionchecklistitem) => {
        state.inspectionchecklistitem = inspectionchecklistitem
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
}