import Vue from 'vue';
import Vuex from 'vuex';

import archive from './modules/archive'
import asm from './modules/asm'
import attachment from './modules/attachment'
import auth from './modules/auth'
import checklist_legend from './modules/checklist_legend'
import checklistitem from './modules/checklistitem'
import checklistgroup from './modules/checklistgroup'
import checklist from './modules/checklist'
import equipment from './modules/equip'
import event from './modules/event'
import hrwchecklist from './modules/hrwchecklist'
import hrw from './modules/hrw'
import inspection from './modules/inspection'
import inspectionchecklist from './modules/inspectionchecklist'
import inspectionchecklistitem from './modules/inspectionchecklistitem'
import inspectionchecklistitemresult from './modules/inspectionchecklistitemresult'
import permission_role from './modules/permission_role'
import permission from './modules/permission'
import project_subcontractor from './modules/project_subcontractor'
import project from './modules/project'
import ptwworkercertificate from './modules/ptwworkercertificate'
import ptw from './modules/ptw'
import ptwchecklistitem from './modules/ptwchecklistitem'
import ptwchecklistitemdetail from './modules/ptwchecklistitemdetail'
import ptwsignee from './modules/ptwsignee'
import snackbar from './modules/snackbar'
import subcontractor from './modules/subcontractor'
import swp from './modules/swp'
import swpstatushistory from './modules/swpstatushistory'
import trade from './modules/trade'
import user from './modules/user'
import worker from './modules/worker'
import workercertificate from './modules/workercertificate'
import role from './modules/role'


Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        archive,
        asm,
        attachment,
        auth,
        checklist_legend,
        checklistitem,
        checklistgroup,
        checklist,
        equipment,
        event,
        hrwchecklist,
        hrw,
        inspection,
        inspectionchecklist,
        inspectionchecklistitem,
        inspectionchecklistitemresult,
        permission_role,
        permission,
        project_subcontractor,
        project,
        ptwworkercertificate,
        ptw,
        ptwchecklistitem,
        ptwchecklistitemdetail,
        ptwsignee,
        snackbar,
        subcontractor,
        swp,
        swpstatushistory,
        trade,
        user,
        worker,
        workercertificate,
        role,
    }
});