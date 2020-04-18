const state = {
    hazardcategories: [],
    inspectionStatus: '',
    inspectionitemsStatus: '',    
    inspectiontypeitems: [],
    inspectiontypes: [],
    inspections: [],
    inspection: {},
    inspectionitems: [],
    neginspectionitems: [],
    posinspectionitems: [],
    siteobservations: [],    
}

const getters = {
    hazardcategories: state => state.hazardcategories,
    inspectionitemsStatus: state => state.inspectionitemsStatus,
    inspectiontypeitems: state => state.inspectiontypeitems,
    inspectiontypes: state => state.inspectiontypes,
    inspection: state => state.inspection,
    inspections: state => state.inspections,
    inspectionStatus: state => state.inspectionStatus,
    inspectionitems: state => state.inspectionitems,
    neginspectionitems: state => state.neginspectionitems,
    posinspectionitems: state => state.posinspectionitems,
    siteobservations: state => state.siteobservations,
};

const actions = {
   fetchInspections: ({commit}) => {
        return new Promise((resolve,reject) => {
            axios.get('/api/inspections')
            .then(response => {    
                
                commit('SET_INSPECTION_STATUS','Fetched');
                commit('INSPECTION_LIST',response.data);
                resolve(response.data);
            })
            .catch(error => {
                commit('SET_INSPECTION_STATUS','Error');
                reject(error.response.data);
            });
        });
   },
   fetchInspection: ({commit}, payload) => {
        return new Promise((resolve,reject) => {
            axios.get('/api/inspections/'+payload.id)
            .then(response => {    

                commit('SET_INSPECTION_STATUS','Fetched');
                commit('SET_INSPECTION',response.data);
                resolve(response.data);
            })
            .catch(error => {
                commit('SET_INSPECTION_STATUS','Error');
                reject(error.response.data);
            });
        });
    },
    fetchInspectionItemsByInspectionId: ({commit}, payload) => {

        return new Promise((resolve, reject) => {
            axios.get('/api/inspectiondetails/'+ payload.inspection_id)
                .then(response => {
                    commit('SET_INSPECTION_ITEMS_STATUS','Fetched Items');
                    commit('SET_INSPECTION_ITEMS',response.data);
                    commit('SET_POSITIVE_INSPECTIONS_DETAILS',response.data);
                    commit('SET_NEGATIVE_INSPECTIONS_DETAILS',response.data);
                    resolve(response.data);
                })
                .catch(error => {
                    commit('SET_INSPECTION_STATUS','Error');
                    reject(error.response.data);
                });
        })
    },
    fetchInspectionTypes: ({commit}) => {
        commit('SET_INSPECTION_STATUS', 'Fetching Inspection Types');

        return new Promise((resolve,reject) => {
            axios.get('/api/inspectiontypes')
                .then(response => {                             
                    commit('SET_INSPECTION_TYPES', response.data);            
                    
                    resolve(response.data);
            }).catch((errors) => {
                commit('SET_INSPECTION_STATUS','Error'); 
                
                reject(errors.response.data);
            });
        });
   },
   fetchInspectionItemsByType: ({commit},payload) => {
        commit('SET_INSPECTION_STATUS', 'Fetching Inspection Items by Type');

        return new Promise((resolve,reject) => {
            axios.get('/api/inspectiontypeitems/'+payload.inspection_type_id+'/items')
                .then(response => {  
                    commit('SET_INSPECTION_ITEMS_BY_TYPE', response.data);            
                    
                    resolve(response.data);
            }).catch((errors) => {
                commit('SET_INSPECTION_STATUS','Error'); 
                
                reject(errors.response.data);
            });
        });
    },
   fetchInspectionTypeItems: ({commit}) => {
        commit('SET_INSPECTION_STATUS', 'Fetching Inspection Type Items');

        return new Promise((resolve,reject) => {
            axios.get('/api/inspectiontypeitems')
                .then(response => {                             
                    commit('SET_INSPECTION_TYPE_ITEMS', response.data);            
                    
                    resolve(response.data);
            }).catch((errors) => {
                commit('SET_INSPECTION_STATUS','Error'); 
                
                reject(errors.response.data);
            });
        });
    },
   fetchHazardCategories: ({commit}) => {
        commit('SET_INSPECTION_STATUS', 'Fetching Hazard Categories');

        return new Promise((resolve,reject) => {
            axios.get('/api/hazardcategories')
                .then(response => {                             
                    commit('SET_HAZARD_CATEGORIES', response.data);            
                    
                    resolve(response.data);
            }).catch((errors) => {
                commit('SET_INSPECTION_STATUS','Error'); 
                
                reject(errors.response.data);
            });
        });
   },
   fetchSiteObservations: ({commit}) => {
        commit('SET_INSPECTION_STATUS', 'Fetching Site Observations');

        return new Promise((resolve,reject) => {
            axios.get('/api/siteobservations')
                .then(response => {  
                    commit('SET_SITE_OBSERVATIONS', response.data);            
                    resolve(response.data);
            }).catch((errors) => {
                commit('SET_INSPECTION_STATUS','Error'); 
                
                reject(errors.response.data);
            });
        });
    },    

    createInspection: ({commit}, payload) => {
        commit('SET_INSPECTION_STATUS','Creating...');
            
        return new Promise((resolve, reject) => {
            axios.post('/api/inspections', payload)
            .then((response) => {
                var message = 'Inspection successfully created!';                                
                commit('SET_INSPECTION_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                resolve(response.data);
            })
            .catch((errors) => {
                commit('SET_INSPECTION_STATUS','Error'); 
                
                reject(errors.response.data);
            });
        });
   },
   createInspectionDetail: ({commit},payload) => {
        commit('SET_INSPECTION_STATUS', 'Creating Inspection Detail...')

        return new Promise((resolve, reject) => {
            axios.post('/api/inspectiondetails/'+payload.get('inspection_id'), payload)
                .then((response) => {
                    var message = 'Inspection Detail successfully created!';                                
                    commit('SET_INSPECTION_STATUS', message);            
                    commit('setSnackbar',{text: message, visible: true, color: 'success'});
                    resolve(response.data);
                })
                .catch((errors) => {
                    commit('SET_INSPECTION_STATUS','Error'); 
                    
                    reject(errors.response.data);
                });
        })
   },
   updateInspection: ({commit}, payload) => {
        commit('SET_INSPECTION_STATUS','Updating...');
        
        return new Promise((resolve,reject) => {
            axios.post('/api/inspections/'+payload.id, payload)
            .then(() => {
                var message = 'Inspection successfully updated!';                                
                commit('SET_INSPECTION_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                resolve();
            })
            .catch((errors) => {
                commit('SET_INSPECTION_STATUS','Error'); 
            
                reject(errors.response.data);
            });
        }); 
    },
    deleteInspection: ({commit}, payload) => {
        commit('SET_INSPECTION_STATUS','Deleting...');
        
        return new Promise((resolve,reject) => {
            // axios.delete('/api/inspections/'+payload.id)
            axios.delete('/api/inspections/'+payload.id+'/'+payload.delete_remark)
            .then(() => {
                var message = 'Inspection successfully deleted!';                                
                commit('SET_INSPECTION_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'error'});
                resolve();
            })
            .catch((errors) => {
                commit('SET_INSPECTION_STATUS','Error'); 
                
                reject(errors.response.data);
            });
        });
    },
    
    deleteInspectionDetail: ({commit}, payload) => {
        commit('SET_INSPECTION_STATUS','Deleting Inspection Detail...');
        
        return new Promise((resolve,reject) => {

            axios.delete('/api/inspectiondetails/'+payload.id)
            .then(() => {
                var message = 'Inspection Detail successfully deleted!';                                
                commit('SET_INSPECTION_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'error'});
                resolve();
            })
            .catch((errors) => {
                commit('SET_INSPECTION_STATUS','Error'); 
                
                reject(errors.response.data);
            });
        });
    },

    incompleteInspection: ({commit}, payload) => {
        commit('SET_INSPECTION_STATUS','Updating to Incomplete...');
        
        return new Promise((resolve,reject) => {
            axios.post('/api/inspections/'+payload.inspection_id+'/incomplete', payload)
            .then(() => {
                var message = 'Inspection successfully send to Sub-Contractor(s)!';                                
                commit('SET_INSPECTION_STATUS', message);    
                commit('RESET_POSITITVE_INSPECTIONS_DETAILS');
                commit('RESET_NEGATIVE_INSPECTIONS_DETAILS');    
                commit('RESET_INSPECTION_ITEMS');
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                resolve();
            })
            .catch((errors) => {
                commit('SET_INSPECTION_STATUS','Error'); 
            
                reject(errors.response.data);
            });
        }); 
    },

    closeInspection: ({commit}, payload) => {
        commit('SET_INSPECTION_STATUS','Updating to Completed...');
        
        return new Promise((resolve,reject) => {
            axios.post('/api/inspections/'+payload.inspection_id+'/close', payload)
            .then(() => {
                var message = 'Inspection successfully Closed!';                                
                commit('SET_INSPECTION_STATUS', message);    
                commit('RESET_POSITITVE_INSPECTIONS_DETAILS');
                commit('RESET_NEGATIVE_INSPECTIONS_DETAILS');    
                commit('RESET_INSPECTION_ITEMS');
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                resolve();
            })
            .catch((errors) => {
                commit('SET_INSPECTION_STATUS','Error'); 
            
                reject(errors.response.data);
            });
        }); 
    }
}

const mutations = {
    RESET_INSPECTION_LIST: (state) => {
        state.inspections = []
    },
    RESET_INSPECTION: (state) => {
        state.inspection = []
    },
    INSPECTION_LIST: (state, inspections) => {
       state.inspections = inspections
    },
    SET_INSPECTION: (state, inspection) => {
        state.inspection = inspection
    },
    SET_INSPECTION_ITEMS: (state, inspectionitems) => {
        state.inspectionitems = inspectionitems
    },
    RESET_INSPECTION_ITEMS: (state) => {
        state.inspectionitems = []
    },
    SET_INSPECTION_TYPES: (state, inspectiontypes) => {
        state.inspectiontypes = inspectiontypes
    },
    SET_HAZARD_CATEGORIES: (state, hazardcategories) => {
        state.hazardcategories = hazardcategories
    },
    SET_SITE_OBSERVATIONS: (state, siteobservations) => {
        state.siteobservations = siteobservations
    },
    SET_INSPECTION_TYPE_ITEMS:(state, inspectiontypeitems) => {
        state.inspectiontypeitems = inspectiontypeitems
    },
    SET_INSPECTION_ITEMS_BY_TYPE: (state, inspectiontypeitems) => {
        state.inspectiontypeitems = inspectiontypeitems
    },
    SET_INSPECTION_ITEMS_STATUS: (state, status) => {
        state.inspectionitemsStatus = status
    },
    SET_INSPECTION_STATUS: (state, status) => {
        state.inspectionStatus = status
    },
    RESET_POSITITVE_INSPECTIONS_DETAILS: (state) => {
        state.posinspectionitems = []
    },
    SET_POSITIVE_INSPECTIONS_DETAILS: (state, inspectiontypeitems) => {
        let pos = _.filter(inspectiontypeitems, function (o) {
                return o.site_observation_id == 2
        });

        state.posinspectionitems = pos
    },
    RESET_NEGATIVE_INSPECTIONS_DETAILS: (state) => {
        state.neginspectionitems = []
    },
    SET_NEGATIVE_INSPECTIONS_DETAILS: (state, inspectiontypeitems) => {
        let neg = _.filter(inspectiontypeitems, function (o) {
                return o.site_observation_id == 1
        });

        state.neginspectionitems = neg
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
}