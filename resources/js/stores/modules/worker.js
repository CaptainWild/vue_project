import Axios from "axios";

const state = {
    workerStatus: '',
    workers: [],
    worker: {},
};

const getters = {
    workers: state => state.workers,
    worker: state => state.worker,
    workerStatus: state => state.workerStatus,
};

const actions = {
    fetchWorkers:({commit},payload) => {
        
        commit('WORKER_STATUS','Fetching Data...');
        
        return payload.get('/api/workers')
                .then((response) => {
                    commit('WORKER_LIST',response);
                }).catch((errors) => {});
    },
    fetchWorker: ({commit},payload) => {
        //nothing to do muna
    },
    createWorker:({commit}, payload) => {        
        
        commit('WORKER_STATUS','Creating...');

        return payload.post('/api/workers')
            .then(() => {
                var message = 'Worker successfully created!';                                
                commit('WORKER_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('WORKER_STATUS','Error'); 
                
                throw errors;
            });
    },
    updateWorker: ({commit}, payload) => {
        commit('WORKER_STATUS','Updating...');
        
        return payload.patch('/api/workers/'+payload.id)
            .then(() => {
                var message = 'Worker successfully updated!';                                
                commit('WORKER_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('WORKER_STATUS','Error'); 
                
                throw errors;
            });
    },
    deleteWorker: ({commit}, payload) => {
        commit('WORKER_STATUS','Deleting...');
        
        return axios.delete('/api/workers/'+payload.id+'/'+payload.delete_remark)
            .then(() => {
                var message = 'Worker successfully deleted!';                                
                commit('WORKER_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'error'});
            })
            .catch((errors) => {
                commit('WORKER_STATUS','Error'); 
                
                throw errors;
            });
    }
};

const mutations = {
    RESET_WORKER: (state) => {
        state.worker = []
    },
    RESET_WORKERS: (stat) => {
        state.workers = []
    },
    SET_WORKER: (state, worker) => {
        state.worker = worker
    },    
    WORKER_STATUS : (state,status) => {
        state.workerStatus = status;
    },
    WORKER_LIST : (state, workers) => {
       state.workers = workers;   
    },    
};

export default {
    state,
    getters,
    actions,
    mutations,
}