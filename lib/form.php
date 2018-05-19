<?php
    function input($id){
        $value= isset($_POST[$id])? $_POST[$id]:'';
        return "<input type='text' class='form-control' id='$id' name='$id' value='$value'>";
    }
    function textarea($id){
        $value= isset($_POST[$id])? $_POST[$id]:'';
        return "<textarea type='text' class='form-control' id='$id' name='$id' >$value</textarea>";
    }
    function select($id,$options=array()){
        $return ="<select class='form-control' id='$id' name='$id''>";
        foreach ($options as $k=> $value)
        {
            $selected='';
            if($k==$_POST[$id] && isset($_POST[$id])){
                $selected= 'selected="selected"';
            }else{
                $return.="<option value='$id'>$value</option>";
            }
            $return .="<option value='$k' $selected >$value</option>";
        }
        $return .="</select>";
        return $return;
    }
    function selectAll($id,$options=array()){
        $return ="<select class='form-control' id='$id' name='$id''>";
        foreach ($options as $id=> $value)
        {
                $return.="<option value='$id'>$value</option>";
        }
        $return .="</select>";
        return $return;
    }