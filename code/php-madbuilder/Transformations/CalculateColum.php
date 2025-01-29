<?php

/*
    Code generated with MadBuilder
    Transformed column in percent bar.
    Problem: {value} is fracitonal and colors limit are fixed in 100, 75, 50
    Can't be changed on actual code block
    */
$column_calculated_1->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
{
    $bar = new TProgressBar;
    $bar->setMask("<b>{value}</b>%");
    $bar->setValue($value);

    if ($value == 100) {
        $bar->setClass("success");
    }
    else if ($value >= 75) {
        $bar->setClass("info");
    }
    else if ($value >= 50) {
        $bar->setClass("warning");
    }
    else {
        $bar->setClass("danger");
    }
    return $bar;
}); 

/*
    Applying overrided code in <onBeforeColumnsCreation> event.
    Force 2 decimals in percent value
    New colors limits: 100, 90, 80
    */   

//<onBeforeColumnsCreation>
$column_calculated_1->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
{
    $bar = new TProgressBar;
    $new_value = number_format($value, 2);  // 2 decimals
    $bar->setMask("<b>{$new_value}</b>%");
    $bar->setValue( $value );

    if ($value >= 100) {
        $bar->setClass("success");
        }
        else if ($value >= 90) {
            $bar->setClass("info");
        }
        else if ($value >= 80) {
            $bar->setClass("warning");
        }
        else {
            $bar->setClass("danger");
        }
        return $bar;
    }); 

