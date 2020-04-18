const state = {
    approvedSwps: [],
    categories: [],
    swpStatus: '',
    swps: [],
    swp: {},
    swpCategories: []    
};

const getters = {
    approvedSwps: state => state.approvedSwps, 
    categories:  state => state.categories,
    swps: state => state.swps,
    swp: state => state.swp,
    swpStatus: state => state.swpStatus,
    swpCategories: state => state.swpCategories
}

const actions = {
    fetchSwps:({commit},payload) => {
        
        commit('SWP_STATUS','Fetching Data...');
        
        return payload.get('/api/swps')
                .then((response) => {
                    commit('SWP_LIST',response);
                    commit('SWP_APPROVED_LIST',response)
                }).catch((errors) => {});
    },
    fetchSwpCategories: ({commit}, payload) => {
        commit('SWP_STATUS','Fetching Data...');
           
        return payload.get('/api/swpcategories/'+payload.id+'/swps')
                .then((response) => {
                    commit('SWP_CATEGORY_LIST',response);
                }).catch((errors) => {});
    },
    fetchCategories: ({commit},payload) => {
        
        return payload.get('/api/swpcategories')
                .then((response) => {
                    commit('CATEGORY_LIST',response);
                }).catch((errors) => {});
    },
    createSwp:({commit}, payload) => {        
        
        commit('SWP_STATUS','Creating...');
        
        return payload.post('/api/swps')
            .then(() => {
                var message = 'Safe work procedure successfully created!';                                
                commit('SWP_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('SWP_STATUS','Error'); 
                
                throw errors;
            });
    },
    updateSwp: ({commit}, payload) => {
        commit('SWP_STATUS','Updating...');
        
        return payload.patch('/api/swps/'+payload.id)
            .then(() => {
                var message = 'Safe work procedure successfully updated!';                                
                commit('SWP_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('SWP_STATUS','Error'); 
                
                throw errors;
            });
    },
    downloadProcedureFile: ({commit}, payload) => {
        commit('SWP_STATUS','Downloading...');
        
        return new Promise((resolve,reject) => {
            axios.get('/api/swps/download/'+payload.id)
            .then(response => {
                commit('SWP_STATUS', "Downloaded.");   
                
                resolve(response.data);
            })
            .catch(error => {
                commit('SWP_STATUS', "error");   
                
                commit('setSnackbar',{text: "Downloading Failed. Something went wrong.", visible: true, color: 'error'});

                reject(error.response.data);
            });
        })

    },
    uploadSwp: ({commit}, payload) => {
        commit('SWP_STATUS','Uploading...');
       
        return new Promise((resolve,reject) => {
            axios.post('/api/swps/upload/'+payload.get('id'), payload)
            .then(response => {
                var message = 'Attachment successfully uploaded!';                                
                
                commit('SWP_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response.data);
            });
        });
    },
    deleteSwp: ({commit}, payload) => {
        commit('SWP_STATUS','Deleting...');
        
        return axios.delete('/api/swps/'+payload.id+'/'+payload.delete_remark)
            .then(() => {
                var message = 'Safe work procedure successfully deleted!';                                
                commit('SWP_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'error'});
            })
            .catch((errors) => {
                commit('SWP_STATUS','Error'); 
                
                throw errors;
            });
    }
};

const mutations = {
    SWP_STATUS : (state,status) => {
        state.swpStatus = status;
    },
    SWP_LIST : (state, swps) => {
       state.swps = swps;   
    },
    SWP_APPROVED_LIST : (state, swps) => {
        state.approvedSwps = _.filter(swps, function (o) { return o.swp_status_id == 1 });   
    },
    CATEGORY_LIST : (state, categories) => {
        state.categories = categories;
    },
    SWP_CATEGORY_LIST : (state, swpCategories) => {
        state.swpCategories = swpCategories;
    },
    RESET_SWP_CATEGORY : (state) => {
        state.swpCategories = [];
    }
};


export default {
    state,
    getters,
    actions,
    mutations,
}
