/**
* Class to search and select record 
* It can be converted to widget later?
* 
* @param rectype_set - allowed record types for search, otherwise all rectypes will be used
* @returns {Object}
* @see editing_input.js
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

function hDatabaseAddData() {
    var _className = "DatabaseAddData",
    _version   = "0.4";

    function _init(){

        var parentdiv = $('.accordion_pnl').accordion({
            heightStyle: "content",
            collapsible: true, 
            active: false
        });

        parentdiv.find('div')
        .addClass('menu-list')
        .css({'border-color':'white !important', 'background':'none'});   // ui-corner-all
        $( parentdiv ).find('h3')
        .css({border:'none', 'background':'none'});

        parentdiv.find('li').addClass('ui-menu-item');

        parentdiv.find('li').each(function(idx,item){
            $('<div class="svs-contextmenu ui-icon ui-icon-arrowthick-1-e"></div>').appendTo($(item));
        });

        _initLinks(parentdiv);

        //parentdiv.accordion('option', 'active', 1); //STRUCTURE
        $('#menulink-add-record').click();
    }
    
    
    //init listeners for auto-popup links
    function _initLinks(menu){

        menu.find('[name="auto-popup"]').each(function(){
            var ele = $(this);
            var href = ele.attr('href');
            if(!top.HEURIST4.util.isempty(href)){
                href = href + (href.indexOf('?')>0?'&':'?') + 'db=' + top.HAPI4.database;

                if(ele.hasClass('h3link')){
                    href = top.HAPI4.basePathV3 + href;
                    //h3link class on menus implies location of older (vsn 3) code
                }
                
                ele.attr('href', href).click(
                    function(event){
                        _onPopupLink(event);
                    }
                );

            }
        });

        menu.find('li').each( function (idx, item)
            {
                if($(item).text()=='-'){
                   $(item).addClass('ui-menu-divider');
                }
            });

        menu.find('.top-menu-only').hide();
        
        
        menu.find('#menu-import-csv').click(
            function(event){
                top.HAPI4.SystemMgr.is_logged(
                function(){
                   var url = top.HAPI4.basePathV4 + "hclient/framecontent/import/importRecordsCSV.php?db="+ top.HAPI4.database;
                   
                   var body = $(this.document).find('body');
                   var dim = {h:body.innerHeight(), w:body.innerWidth()};
                   
                   top.HEURIST4.msg.showDialog(url, {    
                        title: 'Import Records from CSV/TSV',
                        height: dim.h-5,
                        width: dim.w-5,
                        'context_help':top.HAPI4.basePathV4+'context_help/importRecordsCSV.html #content'
                        //callback: _import_complete
                    });
                
                event.preventDefault();
                return false;
                })
            }
        );
        
        
        $('#menulink-add-record').click( //.attr('href', 
            function(event){
            }
        );
        
    }

    
    //
    //
    //    
    function _onPopupLink(event){
        
        var action = $(event.target).attr('id');
        
        var body = $(this.document).find('body');
        var dim = {h:body.innerHeight   (), w:body.innerWidth()},
        link = $(event.target);

        var options = { title: link.html() };

        if (link.hasClass('small')){
            options.height=dim.h*0.6; options.width=dim.w*0.5;
        }else if (link.hasClass('portrait')){
            options.height=dim.h*0.8; options.width=dim.w*0.55;
            if(options.width<700) options.width = 700;
        }else if (link.hasClass('large')){
            options.height=dim.h*0.8; options.width=dim.w*0.8;
        }else if (link.hasClass('verylarge')){
            options.height = dim.h*0.95;
            options.width  = dim.w*0.95;
        }else if (link.hasClass('fixed')){
            options.height=dim.h*0.8; options.width=800;
        }else if (link.hasClass('fixed2')){
            if(dim.h>700){ options.height=dim.h*0.8;}
            else { options.height=dim.h-40; }
            options.width=800;
        }else if (link.hasClass('landscape')){
            options.height=dim.h*0.5;
            options.width=dim.w*0.8;
        }

        var url = link.attr('href');
        if (link.hasClass('currentquery')) {
            url = url + that._current_query_string
        }
        
        if (link.hasClass('refresh_structure')) {
               options['afterclose'] = this._refreshLists;
        }


        if(link.attr('id')=='menulink-add-record'){
                
                $('.accordion_pnl').find('a').removeClass('selected');
                link.addClass('selected');
                $('#frame_container2').attr('src', url); 
                event.preventDefault();
                return false;
                
        }else if(link.hasClass('embed')) {
        
            //check if login
            top.HAPI4.SystemMgr.is_logged(function(){
                $('.accordion_pnl').find('a').removeClass('selected');
                link.addClass('selected');
                $('#frame_container2').attr('src', url); 
                event.preventDefault();
                return false;
            });
                
                
        }else if(event.target && $(event.target).attr('data-nologin')!='1'){
            //check if login
            top.HAPI4.SystemMgr.is_logged(function(){top.HEURIST4.msg.showDialog(url, options);});
        }else{
            top.HEURIST4.msg.showDialog(url, options);
        }        

        return false;
    }
    
    
    //public members
    var that = {

        getClass: function () {return _className;},
        isA: function (strClass) {return (strClass === _className);},
        getVersion: function () {return _version;},

    }

    _init();
    return that;  //returns object
}
    
            
   
