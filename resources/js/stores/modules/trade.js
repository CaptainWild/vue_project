const state = {
    tradeStatus: '',
    trades: [],
    trade: {},
};

const getters = {
    trades: state => state.trades,
    trade: state => state.trade,
    tradeStatus: state => state.tradeStatus,
};

const actions = {
    fetchTrades:({commit},payload) => {
        
        commit('TRADE_STATUS','Fetching Data...');
        
        return payload.get('/api/trades')
                .then((response) => {
                    commit('TRADE_LIST',response);
                }).catch((errors) => {});
    },
    fetchTrade: ({commit},payload) => {
        //nothing to do muna
    },
    createTrade:({commit}, payload) => {        
        
        commit('TRADE_STATUS','Creating...');
        
        return payload.post('/api/trades')
            .then(() => {
                var message = 'Trade successfully created!';                                
                commit('TRADE_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('TRADE_STATUS','Error'); 
                
                throw errors;
            });
    },
    updateTrade: ({commit}, payload) => {
        commit('TRADE_STATUS','Updating...');
        
        return payload.patch('/api/trades/'+payload.id)
            .then(() => {
                var message = 'Trade successfully updated!';                                
                commit('TRADE_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            })
            .catch((errors) => {
                commit('TRADE_STATUS','Error'); 
                
                throw errors;
            });
    },
    deleteTrade: ({commit}, payload) => {
        commit('TRADE_STATUS','Deleting...');
        
        return axios.delete('/api/trades/'+payload.id+'/'+payload.delete_remark)
            .then(() => {
                var message = 'Trade successfully deleted!';                                
                commit('TRADE_STATUS', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'error'});
            })
            .catch((errors) => {
                commit('TRADE_STATUS','Error'); 
                
                throw errors;
            });
    }
};

const mutations = {
    TRADE_STATUS : (state,status) => {
        state.tradeStatus = status;
    },
    TRADE_LIST : (state, trades) => {
       state.trades = trades;   
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
}