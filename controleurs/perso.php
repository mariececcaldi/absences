<?php
 /*******************
 *     DATES       *
 *******************/
isset($_GET['year'])    ? $year = $_GET['year']     : $year = date("Y",time())  ;
isset($_GET['month'])   ? $month = $_GET['month']   : $month = date("m",time()) ;

$days_in_month = date('t',strtotime($year.'-'.$month.'-01'));

/********************************
 * AUTRES EMPLOYES DE L'EQUIPE  *
*********************************/
// TODO: completer un tableau de parametre pour la fonction getbyparams en fonction de qui est connecté
$params_select_employes_service = array(
    'crc'           => array('bases_id' => @$employe['bases_id'], 'service' => $employe['service'], 'pole' => $employe['pole']),
    'informatique'  => array('service' => $employe['service'])
) ;
// tous les employes du service
$employes_service = Openpap_Employe::getByParams($params_select_employes_service[$employe['service']], array('nom ASC')) ;
$employes_service_absences = Openpap_Absence::getTeamLeaveInfos($employes_service,$min_date_compteur, $max_date_compteur, $annee_compteur, $rtt_a_prendre) ;


/*****************************************************
 * RECAP DE MES ABSENCES DEPUIS LE DEBUT DE L ANNEE  *
******************************************************/
$mes_absences     = Openpap_Absence::getByParams(array("employes_id" => $employe['id'], "min_date" => $min_date_compteur), $order = array('a.date_debut DESC')) ;
$mes_absences_formatees = $employes_service_absences[$employe['equipe']][$employe['id']] ;


/***************************
 * SUPPRESSION D'ABSENCES  *
****************************/
//TODO: le faire en ajax ?
if (@$_POST['suppr_conges'] == 'Valider' && $_POST['employes_id'] == $employe['id'])
{
    Openpap_Absence::delete($_POST['id'], $_POST['employes_id']) ;
    redirect($_SERVER['REQUEST_URI']);

}


//On inclut les alertes
include(dirname(__FILE__).'/../vues/depot_conges_mai_juin.phtml');
//On inclut la vue
include(dirname(__FILE__).'/../vues/perso.phtml');
//On inclut les popins
include(dirname(__FILE__).'/../vues/perso_conges.box.phtml');


