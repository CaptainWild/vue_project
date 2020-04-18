const state = {
    workercertificateStatus: '',
    workercertificates: [],
    workercertificate: {},
    workercertificateIds: {}
};

const getters = {
    workercertificates: state => state.workercertificates,
    workercertificate: state => state.workercertificate,
    workercertificateStatus: state => state.workercertificateStatus,
    workercertificateIds: state => state.workercertificateIds
};

const actions = {
    fetchWorkerCertificates:({commit},payload) => {
        
        commit('WORKER_CERTIFICATE_STATUS','Fetching Data...');
        
        return new Promise((resolve, reject) => {
            axios.get('/api/workercertificates/'+ payload.id+'/worker')
            .then((response) => {
                commit('WORKER_CERTIFICATE_LIST',response.data);
                resolve(response.data)
            }).catch((errors) => {
                commit('WORKER_CERTIFICATE_STATUS','Error');
                reject(errors.response.data)
            });
        })
    },
    fetchWorkerCertificate: ({commit},payload) => {
        commit('WORKER_CERTIFICATE_STATUS','Fetching Record...');
        
        return new Promise((resolve, reject) => {
            axios.get('/api/workercertificates/'+ payload.id)
            .then((response) => {
                commit('SET_WORKER_CERTIFICATE',response);
                resolve(response)
            }).catch((errors) => {
                commit('WORKER_CERTIFICATE_STATUS','Error');
                reject(errors.response.data)
            });
        })
    },    
    updateWorkerCertificate: ({commit}, payload) => {
        commit('WORKER_CERTIFICATE_STATUS','Updating...');
        
        return new Promise((resolve, reject) => {
            axios.post('/api/workercertificates/'+payload.get('id'), payload)
            .then(() => {
                var message = 'Worker Certificate successfully updated!';                                
                commit('WORKER_CERTIFICATE_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                resolve()
            })
            .catch((errors) => {
                commit('WORKER_CERTIFICATE_STATUS','Error'); 
                
                reject(errors.response.data);
            });
        });
    },
    deleteWorkerCertificate: ({commit}, payload) => {
        commit('WORKER_CERTIFICATE_STATUS','Deleting...');
        
        return new Promise( (resolve, reject) => {
            axios.delete('/api/workercertificates/'+payload.id)
            .then(() => {
                var message = 'Worker Certificate successfully deleted!';                                
                commit('WORKER_CERTIFICATE_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'error'});
                resolve()
            })
            .catch((errors) => {
                commit('WORKER_CERTIFICATE_STATUS','Error'); 
                
                reject(errors);
            });
        })
    },
    downloadWorkerCertificateFile: ({commit}, payload) => {
        commit('WORKER_CERTIFICATE_STATUS','Downloading...');
        
        return new Promise((resolve,reject) => {
            axios.get('/api/workercertificates/'+payload.id+'/download')
            .then(response => {
                commit('WORKER_CERTIFICATE_STATUS', "Downloaded.");   
                
                resolve(response.data);
            })
            .catch(error => {
                commit('WORKER_CERTIFICATE_STATUS', "error");   
                
                commit('setSnackbar',{text: "Downloading Failed. Something went wrong.", visible: true, color: 'error'});

                reject(error.response.data);
            });
        })
    },
};

const mutations = {
    RESET_WORKER_CERTIFICATE: (state) => {
        state.workercertificate = []
    },
    RESET_WORKER_CERTIFICATES: (state) => {
        state.workercertificates = []
    },
    RESET_WORKER_CERTIFICATE_ID: (state) => {
        state.workercertificateIds = {}
    },
    SET_WORKER_CERTIFICATE : (state, workercertificate) => {
        state.workercertificate = workercertificate
    },
    WORKER_CERTIFICATE_STATUS : (state,status) => {
        state.workercertificateStatus = status;
    },
    WORKER_CERTIFICATE_LIST : (state, workercertificates) => {
       state.workercertificates = workercertificates;   
    },
    SET_WORKER_CERTIFICATE_ID: (state,row) => {
        if(row.checked){
            if(!state.workercertificateIds.hasOwnProperty(row.workerid)){
                state.workercertificateIds[row.workerid] = []
            }
           state.workercertificateIds[row.workerid].push(row.workercertificateid)
        } else {
           state.workercertificateIds[row.workerid].splice(state.workercertificateIds[row.workerid].indexOf(row.workercertificateid),1)
        }   
    },
    SET_WORKER_ROW_SELECTED: (state, row) => {
        if(row.checked){
            state.workercertificateIds[row.workerid] = []
        } else {
            delete state.workercertificateIds[row.workerid]           
        }   
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
}