const state = {
    inspectionChecklistItemResultStatus: '',
    inspectionChecklistItemResults: [],
    inspectionChecklistItemResult: {},
};

const getters = {
    inspectionChecklistItemResults: state => state.inspectionChecklistItemResults,
    inspectionChecklistItemResult: state => state.inspectionChecklistItemResult,
    inspectionChecklistItemResultStatus: state => state.inspectionChecklistItemResultStatus,
};

const actions = {  
    fetchInspectionChecklistItemResult:({commit}, payload) => {
        commit('INSPECTION_CHECK_ITEM_RESULT_STATUS', 'Fetching Inspection Checklist Item Result Record');

        return new Promise((resolve,reject) => {
            axios.get('/api/inspectionchecklistitemresults/'+ payload.id)
                .then(response => {                             
                    commit('SET_INSPECION_CHECKLIST_ITEM_RESULT', response.data);            
                    
                    resolve(response.data);
            }).catch((errors) => {
                commit('INSPECTION_CHECK_ITEM_RESULT_STATUS','Error'); 
                
                reject(errors.response.data);
            });
        });
    },
    createInspectionChecklistItemResult:({commit}, payload) => {        
        
        commit('INSPECTION_CHECK_ITEM_RESULT_STATUS','Creating...');
        
        return new Promise((resolve, reject) => {
            axios.post('/api/inspectionchecklistitemresults/'+ payload.inspection_checklist_item_id, payload)
            .then(() => {
                var message = 'Inspection Checklist Item Results successfully created!';                                
                commit('INSPECTION_CHECK_ITEM_RESULT_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                resolve();
            })
            .catch((errors) => {
                commit('INSPECTION_CHECK_ITEM_RESULT_STATUS','Error'); 
                
                reject(errors);
            });
        });
    },
    updateInspectionChecklistItemResult: ({commit}, payload) => {
        commit('INSPECTION_CHECK_ITEM_RESULT_STATUS','Updating...');
        
        return new Promise((resolve,reject) => {
            axios.post('/api/inspectionchecklistitemresults/'+payload.inspection_checklist_item_id, payload)
            .then(() => {
                var message = 'Inspection Checklist Item Results successfully updated!';                                
                commit('INSPECTION_CHECK_ITEM_RESULT_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                resolve();
            })
            .catch((errors) => {
                commit('INSPECTION_CHECK_ITEM_RESULT_STATUS','Error'); 
             
                reject(errors);
            });
        }); 
    },
    deleteInspectionChecklistItemResult: ({commit}, payload) => {
        commit('INSPECTION_CHECK_ITEM_RESULT_STATUS','Deleting...');
        
        return new Promise((resolve,reject) => {
            axios.delete('/api/inspectionchecklistitemresults/'+payload.id)
            .then(() => {
                var message = 'Inspection Checklist Item Result successfully deleted!';                                
                commit('INSPECTION_CHECK_ITEM_RESULT_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'error'});

                resolve();
            })
            .catch((errors) => {
                commit('INSPECTION_CHECK_ITEM_RESULT_STATUS','Error'); 
                
                reject(errors);
            });
        });
    }
};

const mutations = {
    INSPECTION_CHECK_ITEM_RESULT_STATUS : (state,status) => {
        state.inspectionChecklistItemResultStatus = status;
    },
    RESET_INSPECTION_CHECKLIST_ITEM_RESULT: (state) => {
        state.inspectionChecklistItemResult = []
    },
    SET_INSPECTION_CHECKLIST_ITEM_RESULT: (state, inspectionchecklistitemresult) => {
        state.inspectionChecklistItemResult = inspectionchecklistitemresult
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
}