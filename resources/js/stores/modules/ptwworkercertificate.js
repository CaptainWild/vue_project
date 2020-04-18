const state = {
    ptwworkercertificateStatus: '',
    ptwworkercertificates: [],
    ptwworkercertificate: {},
};

const getters = {
    ptwworkercertificates: state => state.ptwworkercertificates,
    ptwworkercertificate: state => state.ptwworkercertificate,
    ptwworkercertificateStatus: state => state.ptwworkercertificateStatus,
};

const actions = {
    fetchPtwWorkerCertificates:({commit},payload) => {
        
        commit('PTW_WORKER_CERTIFICATE_STATUS','Fetching Data...');
        
        return new Promise((resolve, reject) => {
            axios.get('/api/ptwworkercertificates/'+ payload.worker_id+'/'+payload.ptw_id)
            .then((response) => {
                commit('PTW_WORKER_CERTIFICATE_LIST',response.data);
                resolve(response.data)
            }).catch((errors) => {
                commit('PTW_WORKER_CERTIFICATE_STATUS','Error');
                reject(errors.response.data)
            });
        })
    },
    fetcPtwWorkerCertificate: ({commit},payload) => {
        commit('PTW_WORKER_CERTIFICATE_STATUS','Fetching Record...');
        
        return new Promise((resolve, reject) => {
            axios.get('/api/ptwworkercertificates/'+ payload.id)
            .then((response) => {
                commit('SET_PTW_WORKER_CERTIFICATE',response);
                resolve(response)
            }).catch((errors) => {
                commit('PTW_WORKER_CERTIFICATE_STATUS','Error');
                reject(errors.response.data)
            });
        })
    },    
    updatePtwWorkerCertificate: ({commit}, payload) => {
        commit('PTW_WORKER_CERTIFICATE_STATUS','Updating...');
        
        return new Promise((resolve, reject) => {
            axios.post('/api/ptwworkercertificates/'+payload.get('id'), payload)
            .then(() => {
                var message = 'Worker Certificate successfully updated!';                                
                commit('PTW_WORKER_CERTIFICATE_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                resolve()
            })
            .catch((errors) => {
                commit('PTW_WORKER_CERTIFICATE_STATUS','Error'); 
                
                reject(errors.response.data);
            });
        });
    },
    deletePtwWorkerCertificate: ({commit}, payload) => {
        commit('PTW_WORKER_CERTIFICATE_STATUS','Deleting...');
        
        return new Promise( (resolve, reject) => {
            axios.delete('/api/ptwworkercertificates/'+payload.id)
            .then(() => {
                var message = 'Worker Certificate successfully deleted!';                                
                commit('PTW_WORKER_CERTIFICATE_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'error'});
                resolve()
            })
            .catch((errors) => {
                commit('PTW_WORKER_CERTIFICATE_STATUS','Error'); 
                
                reject(errors);
            });
        })
    },
    downloadPtwWorkerCertificateFile: ({commit}, payload) => {
        commit('PTW_WORKER_CERTIFICATE_STATUS','Downloading...');
        
        return new Promise((resolve,reject) => {
            axios.get('/api/ptwworkercertificates/'+payload.id+'/download')
            .then(response => {
                commit('PTW_WORKER_CERTIFICATE_STATUS', "Downloaded.");   
                
                resolve(response.data);
            })
            .catch(error => {
                commit('PTW_WORKER_CERTIFICATE_STATUS', "error");   
                
                commit('setSnackbar',{text: "Downloading Failed. Something went wrong.", visible: true, color: 'error'});

                reject(error.response.data);
            });
        })
    },
};

const mutations = {
    RESET_PTW_WORKER_CERTIFICATE: (state) => {
        state.ptwworkercertificate = []
    },
    RESET_PTW_WORKER_CERTIFICATES: (state) => {
        state.ptwworkercertificates = []
    },
    SET_PTW_WORKER_CERTIFICATE : (state, ptwworkercertificate) => {
        state.ptwworkercertificate = ptwworkercertificate
    },
    PTW_WORKER_CERTIFICATE_STATUS : (state,status) => {
        state.ptwworkercertificateStatus = status;
    },
    PTW_WORKER_CERTIFICATE_LIST : (state, ptwworkercertificates) => {
       state.ptwworkercertificates = ptwworkercertificates;   
    },    
};

export default {
    state,
    getters,
    actions,
    mutations,
}