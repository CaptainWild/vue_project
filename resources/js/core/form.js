import Errors from "./errors";

export default class Form {
    
    /**
     * Create a new From instance
     * 
     * @param {object} data
     */
    constructor(data) {
        this.originalData = data;

        for(let field in data) {
            this[field] = data[field];
        }

        this.errors = new Errors();

    }

    /**
     * Fetch all relevant data for the form.
     */
    data() {
        let data = {};

        for (let property in this.originalData) {
            data[property] = this[property];
        }

        return data;
    }

    /**
     * Reset the form fields.
     */
    reset() {
        for (let field in this.originalData) {
            this[field] = '';
        }

        this.errors.clear();
    }

    /**
     * Send a GET request to the given URL
     * 
     * @param {string} url 
     */
    get(url,config={}) {
        return this.submit('get',url,config);
    }

    /**
     * Send a POST request to the given URL.
     * 
     * @param {string} url 
     */
    post(url,config={}) {
        return this.submit('post',url,config);
    }

    /**
     * Send a PUT request to the given URL.
     * 
     * @param {string} url 
     */ 
    put(url,config={}) {
        return this.submit('put',url,config);
    }

     /**
     * Send a PATCH request to the given URL.
     * 
     * @param {string} url 
     */ 
    patch(url,config={}) {
        return this.submit('patch',url,config);
    }

     /**
     * Send a DELETE request to the given URL.
     * 
     * @param {string} url 
     */ 
    delete(url,config={}) {
        return this.submit('delete',url,config);
    }

    /**
     * Submit the form.
     * 
     * @param {string} requestType 
     * @param {string} url 
     */
    submit(requestType,url,config) {        
        return new Promise((resolve,reject) => {
            axios[requestType](url, this.data(),config)
            .then(response => {
                this.onSuccess(response.data);
                resolve(response.data);
            })
            .catch(error => {
                this.onFail(error.response.data.errors);
                
                reject(error.response.data);
            });
        });
    }

    /**
     * Handle a successful form submission.
     * 
     * @param {object} data 
     */
    onSuccess(data){
        //console.log(data.message); //temporary

        this.reset();
    }

    onFail(errors) {
        this.errors.record(errors);
    }

}