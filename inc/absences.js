$(document).ready(function(){






    // Modif absence (box dans un foreach)
// pour perso_modification_conges.box
//    $.each($('.modif_conges_open'), function() {
//        var id = $(this).attr('id') ;
//        var congesid = $(this).data('congesid') ;
//        $('#'+id).click(function(ev) {
//            $('#modif_conges'+congesid).appendTo("body").modal('show') ;
//
//            //$("#commentaire_conge_exceptionnel_modif"+congesid).hide() ;
//            $("#type_modif"+congesid).change(function(){
//                if ($("#type_modif"+congesid).val() == 'conge_exceptionnel')
//                {
//                    $("#commentaire_conge_exceptionnel_modif"+congesid).show() ;
//                }
//                else 
//                {
//                    $("#commentaire_conge_exceptionnel_modif"+congesid).hide() ;
//                }
//                if ($("#type_modif"+congesid).val() == 'conges' || $("#type_modif"+congesid).val() == 'rtt' )
//                {
//                    $("#nb_jours_modif"+congesid).show() ;
//                }
//                else 
//                {
//                    $("#nb_jours_modif"+congesid).hide() ;
//                }
//                if ($("#type_modif"+congesid).val() == 'conges' )
//                {
//                    $("#nb_samedis_modif"+congesid).show() ;
//                }
//                else 
//                {
//                    $("#nb_samedis_modif"+congesid).hide() ;
//                }
//            });
//            /* A rajouter pour que apres avoir cliqué sur un bouton on ait toujours le bon libellé de date qui s'affiche */
//            
//            if ($("#type_modif"+congesid).val() == 'conge_exceptionnel')
//            {
//                $("#commentaire_conge_exceptionnel_modif"+congesid).show() ;
//            }
//            else
//            {
//                $("#commentaire_conge_exceptionnel_modif"+congesid).hide() ;
//            }
//            if ($("#type_modif"+congesid).val() == 'conges' || $("#type_modif"+congesid).val() == 'rtt' )
//            {
//                $("#nb_jours_modif"+congesid).show() ;
//            }
//            else 
//            {
//                $("#nb_jours_modif"+congesid).hide() ;
//            }
//            if ($("#type_modif"+congesid).val() == 'conges' )
//            {
//                $("#nb_samedis_modif"+congesid).show() ;
//            }
//            else 
//            {
//                $("#nb_samedis_modif"+congesid).hide() ;
//            }
//
//
//
//            ev.preventDefault() ;
//        }) ;
//    }) ;

    // Suppr (box dans un foreach)
    $.each($('.suppr_conges_open'), function() {
        var id = $(this).attr('id') ;
        var congesid = $(this).data('congesid') ;
        $('#'+id).click(function(ev) {
            $('#suppr_conges'+congesid).appendTo("body").modal('show') ;
            ev.preventDefault() ;
        }) ;
    }) ;

    /* ---------- Datepickers ---------- */
    // Pour les avoir en francais
    ! function(a){"function"==typeof define&&define.amd?define(["jquery","moment"],a):a(jQuery,moment)}
    (function(a,b){(b.defineLocale||b.lang).call(b,"fr",{months:"janvier_f&eacute;vrier_mars_avril_mai_juin_juillet_ao&ucirc;t_septembre_octobre_novembre_d&eacute;cembre".split("_"),monthsShort:"janv._f&eacute;vr._mars_avr._mai_juin_juil._ao&ucirc;t_sept._oct._nov._d&eacute;c.".split("_"),weekdays:"dimanche_lundi_mardi_mercredi_jeudi_vendredi_samedi".split("_"),weekdaysShort:"dim._lun._mar._mer._jeu._ven._sam.".split("_"),weekdaysMin:"Di_Lu_Ma_Me_Je_Ve_Sa".split("_"),longDateFormat:{LT:"HH:mm",LTS:"LT:ss",L:"DD/MM/YYYY",LL:"D MMMM YYYY",LLL:"D MMMM YYYY LT",LLLL:"dddd D MMMM YYYY LT"},calendar:{sameDay:"[Aujourd'hui à] LT",nextDay:"[Demain à] LT",nextWeek:"dddd [à] LT",lastDay:"[Hier à] LT",lastWeek:"dddd [dernier à] LT",sameElse:"L"},relativeTime:{future:"dans %s",past:"il y a %s",s:"quelques secondes",m:"une minute",mm:"%d minutes",h:"une heure",hh:"%d heures",d:"un jour",dd:"%d jours",M:"un mois",MM:"%d mois",y:"un an",yy:"%d ans"},ordinalParse:/\d{1,2}(er|)/,ordinal:function(a){return a+(1===a?"er":"")},week:{dow:1,doy:4}}),a.fullCalendar.datepickerLang("fr","fr",{closeText:"Fermer",prevText:"Pr&eacute;c&eacute;dent",nextText:"Suivant",currentText:"Aujourd'hui",monthNames:["janvier","f&eacute;vrier","mars","avril","mai","juin","juillet","ao&ucirc;t","septembre","octobre","novembre","d&eacute;cembre"],monthNamesShort:["janv.","f&eacute;vr.","mars","avr.","mai","juin","juil.","ao&ucirc;t","sept.","oct.","nov.","d&eacute;c."],dayNames:["dimanche","lundi","mardi","mercredi","jeudi","vendredi","samedi"],dayNamesShort:["dim.","lun.","mar.","mer.","jeu.","ven.","sam."],dayNamesMin:["D","L","M","M","J","V","S"],weekHeader:"Sem.",dateFormat:"dd/mm/yy",firstDay:1,isRTL:!1,showMonthAfterYear:!1,yearSuffix:""}),a.fullCalendar.lang("fr",{buttonText:{month:"Mois",week:"Semaine",day:"Jour",list:"Mon planning"},allDayHtml:"Toute la journ&eacute;e",eventLimitText:"en plus"})});



    $('#datepicker_retour').datepicker({
        dateFormat: "yy-mm-dd" 
    });

    $("#datepicker_depart").datepicker({
        dateFormat: "yy-mm-dd", 
        onSelect: function(date){            
            var newDate = $('#datepicker_depart').datepicker('getDate');           
            $('#datepicker_retour').datepicker("option","minDate",newDate);            
        }
    });

    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
    });

// pour perso_demainde_conges.box
    $("#type_add").change(function(){
        
        if ($("#type_add").val() == 'conge_exceptionnel')
        {
            $("#commentaire_conge_exceptionnel_add").show() ;
        }
        else 
        {
            $("#commentaire_conge_exceptionnel_add").hide() ;
        }
        if ($("#type_add").val() == 'conges' || $("#type_add").val() == 'rtt' )
        {
            $("#nb_jours_add").show() ;
        }
        else 
        {
            $("#nb_jours_add").hide() ;
        }
        if ($("#type_add").val() == 'conges' )
        {
            $("#nb_samedis_add").show() ;
            $("#infos_legales").show() ;
        }
        else 
        {
            $("#nb_samedis_add").hide() ;
            $("#infos_legales").hide() ;
        }
    });
    /* A rajouter pour garder à la reouverture de la popin */
    if ($("#type_add").val() == 'conge_exceptionnel')
    {
        $("#commentaire_conge_exceptionnel_add").show() ;
    }
    else
    {
        $("#commentaire_conge_exceptionnel_add").hide() ;
    }
    if ($("#type_add").val() == 'conges' || $("#type_add").val() == 'rtt' )
    {
        $("#nb_jours_add").show() ;
    }
    else 
    {
        $("#nb_jours_add").hide() ;
    }
    if ($("#type_add").val() == 'conges' )
    {
        $("#nb_samedis_add").show() ;
        $("#infos_legales").show() ;
    }
    else 
    {
        $("#nb_samedis_add").hide() ;
        $("#infos_legales").hide() ;
    }




    $('.div_perso_conges_open').click(function(e) {
        e.preventDefault();
        $('#div_perso_conges').appendTo("body").modal('show');
        $('h4').html('<b>FAIRE UNE DEMANDE D\'ABSENCE</b>');
        $('#type_demande').val('creation');
    }) ;

    $('.modif_conges_open').click(function(e) {
        e.preventDefault();
        $('#div_perso_conges').appendTo("body").modal('show');
        $('h4').html('<b>MODIFIER UNE ABSENCE</b>');
        var absenceid = $(this).data('absenceid') ;
        $('#type_demande').val('modification');
        $('#absence_id').val(absenceid);
    }) ;

// validation demande de conges
        $('#perso_conges').submit(function(event)
        {
            //var emails = '&mail_rh='+<?php echo $mail_rh ?>+'&mail_direction='+<?php echo $mail_direction ?>+'&mail_responsable='+<?php echo $mail_responsable ?>;
            //console.log($( "#perso_conges" ).serialize()+emails) ;
            $.ajax({
                //url: 'ajax/perso_conges.ajax.php',
                url: '/modules/absences/',
                dataType: 'json',
                data: $('#perso_conges' ).serialize(),
                success: function(data)
                {
                    if (data[0].statut == 1)
                    {
                        console.log('succes');

                        $('#message_noty_success').click();
                        $('#div_perso_conges').modal('hide');
      //$('#loaderImg').show();    /*showing  a div with spinning image */
                        location.reload();

       //$('#loaderImg').hide();
                    }
                    if (data[0].statut == 0)
                    {
                        console.log('erreur1');
                        $('#message_noty_fail').click();
                        event.preventDefault();
                    }

                },
                error: function( xhr, status )
                {
                    console.log('erreur2');
                    $('#CompanyProfile').modal('hide');
                    $('#message_noty_fail').click();
                },
            }) ;
            //$('#div_perso_conges').modal('hide');

            event.preventDefault() ;
            //location.reload();
            return false ;
        }) ;





}) ;

