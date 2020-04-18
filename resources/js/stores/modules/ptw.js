const state = {
    checkers: [],
    checker: {},
    ptwStatus: '',
    ptwVerifiedChecklist: [],
    ptws: [],
    ptw: {},
}

const getters = {
    checkers: state => state.checkers,
    checker: state => state.checker,
    ptws: state => state.ptws,
    ptw: state => state.ptw,
    ptwStatus: state => state.ptwStatus,
    ptwCheckedChecklist: state =>state.ptwCheckedChecklist,
    ptwVerifiedChecklist: state => state.ptwVerifiedChecklist
};

const actions = {
    batchApprovalPtw: ({commit}, payload) => {
        commit('PTW_STATUS','Approving...');

        return new Promise((resolve,reject) => {
            axios.post('/api/ptws/batch-approval', payload)
            .then(response => {
                var message = 'Permit to work successfully created!';                                
                
                commit('PTW_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                
                resolve(response.data);
            }).catch(error => {
                reject(error.response.data);
            });
        });
    },

    copyPtw: ({commit}, payload) => {
           
        commit('PTW_STATUS','Copying...');
        
        return new Promise((resolve,reject) => {
            axios.post('/api/ptws/'+payload.get('id')+'/copy', payload)
            .then(response => {
                var message = 'Permit to work successfully copied!';                                
                
                commit('PTW_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                
                resolve(response.data);
            }).catch(error => {
                reject(error.response.data);
            });
        });
    },
    
    createPtw: ({commit}, payload) => {
           
        commit('PTW_STATUS','Creating...');
        
        return new Promise((resolve,reject) => {
            axios.post('/api/ptws', payload)
            .then(response => {
                var message = 'Permit to work successfully created!';                                
                
                commit('PTW_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                
                resolve(response.data);
            }).catch(error => {
                reject(error.response.data);
            });
        });
    },

    completePtw: ({commit}, payload) => {
        commit('PTW_STATUS','Complete..')
        
        return new Promise((resolve,reject) => {
            axios.post('/api/ptws/'+payload.id+'/complete',payload)
            .then(response => {
                var message = 'Permit to work successfully completed!';                                
                
                commit('PTW_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response.data);
            });
        });
    },

    revokePtw:({commit}, payload) => {
        commit('PTW_STATUS','Revoking...');

        return new Promise((resolve,reject) => {
            axios.post('/api/ptws/'+payload.id+'/revoke',payload)
            .then(response => {
                var message = 'Permit to work successfully revoked!';                                
                
                commit('PTW_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'error'});
                
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response.data);
            });
        });
    },

    updatePtw:({commit}, payload) => {
        commit('PTW_STATUS','Updating...');

        return new Promise((resolve,reject) => {
            axios.post('/api/ptws/'+payload.get('id'),payload)
            .then(response => {
                var message = 'Permit to work successfully updated!';                                
                
                commit('PTW_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response.data);
            });
        });
    },

    deletePtw: ({commit}, payload) => {
        commit('PTW_STATUS','Deleting...');
        return new Promise ((resolve, reject) => {
            axios.delete('/api/ptws/'+payload.id+'/'+payload.delete_remark)
            .then(() => {
                var message = 'Permit To work successfully deleted!';                                
                commit('PTW_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'error'});
                resolve()
            })
            .catch((errors) => {
                commit('PTW_STATUS','Error');                 
                reject(errors);
            });
        });

    },

    fetchPtws: ({commit}) => {
        commit('PTW_STATUS','Fetching Data...');

        return new Promise((resolve,reject) => {
            axios.get('/api/ptws')
            .then(response => {    
                
                commit('PTW_STATUS','Fetched');
                commit('PTW_LIST',response.data);
                resolve(response.data);
            })
            .catch(error => {
                commit('PTW_STATUS','Error');
                reject(error.response.data);
            });
        });
    },

    fetchPtwCheckers: ({commit}) => {
        commit('PTW_STATUS', 'Fetching records');

        return new Promise((resolve,reject) => {
            axios.get('/api/ptws/checkers')
                .then(response => {
                    commit('PTW_STATUS','Fetched Records')
                    commit('PTW_CHECKER_LIST', response.data);
                    resolve(response)
                }).catch( error => {
                    commit("PTW_STATUS", 'Error')
                    reject(error)
                })
        });
    },

    updatePtwChecker: ({commit},payload) => {
        commit('PTW_STATUS','Fetching checkers')

        return new Promise((resolve,reject) => {
            axios.post('/api/ptws/update-checker', payload)
            .then(response => { 
                var message = 'Permit to work checker list successfully Updated!';                                
                commit('PTW_STATUS', message);
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                resolve(response.data)
            }).catch( error => {
                commit('PTW_STATUS','Error')
                reject(error)
            })
        });
    },
    
    deletePtwChecker:({commit},payload) => {
        commit('PTW_STATUS','Deleting Checker');

        return new Promise((resolve, reject) => {
            axios.delete('/api/ptws/destroy-checker/'+payload.id,payload)
                .then(response => {
                    var message= 'Permit to work checker successfully deleted!'
                    commit('PTW_STATUS', message);
                    commit('setSnackbar',{text: message, visible: true, color: 'error'});
                    resolve(response.data)
                }).catch( errors => {
                    commit('PTW_STATUS','Error')
                    reject(errors)
                })
        });
    }
}

const mutations = {
    PTW_STATUS : (state,status) => {
        state.ptwStatus = status;
    },
    PTW_LIST : (state, ptws) => {
        state.ptws = ptws;   
    },
    PTW_CHECKER_LIST: (state, ptwcheckers) => {
        state.checkers = ptwcheckers
    },
    SET_PTW_CHECKER: (state, checker) => {
        state.checker = checker
    },
    RESET_PTW_CHECKER_LIST: (state) =>{
        state.checkers = []
    },
    RESET_PTW_CHECKER: (state) => {
        state.checker = []
    },
    CLEAR_PTW: (state) => {
        state.ptw = {}
    },
    SET_PTW: (state, ptw) => {
        state.ptw = ptw
    },
    SET_PTW_VERIFIED_CHECKLIST: (state, ptw) => {
        var checklist = ptw.hrw.hrwchecklists
        var hrwchecklist = ptw.ptwhrwchecklists

        for(const [index, value] of checklist.entries()) {
            for(var ptwhrwlist of hrwchecklist) {                
                if(value.id == ptwhrwlist.hrw_checklist_id && ptwhrwlist.checked == 1){
                    if(ptwhrwlist.checker.role_id == 4){ //applicant
                        checklist[index].original = 1 
                    }

                    if(ptwhrwlist.checker.role_id == 3) { //safety assessor
                        checklist[index].verified = 1 
                    }

                    if(ptwhrwlist.checker.role_id == 5) { //engineer
                        checklist[index].checked = 1
                    }

                }
            }
        } 

        state.ptwVerifiedChecklist = checklist
    },
};

export default {
    state,
    getters,
    actions,
    mutations,
}