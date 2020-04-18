import axios from "axios";

const state = {
    checklistLegendsStatus: '',
    checklistLegends: {},
    legendStatus: '',
    legends: [],
};

const getters = {
    checklistLegendsStatus: state => state.checklistLegendsStatus,
    checklistLegends: state => state.checklistLegends,    
    legends: state => state.legends,
};

const actions = {
    fetchLegends:({commit}) => {
        //get api for legends since we did not do any store js dedicated for legends
        return new Promise((resolve, reject) => {
            axios.get('/api/legends')
            .then(response => {    

                commit('LEGEND_STATUS','Fetched');
                commit('LEGEND_LIST',response.data);
                resolve(response.data);
            })
            .catch(error => {
                commit('LEGEND_STATUS','Error');
                reject(error.response.data);
            });
        }) 
    },
    toggleChecklistLegend:({commit},payload) => {
        
        commit('CHECKLIST_LEGEND_STATUS','Updating Datum...');
        
        return new Promise((resolve,reject) => {
                axios.post('/api/checklists/'+payload.checklist_id+'/toggle',payload)
                .then(response => {
                    commit('setSnackbar',{text: 'Checklist Updated!', visible: true, color: 'info'});
                    resolve(response)
                }).catch((errors) => {
                    reject(errors.response.data)
                });
            });
    },
    toggleAllChecklistLegend:({commit},payload) => {
        
        commit('CHECKLIST_LEGEND_STATUS','Updating Data...');
        
        return new Promise((resolve,reject) => {
                axios.post('/api/checklists/'+payload.checklist_id+'/toggle-all',payload)
                .then(response => {                    
                    commit('setSnackbar',{text: 'Checklist Updated!', visible: true, color: 'info'});
                    resolve(response)
                }).catch((errors) => {
                    reject(errors.response.data)
                });
            });
    },

}

const mutations = {
    CHECKLIST_LEGEND_STATUS : (state,status) => {
        state.checklistLegendsStatus = status;
    },
    // PROJECT_SUBCONTRACTOR_LIST: (state, subcontractors) => {
    //     state.projectSubcontractors = subcontractors
    // },
    // RESET_PROJECT_SUBCONTRACTORS: (state) => {
    //     state.projectSubcontractors = []
    // },
    LEGEND_LIST: (state, legends) => {
        state.legends = legends
    },
    LEGEND_STATUS: (state, status) => {
        state.legendStatus = status
    },
    SET_CHECKLIST_LEGENDS: (state, checklist) => {
        state.checklistLegends = checklist
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
}