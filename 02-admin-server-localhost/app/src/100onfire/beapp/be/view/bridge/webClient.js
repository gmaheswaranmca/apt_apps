$(document).ready(function(){
    //gfMgr.Alert(1100);	
    var f = function(){
        //$('#PageBefore').css('display','block');$('#PageAfter').css('display','none');
        BridgeEditorRestClientProcessor.Init(); 
        BridgeEditorRestClient.Init();		
    };
    f();//gfMgr.RunAfGivSec(f,10);		
}
);
var BridgeEditorConfig = { 
'EditedData':{'url':'controller.php',
    'params':{'m':'EditedData'}
}
,'SaveEdited':{'url':'controller.php',
    'params':{'m':'SaveEdited'}
}	
};var BridgeEditorModel = {
'EditedData':{}
,
'SaveEdited':{}
};var BridgeEditorRestClient = new function (){ 
this.EditedData = null;
this.SaveEdited = null;

this.Init=function(){
    this.EditedData = new gfMgr.DefServiceReq(
        BridgeEditorRestClient,
        BridgeEditorConfig,
        BridgeEditorModel, 
        'EditedData',
        function(){
            var model = BridgeEditorModel[this.Dor.ReqName];
            BridgeEditorRestClientProcessor.EditedData.Render(model);
        }
    );
    this.SaveEdited = new gfMgr.DefServiceReq(
        BridgeEditorRestClient,
        BridgeEditorConfig,
        BridgeEditorModel, 
        'SaveEdited',
        function(){
            var Res = BridgeEditorModel[this.Dor.ReqName];											
            //BridgeEditorRestClientProcessor.SaveEdited();
        }
    );
    this.EditedData.Init();
    this.SaveEdited.Init();		
    this.EditedData.Dor.fReqDo();
};
};var BridgeEditorRestClientProcessor = new function(){	
this.EditedData = new function(){
    this.Render = function(model){			
        var BridgeEditedData = 	model.BridgeEditedData;					
        CKEDITOR.instances.idEditor.setData(BridgeEditedData[0].src_text);
    };	
};
this.SaveEdited = function(){
    //Postable Data
    var edited_text = CKEDITOR.instances.idEditor.getData();
    //Call Save
    BridgeEditorConfig.SaveEdited.params['edited_text'] = edited_text;		
    BridgeEditorRestClient.SaveEdited.Dor.fReqDo();
    return false;
};
this.Init=function(){		
};
}
