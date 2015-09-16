<?php

/**
*  Main script loading the Heurist application
*
*  1) System init on server side (see System.php) - connects to database , if db parameter is missing redirects to database selection page
*  2) System init on client side (see hapi.js) - init hAPI object
*  3) Load localization, theme and basic database structure definition
*
* @package     Heurist academic knowledge management system
* @link        http://HeuristNetwork.org
* @copyright   (C) 2005-2015 University of Sydney
* @author      Artem Osmakov   <artem.osmakov@sydney.edu.au>
* @license     http://www.gnu.org/licenses/gpl-3.0.txt GNU License 3.0
* @version     4.0
*/

/*
* Licensed under the GNU License, Version 3.0 (the "License"); you may not use this file except in compliance
* with the License. You may obtain a copy of the License at http://www.gnu.org/licenses/gpl-3.0.txt
* Unless required by applicable law or agreed to in writing, software distributed under the License is
* distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied
* See the License for the specific language governing permissions and limitations under the License.
*/


require_once(dirname(__FILE__)."/php/System.php");

// either init system or redirect to database selection
$system = new System();
if(@$_REQUEST['db']){
    // connrect to given database
    if(! $system->init(@$_REQUEST['db']) ){
        //cannot connect to given database
        $err = $system->getError();
        $msg = @$err['message'];
        header('Location: php/databases.php?msg='.rawurlencode($msg));
        //echo "FATAL ERROR!!!! ".print_r($arr, $system->getError());
        exit();
    }
}else{
    //db parameter is missing, redirects to database selection page
    header('Location: php/databases.php');
    exit();
}

?>
<html>
    <head>
        <title><?=(@$_REQUEST['db']?$_REQUEST['db']:'').'. '.HEURIST_TITLE ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <link rel=icon href="favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

        <link rel="stylesheet" type="text/css" href="ext/fancytree/skin-themeroller/ui.fancytree.css" />

        <!-- Provides wide variety of icons as font, used eg. for facet search icon. Vsn 2 -->
        <link rel="stylesheet" type="text/css" href="ext/font-awesome/css/font-awesome.min.css" />
        <!-- Later version of font-awesome, but have not got it to work -->
        <!-- <link rel="stylesheet" type="text/css" href="http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" /> -->

        <script type="text/javascript" src="ext/jquery-ui-1.10.2/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="ext/jquery-ui-1.10.2/ui/jquery-ui.js"></script>

        <script type="text/javascript" src="ext/layout/jquery.layout-latest.js"></script>


        <!-- Gridster layout is an alternative similar to Windows tiles, not useful except with small
             number of widgets. Currently it is commented out of the code in layout_default.js -->

        <!-- for gridster layout, development version - remove comments to use
        <link rel="stylesheet" type="text/css" href="ext/gridster/jquery.gridster.css" />
        <script type="text/javascript" src="ext/gridster/utils.js"></script>
        <script type="text/javascript" src="ext/gridster/jquery.collision.js"></script>
        <script type="text/javascript" src="ext/gridster/jquery.coords.js"></script>
        <script type="text/javascript" src="ext/gridster/jquery.draggable.js"></script>
        <script type="text/javascript" src="ext/gridster/jquery.gridster.js"></script>
        -->
        <!-- for gridster layout, production (minimised) version - remove comments to use
        <link rel="stylesheet" type="text/css" href="ext/gridster/jquery.gridster.all.css" />
        <script type="text/javascript" src="ext/gridster/jquery.gridster.all.js"></script>
        -->

        <!-- DOCUMENTATION TODO: What's this for? -->
        <!-- jquery-contextmenu (https://github.com/mar10/jquery-ui-contextmenu/)
        src="//cdn.jsdelivr.net/jquery.ui-contextmenu/1/jquery.ui-contextmenu.min.js"
        -->

        <script type="text/javascript" src="ext/js/jquery.ui-contextmenu.min.js"></script>
        <!-- script type="text/javascript" src="ext/js/moment.min.js"></script -->
        <script type="text/javascript" src="ext/js/date.format.js"></script>

        <script type="text/javascript" src="localization.js"></script>
        <script type="text/javascript" src="js/utils.js"></script>
        <!-- script type="text/javascript" src="js/utils_ajax.js"></script -->
        <script type="text/javascript" src="js/recordset.js"></script>
        <script type="text/javascript" src="js/hapi.js"></script>
        <script type="text/javascript" src="js/layout.js"></script>
        <!-- script type="text/javascript" src="js/hintDiv.js"></script -->

        <script type="text/javascript" src="apps/topmenu/help_tips.js"></script>

        <script type="text/javascript" src="migrated/common/js/temporalObjectLibrary.js"></script>

        <!-- DOCUMENTATION TODO: explain this -->
        <!-- these scripts are loaded explicitely - for debug purposes -->
        <script type="text/javascript" src="apps/file_manager.js"></script>
        <script type="text/javascript" src="apps/viewers/recordListExt.js"></script>
        <script type="text/javascript" src="apps/svs_manager.js"></script>
        <script type="text/javascript" src="apps/search/search_faceted.js"></script>
        <script type="text/javascript" src="apps/search/search_faceted_wiz.js"></script>
        <script type="text/javascript" src="apps/viewers/app_timemap.js"></script>
        <script type="text/javascript" src="apps/search/search.js"></script>
        <script type="text/javascript" src="apps/topmenu/mainMenu.js"></script>
        <script type="text/javascript" src="apps/search/svs_edit.js"></script>
        <script type="text/javascript" src="apps/search/svs_list.js"></script>
        <script type="text/javascript" src="apps/viewers/resultList.js"></script>

        <script type="text/javascript" src="apps/digital_harlem/dh_search.js"></script>
        <script type="text/javascript" src="apps/digital_harlem/dh_maps.js"></script>


        <!-- DOCUMENTATION TODO: What are these, why are they commented out -->
        <!--
        <script type="text/javascript" src="apps/profile/profile.js"></script>
        <script type="text/javascript" src="apps/viewers/connections.js"></script>
        <script type="text/javascript" src="apps/viewers/recordDetails.js"></script>
        <script type="text/javascript" src="apps/topmenu/mainMenu.js"></script>
        script type="text/javascript" src="apps/search.js"></script>
        <script type="text/javascript" src="apps/rec_list.js"></script>
        <script type="text/javascript" src="apps/profile_edit.js"></script>
        <script type="text/javascript" src="apps/pagination.js"></script>
        <script type="text/javascript" src="apps/rec_list.js"></script>
        -->
        <!-- DEBUG -->

        <script type="text/javascript" src="apps/profile/profile_login.js"></script>
        <script type="text/javascript" src="apps/viewers/resultListMenu.js"></script>
        <script type="text/javascript" src="apps/rec_actions.js"></script>
        <script type="text/javascript" src="apps/rec_search.js"></script>
        <script type="text/javascript" src="apps/rec_relation.js"></script>
        <script type="text/javascript" src="js/editing_input.js"></script>
        <script type="text/javascript" src="js/editing.js"></script>

        <!-- move to profile.js dynamic load -->
        <script type="text/javascript" src="ext/js/themeswitchertool.js"></script>
        <script type="text/javascript" src="ext/yoxview/yoxview-init.js"></script>

        <!-- to do -->
        <script type="text/javascript" src="layout_default.js"></script>

        <script type="text/javascript">

            $(function() {

                //overwrite the standard show method
                var orgShow = $.fn.show;
                $.fn.show = function()
                {
                    orgShow.apply( this, arguments );
                    $(this).trigger( 'myOnShowEvent' );
                    return this;
                };

                //Performs hAPI initialization for given database
                window.HAPI4 = new hAPI('<?=$_REQUEST['db']?>',
                    function(success) //callback function of hAPI initialization
                    {
                        if(success)  //system is inited
                        {
                            var prefs = window.HAPI4.get_prefs();

                            //loads localization
                            window.HR = window.HAPI4.setLocale(prefs['layout_language']);

                            //loads theme (style for layout) - as we are using H3 functions always use default theme
                            if(prefs['layout_theme'] && !(prefs['layout_theme']=="heurist" || prefs['layout_theme']=="base")){
                                cssLink = $('<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/'+
                                    prefs['layout_theme']+'/jquery-ui.css" />');
                            }else{
                                //default BASE theme
                                cssLink = $('<link rel="stylesheet" type="text/css" href="ext/jquery-ui-1.10.2/themes/'+prefs['layout_theme']+'/jquery-ui.css" />');
                            }

                            //add theme link to html header
                            $("head").append(cssLink);
                            $("head").append($('<link rel="stylesheet" type="text/css" href="style3.css?t='+(new Date().getTime())+'">'));

                            //top.HAPI4.database+'. HEURIST_TITLE
                            window.document.title = window.document.title+' V'+top.HAPI4.sysinfo.version;

                            // OLD H3 stuff
                            window.HEURIST.baseURL  = window.HAPI4.basePathOld;
                            window.HEURIST.basePath = window.HAPI4.basePathOld;
                            window.HEURIST.loadScript(window.HAPI4.basePathOld+"common/php/loadUserInfo.php?db=" + window.HAPI4.database);
                            window.HEURIST.iconBaseURL = window.HAPI4.iconBaseURL;
                            window.HEURIST.database = {  name: window.HAPI4.database };


                            //load database structure (record types, field types, terms) definitions
                            window.HAPI4.SystemMgr.get_defs({rectypes:'all', terms:'all', detailtypes:'all', mode:2}, function(response){
                                if(response.status == top.HAPI4.ResponseStatus.OK){
                                    top.HEURIST4.rectypes = response.data.rectypes;
                                    top.HEURIST4.terms = response.data.terms;
                                    top.HEURIST4.detailtypes = response.data.detailtypes;

                                    //in layout.js - load layout #101

                                    var layoutid = '<?=@$_REQUEST['ll']?>';
                                    if(top.HEURIST4.util.isempty(layoutid)){
                                        layoutid = top.HAPI4.get_prefs('layout_id');
                                        if(top.HEURIST4.util.isempty(layoutid)){
                                            layoutid = "H4Default";
                                        }
                                    }
                                    top.HAPI4.sysinfo['layout'] = layoutid; //keep current layout

                                    if(layoutid=='DigitalHarlem'){ //digital harlem - @todo move style to layout
                                        $("head").append($('<link rel="stylesheet" type="text/css" href="apps/digital_harlem/dh_style.css?t='+(new Date().getTime())+'">'));
                                    }

                                    appInitAll(layoutid, "#layout_panes");

                                    //perform search in the case that parameter "q" is defined
                                    var qsearch = '<?=@$_REQUEST['q']?>';
                                    if(!top.HEURIST4.util.isempty(qsearch)){
                                        var qdomain = '<?=@$_REQUEST['w']?>';
                                        if(top.HEURIST4.util.isempty(qdomain)) qdomain = 'a';
                                        var request = {q: qsearch, w: qdomain, f: 'map', source:'init' };
                                        //top.HEURIST4.query_request = request;
                                        setTimeout(function(){top.HAPI4.RecordMgr.search(request, $(document));}, 3000);
                                    }else if(layoutid!='DigitalHarlem'){
                                        var init_search = top.HEURIST.displayPreferences['defaultSearch'];
                                        if(!top.HEURIST4.util.isempty(init_search)){
                                            var request = {q: init_search, w: 'a', f: 'map', source:'init' };
                                            setTimeout(function(){top.HAPI4.RecordMgr.search(request, $(document));}, 3000);
                                        }
                                    }

                                    if(!(top.HAPI4.sysinfo.db_total_records>0)){
                                        showTipOfTheDay(false);
                                    }

                                    $(document).trigger(top.HAPI4.Event.ON_SYSTEM_INITED, []);

                                }else{  // failed to load database structure

                                    top.HEURIST4.util.redirectToError(response.message);
                                }
                            });



                        }else{  // Failed to initialise system

                            //top.HEURIST4.util.redirectToError
                            alert("Cannot initialize system, please consult Heurist developers");
                        }
                });

                //definition of ABOUT dialog, called from Help > About, see content below
                $( "#heurist-about" ).dialog(
                    {
                        autoOpen: false,
                        height: 400,
                        width: 450,
                        modal: true,
                        resizable: false,
                        draggable: false,
                        hide: {
                            effect: "puff",
                            duration: 500
                        }
                    }
                );



            });

        </script>

    </head>
    <body style="background-color:#c9c9c9">


        <!-- These are old H3 stuff - needed to support existing features in popups -->
        <script>top.installDirFromH4="<?=HEURIST_BASE_URL_OLD?>";</script>
        <script src="<?=HEURIST_BASE_URL_OLD?>common/js/utilsLoad.js"></script>
        <script src="<?=HEURIST_BASE_URL_OLD?>common/php/displayPreferences.php"></script>

        <!-- TODO: H4 currently not using Magic Numbers, but should be using them -->
        <!-- <script src="../../common/php/getMagicNumbers.php"></script> -->

        <div id="layout_panes" style="height:100%">
            &nbsp;
        </div>

        <div id="heurist-about" title="About" style="width:300px">
            <div class='logo'></div>
            <h4>Heurist Academic Knowledge Management System</h4>
            <p style="margin-top: 1em;">version <?=HEURIST_VERSION?></p>
            <p style="margin-top: 1em;">
                author: Dr Ian Johnson<br/>
                programmers: Artem Osmakov, Tom Murtagh, Kim Jackson, Stephen White and others...</p>

            <p style="margin-top: 1em;">Copyright (C) 2005-2015 <a href="http://sydney.edu.au/arts/" target="_blank">University of Sydney</a></p>

            <p style="font-size: x-small;margin-top: 1em;">
                Licensed under the GNU General Public License Version 3.0 (the "License"); you may not use this file except
                in compliance with the License. You may obtain a copy of the License at
                <a href="http://www.gnu.org/licenses/gpl-3.0.txt" target="_blank">http://www.gnu.org/licenses/gpl-3.0.txt</a></p>

            <p style="font-size: x-small;margin-top: 1em;">
                Unless required by applicable law or agreed to in writing, software distributed under the License
                is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express
                or implied. See the License for the specific language governing permissions and limitations under
                the License.
            </p>
        </div>

        <div id="heurist-dialog">
        </div>
    </body>
</html>
