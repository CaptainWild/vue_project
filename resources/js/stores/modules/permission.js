const state = {
    permission: {},
    permissions: [],
    permissionStatus: '',
}

const getters = {
    permission: state => state.permission,
    permissions: state => state.permissions,
    permissionStatus: state => state.permissionStatus,
};

const actions = {
   fetchPermissions: ({commit}) => {
        commit('PERMISSION_STATUS','Fetching Data...');
            
        return new Promise((resolve,reject) => {
            axios.get('/api/permissions')
            .then((response) => {
                commit('PERMISSION_LIST',response.data);
                resolve(response)
            }).catch((errors) => {
                reject(errors.response.data)
            });
        });
   },
   fetchPermission: ({commit}) => {
        commit('PERMISSION_STATUS', 'Fetching Record');

        return new Promise((resolve,reject) => {
            axios.get('/api/permissions/'+ payload.id)
                .then(response => {                             
                    commit('SET_PERMISSION', response.data);            
                    
                    resolve(response.data);
            }).catch((errors) => {
                commit('PERMISSION_STATUS','Error'); 
                
                reject(errors.response.data);
            });
        });
   },
   createPermission: ({commit}, payload) => {
        commit('PERMISSION_STATUS','Creating...');
            
        return new Promise((resolve, reject) => {
            axios.post('/api/permissions', payload)
            .then(() => {
                var message = 'Permission successfully created!';                                
                commit('PERMISSION_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                resolve();
            })
            .catch((errors) => {
                commit('PERMISSION_STATUS','Error'); 
                
                reject(errors.response.data);
            });
        });
   },
   updatePermission: ({commit}, payload) => {
        commit('PERMISSION_STATUS','Updating...');
            
        return new Promise((resolve,reject) => {
            axios.post('/api/permissions/'+payload.id, payload)
            .then(() => {
                var message = 'Permission successfully updated!';                                
                commit('PERMISSION_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                resolve();
            })
            .catch((errors) => {
                commit('PERMISSION_STATUS','Error'); 
            
                reject(errors.response.data);
            });
        }); 
   },
   deletePermission: ({commit}, payload) => {
        commit('PERMISSION_STATUS','Deleting...');
            
        return new Promise((resolve,reject) => {
            axios.delete('/api/permissions/'+payload.id)
            .then(() => {
                var message = 'Permission successfully deleted!';                                
                commit('PERMISSION_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'error'});
                resolve();
            })
            .catch((errors) => {
                commit('PERMISSION_STATUS','Error'); 
                
                reject(errors.response.data);
            });
        });
   }
}

const mutations = {
    PERMISSION_STATUS : (state, status) => {
        state.permissionStatus = status
    },    
    PERMISSION_LIST: (state, permissions) => {
        state.permissions = permissions
    },    
    SET_PERMISSION: (state, permission) => {
        state.permission = permission
    },
    CLEAR_PERMISSION: (state) => {
        state.permission = {}
    },
    CLEAR_PERMISSIONS: (state) => {
        state.permissions = []
    },
};

export default {
    state,
    getters,
    actions,
    mutations,
}