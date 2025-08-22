<?php 

 //<builder-transformer>
function($value, $object, $row)
{
    if($value=='A'){
        $class =  'success';
        $label =  "Ativo";
    }
    else if($value=='I'){
        $class = 'danger';
        $label = "Inativo";
    }
    else {
        $class = 'warning';
        $label = "Erro";
   }
 
    $div = new TElement('span');
    $div->class="label label-{$class}";
    $div->style="text-shadow:none; font-size:12px; font-weight:lighter";
    $div->add($label);
    return $div;
    
};
//</builder-transformer>
