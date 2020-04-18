const state = {
    checklistgroupsStatus: '',
    checklistgroups: [],
}

const getters = {
    checklistgroupsStatus: state => state.checklistgroupsStatus,
    checklistgroups: state => state.checklistgroups
};

const actions = {
    fetchChecklistGroups:({commit},payload) => {
        
        commit('CHECKLIST_GROUP_STATUS','Fetching Data...');
        
        return payload.get('/api/checklistgroups')
            .then((response) => {
                commit('CHECKLIST_GROUP_STATUS','Fetched');
                commit('CHECKLIST_GROUP_LIST',response);
            }).catch((errors) => {
                commit('CHECKLIST_GROUP_STATUS','Error');
                throw errors.response.data
            });
    },
}

const mutations = {
    CHECKLIST_GROUP_STATUS: (state, status) => {
        state.checklistgroupsStatus = status
    },
    CHECKLIST_GROUP_LIST: (state, checklistgroups) => {
        state.checklistgroups = checklistgroups
    },
    RESET_CHECKLIST_GROUP: (state) => {
        state.checklistgroups = []
    },
    

};

export default {
    state,
    getters,
    actions,
    mutations,
}