const state = {
    projectSubContractorsStatus: '',
    projectSubcontractors: [],
};

const getters = {
    projectSubContractorsStatus: state => state.projectSubContractorsStatus,
    projectSubcontractors: state => state.projectSubcontractors,
};

const actions = {
    fetchProjectSubContractors: ({commit}, payload) => {
        commit('PROJECT_SUBCONTRACTORS_STATUS','Fetching Project Sub-Cons...');
        return payload.get('/api/projects/'+payload.project_id+'/subcontractors')
            .then(response => {
                commit('PROJECT_SUBCONTRACTORS_STATUS','Success');
                commit('PROJECT_SUBCONTRACTOR_LIST',response)
            }).catch((errors) => {
                commit('PROJECT_SUBCONTRACTORS_STATUS','Error');
            });
    },
    toggleProjectSubCons:({commit},payload) => {
        
        commit('PROJECT_SUBCONTRACTORS_STATUS','Updating Datum...');
        
        return new Promise((resolve,reject) => {
                axios.post('/api/subcontractors/toggle',payload)
                .then(response => {
                    commit('setSnackbar',{text: 'Sub-Contractors updated!', visible: true, color: 'info'});
                    resolve(response)
                }).catch((errors) => {
                    reject(errors.response.data)
                });
            });
    },
    toggleAllProjectSubCons:({commit},payload) => {
        
        commit('PROJECT_SUBCONTRACTORS_STATUS','Updating All Data...');
        
        return new Promise((resolve,reject) => {
                axios.post('/api/projects/'+payload.project_id+'/toggle-all',payload)
                .then(response => {                    
                    commit('setSnackbar',{text: 'All Sub-Contractors updated!', visible: true, color: 'info'});
                    resolve(response)
                }).catch((errors) => {
                    reject(errors.response.data)
                });
            });
    },

}

const mutations = {
    PROJECT_SUBCONTRACTORS_STATUS : (state,status) => {
        state.projectSubContractorsStatus = status;
    },
    PROJECT_SUBCONTRACTOR_LIST: (state, subcontractors) => {
        state.projectSubcontractors = subcontractors
    },
    RESET_PROJECT_SUBCONTRACTORS: (state) => {
        state.projectSubcontractors = []
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
}