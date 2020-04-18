const state = {
    eventStatus: '',
    events: [],
    event: {},
}

const getters = {
    events: state => state.events,
    event: state => state.event,
    eventStatus: state => state.eventStatus,
};

const actions = {
    createEvent:({commit}, payload) => {        
        
        commit('eventStatus','Creating...');
        
        return new Promise((resolve,reject) => {
            axios.post('/api/events', payload)
            .then(response => {
                var message = 'Event successfully created!';                                
                
                commit('eventStatus', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response.data);
            });
        });

    },

    cancelEvent: ({commit}, payload) => {
        return new Promise((resolve,reject) => {
            axios.patch('/api/cancel-events/'+payload.id)
            .then(response => {
                var message = 'Event successfully cancelled!';                                
                
                commit('eventStatus', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response.data);
            });
        });
    },

    deleteEvent: ({commit}, payload) => {
        commit('eventStatus','Deleting...');
        
        return new Promise((resolve,reject) => {
            axios.delete('/api/events/'+payload.id)
            .then(response => {
                var message = 'Event successfully deleted!';                                
                commit('eventStatus', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'error'});
                resolve(response.data);
            })
            .catch(error => {
                commit('eventStatus','Error'); 
                
                reject(error.response.data);
            });
        });
    },
    
    fetchEvents:({commit}, payload) => {
        
        commit('eventStatus','Fetching Data...');
        
        return new Promise((resolve,reject) => {
                axios.get('/api/events/'+payload.start+'/'+payload.end+'/'+payload.type)
                .then(response => {                    
                    commit('eventList',response.data);
                    resolve(response.data);
                }).catch(error => {
                    reject(error.response.data);
                });
            });
    },

    updateEvent:({commit}, payload) => {
        return new Promise((resolve,reject) => {
            axios.post('/api/events/'+payload.get('id'),payload)
            .then(response => {
                var message = 'Event successfully updated!';                                
                
                commit('eventStatus', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response.data);
            });
        });
    },
};

const mutations = {
    eventStatus : (state,status) => {
        state.eventStatus = status;
    },
    eventList : (state, events) => {
       state.events = events;   
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
}