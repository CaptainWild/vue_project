const state = {
    roleStatus: '',
    roles: [],
    role: {},
};

const getters = {
    roles: state => state.roles,
    role: state => state.role,
    roleStatus: state => state.roleStatus,
};

const actions = {
    fetchRoles:({commit},payload) => {
        
        commit('ROLE_STATUS','Fetching Data...');
        
        return payload.get('/api/roles')
                .then((response) => {
                    commit('ROLE_LIST',response);
                }).catch((errors) => {});
    },
    fetchRole: ({commit},payload) => {
        commit('ROLE_STATUS', 'Fetching Record');

        return new Promise((resolve,reject) => {
            axios.get('/api/roles/'+ payload.id)
                .then(response => {                             
                    commit('SET_ROLE', response.data);            
                    
                    resolve(response.data);
            }).catch((errors) => {
                commit('ROLE_STATUS','Error'); 
                
                reject(errors.response.data);
            });
        });
    },
    createRole:({commit}, payload) => {        
        
        commit('ROLE_STATUS','Creating...');
        
        return payload.post('/api/roles')
            .then(() => {
                var message = 'Role successfully created!';                                
                commit('ROLE_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('ROLE_STATUS','Error'); 
                
                throw errors;
            });
    },
    updateRole: ({commit}, payload) => {
        commit('ROLE_STATUS','Updating...');
        
        return payload.patch('/api/roles/'+payload.id)
            .then(() => {
                var message = 'Role successfully updated!';                                
                commit('ROLE_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('ROLE_STATUS','Error'); 
                
                throw errors;
            });
    },
    deleteRole: ({commit}, payload) => {
        commit('ROLE_STATUS','Deleting...');
        
        return axios.delete('/api/roles/'+payload.id+'/'+payload.delete_remark)
            .then(() => {
                var message = 'Role successfully deleted!';                                
                commit('ROLE_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'error'});
            })
            .catch((errors) => {
                commit('ROLE_STATUS','Error'); 
                
                throw errors;
            });
    }
};

const mutations = {
    ROLE_STATUS : (state,status) => {
        state.roleStatus = status;
    },
    ROLE_LIST : (state, roles) => {
       state.roles = roles;   
    },
    SET_ROLE: (state, role) => {
        state.role = role
    },
    CLEAR_ROLE: (state) => {
        state.role = {}
    },
    CLEAR_ROLES: (state) => {
        state.roles = []
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
}