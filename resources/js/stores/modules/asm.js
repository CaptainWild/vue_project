import Axios from "axios";

const state = {
    asmStatus: '',
    asms: [],
    asm: {},
}

const getters = {
    asms: state => state.asms,
    asm: state => state.asm,
    asmStatus: state => state.asmStatus,
};

const actions = {
    fetchAsms: ({commit}) => {
        
        commit('ASM_STATUS','Fetching Data...');
        
        return new Promise ((resolve,reject) => {            
            axios.get('/api/asms')
                .then(response => {    
                
                commit('ASM_STATUS','Fetched');
                commit('ASM_LIST',response.data);
                resolve(response.data);
            })
            .catch(error => {
                commit('ASM_STATUS','Error');
                reject(error.response.data);
            });
        });
            
    },
}

const mutations = {
    ASM_STATUS: (state, status) => {
        state.asmStatus = status
    },
    ASM_LIST: (state, asms) => {
        state.asms = asms
    }

};

export default {
    state,
    getters,
    actions,
    mutations,
}