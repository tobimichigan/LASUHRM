<?php

/** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

class ohrmWidgetDatePicker extends sfWidgetFormInput {
    
    public function getJavaScripts() {
        
        $javaScripts = parent::getJavaScripts();
        $javaScripts[] = 'orangehrm.datepicker.js';

        return $javaScripts;
        
    }
    
    public function getStylesheets() {
        $css = parent::getStylesheets();
        $css[theme_path('css/orangehrm.datepicker.css')] = 'all';
        
        return $css;
    }

    public function render($name, $value = null, $attributes = array(), $errors = array()) {

        if (array_key_exists('class', $attributes)) {
            $attributes['class'] .= ' calendar';
        } else {
            $attributes['class'] = 'calendar';
        }
        
        if (!isset($attributes['id']) && isset($this->attributes['id'])) {
            $attributes['id'] = $this->attributes['id'];
        }

        $html = parent::render($name, $value, $attributes, $errors);

        $javaScript = sprintf(<<<EOF
 <script type="text/javascript">

    var datepickerDateFormat = '%s';
    var displayDateFormat = datepickerDateFormat.replace('yy', 'yyyy');

    $(document).ready(function(){
        
        var dateFieldValue = $.trim($("#%s").val());
        if (dateFieldValue == '') {
            $("#%s").val(displayDateFormat);
        }

        daymarker.bindElement("#%s",
        {
            showOn: "both",
            dateFormat: datepickerDateFormat,
            buttonImage: "%s",
            buttonText:"",
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+100",
            firstDay: 1,
            onClose: function() {
                $("#%s").trigger('blur');
            }            
        });
        
        //$("img.ui-datepicker-trigger").addClass("editable");
        
        $("#%s").click(function(){
            daymarker.show("#%s");
            if ($(this).val() == displayDateFormat) {
                $(this).val('');
            }
        });
    
    });

</script>
EOF
                        ,
                        get_datepicker_date_format(sfContext::getInstance()->getUser()->getDateFormat()),
                        $this->attributes['id'],
                        $this->attributes['id'],
                        $this->attributes['id'],
                        theme_path('images/calendar.png'),
                        $this->attributes['id'],
                        $this->attributes['id'],
                        $this->attributes['id']
        );

        return $html . $javaScript;
    }
    
}

