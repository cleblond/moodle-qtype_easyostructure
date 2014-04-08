M.qtype_easyostructure={
    insert_structure_into_applet : function(){
        var textfieldid = 'id_structure';
        if(document.getElementById(textfieldid).value != '') {	
            var s = document.getElementById(textfieldid).value;
            document.MSketch.setMol(s, 'mrv');
        }

	},

    insert_applet : function(Y, moodleurl, marvinpath){

	var warningspan = document.getElementById('appletdiv');

        var newApplet = document.createElement("applet");
        newApplet.code='chemaxon.marvin.applet.JMSketchLaunch';
        newApplet.archive='appletlaunch.jar';
        newApplet.name='MSketch';
        newApplet.width='650';
        newApplet.height='460';
        newApplet.tabIndex = -1; // Not directly tabbable
        newApplet.mayScript = true;     
	newApplet.id = 'MSketch';
	newApplet.setAttribute('codebase', marvinpath);

	var param=document.createElement('param');
	param.name='codebase_lookup';
        param.value='false';
	newApplet.appendChild(param);

        var param=document.createElement('param');
	param.name='menubar';
        param.value='true';
	newApplet.appendChild(param);

	var param=document.createElement('param');
	param.name='menuconfig';
        param.value = moodleurl + '/question/type/easyostructure/customization_mech_instructor.xml';
	newApplet.appendChild(param);

	var param=document.createElement('param');
	param.setAttribute('bondDraggedAlong','false');
	newApplet.appendChild(param);

	var param=document.createElement('param');
	param.name='chargeWithCircle';
        param.value='true';
	newApplet.appendChild(param);

	var param=document.createElement('param');
	param.name='lonePairsVisible';
        param.value='true';
	newApplet.appendChild(param);

	var param=document.createElement('param');
	param.name='lonePairsAutoCalc';
        param.value='false';
	newApplet.appendChild(param);

        warningspan.appendChild(newApplet);

    }

}


M.qtype_easyostructure.init_getanswerstring = function(Y, moodle_version){
    var handleSuccess = function(o) {

    };
    var handleFailure = function(o) {
        /*failure handler code*/
    };
    var callback = {
        success:handleSuccess,
        failure:handleFailure
    };
    if (moodle_version >= 2012120300) { //Moodle 2.4 or higher
        YAHOO = Y.YUI2;
    }

    Y.all(".id_insert").each(function(node) {
    	node.on("click", function () {
        var buttonid = node.getAttribute('id');
        var s = document.MSketch.getMol('mrv');
	textfieldid = 'id_structure';
	document.getElementById(textfieldid).value = s;
    	});
    });
};
