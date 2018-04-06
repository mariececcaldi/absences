<?php
/*
http://www-openpap-dev.web.groupe-pap.fr/modules/absences/ajax/perso_conges.ajax.php?date_depart=2017-07-17&heure_depart=matin&date_retour=2017-07-18&heure_retour=matin&type=rtt&nombre_jours=1&nombre_samedi=&commentaire=&employes_id=685
*/

header('Cache-Control: no-cache');
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json; charset=utf-8');

// REQUIRE
require 'inc/db.inc.php' ;
require 'emails/openpap/absences/sendmail.php';
/***********************************/
/* Destinataires fixes de mails    */
/***********************************/
$mail_rh            = 's.baillet@pap.fr' ;
$mail_direction     = 'c.jolly@pap.fr,l.caron@pap.fr' ;


// INIT
$ca_a_marche        = 0;
$message            = '' ;

// RECUPERATION DES PARAMETRES
$absence = array(
    'employes_id'       => $_GET['employes_id'],
    'date_debut'        => $_GET['heure_depart'] == 'matin' ? $_GET['date_depart'] .' 09:00:00' : $_GET['date_depart'] .' 13:00:00' ,
    'date_fin'          => $_GET['heure_retour'] == 'matin' ? $_GET['date_retour'] .' 09:00:00' : $_GET['date_retour'] .' 13:00:00' ,
    'nombre_jours'      => in_array($_GET['type'], array('conges', 'rtt')) ? @$_GET['nombre_jours']  : null,
    'nombre_samedi'     => $_GET['type'] == 'conges'                       ? @$_GET['nombre_samedi'] : null,
    'type'              => $_GET['type'],
    'etat'              => $_GET['etat'],
    'valide_par'        => $_GET['valide_par'] ? Openpap_Employe::getById($_GET['valide_par']) : '',
    'commentaire'       => $_GET['type'] == 'conge_exceptionnel' ? $_GET['commentaire'] : null,
) ;

if ($_GET['type_demande'] == 'creation')
{
    $absence['date_creation'] = date("Y-m-d H:i:s");
}
elseif($_GET['type_demande'] == 'modification')
{
    $absence['id']                  = $_GET['absence_id'] ;
    $absence['date_modification']   = date("Y-m-d H:i:s") ;
}

// On empeche de poser conges ou RTT a cheval sur mai / juin (=> difficulte dans les compteurs)
if(in_array($absence['type'], array('conges', 'rtt')) && date('m-d H', strtotime($absence['date_fin'])) != '06-01 09' && date('m', strtotime($absence['date_debut'])) < 6 && date('m', strtotime($absence['date_fin'])) >= 6 )
{
    $ca_a_marche        = 0;
    $message = 'depot_mai_juin' ;
}
else
{
    // on verifie que la demande est conforme aux attentes de l'entreprise (si non, on envoie un mail aux rh)
    $warning_rh = Openpap_Absence::verification_conformite($absence) ;
    
    // Création
    if ($_GET['type_demande'] == 'creation')
    {
        try
        {
            Openpap_Absence::insert($absence) ;
            $message = 'insert OK' ;
            $ca_a_marche = 1;
        }
        catch(Exception $e)
        {
            $db->query("ROLLBACK") ;
            $message = 'insert NOK' ;
            $ca_a_marche = 0;
            throw $e ;
        }
    }
    elseif($_GET['type_demande'] == 'modification')
    {
        // Modification
        try
        {
            Openpap_Absence::update($absence) ;
            $message = 'insert OK' ;
            $ca_a_marche = 1;
        }
        catch(Exception $e)
        {
            $db->query("ROLLBACK") ;
            $message = 'insert NOK' ;
            $ca_a_marche = 0;
            throw $e ;
        }
    }

    //TODO: dans le cas de la modification verifier les AI

    $employe_absent = Openpap_Employe::getById($absence['employes_id']) ;
    if ($warning_rh == 1)
    {
        sendmail(array('type'=>'warning_rh', 'to'=> $mail_rh, 'qui'=>$employe_absent, 'absence'=>$absence)) ;
    }
    if(@$absence['valide_par'] != '')
    {
        sendmail(array('type'=>'info_auto_validation', 'to'=> $mail_direction, 'qui'=>$employe_absent, 'absence'=>$absence)); 
    }
    else
    {
        $mail_responsable = '';
        foreach($employe_absent['responsable'] as $resp_service)
        {
            $mail_responsable  .= $resp_service['email_perso_pap'].",";
        }
        sendmail(array('type'=>'absence_a_traiter', 'to'=> $mail_responsable, 'qui'=>$employe_absent, 'absence'=>$absence)); 
    }
}


// FORMATAGE DU JSON RETOURNE
$data[] = array(
    'statut'  => $ca_a_marche,
    'message' => $message
) ;
echo json_encode($data) ;
exit() ;

?>

