/*
function getSmiles(textfieldid) {
	document.getElementById(textfieldid).value = document.getElementById('EASYOSTRUCTURE' + textfieldid).smiles();
}

*/
/*
function getSmilesEdit(buttonname){
    var buttonnumber= buttonname.slice(7,-1);
	textfieldid = 'id_answer_' + buttonnumber;
	document.getElementById(textfieldid).value = document.getElementById('JME').smiles();
}
*/

/*
///modified by crl for easyostructure sketch
function getSmilesEdit(buttonname, format){
    var buttonnumber = buttonname.slice(7,-1);
    var s = document.MSketch.getMol(format);
	s = local2unix(s); // Convert "\n" to local line separator
	s = "\n" + s;
	textfieldid = 'id_structure';
	document.getElementById(textfieldid).value = s;
}

*/







M.qtype_easyostructure={
    insert_structure_into_applet : function(){
		var textfieldid = 'id_structure';
		if(document.getElementById(textfieldid).value != '') {
		
		var s = document.getElementById(textfieldid).value;
		document.MSketch.setMol(s, 'mrv');
		}

	},

    insert_applet : function(Y, moodleurl){

	var warningspan = document.getElementById('appletdiv');
//        warningspan.innerHTML = '';

        var newApplet = document.createElement("applet");
        newApplet.code='chemaxon.marvin.applet.JMSketchLaunch';
        newApplet.archive='appletlaunch.jar';
        newApplet.name='MSketch';
        newApplet.width='650';
        newApplet.height='460';
        newApplet.tabIndex = -1; // Not directly tabbable
        newApplet.mayScript = true;     
	newApplet.id = 'MSketch';
	newApplet.setAttribute('codebase','/marvin');

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
