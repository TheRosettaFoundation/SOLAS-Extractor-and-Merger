<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Validator
 *
 * @author philip
 */
class Validator {
    public function validator($file)
    {
//        <java fork="true" classname="net.sf.saxon.Transform">
//            <classpath refid="saxon9.classpath"/>
//            <arg value="-o:temp/intermediate.xsl"/>
//            <arg value="tools/datacategories-definition.xml"/>            
//            <arg value="tools/datacategories-2-xsl.xsl"/>
//            <arg value="inputDatacats=${datacategories}"/>            
//            <arg value="inputDocUri=temp/inputfile.xml"/>
//        </java>
        
        echo "Hello World";
        shell_exec("pwd");
        
        return true;
    }
    
    public function message()
    {
        return $thing;
    }
    //put your code here
}

?>
