<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Defines the editing form for the easyostructure question type.
 *
 * @package    qtype
 * @subpackage easyostructure
 * @copyright  2007 Jamie Pratt
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();


/**
 * easyostructure question editing form definition.
 *
 * @copyright  2007 Jamie Pratt
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once($CFG->dirroot . '/question/type/shortanswer/edit_shortanswer_form.php');


/**
 * Calculated question type editing form definition.
 *
 * @copyright  2007 Jamie Pratt me@jamiep.org
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_easyostructure_edit_form extends qtype_shortanswer_edit_form {

    protected function definition_inner($mform) {
		global $PAGE, $CFG;
		
		$PAGE->requires->js('/question/type/easyostructure/easyostructure_script.js');
		$PAGE->requires->css('/question/type/easyostructure/easyostructure_styles.css');
        $mform->addElement('hidden', 'usecase', 1);
//$question = $qa->get_question();



/*        $menu = array(
           get_string('caseshowproducts', 'qtype_easyostructure'),
             get_string('casenoshowproducts', 'qtype_easyostructure')
        );*/










//$mform->addElement('html', html_writer::empty_tag('br'));
        $mform->addElement('static', 'answersinstruct',
                get_string('correctanswers', 'qtype_easyostructure'),
                get_string('filloutoneanswer', 'qtype_easyostructure'));
//        $mform->closeHeaderBefore('answersinstruct');


        $menu = array(
           get_string('displaymodelinebond', 'qtype_easyostructure'),
             get_string('displaymodenormal', 'qtype_easyostructure'),
		get_string('displaymode3d', 'qtype_easyostructure')
        );
        $mform->addElement('select', 'displaymode',
                get_string('displaymodedescrip', 'qtype_easyostructure'), $menu);




//$mform->addElement('html', html_writer::empty_tag('br'));


	    $easyostructurebuildstring = "\n<script LANGUAGE=\"JavaScript1.1\" SRC=\"../../marvin/marvin.js\"></script>".

"<script LANGUAGE=\"JavaScript1.1\">



msketch_name = \"MSketch\";
msketch_begin(\"../../marvin\", 460, 335);
msketch_param(\"menuconfig\", \"customization_mech_instructor.xml\");
msketch_param(\"background\", \"#ffffff\");
msketch_param(\"molbg\", \"#ffffff\");
msketch_end();
</script> ";


        //output the marvin applet
        $mform->addElement('html', html_writer::start_tag('div', array('style'=>'width:650px;')));
		$mform->addElement('html', html_writer::start_tag('div', array('style'=>'float: right;font-style: italic ;')));
//		$mform->addElement('html', html_writer::start_tag('small'));
//		$easyostructurehomeurl = 'http://www.chemaxon.com';
//		$mform->addElement('html', html_writer::link($easyostructurehomeurl, get_string('easyostructureeditor', 'qtype_easyostructure')));
//		$mform->addElement('html', html_writer::empty_tag('br'));
//		$mform->addElement('html', html_writer::tag('span', get_string('author', 'qtype_easyostructure'), array('class'=>'easyostructureauthor')));
//		$mform->addElement('html', html_writer::end_tag('small'));
//		$mform->addElement('html', html_writer::end_tag('div'));
		$mform->addElement('html',$easyostructurebuildstring);
		$mform->addElement('html', html_writer::end_tag('div'));
$mform->addElement('html', html_writer::empty_tag('br'));

//		$result .= html_writer::tag('textarea', $stripped_xml, array('id' => 'stripped_answer', 'style' => 'display:none;'));


//        $mform->addElement('textarea', 'structure', '', 'id="structure_current", style="display:none;"');



        $mform->addElement('textarea', 'structure',
                'Build structure here!  Be sure to click the <b>"Insert from editor"</b> button below');
	$mform->addRule('structure','', 'required');
	

	$jsmodule = array(
            'name'     => 'qtype_easyostructure',
            'fullpath' => '/question/type/easyostructure/easyostructure_script.js',
            'requires' => array(),
            'strings' => array(
                array('enablejava', 'qtype_easyostructure')
            )
        );





	$PAGE->requires->js_init_call('M.qtype_easyostructure.insert_structure_into_applet',
                                      array(),		
                                      true,
                                      $jsmodule);

	$scriptattrs = 'onClick = "getSmilesEdit(this.name, \'mrv\')"';
	$mform->addElement('button','insert',get_string('insertfromeditor', 'qtype_easyostructure'),$scriptattrs);




	$scriptattrs = 'onClick = "clean3D(this.name)"';

//	$mform->addElement('html', html_writer::start_tag('div', array('style'=>'float: left;font-style: italic ;')));

	$mform->addElement('button','clean3d','Clean 3D',$scriptattrs);


	$scriptattrs = 'onClick = "clean2D(this.name)"';
	$mform->addElement('button','clean2d','Clean 2D',$scriptattrs);
//	$mform->addElement('html', html_writer::end_tag('div'));




//        $mform->addElement('static', 'answersinstruct',
//                get_string('correctanswers', 'qtype_easyostructure'),
//                get_string('filloutoneanswer', 'qtype_easyostructure'));
//        $mform->closeHeaderBefore('answersinstruct');
		
//		$appleturl = new moodle_url('/question/type/easyostructure/easyostructure/easyostructure.jar');


		//get the html in the easyostructurelib.php to build the applet
//	    $easyostructurebuildstring = "\n<applet code=\"easyostructure.class\" name=\"easyostructure\" id=\"easyostructure\" archive =\"$appleturl\" width=\"460\" height=\"335\">" .
//	  "\n<param name=\"options\" value=\"" . $CFG->qtype_easyostructure_options . "\" />" .
//      "\n" . get_string('javaneeded', 'qtype_easyostructure', '<a href="http://www.java.com">Java.com</a>') .
//	  "\n</applet>";




        $this->add_per_answer_fields($mform, get_string('answerno', 'qtype_easyostructure', '{no}'), question_bank::fraction_options());

        $this->add_interactive_settings();
    }
	
	protected function get_per_answer_fields($mform, $label, $gradeoptions,
            &$repeatedoptions, &$answersoption) {
		
        $repeated = parent::get_per_answer_fields($mform, $label, $gradeoptions,
                $repeatedoptions, $answersoption);
		
		//construct the insert button
//crl mrv		$scriptattrs = 'onClick = "getSmilesEdit(this.name, \'cxsmiles:u\')"';
//		$scriptattrs = 'onClick = "getSmilesEdit(this.name, \'mrv\')"';


//disabled by crl to move button out of answers and into question info
//        $insert_button = $mform->createElement('button','insert',get_string('insertfromeditor', 'qtype_easyostructure'),$scriptattrs);
//        array_splice($repeated, 2, 0, array($insert_button));

        return $repeated;
    }

    protected function data_preprocessing($question) {
        $question = parent::data_preprocessing($question);
        return $question;
    }

    public function qtype() {
        return 'easyostructure';
    }
}
