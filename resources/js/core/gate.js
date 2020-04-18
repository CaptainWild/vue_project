export default class Gate {
    constructor(user) {
        this.user = user
    }
    
    permit(access) {
        if(this.user.is_admin) {
            return true
        }
            
        var result = _.find(this.user.role.permissions, function (o) {
            return o.code == access;
        });     
        
        if(result != undefined) {
            return true
        }
    
        return false
    }
}