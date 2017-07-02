<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

class ohrmWidgetDatePickerNew extends sfWidgetFormInput {

    public function render($name, $value = null, $attributes = array(), $errors = array()) {

        if (array_key_exists('class', $attributes)) {
            $attributes['class'] .= ' ohrm_datepicker';
        } else {
            $attributes['class'] = 'ohrm_datepicker';
        }

        $html = parent::render($name, $value, $attributes, $errors);
        $html .= $this->renderTag('input', array(
                    'type' => 'button',
                    'id' => "{$this->attributes['id']}_Button",
                    'class' => 'calendarBtn',
                    'style' => 'float: none; display: inline; margin-left: 6px;',
                    'value' => '',
                ));

        $javaScript = sprintf(<<<EOF
 <script type="text/javascript">

    var datepickerDateFormat = '%s';
    var displayDateFormat = datepickerDateFormat.replace('yy', 'yyyy');

    $(document).ready(function(){

        var rDate = $.trim($("#%s").val());
            if (rDate == '') {
                $("#%s").val(displayDateFormat);
            }

        //Bind date picker
        daymarker.bindElement("#%s",
        {
            onSelect: function(date){

            },
            dateFormat : datepickerDateFormat,
            onClose: function(){
                $(this).valid();
            }
        });

        $('#%s_Button').click(function(){
            daymarker.show("#%s");

        });
    });
</script>
EOF
                        ,
                        get_datepicker_date_format(sfContext::getInstance()->getUser()->getDateFormat()),
                        $this->attributes['id'],
                        $this->attributes['id'],
                        $this->attributes['id'],
                        $this->attributes['id'],
                        $this->attributes['id']
        );

        return $html . $javaScript;
    }

}

