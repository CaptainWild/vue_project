import Vue from 'vue'

const state = {
    mainConAssessors: [],
    mainConManagers: [],
    userPass: {},
    users: [],
    status: '',
    profile: {},
    userErrors: []
}

const getters = {
    mainConAssessors: state => state.mainConAssessors,
    mainConManagers: state => state.mainConManagers,
    users: state => state.users,
    getProfile: state => state.profile,
    isProfileLoaded: state => !!state.profile.name,
    userPass: state => state.userPass,
    userErrors: state => state.userErrors
}

const actions = {
    userRequest: ({commit, dispatch}) => {
        commit('userRequest')
        return new Promise ((resolve, reject) => {
            axios.get('/api/user')
            .then((resp) => {
                commit('userSuccess', resp.data);
                resolve(resp.data)
            })
            .catch(errors => {
                console.log(errors)              
                // if resp is unauthorized, logout, to
                dispatch('authLogout')
                commit('USER_ERROR', errors.response.data);                
                reject(errors)
            })
        })
    },
    resetUserPassword: ({commit}, payload) => {
        return payload.patch('/api/reset-password/'+payload.id)
                .then((response) => {
                    commit('USER_PASS', response);
                }).catch(errors => {
                    commit('USER_ERROR', errors.response.data);                 
                    throw errors;
                });
    },
    fetchUsers:({commit},payload) => {        
        commit('userRequest');
        
        return payload.get('/api/users')
                .then((response) => {
                    commit('USER_LIST',response);
                }).catch(errors => {
                    commit('USER_ERROR',errors.response.data);
                    throw errors;
                });
    },
    fetchMainContractorAuthorizedManagers: ({commit}) => {
        return new Promise ((resolve, reject) => {
            axios.get('/api/users/managers')
            .then(response => {                  
                commit('SET_MAIN_CON_MANAGERS',response.data);
                resolve(response.data) 
            })
            .catch(errors => {
                commit('USER_ERROR',errors.response.data); 

                reject(errors.response.data);
            });
        }); 
    },
    fetchMainContractorSafetyAssessors: ({commit}) => {
        return new Promise ((resolve, reject) => {
            axios.get('/api/users/assessors')
            .then(response => {                  
                commit('SET_MAIN_CON_ASSESSORS',response.data);
                resolve(response.data) 
            })
            .catch(errors => {
                commit('USER_ERROR',errors.response.data); 

                reject(errors.response.data);
            });
        }); 
    },
    createUser:({commit}, payload) => {
        commit('userRequest')
        
        return payload.post('/api/users')
            .then((response) => {
                commit('USER_PASS', response);
                var message = 'User successfully created!';                                            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch( errors => {
                commit('USER_ERROR',errors.response.data);                 
                throw errors;
            });
    },
    updateUser: ({commit}, payload) => {
        commit('userRequest');
        
        return payload.patch('/api/users/'+payload.id)
            .then(() => {
                var message = 'User successfully updated!';                                          
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch(errors => {
                commit('USER_ERROR',errors.response.data); 
                throw errors;
            });
    },
    updateUserPassword: ({commit,dispatch}, payload) => {
        return new Promise ((resolve, reject) => {
            axios.patch('/api/change-password/'+payload.id, payload)
            .then(response => {                  
                commit('setSnackbar',{text: "Password successfully changed! Please Log in again.", visible: true, color: 'success'});
                resolve(response) 
            })
            .catch(errors => {
                commit('USER_ERROR',errors.response.data); 

                reject(errors.response.data);
            });
        });
    },
    deleteUser: ({commit}, payload) => {
        commit('userRequest');
        
        return axios.delete('/api/users/'+payload.id+'/'+payload.delete_remark)
        .then(() => {
            var message = 'User successfully deleted!';                                
            commit('setSnackbar',{text: message, visible: true, color: 'success'});
        })
        .catch(errors => {
            commit('USER_ERROR',errors.response.data); 
            throw errors;
        });
    }
}

const mutations = {
    USER_PASS: (state,response) => {
        state.userPass = response;
    },
    userRequest: (state) => {
        state.status = 'loading';
    },
    userSuccess: (state, resp) => {
        state.status = 'success';
        Vue.set(state, 'profile', resp);
    },
    USER_ERROR: (state,err) => {        
        let errors=err.errors;
        console.log(errors);
        state.status = 'error';
        state.userErrors = errors;
    },
    USER_LIST: (state, users) => {
        state.users = users;
    },
    SET_MAIN_CON_ASSESSORS: (state, assessors) => {
        state.mainConAssessors = assessors
    },
    RESET_MAIN_CON_ASSESSORS: (state) => {
        state.mainConAssessors = []
    },
    SET_MAIN_CON_MANAGERS: (state, managers) => {
        state.mainConManagers = managers
    },
    RESET_MAIN_CON_MANAGERS: (state) => {
        state.mainConManagers = []
    }
}

export default {
    state,
    getters,
    actions,
    mutations,
}