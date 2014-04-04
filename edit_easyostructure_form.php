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
 * @copyright  2014 onwards Carl LeBlond
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/question/type/shortanswer/edit_shortanswer_form.php');

class qtype_easyostructure_edit_form extends qtype_shortanswer_edit_form {

    protected function definition_inner($mform) {
        global $PAGE, $CFG;

        $PAGE->requires->js('/question/type/easyostructure/easyostructure_script.js');
        $PAGE->requires->css('/question/type/easyostructure/easyostructure_styles.css');
        $mform->addElement('hidden', 'usecase', 1);
        $mform->addElement('static', 'answersinstruct',
                get_string('correctanswers', 'qtype_easyostructure'),
                get_string('filloutoneanswer', 'qtype_easyostructure'));
        $menu = array(
                get_string('displaymodelinebond', 'qtype_easyostructure'),
                get_string('displaymodenormal', 'qtype_easyostructure'),
        get_string('displaymode3d', 'qtype_easyostructure'));

        $mform->addElement('select', 'displaymode',
                get_string('displaymodedescrip', 'qtype_easyostructure'), $menu);

        // Add applet to page!
        $jsmodule = array(
            'name'     => 'qtype_easyostructure',
            'fullpath' => '/question/type/easyostructure/easyostructure_script.js',
            'requires' => array(),
            'strings' => array(
                array('enablejava', 'qtype_easyostructure')
            )
        );

        $PAGE->requires->js_init_call('M.qtype_easyostructure.insert_applet',
                                      array($CFG->wwwroot),
                                      true,
                                      $jsmodule);

        $mform->addElement('html', html_writer::start_tag('div', array('style' => 'width:650px;', 'id' => 'appletdiv')));
        $mform->addElement('html', html_writer::start_tag('div', array('style' => 'float: right;font-style: italic ;')));
        $mform->addElement('html', html_writer::end_tag('div'));
        $mform->addElement('html', html_writer::end_tag('div'));
        $mform->addElement('html', html_writer::empty_tag('br'));

        // Insert structure into applet.
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

        $scriptattrs = 'class = id_insert';
        $mform->addElement('textarea', 'structure', get_string('insertfromeditordesc', 'qtype_easyostructure'));
        $mform->addRule('structure', '', 'required');
        $mform->addElement('button', 'insert', get_string('insertfromeditor', 'qtype_easyostructure'), $scriptattrs);

        $this->add_per_answer_fields($mform, get_string('answerno', 'qtype_easyostructure', '{no}'),
        question_bank::fraction_options());

        $this->add_interactive_settings();
    }

    protected function get_per_answer_fields($mform, $label, $gradeoptions,
            &$repeatedoptions, &$answersoption) {

            $repeated = parent::get_per_answer_fields($mform, $label, $gradeoptions,
                $repeatedoptions, $answersoption);
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
