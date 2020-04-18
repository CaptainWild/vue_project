const state = {
    equip: {},
    equipment: [],
    equipmentstatus: '',    
    equipstatuses: [],
    equipcategories: [],    
}

const getters = {
  equip: state => state.equip,
  equipment: state => state.equipment,
  equipmentstatus: state => state.equipmmentstatus,
  equipstatuses: state => state.equipstatuses,
  equipcategories: state => state.equipcategories,
};

const actions = {
    fetchEquipment: ({commit}) => {
        commit('EQUIPMENT_STATUS','Fetching Data...');
        
        return new Promise((resolve,reject) => {
            axios.get('/api/equips')
            .then((response) => {
                commit('EQUIPMENT_LIST',response.data);
                resolve(response)
            }).catch((errors) => {
                reject(errors.response.data)
            });
        });
    },
    fetchEquip:({commit}, payload) => {
        commit('EQUIPMENT_STATUS', 'Fetching Equip Record');

        return new Promise((resolve,reject) => {
            axios.get('/api/equips/'+ payload.id)
                .then(response => {                             
                    commit('SET_EQUIP', response.data);            
                    
                    resolve(response.data);
            }).catch((errors) => {
                commit('EQUIPMENT_STATUS','Error'); 
                
                reject(errors.response.data);
            });
        });
    },
    fetchEquipStatuses: ({commit}) => {
        commit('EQUIPMENT_STATUS', 'Fetching Equipment Status');

        return new Promise((resolve,reject) => {
            axios.get('/api/equipstatuses')
                .then(response => {                             
                    commit('SET_EQUIP_STATUSES', response.data);            
                    
                    resolve(response.data);
            }).catch((errors) => {
                commit('EQUIPMENT_STATUS','Error'); 
                
                reject(errors.response.data);
            });
        });
    },
    fetchEquipCategories: ({commit}) => {
        commit('EQUIPMENT_STATUS', 'Fetching Equipment Categories');

        return new Promise((resolve,reject) => {
            axios.get('/api/equipcategories')
                .then(response => {                             
                    commit('SET_EQUIP_CATEGORIES', response.data);            
                    
                    resolve(response.data);
            }).catch((errors) => {
                commit('EQUIPMENT_STATUS','Error'); 
                
                reject(errors.response.data);
            });
        });
    },
    createEquip:({commit}, payload) => {                
        commit('EQUIPMENT_STATUS','Creating...');
        
        return new Promise((resolve, reject) => {
            axios.post('/api/equips', payload)
            .then(() => {
                var message = 'Equipment successfully created!';                                
                commit('EQUIPMENT_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                resolve();
            })
            .catch((errors) => {
                commit('EQUIPMENT_STATUS','Error'); 
                
                reject(errors.response.data);
            });
        });
    },
    updateEquip: ({commit}, payload) => {
        commit('EQUIPMENT_STATUS','Updating...');
        
        return new Promise((resolve,reject) => {
            axios.post('/api/equips/'+payload.id, payload)
            .then(() => {
                var message = 'Equipment successfully updated!';                                
                commit('EQUIPMENT_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                resolve();
            })
            .catch((errors) => {
                commit('EQUIPMENT_STATUS','Error'); 
            
                reject(errors.response.data);
            });
        }); 
    },
    deleteEquip: ({commit}, payload) => {
        commit('EQUIPMENT_STATUS','Deleting...');
        
        return new Promise((resolve,reject) => {
            axios.delete('/api/equips/'+payload.id+'/'+payload.delete_remark)
            .then(() => {
                var message = 'Equipment successfully deleted!';                                
                commit('EQUIPMENT_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'error'});
                resolve();
            })
            .catch((errors) => {
                commit('EQUIPMENT_STATUS','Error'); 
                
                reject(errors.response.data);
            });
        });
    }
}

const mutations = {   
    EQUIPMENT_LIST : (state, equipment) => {
        state.equipment = equipment
    },
    EQUIPMENT_STATUS :  (state,status) => {
        state.equipmentstatus = status
    },    
    RESET_EQUIP :  (state) => {
        state.equip = []
    },
    RESET_EQUIPMENT_LIST : (state) => {
        state.equipment = []
    },    
    SET_EQUIP_CATEGORIES : (state,categories) => {
        state.equipcategories = categories
    },
    SET_EQUIP_STATUSES : (state, statuses) => {
        state.equipstatuses = statuses
    },
    SET_EQUIP : (state, equip) => {
        state.equip = equip
    },
};

export default {
    state,
    getters,
    actions,
    mutations,
}