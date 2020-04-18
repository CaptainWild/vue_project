const state = {
    projectStatus: '',
    projects: [],
    project: {},
    projectPtws:[],
};

const getters = {
    projects: state => state.projects,
    project: state => state.project,
    projectStatus: state => state.projectStatus,
    projectPtws: state => state.projectPtws,
};

const actions = {
    fetchProjects:({commit},payload) => {
        
        commit('PROJECT_STATUS','Fetching Data...');
        
        return payload.get('/api/projects')
                .then((response) => {
                    commit('PROJECT_LIST',response);
                }).catch((errors) => {});
    },
    fetchProjectPtwsByDate:({commit},payload) => {
        
        commit('PROJECT_STATUS','Fetching Data...');
        
        return new Promise((resolve, reject) => {
            
            axios.get('/api/projects/'+payload.project_id+'/ptws/'+payload.date)
                .then((response) => {
                    commit('PROJECT_STATUS','Fetched PTW...');
                    commit('PROJECT_PTW_LIST',response.data);
                    resolve(response.data)
                }).catch((errors) => {
                    commit('PROJECT_STATUS','Error');
                    reject(errors.response.data);
                });
        });
    },
    createProject:({commit}, payload) => {        
        
        commit('PROJECT_STATUS','Creating...');
        
        return payload.post('/api/projects')
            .then(() => {
                var message = 'Project successfully created!';                                
                commit('PROJECT_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('PROJECT_STATUS','Error'); 
                
                throw errors;
            });
    },
    updateProject: ({commit}, payload) => {
        commit('PROJECT_STATUS','Updating...');
        
        return payload.patch('/api/projects/'+payload.id)
            .then(() => {
                var message = 'Project successfully updated!';                                
                commit('PROJECT_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('PROJECT_STATUS','Error'); 
                
                throw errors;
            });
    },
    deleteProject: ({commit}, payload) => {
        commit('PROJECT_STATUS','Deleting...');
        
        return axios.delete('/api/projects/'+payload.id+'/'+payload.delete_remark)
            .then(() => {
                var message = 'Project successfully deleted!';                                
                commit('PROJECT_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'error'});
            })
            .catch((errors) => {
                commit('PROJECT_STATUS','Error'); 
                
                throw errors;
            });
    }
};

const mutations = {
    PROJECT_STATUS : (state,status) => {
        state.projectStatus = status;
    },
    PROJECT_LIST : (state, projects) => {
        state.projects = projects;   
    },
    CLEAR_PROJECT: (state) => {
        state.projects = []
    },
    PROJECT_PTW_LIST: (state, projectPtws) => {
        state.projectPtws = projectPtws
    },
    CLEAR_PROJECT_PTW: (state) => {
        state.projectPtws = []
    },
};

export default {
    state,
    getters,
    actions,
    mutations,
}