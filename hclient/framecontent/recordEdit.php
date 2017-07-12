<?php

    /**
    *  Standalone record edit page. It may be used separately or wihin widget (in iframe)
    *
    * @package     Heurist academic knowledge management system
    * @link        http://HeuristNetwork.org
    * @copyright   (C) 2005-2016 University of Sydney
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
    require_once(dirname(__FILE__)."/initPage.php");
?>
        <script type="text/javascript" src="<?php echo PDIR;?>hclient/widgets/editing/rec_relation.js"></script>

        <script type="text/javascript" src="<?php echo PDIR;?>hclient/widgets/editing/editing2.js"></script>
        <script type="text/javascript" src="<?php echo PDIR;?>hclient/widgets/editing/editing_input.js"></script>

        <script type="text/javascript" src="<?php echo PDIR;?>hclient/widgets/viewers/resultList.js"></script>
        <script type="text/javascript" src="<?php echo PDIR;?>hclient/widgets/entity/manageEntity.js"></script>
        <script type="text/javascript" src="<?php echo PDIR;?>hclient/widgets/entity/searchEntity.js"></script>

        <script type="text/javascript" src="<?php echo PDIR;?>hclient/widgets/entity/manageRecords.js"></script>
        <!--script type="text/javascript" src="<?php echo PDIR;?>hclient/widgets/entity/searchRecords.js"></script-->
        
        <script type="text/javascript">
            var editing;
            
            // Callback function on initialization
            function onPageInit(success){
                if(success){
                    var $container = $("<div>").appendTo($("body"));
                    
                    //hidden result list, inline edit form
                    var options = {
                        select_mode:'manager',
                        edit_mode:'inline',
                        layout_mode:  '<div class="ent_wrapper">'
                            +'<div class="ent_header editForm-toolbar"/>'
                            +'<div class="recordList"  style="display:none;"/>'
                            +'<div class="ent_content_full editForm" style="padding:10px"/>'
                            +'</div>'
                    }
                    
                    $container.manageRecords( options );
                    
                    var q = window.hWin.HEURIST4.util.getUrlParameter('q', window.location.search);
                    
                    if(q){
                    
                        window.hWin.HAPI4.RecordMgr.search({q: q, w: "all", 
                                        limit: 100,
                                        needall: 1,
                                        detail: 'ids'}, 
                        function( response ){
                            //that.loadanimation(false);
                            if(response.status == window.hWin.HAPI4.ResponseStatus.OK){
                                
                                var recset = new hRecordSet(response.data);
                                if(recset.length()>0){
                                    $container.manageRecords('updateRecordList', null, 
                                            {recordset:recset});
                                    $container.manageRecords('addEditRecord', recset.getOrder()[0]);
                                }
                            }else{
                                window.hWin.HEURIST4.msg.showMsgErr(response);
                            }

                        });
                    
                    }else{
                        $container.manageRecords('addEditRecord',-1);
                    }
                }
            }            
        </script>
    </head>
    <body>
    </body>
</html>
