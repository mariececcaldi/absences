<?php
 /*******************
 *     DATES       *
 *******************/
isset($_GET['year'])    ? $year = $_GET['year']     : $year = date("Y",time())  ;
isset($_GET['month'])   ? $month = $_GET['month']   : $month = date("m",time()) ;

$days_in_month = date('t',strtotime($year.'-'.$month.'-01'));

/*****************************************************
 * EMPLOYES DONT L'EMPLOYE CONNECTE EST RESPONSABLE  *
*****************************************************/
$employes_a_valider = Openpap_Employe::getEmployesAValider($employes_id) ;
$employes_a_valider_absences = Openpap_Absence::getTeamLeaveInfos($employes_a_valider,$min_date_compteur, $max_date_compteur, $annee_compteur, $rtt_a_prendre) ;


//On inclut la vue
include(dirname(__FILE__).'/../vues/responsable_equipe.phtml');
