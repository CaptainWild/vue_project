const state = {
    archiveStatus: '',
    archives: [],
    archive: {},
};

const getters = {
    archives: state => state.archives,
    archive: state => state.archive,
    archiveStatus: state => state.archiveStatus,
};

const actions = {
    fetchArchives:({commit},payload) => {
        
        commit('archiveStatus','Fetching Data...');
        
        return payload.get('/api/archives')
                .then((response) => {
                    commit('archiveList',response);
                }).catch((errors) => {});
    },
    fetchArchive: ({commit},payload) => {
        //this.form.submit('get','/archives/${payload.id}')
    },
    createArchive:({commit}, payload) => {        
        
        commit('archiveStatus','Creating...');
        
        return payload.post('/api/archives')
            .then(() => {
                var message = 'Archive successfully created!';                                
                commit('archiveStatus', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('archiveStatus','Error'); 
                
                throw errors;
            });
    },
    updateArchive: ({commit}, payload) => {
        commit('archiveStatus','Updating...');
        
        return payload.patch('/api/archives/'+payload.id)
            .then(() => {
                var message = 'Archive successfully updated!';                                
                commit('archiveStatus', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('archiveStatus','Error'); 
                
                throw errors;
            });
    },
    deleteArchive: ({commit}, payload) => {
        commit('archiveStatus','Deleting...');
        
        return payload.delete('/api/archives/'+payload.id)
            .then(() => {
                var message = 'Archive successfully deleted!';                                
                commit('archiveStatus', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'error'});
            })
            .catch((errors) => {
                commit('archiveStatus','Error'); 
                
                throw errors;
            });
    }
};

const mutations = {
    archiveStatus : (state,status) => {
        state.archiveStatus = status;
    },
    archiveList : (state, archives) => {
       state.archives = archives;   
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
}