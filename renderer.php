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
 * easyostructure question renderer class.
 *
 * @package    qtype
 * @subpackage easyostructure
 * @copyright  2014 onwards Carl LeBlond
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

class qtype_easyostructure_renderer extends qtype_renderer {
    public function formulation_and_controls(question_attempt $qa, question_display_options $options) {
        global $CFG, $PAGE;

        $question = $qa->get_question();
        $currentanswer = $qa->get_last_qt_var('answer');
        $inputname = $qa->get_qt_field_name('answer');
        $inputattributes = array(
            'type' => 'text',
            'name' => $inputname,
            'value' => $currentanswer,
            'id' => $inputname,
            'size' => 80,
        );

        $feedbackimg = '';

        if ($options->correctness) {
            $answer = $question->get_matching_answer(array('answer' => $currentanswer));
            if ($answer) {
                $fraction = $answer->fraction;
            } else {
                $fraction = 0;
            }
            $inputattributes['class'] = $this->feedback_class($fraction);
            $feedbackimg = $this->feedback_image($fraction);
        }

        $questiontext = $question->format_questiontext($qa);
        $placeholder = false;
        if (preg_match('/_____+/', $questiontext, $matches)) {
            $placeholder = $matches[0];
        }

        $toreplaceid = 'applet'.$qa->get_slot();
        $toreplace = html_writer::tag('span',
                                      get_string('enablejavaandjavascript', 'qtype_easyostructure'),
                                      array('id' => $toreplaceid));
        $input = html_writer::empty_tag('input', $inputattributes) . $feedbackimg;

        if ($placeholder) {
            $toreplace = html_writer::tag('span',
                                      get_string('enablejavaandjavascript', 'qtype_easyostructure'),
                                      array('class' => 'ablock'));
            $inputinplace = html_writer::tag('label', get_string('answer'),
                array('for' => $inputattributes['id'], 'class' => 'accesshide'));
            $inputinplace .= $input;
            $questiontext = substr_replace($questiontext, $inputinplace,
                strpos($questiontext, $placeholder), strlen($placeholder));
            $questiontext = substr_replace($questiontext,
                                            $toreplace,
                                            strpos($questiontext, $placeholder),
                                            strlen($placeholder));

        }

        $result = html_writer::tag('div', $questiontext, array('class' => 'qtext'));

        if (!$placeholder) {
            $result .= html_writer::tag('label', get_string('answer', 'qtype_easyostructure',
            html_writer::tag('span', $input, array('class' => 'answer'))), array('for' => $inputattributes['id']));
            $result .= html_writer::tag('div', $toreplace, array('class' => 'ablock'));
        }

        if ($qa->get_state() == question_state::$invalid) {
            $lastresponse = $this->get_last_response($qa);
            $result .= html_writer::nonempty_tag('div',
                                                $question->get_validation_error($lastresponse),
                                                array('class' => 'validationerror'));
        }

        $question = $qa->get_question();
        $answer = $question->get_matching_answer($question->get_correct_response());

        $structure = $question->structure;
        $strippedanswerid = "stripped_answer".$qa->get_slot();

        $result .= html_writer::tag('textarea', $structure,
            array('id' => $strippedanswerid, 'style' => 'display:none;', 'name' => $strippedanswerid));

        if ($options->readonly) {
            $currentanswer = $qa->get_last_qt_var('answer');
        }

        $result .= html_writer::tag('div',
                                    $this->hidden_fields($qa),
                                    array('class' => 'inputcontrol'));

        $this->require_js($toreplaceid, $qa, $options->readonly, $options->correctness, $CFG->qtype_easyostructure_options);

        return $result;
    }


    protected function require_js($toreplaceid, question_attempt $qa, $readonly, $correctness, $appletoptions) {
        global $PAGE;
        $jsmodule = array(
            'name'     => 'qtype_easyostructure',
            'fullpath' => '/question/type/easyostructure/module.js',
            'requires' => array(),
            'strings' => array(
                array('enablejava', 'qtype_easyostructure')
            )
        );
        $topnode = 'div.que.easyostructure#q'.$qa->get_slot();
        $appleturl = new moodle_url('appletlaunch.jar');
        if ($correctness) {
            $feedbackimage = $this->feedback_image($this->fraction_for_last_response($qa));
        } else {
            $feedbackimage = '';
        }
        $name = 'EASYOSTRUCT'.$qa->get_slot();
        $appletid = 'easyostructure'.$qa->get_slot();
        $question = $qa->get_question();
        $strippedanswerid = "stripped_answer".$qa->get_slot();
        $displaymode = $question->displaymode;
        $PAGE->requires->js_init_call('M.qtype_easyostructure.insert_easyostructure_applet',
                                      array($toreplaceid,
                                            $name,
                                            $appletid,
                                            $topnode,
                                            $appleturl->out(),
                                            $feedbackimage,
                                            $readonly,
                                            $appletoptions,
                                            $displaymode,
                                            $strippedanswerid),
                                        false,
                                        $jsmodule);
    }

    protected function fraction_for_last_response(question_attempt $qa) {
        $question = $qa->get_question();
        $lastresponse = $this->get_last_response($qa);
        $answer = $question->get_matching_answer($lastresponse);
        if ($answer) {
            $fraction = $answer->fraction;
        } else {
            $fraction = 0;
        }
        return $fraction;
    }


    protected function get_last_response(question_attempt $qa) {
        $question = $qa->get_question();
        $responsefields = array_keys($question->get_expected_data());
        $response = array();
        foreach ($responsefields as $responsefield) {
            $response[$responsefield] = $qa->get_last_qt_var($responsefield);
        }
        return $response;
    }

    public function specific_feedback(question_attempt $qa) {
        $question = $qa->get_question();

        $answer = $question->get_matching_answer($this->get_last_response($qa));
        if (!$answer) {
            return '';
        }

        $feedback = '';
        if ($answer->feedback) {
            $feedback .= $question->format_text($answer->feedback, $answer->feedbackformat,
                    $qa, 'question', 'answerfeedback', $answer->id);
        }
        return $feedback;
    }

    public function correct_response(question_attempt $qa) {
        $question = $qa->get_question();

        $answer = $question->get_matching_answer($question->get_correct_response());
        if (!$answer) {
            return '';
        }

        return get_string('correctansweris', 'qtype_easyostructure', s($answer->answer));
    }

    protected function hidden_fields(question_attempt $qa) {
        $question = $qa->get_question();

        $hiddenfieldshtml = '';
        $inputids = new stdClass();
        $responsefields = array_keys($question->get_expected_data());
        foreach ($responsefields as $responsefield) {
            $hiddenfieldshtml .= $this->hidden_field_for_qt_var($qa, $responsefield);
        }
        return $hiddenfieldshtml;
    }
    protected function hidden_field_for_qt_var(question_attempt $qa, $varname) {
        $value = $qa->get_last_qt_var($varname, '');
        $fieldname = $qa->get_qt_field_name($varname);
        $attributes = array('type' => 'hidden',
                            'id' => str_replace(':', '_', $fieldname),
                            'class' => $varname,
                            'value' => $value);
        return html_writer::empty_tag('input', $attributes);
    }
}
