/**
* Integration with existing H3 applications - mapping and smarty reports
* Working with current result set and selection
* External application are loaded in iframe
* 
* @package     Heurist academic knowledge management system
* @link        http://HeuristNetwork.org
* @copyright   (C) 2005-2014 University of Sydney
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


$.widget( "heurist.staticPage", {

    // default options
    options: {
        title: '',
        url:null
    },
    
    _loaded_url:null,

    // the constructor
    _create: function() {

        var that = this;
        
        this.div_content = $('<div>')
                   /*.css({
                        position:'absolute', top:(this.options.title==''?0:'2.5em'), bottom:0, left:0, right:0,
                        'background':'url('+top.HAPI4.basePath+'assets/loading-animation-white.gif) no-repeat center center'})*/
                   .appendTo( this.element );
                   
        //this.dosframe = $( "<iframe>" ).css({overflow: 'none !important', width:'100% !important'}).appendTo( this.div_content );

        
        this.element.on("myOnShowEvent", function(event){
            if( event.target.id == that.element.attr('id')){
                that._refresh();
            }
        });
        
        this._refresh();
        

    }, //end _create


    _setOptions: function() {
        // _super and _superApply handle keeping the right this-context
        this._superApply( arguments );
        this._refresh();
    },
/*    
    _setOption: function( key, value ) {
        if(key=='url'){
            value = top.HAPI4.basePathOld + value;
        }else if (key=='title'){
             var id = this.element.attr('id');
             $(".header"+id).html(value);
             $('a[href="#'+id+'"]').html(value);
        }

        this._super( key, value );
        this._refresh();
    },*/  

    /* private function */
    _refresh: function(){

        if(this.options.title!=''){
            var id = this.element.attr('id');
            $(".header"+id).html(this.options.title);
            $('a[href="#'+id+'"]').html(this.options.title);
        }
        
        //refesh if element is visible only - otherwise it costs much resources        
        if(!this.element.is(':visible') || top.HEURIST4.util.isempty(this.options.url)) return;
        
        //if(this.dosframe.attr('src')!==this.options.url){
        if(this._loaded_url!==this.options.url){
            this.options.url = top.HAPI4.basePathOld +  this.options.url.replace("[dbname]",  top.HAPI4.database);
            this._loaded_url=this.options.url;
            var that=this;
            $(this.div_content).load(this.options.url); //, function(){ that.loadanimation(false); });
            //this.dosframe.attr('src', this.options.url);
        }
        
    },

    // events bound via _on are removed automatically
    // revert other modifications here
    _destroy: function() {

        this.element.off("myOnShowEvent");

        var that = this;

        // remove generated elements
        //this.dosframe.remove();
        this.div_content.remove();
    },
    
    loadanimation: function(show){
        if(show){
            //this.dosframe.hide();
            this.div_content.css('background','url('+top.HAPI4.basePath+'assets/loading-animation-white.gif) no-repeat center center');
        }else{
            this.div_content.css('background','none');
            //this.dosframe.show();
        }
    },

});
