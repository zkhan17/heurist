<?php

    /**
    * verifyInstallation.php
    * Verifies presence and correct versions for external JS components, Help, fiel directories and so forth
    *
    * @package     Heurist academic knowledge management system
    * @link        http://HeuristNetwork.org
    * @copyright   (C) 2005-2014 University of Sydney
    * @author      Artem Osmakov   <artem.osmakov@sydney.edu.au>
    * @author      Ian Johnson     <ian.johnson@sydney.edu.au>
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

    // SHHOUKLDN'T NEED THESE, SHOUDL BE ABLE TO RUN STANDALONE
    // require_once(dirname(__FILE__).'/../../common/connect/applyCredentials.php');
    // require_once(dirname(__FILE__).'/../../common/php/dbMySqlWrappers.php');

?>

<html>

    <head>
        <link rel="stylesheet" type="text/css" href="../../common/css/global.css">
        <link rel="stylesheet" type="text/css" href="../../common/css/admin.css">
        <style type="text/css">
            h3, h3 span {
                display: inline-block;
                padding:0 0 10px 0;
            }
            Table tr td {
                line-height:2em;
            }
            .statusCell{
                width:50px;
                display: table-cell;
            }
            .maskCell{
                width:550px;
                display: table-cell;
            }
            .errorCell{
                display: table-cell;
            }
            .valid{
                color:green;
            }
            .invalid{
                color:red;
            }

        </style>
    </head>

    <body class="popup">

        <div class="banner">
            <h2>Verify Heurist installation</h2> 
        </div>
        <div id="page-inner">

        This function verifies the presence of required program components and the location and writability of folders required by the software.<br />
        It assumes that all instances of Heurist are located in subdirectories in a common location (generally /var/www/html/HEURIST)<br />
        and point to the same Heurist filestore (generally .../HEURIST/HEURIST_FILESTORE, which is often a simlink to the real storage location).<br /> 
        Checks include: external javascript functions; help system; exemplars; root file upload directory; index.html in parent. <br />

        <h3>Please run this using the latest instance on your server eg. h3-alpha</h3><br />
        If you use an older instance it may not pick up all requirements for the latest instance.<br/>&nbsp;<br/>
        <hr>
        <br />

        Verification under development July 2014 <br />
        <?php



        ?>
        <br />
        <hr>
        <br /> Verification complete. Please note any errors listed above.
    </body>
</html>