import Axios from "axios";

const state = {
    subcontractorStatus: '',
    subcontractors: [],
    subcontractor: {},
    subcontractorAssessors: [],
    subcontractorAuthorizeMgrs: [],  
    subcontractorWorkers: [],
    subcontractorEquipment: [],      
};

const getters = {
    subcontractors: state => state.subcontractors,
    subcontractor: state => state.subcontractor,
    subcontractorStatus: state => state.subcontractorStatus,
    subcontractorAssessors: state => state.subcontractorAssessors,
    subcontractorAuthorizeMgrs: state =>state.subcontractorAuthorizeMgrs,
    subcontractorWorkers: state => state.subcontractorWorkers,
    subcontractorEquipment: state => state.subcontractorEquipment,
};

const actions = {
    fetchSubContractors:({commit},payload) => {
        
        commit('SUB_CONTRACTOR_STATUS','Fetching Data...');
        
        return payload.get('/api/subcontractors')
                .then((response) => {
                    commit('SUB_CONTRACTOR_LIST',response);
                }).catch((errors) => {});
    },
    fetchSubContractorWorkers: ({commit},payload) => {
        commit('SUB_CONTRACTOR_STATUS','Fetching Workers...');

        return new Promise((resolve, reject) => {
            axios.get('/api/subcontractors/'+payload.sub_contractor_id+'/workers')
                .then(response => {                    
                    commit('SUB_CONTRACTOR_WORKER_LIST',response.data);
                    resolve(response.data);
                }).catch(error => {
                    reject(error.response.data);
            });
        });
    },
    
    fetchSubContractorEquipment: ({commit},payload) => {
        commit('SUB_CONTRACTOR_STATUS','Fetching Equipment...');

        return new Promise((resolve, reject) => {
            axios.get('/api/subcontractors/'+payload.sub_contractor_id+'/equipment')
                .then(response => {                    
                    commit('SUB_CONTRACTOR_EQUIPMENT_LIST',response.data);
                    resolve(response.data);
                }).catch(error => {
                    reject(error.response.data);
            });
        });
    },

    fetchSubContractorAssessors:({commit,dispatch}, payload) => {
        commit('SUB_CONTRACTOR_STATUS','Fetching Assessors...');
        return new Promise((resolve, reject) => {
            axios.get('/api/subcontractors/'+payload.sub_contractor_id+'/assessors')
                .then(response => {
                    if(response.data.length > 0) {
                        commit('SUB_CONTRACTOR_ASSESSOR_LIST',response.data)
                    } else {
                        dispatch('fetchMainContractorSafetyAssessors')
                    }
                                        
                    resolve(response.data)
                }).catch(error => {                    
                    reject(error.response.data)
                });
        });
    },
    
    fetchSubContractorAuthorizeMgrs: ({commit}, payload) => {
        commit('SUB_CONTRACTOR_STATUS','Fetching Assessors...');
        return new Promise((resolve, reject) => {
            axios.get('/api/subcontractors/'+payload.sub_contractor_id+'/authorizemgrs')
                .then(response => {
                    commit('SUB_CONTRACTOR_AUTHORIZE_MGRS_LIST',response.data)
                    resolve(response.data)
                }).catch(error => {      
                    console.log(error)              
                    reject(error.response.data)
                });
        });
    },

    createSubContractor:({commit}, payload) => {        
        
        commit('SUB_CONTRACTOR_STATUS','Creating...');
        
        return payload.post('/api/subcontractors')
            .then(() => {
                var message = 'Sub-Contractor successfully created!';                                
                commit('SUB_CONTRACTOR_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('SUB_CONTRACTOR_STATUS','Error'); 
                
                throw errors;
            });
    },
    updateSubContractor: ({commit}, payload) => {
        commit('SUB_CONTRACTOR_STATUS','Updating...');
        
        return payload.patch('/api/subcontractors/'+payload.id)
            .then(() => {
                var message = 'Sub-Contractor successfully updated!';                                
                commit('SUB_CONTRACTOR_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('SUB_CONTRACTOR_STATUS','Error'); 
                
                throw errors;
            });
    },
    deleteSubContractor: ({commit}, payload) => {
        commit('SUB_CONTRACTOR_STATUS','Deleting...');
        
        return axios.delete('/api/subcontractors/'+payload.id+'/'+payload.delete_remark)
            .then(() => {
                var message = 'Sub-Contractor successfully deleted!';                                
                commit('SUB_CONTRACTOR_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'error'});
            })
            .catch((errors) => {
                commit('SUB_CONTRACTOR_STATUS','Error'); 
                
                throw errors;
            });
    }
};

const mutations = {
    SUB_CONTRACTOR_STATUS : (state,status) => {
        state.subcontractorStatus = status;
    },
    SUB_CONTRACTOR_LIST : (state, subcontractors) => {
       state.subcontractors = subcontractors;   
    },
    SUB_CONTRACTOR_ASSESSOR_LIST : (state, subcontractorAssessors) => {
        state.subcontractorAssessors = subcontractorAssessors;
    },
    SUB_CONTRACTOR_AUTHORIZE_MGRS_LIST: (state, subcontractorAuthorizeMgrs) => {
        state.subcontractorAuthorizeMgrs = subcontractorAuthorizeMgrs;
    },
    SUB_CONTRACTOR_WORKER_LIST: (state, subcontractorWorkers) => {
        state.subcontractorWorkers = subcontractorWorkers;
    },
    SUB_CONTRACTOR_EQUIPMENT_LIST : (state, subcontractorEquipment) => {
        state.subcontractorEquipment =  subcontractorEquipment
    },
    RESET_SUBCONTRACTOR_WORKERS_LIST: (state) => {
        state.subcontractorWorkers = []
    },
    RESET_SUBCONTRACTOR_EQUIPMENT_LIST: (state) => {
        state.subcontractorEquipment = []
    },
    RESET_SUBCONTRACTOR_ASSESSORS_LIST: (state) => {
        state.subcontractorAssessors = []
    },
    RESET_SUBCONTRACTOR_AUTHORIZE_MGRS_LIST: (state) => {
        state.subcontractorAuthorizeMgrs = []
    }    
};

export default {
    state,
    getters,
    actions,
    mutations,
}