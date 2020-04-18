const state = {
    attachmentStatus: '',
    attachments: [],
    attachment: {},
    tempAttachments:{},
};

const getters = {
    attachments: state => state.attachments,
    attachment: state => state.attachment,
    attachmentStatus: state => state.attachmentStatus,
    tempAttachments: state => state.tempAttachments,
};

const actions = {    
    createAttachment:({commit}, payload) => {        
        
        commit('attachmentStatus','Uploading...');
        
        return new Promise((resolve,reject) => {
            axios.post('/api/attachments', payload)
            .then(response => {
                var message = 'Attachment successfully uploaded!';                                
                
                commit('attachmentStatus', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response.data);
            });
        });

    },
    createAttachments:({commit}, payload) => {        
        
        commit('attachmentStatus','Uploading...');
        
        return new Promise((resolve,reject) => {
            axios.post('/api/attachments/multiple', payload)
            .then(response => {
                var message = 'Attachments successfully uploaded!';                                
                
                commit('attachmentStatus', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
                
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response.data);
            });
        });

    },
    downloadFile: ({commit}, payload) => {
        commit('attachmentStatus','Downloading...');
        
        if(payload == undefined) {            
            
            commit('setSnackbar',{text: "No Attachment / No Primary Attachment.", visible: true, color: 'error'});

            return payload;
        } else {
            return new Promise((resolve,reject) => {
                axios.get('/api/attachments/'+payload.id)
                .then(response => {
                    commit('attachmentStatus', "Downloaded.");   
                    
                    resolve(response.data);
                })
                .catch(error => {
                    commit('attachmentStatus', "error");   
                    
                    commit('setSnackbar',{text: "Downloading Failed. Something went wrong.", visible: true, color: 'error'});
    
                    reject(error.response.data);
                });
            });
        }

        
    },
    deleteAttachment: ({commit}, payload) => {
        commit('attachmentStatus','Deleting...');
        
        return payload.delete('/api/attachments/'+payload.id)
            .then(() => {
                var message = 'Attachment successfully deleted!';                                
                commit('attachmentStatus', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'error'});
            })
            .catch((errors) => {
                commit('attachmentStatus','Error'); 
                
                throw errors;
            });
    },
    fetchAttachments:({commit},payload) => {
        
        commit('attachmentStatus','Fetching Data...');
        
        return payload.get('/api/attachments/'+payload.originalData.reference_id+'/'+payload.originalData.reference_table)
            .then((response) => {
                commit('attachmentList',response);
            })
            .catch((errors) => {
                commit('attachmentStatus','Error'); 
            });
    },
    fetchAttachmentsWithSrc:({commit},payload) => {
        
        commit('attachmentStatus','Fetching Data...');
        
        return new Promise((resolve,reject) => {
            axios.get('/api/attachments/'+payload.reference_id+'/'+payload.reference_table+'/'+payload.src_mod)
            .then((response) => {
                commit('SET_TEMP_ATTACHMENT_LIST',{ data:response.data, src_mod: payload.src_mod});
                resolve()
            })
            .catch((errors) => {
                commit('attachmentStatus','Error'); 
                reject(errors)                
            });
        })
    },
    primaryAttachment: ({commit},payload) => {
        commit('attachmentStatus','Updating...');
        
        return payload.patch('/api/attachments/'+payload.id)
            .then((response) => {
                var message = 'Set as Primary Attachment!';                                
                commit('attachmentStatus', message);            
                commit('setSnackbar',{text: message, visible: true, color: 'success'});
            }).catch((errors) => {
                commit('attachmentStatus','Error'); 
            });
    }
};

const mutations = {
    attachmentStatus : (state,status) => {
        state.attachmentStatus = status;
    },
    attachmentList : (state, attachments) => {
       state.attachments = attachments;   
    },
    SET_TEMP_ATTACHMENT_LIST: (state, temp) => {         
        if(!state.tempAttachments.hasOwnProperty(temp.src_mod)) {
            state.tempAttachments[temp.src_mod] = [];
        }

        if(_.isEmpty(state.tempAttachments[temp.src_mod])) {
            state.tempAttachments[temp.src_mod] = temp.data
        }    
    },
    STORE_TEMP_ATTACHMENT: (state,temp) => {
        var tempObj = {'description': temp.get('description'), 'file_name': temp.get('file_name')};
        
        if(!state.tempAttachments.hasOwnProperty(temp.get('src_mod'))){
            state.tempAttachments[temp.get('src_mod')] = [];
        }

        state.tempAttachments[temp.get('src_mod')].push(tempObj)
    },
    DESTORY_TEMP_ATTACHMENT_BY_INDEX: (state,obj) => {
        state.tempAttachments[obj.src_mod].splice(obj.idx,1)
    },
    DESTROY_TEMP_ATTACHMENT: (state) => {
        state.tempAttachments = {}
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
}