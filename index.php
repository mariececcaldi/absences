<?php
$html_title = "Absences" ;
$html_h1    = "Absences" ;
$html_js    = array(
    HUB . '/vendor/genius_v_1_0_4_html/assets/js/dataTables.bootstrap.min.js',
    HUB . '/vendor/genius_v_1_0_4_html/assets/js/uncompressed/jquery.dataTables.js',
    HUB . '/vendor/genius_v_1_0_4_html/assets/js/pages/charts-flot.js',

    HUB . '/vendor/genius_v_1_0_4_html/assets/js/jquery.easy-pie-chart.min.js',
    HUB . '/vendor/genius_v_1_0_4_html/assets/js/jquery.flot.min.js',
    HUB . '/vendor/genius_v_1_0_4_html/assets/js/jquery.flot.pie.min.js',
    HUB . '/vendor/genius_v_1_0_4_html/assets/js/jquery.noty.min.js',

    HUB . '/vendor/genius_v_1_0_4_html/assets/js/jquery.chosen.min.js',
    HUB . '/vendor/genius_v_1_0_4_html/assets/js/jquery.cleditor.min.js',
    '/modules/absences/inc/absences.js',
) ;
$html_css[]  = '/modules/absences/inc/style-absences.css' ;

/***********************/
/* Defintion du module */
/***********************/
$module = 'absences' ;

require 'inc_v2/login.inc.php' ;
require 'inc_v2/constantes.inc.php' ;

/***********************/
/* Employe connecte    */
/***********************/
$employes_id = $employe['id'] ;
$employe = Openpap_Employe::getById($employes_id) ;
//print_r($employe);

/*******************************/
/* Droit de l'employe connecte */
/*******************************/
$droits_conges          = 0 ; // RH
$droits_gestion_absence = 1 ; // valideur de conges
$droits_auto_validation = 0 ; // pas de valideur de conges

/*********************
 * dates compteurs *
 ********************/

$annee_compteur = strval(date("m")) >= 6 ? date("Y") : date('Y', strtotime('-1 year')) ;

$min_date_compteur = $annee_compteur. "-05-31";
$max_date_compteur = date('Y-m-d', strtotime('+1 year', strtotime($min_date_compteur)));
/*******************
 *     COULEURS       *
 *******************/
$colors=array(
'demande'                => '#efd6b8' ,
'valide'                 => '#44c466' ,
'saisi'                  => '#377bef' ,
'refuse'                 => '#c43e0d' ,
'abandonne'              => '#c8b3e0' ,
'conges'                 => '#47a9ff' ,
'rtt'                    => '#ff91de' ,
'maladie'                => '#7df28f' ,
'sans_solde'             => '#a50101' ,
'conge_parental'         => '#87dbca' ,
'conge_maternite'        => '#b62fef' ,
'conge_paternite'        => '#088719' ,
'recuperation'           => '#ff8a38' ,
'absence_injustifiee'    => '#825f47' ,
'formation'              => '#37507a' ,
'conge_exceptionnel'     => '#7c3844' ,
'ferie'                  => '#70625e' ,
'aujourdhui'             => '#f4df42' ,
'travail_a_distance'     => '#f77b7b' ,
);

/**************************
 *     TYPE ABSENCES       *
 **************************/
$type_absences_perso = array('conges', 'rtt', 'sans_solde', 'recuperation', 'formation', 'conge_exceptionnel','travail_a_distance');
$type_absences_responsable = array('absence_injustifiee', 'formation','travail_a_distance');
$type_absences_rh = array('absence_injustifiee','maladie', 'conge_parental', 'conge_maternite', 'conge_paternite');
/*******************
 *    RTT A PRENDRE       *
 *******************/
$rtt_a_prendre = Array("01" => 0, "02" => 3, "03" => 0, "04" => 2, "05" => 0, "06" => 3, "07" => 0, "08" => 3, "09" => 0, "10" => 3, "11" => 0, "12" => 3) ;

$objet          = @$_GET['objet'] ;
$action         = @$_GET['action'] ;
/***********************/
/* Pages a appeler      */
/***********************/
if($objet == 'absences_perso' && $action == 'demande' )
{
    include 'ajax/perso_conges.ajax.php' ;
}
if($objet == 'absences_perso' && $action == 'suppression' )
{
    include 'ajax/perso_conges_suppression.ajax.php' ;
}



include 'inc_v2/debut-layout.inc.php' ;

?>
<div id="loaderImg"><img src="/modules/absences/vues/loading.gif"></div>
<?php
include dirname(__FILE__).'/vues/menu_onglets.phtml' ;
//On inclut le contrôleur s'il existe et s'il est spécifié
if (!empty($_GET['page']) && is_file(dirname(__FILE__).'/controleurs/'.$_GET['page'].'.php'))
{
    include dirname(__FILE__).'/controleurs/'.$_GET['page'].'.php';
}
else
{
    include dirname(__FILE__).'/controleurs/perso.php' ;
}



 
//On inclut le pied de page
include 'inc_v2/fin-layout.inc.php' ;

