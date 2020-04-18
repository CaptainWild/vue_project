const state = {
    permissionRolesStatus: '',
    permissionRoles: [],
};

const getters = {
    permissionRolesStatus: state => state.permissionRolesStatus,
    permissionRoles: state => state.permissionRoles,
};

const actions = {
    fetchPermissionRoles: ({commit}, payload) => {
        commit('PERMISSION_ROLE_STATUS','Fetching Permission Role records...');
        return payload.get('/api/roles/'+payload.role_id+'/permissions')
            .then(response => {
                commit('PERMISSION_ROLE_STATUS','Success');
                commit('PERMISSION_ROLE_LIST',response.data)
            }).catch((errors) => {
                commit('PERMISSION_ROLE_STATUS','Error');
            });
    },
    togglePermissionRole:({commit},payload) => {
        
        commit('PERMISSION_ROLE_STATUS','Updating Datum...');
        
        return new Promise((resolve,reject) => {
                axios.post('/api/roles/'+payload.role_id+'/toggle',payload)
                .then(response => {
                    commit('setSnackbar',{text: 'Permission updated!', visible: true, color: 'info'});
                    resolve(response)
                }).catch((errors) => {
                    commit('PERMISSION_ROLE_STATUS','Error');
                    reject(errors.response.data)
                });
            });
    },
    toggleAllPermissionRole:({commit},payload) => {
        
        commit('PERMISSION_ROLE_STATUS','Updating Data...');
        
        return new Promise((resolve,reject) => {
                axios.post('/api/roles/'+payload.role_id+'/toggle-all',payload)
                .then(response => {
                    commit('PERMISSION_ROLE_STATUS','Success');                    
                    commit('setSnackbar',{text: 'All Permissions updated!', visible: true, color: 'info'});
                    resolve(response)
                }).catch((errors) => {
                    commit('PERMISSION_ROLE_STATUS','Error');
                    reject(errors.response.data)
                });
            });
    },

}

const mutations = {
    PERMISSION_ROLE_STATUS : (state,status) => {
        state.permissionRolesStatus = status;
    },
    PERMISSION_ROLE_LIST: (state, subcontractors) => {
        state.permissionRoles = subcontractors
    },
    CLEAR_PROJECT_SUBCONTRACTORS: (state) => {
        state.permissionRoles = []
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
}