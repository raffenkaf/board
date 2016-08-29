<?php
use yii\helpers\Html;

$this->title = Html::encode($model->name);
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript">
$(document).ready(function(){
    $("#select-type").change(function(){
        switch ($(this).val()){
        case '1':
            $(".add-txt").show();
            $(".add-ref").hide();
            $(".add-img").hide();
            break;
        case '2':
            $(".add-txt").hide();
            $(".add-ref").show();
            $(".add-img").hide();
            break;
        default:
            $(".add-txt").hide();
            $(".add-ref").hide();
            $(".add-img").show();
            break;
        }        
    });

});

$(document).on("click", ".addedTxt, .addedImg, .addedRef", function(event){
	event.preventDefault();
	return false;
	$(".addedTxt, .addedImg, .addedRef").css('border', '0px solid black');
	$(this).css('border', '2px solid black');	
	switch ($(this).attr('class')) {
	     case 'addedTxt':
	    	 $('#edit-ref-div').hide();
	    	 $('#edit-img-div').hide();
    	     $('#edit-txt-div').show();
    	     $('#edit-txt-id').val($(this).attr('id').slice(3));
    	     $('#edit-txt-txt').val($(this).html());
    	     $('#edit-txt-color').val($(this).css('color'));
    	     $('#edit-txt-bgcolor').val($(this).css('background-color'));
    	     $('#edit-txt-size').val($(this).css('font-size'));
    	     $('#edit-txt-x-coord').val($(this).css('left'));
    	     $('#edit-txt-y-coord').val($(this).css('top'));
	         break;
	     case 'addedImg':
	    	 $('#edit-ref-div').hide();
	    	 $('#edit-img-div').show();
    	     $('#edit-txt-div').hide();
    	     $('#edit-img-id').val($(this).attr('id').slice(3));
    	     $('#edit-img-x-coord').val($(this).css('left'));
    	     $('#edit-img-y-coord').val($(this).css('top'));
    	     $('#edit-img-width').val($(this).css('width'));
    	     $('#edit-img-height').val($(this).css('height'));
    	 break;
	     case 'addedRef':
	    	 $('#edit-ref-div').show();
	    	 $('#edit-img-div').hide();
    	     $('#edit-txt-div').hide();
    	     $('#edit-ref-id').val($(this).attr('id').slice(3));
    	     $('#edit-ref-txt').val($(this).html());
    	     $('#edit-ref-color').val($(this).css('color'));
    	     $('#edit-ref-bgcolor').val($(this).css('background-color'));
    	     $('#edit-ref-size').val($(this).css('font-size'));
    	     $('#edit-ref-x-coord').val($(this).css('left'));
    	     $('#edit-ref-y-coord').val($(this).css('top'));
    	     $('#edit-ref-address').val($(this).attr('src'));   	     
    	 break;    	  
	  }
});

function addTxtNode () {
    var params = {
                     'type' : 'txt', 
                     'msg': $("#add-txt-txt").val() == ''? "empty" : $("#add-txt-txt").val() ,
                     'x_coordinate': $("#add-txt-x-coord").val() == ''? '0px' : $("#add-txt-x-coord").val(),
                     'y_coordinate': $("#add-txt-y-coord").val() == ''? '0px' : $("#add-txt-y-coord").val(),
                     'color': $("#add-txt-color").val()== ''? "#000000" : $("#add-txt-color").val(),
                     'bgcolor': $("#add-txt-bgcolor").val()== ''? "#ffffff" : $("#add-txt-bgcolor").val(), 
                     'font_size': $("#add-txt-size").val()== ''? "14px" : $("#add-txt-size").val(),
                     'board_id' : <?= $model->id  ?>
                 };
    $.ajax({
        type: "POST",
        url: "/board/add-node",
        data: params,
        success: function(id){            
            var txtNode = '<p class="addedTxt" id="txt'+id+'">'+params['msg']+'</p>';
            $("#main-board").append(txtNode);
            $("#txt"+id).css("left", (
                                      $("#main-board").offset()['left']
                                            + params['x_coordinate'].slice(0, -2)*1
                                      ) +  "px");
            $("#txt"+id).css("top", (
                                      $("#main-board").offset()['top']
                                            + params['y_coordinate'].slice(0, -2)*1
                                       )  +  "px");
            $("#txt"+id).css("color", params['color']);
            $("#txt"+id).css("background-color", params['bgcolor']);
            $("#txt"+id).css("font-size", params['font_size']);    
        },
        error: function(txt){
            console.log(txt);
        }
    });
}


function addRefNode () {
    var params = {
            'type' : 'ref', 
            'msg': $("#add-ref-txt").val() == ''? "empty" : $("#add-ref-txt").val() ,
            'x_coordinate': $("#add-ref-x-coord").val() == ''? '0px' : $("#add-ref-x-coord").val(),
            'y_coordinate': $("#add-ref-y-coord").val() == ''? '0px' : $("#add-ref-y-coord").val(),
            'color': $("#add-ref-color").val()== ''? "#000000" : $("#add-ref-color").val(),
            'bgcolor': $("#add-ref-bgcolor").val()== ''? "#ffffff" : $("#add-ref-bgcolor").val(), 
            'font_size': $("#add-ref-size").val()== ''? "14px" : $("#add-ref-size").val(),
            'address': $("#add-ref-address").val()== ''? "/" : $("#add-ref-address").val(),
            'board_id' : <?= $model->id  ?>
        };
    $.ajax({
        type: "POST",
        url: "/board/add-node",
        data: params,
        success: function(id){
            var txtNode = '<a class="addedRef disabled" href="'+params['address']
                          + '" id="ref'+id+'">'+params['msg']+'</p>';
            $("#main-board").append(txtNode);
            $("#ref"+id).css("left", (
                                            $("#main-board").offset()['left']
                                            + params['x_coordinate'].slice(0, -2)*1
                                        ) +  "px");
            $("#ref"+id).css("top", (
                                            $("#main-board").offset()['top']
                                            + params['y_coordinate'].slice(0, -2)*1
                                       )  +  "px");
            $("#ref"+id).css("color", params['color']);
            $("#ref"+id).css("background-color", params['bgcolor']);
            $("#ref"+id).css("font-size", params['font_size']);    
        },
        error: function(txt){
            console.log(txt);
        }    
    });
}

function addImgNode () {
    $.ajax({
        type: 'POST',
        url: '/board/add-img-node',
        data: new FormData($("#fakeForm")[0]),
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(data) {
            var imgNode = '<img class="addedImg" src="../../'+data['path']+'" id="img'+data['id']+'">';
            $("#main-board").append(imgNode);
            $("#img"+data['id']).css("left", (
                                      $(
                                          "#main-board").offset()['left']
                                          + data['x_coordinate'].slice(0, -2)*1
                                      )+"px");
            $("#img"+data['id']).css("top", (
                                      $(
                                          "#main-board").offset()['top']
                                          + data['y_coordinate'].slice(0, -2)*1
                                      )+"px");
            $("#img"+data['id']).css("width", data['width']);
            $("#img"+data['id']).css("height", data['height']);            
        },
        error: function(data) {
            console.log(data);
        }
      });    
}

function editTxtNode () {
    var params = {
    	             'id' : $("#edit-txt-id").val(),
                     'type' : 'txt', 
                     'msg': $("#edit-txt-txt").val(),
                     'x_coordinate': $("#edit-txt-x-coord").val(),
                     'y_coordinate': $("#edit-txt-y-coord").val(),
                     'color': $("#edit-txt-color").val(),
                     'bgcolor': $("#edit-txt-bgcolor").val(), 
                     'font_size': $("#edit-txt-size").val(),
                     'board_id' : <?= $model->id  ?>
                 };
    $.ajax({
        type: "POST",
        url: "/board/edit-node",
        data: params,
        success: function(id){
        	$("#txt"+id).html(params['msg']);         
            $("#txt"+id).css("left", params['x_coordinate']);
            $("#txt"+id).css("top", params['y_coordinate']);
            $("#txt"+id).css("color", params['color']);
            $("#txt"+id).css("background-color", params['bgcolor']);
            $("#txt"+id).css("font-size", params['font_size']);
            $("#txt"+id).css("border", "0px");
            $('#edit-txt-div').hide();
        },
        error: function(txt){
            console.log(txt);
        }
    });
}


function editRefNode () {
    var params = {
    		'id' : $("#edit-ref-id").val(),
            'type' : 'ref', 
            'msg': $("#edit-ref-txt").val() == ''? "empty" : $("#edit-ref-txt").val() ,
            'x_coordinate': $("#edit-ref-x-coord").val() == ''? '0px' : $("#edit-ref-x-coord").val(),
            'y_coordinate': $("#edit-ref-y-coord").val() == ''? '0px' : $("#edit-ref-y-coord").val(),
            'color': $("#edit-ref-color").val()== ''? "#000000" : $("#edit-ref-color").val(),
            'bgcolor': $("#edit-ref-bgcolor").val()== ''? "#ffffff" : $("#edit-ref-bgcolor").val(), 
            'font_size': $("#edit-ref-size").val()== ''? "14px" : $("#edit-ref-size").val(),
            'address': $("#edit-ref-address").val()== ''? "/" : $("#edit-ref-address").val(),
            'board_id' : <?= $model->id  ?>
        };
    $.ajax({
        type: "POST",
        url: "/board/edit-node",
        data: params,
        success: function(id){
        	$("#ref"+id).html(params['msg']);
            $("#ref"+id).css("left", params['x_coordinate']);
            $("#ref"+id).css("top", params['y_coordinate']);
            $("#ref"+id).css("color", params['color']);
            $("#ref"+id).css("background-color", params['bgcolor']);
            $("#ref"+id).css("font-size", params['font_size']);
            $("#ref"+id).css("border", "0px");
            $('#edit-ref-div').hide();
        },
        error: function(txt){
            console.log(txt);
        }    
    });
}

function editImgNode () {
    $.ajax({
        type: 'POST',
        url: '/board/edit-image',
        data: new FormData($("#fakeEditForm")[0]),
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(data) {
        	$("#img"+data['id']).remove();
            var imgNode = '<img class="addedImg" src="../../'+data['path']+'" id="img'+data['id']+'">';
            $("#main-board").append(imgNode);
            $("#img"+data['id']).css("left", data['x_coordinate']);
            $("#img"+data['id']).css("top", data['y_coordinate']);
            $("#img"+data['id']).css("width", data['width']);
            $("#img"+data['id']).css("height", data['height']);
            $('#edit-img-div').hide();           
        },
        error: function(data) {
            console.log(data);
        }
      });    
}

function deleteTxtNode() {
    $.ajax({
        type: "POST",
        url: "/board/delete-node",
        data: {'id' :  $("#edit-txt-id").val(), 'type':'txt'},        		
        success: function(txt){            
            $("#txt"+data['id']).remove();
            $('#edit-txt-div').hide();
        },    
        error: function(txt){
            console.log(txt);
        }    
    });   
}

function deleteRefNode() {
    $.ajax({
        type: "POST",
        url: "/board/delete-node",
        data: {'id' :  $("#edit-ref-id").val(), 'type':'ref'},        		
        success: function(txt){            
            $("#ref"+data['id']).remove();
            $('#edit-ref-div').hide();
        },    
        error: function(txt){
            console.log(txt);
        }    
    });   
}

function deleteImgNode() {
    $.ajax({
        type: "POST",
        url: "/board/delete-img-node",
        data: {'id' :  $("#edit-img-id").val()},        		
        success: function(txt){            
            $("#img"+data['id']).remove();
            $('#edit-img-div').hide(); 
        },    
        error: function(txt){
            console.log(txt);
        }    
    });   
}

function addUserAccess() {
    $.ajax({
        type: "POST",
        url: "/board/add-user",
        data: {'login' : $("#add-user").val(), 'boardId' : <?= $model->id ?> },        		
        success: function(txt){            
            console.log(txt);
        },    
        error: function(txt){
            console.log(txt);
        }    
    });   
}
</script>
<div class ="add-wrap">
<?php if (Yii::$app->user->identity->id == $model->create_user_id) { ?>
<div class="addUserAccess">
    <h4>Добавить юзера</h4>
    <?= Html::label('Логин', 'add-user-name', ['class'=>'add-txt-label']) ?> 
    <?= Html::textInput('add-user-name', null, ['class'=>'add-user', 'id'=>'add-user']) ?>
    <?= Html::button('Добавить', ['id' => 'addUserAccess', 'onClick' => 'addUserAccess();']) ?>
</div>
<?php } ?>
<div class = "add-element-block leftFloat">
    <?= Html::dropDownList('add-type', 
                           1, 
                           [
                                   '1'=>'Добавить текст',
                                   '2'=>'Добавить ссылку',
                                   '3'=>'Добавить изображение',
                           ],
                           ['id' => 'select-type']
    ) ?>
    <div id="errorMsg"></div>
    <div class = "add-txt" id = "add-txt-div">
        <?= Html::label('Текст', 'add-txt-txt', ['class'=>'add-txt-label']) ?> 
        <?= Html::textInput('new-txt', null, ['class'=>'add-txt', 'id' => 'add-txt-txt']) ?>
        <?= Html::label('Цвет текста', 'add-txt-color', ['class'=>'add-txt-label']) ?> 
        <?= Html::textInput('new-color', null, ['class'=>'add-txt', 'id' => 'add-txt-color']) ?>
        <?= Html::label('Цвет фона', 'add-txt-bgcolor', ['class'=>'add-txt-label']) ?> 
        <?= Html::textInput('new-bgcolor', null, ['class'=>'add-txt', 'id' => 'add-txt-bgcolor']) ?>
        <?= Html::label('Размер шрифта', 'add-txt-size', ['class'=>'add-txt-label']) ?> 
        <?= Html::textInput('new-size', null, ['class'=>'add-txt', 'id' => 'add-txt-size']) ?>
        <?= Html::label('X-координата', 'add-txt-x-coord', ['class'=>'add-txt-label']) ?> 
        <?= Html::textInput('new-x-coordinate', null, ['class'=>'add-txt', 'id' => 'add-txt-x-coord']) ?>
        <?= Html::label('Y-координата', 'add-txt-y-coord', ['class'=>'add-txt-label']) ?> 
        <?= Html::textInput('new-y-coordinate', null, ['class'=>'add-txt', 'id' => 'add-txt-y-coord']) ?>
        <?= Html::button('Добавить', ['id' => 'addAuthor', 'onClick' => 'addTxtNode();']) ?>
    </div>
        
    <div class = "add-ref" id = "add-ref-div">
        <?= Html::label('Текст', 'add-ref-txt', ['class'=>'add-ref-label']) ?> 
        <?= Html::textInput('new-txt', null, ['class'=>'add-ref', 'id' => 'add-ref-txt']) ?>
        <?= Html::label('Цвет текста', 'add-ref-color', ['class'=>'add-ref-label']) ?> 
        <?= Html::textInput('new-color', null, ['class'=>'add-ref', 'id' => 'add-ref-color']) ?>
        <?= Html::label('Цвет фона', 'add-ref-bgcolor', ['class'=>'add-ref-label']) ?> 
        <?= Html::textInput('new-bgcolor', null, ['class'=>'add-ref', 'id' => 'add-ref-bgcolor']) ?>
        <?= Html::label('Размер шрифта', 'add-ref-size', ['class'=>'add-ref-label']) ?> 
        <?= Html::textInput('new-size', null, ['class'=>'add-ref', 'id' => 'add-ref-size']) ?>
        <?= Html::label('X-координата', 'add-ref-x-coord', ['class'=>'add-ref-label']) ?> 
        <?= Html::textInput('new-x-coordinate', null, ['class'=>'add-ref', 'id' => 'add-ref-x-coord']) ?>
        <?= Html::label('Y-координата', 'add-ref-y-coord', ['class'=>'add-ref-label']) ?> 
        <?= Html::textInput('new-y-coordinate', null, ['class'=>'add-ref', 'id' => 'add-ref-y-coord']) ?>
        <?= Html::label('Адрес', 'add-ref-address', ['class'=>'add-ref-label']) ?> 
        <?= Html::textInput('new-address', null, ['class'=>'add-ref', 'id' => 'add-ref-address']) ?>
        <?= Html::button('Добавить', ['id' => 'addAuthor', 'onClick' => 'addRefNode();']) ?>
    </div>
         
    <div class = "add-img" id = "add-img-div">
        <?= Html::beginForm("fake","POST",['enctype'=>'multipart/form-data', 'id'=> 'fakeForm'] ) ?>
        <?= Html::hiddenInput('board_id', $model->id) ?>
        <?= Html::fileInput('img', null, ['class'=>'add-img', 'id' => 'add-img-img']) ?>
        <?= Html::label('X-координата', 'add-img-x-coord', ['class'=>'add-img-label']) ?> 
        <?= Html::textInput('x_coordinate', null, ['class'=>'add-img', 'id' => 'add-img-x-coord']) ?>
        <?= Html::label('Y-координата', 'add-img-y-coord', ['class'=>'add-img-label']) ?> 
        <?= Html::textInput('y_coordinate', null, ['class'=>'add-img', 'id' => 'add-img-y-coord']) ?>
        <?= Html::label('Ширина', 'add-img-width', ['class'=>'add-img-label']) ?> 
        <?= Html::textInput('width', null, ['class'=>'add-img', 'id' => 'add-img-width']) ?>
        <?= Html::label('Высота', 'add-img-height', ['class'=>'add-img-label']) ?> 
        <?= Html::textInput('height', null, ['class'=>'add-img', 'id' => 'add-img-height']) ?>
        <?= Html::endForm() ?>
        <?= Html::button('Добавить', ['id' => 'addAuthor', 'onClick' => 'addImgNode();']) ?>
    </div>

</div>
<div class = "edit-element-block leftFloat">
    <h5> Редактирование элементов </h5>
    <div class = "edit-txt" id = "edit-txt-div">
        <?= Html::hiddenInput('node_id', null, ['id'=>'edit-txt-id']) ?>
        <?= Html::label('Текст', 'edit-txt-txt', ['class'=>'edit-txt-label']) ?>        
        <?= Html::textInput('new-txt', null, ['class'=>'edit-txt', 'id' => 'edit-txt-txt']) ?>
        <?= Html::label('Цвет текста', 'edit-txt-color', ['class'=>'edit-txt-label']) ?> 
        <?= Html::textInput('new-color', null, ['class'=>'edit-txt', 'id' => 'edit-txt-color']) ?>
        <?= Html::label('Цвет фона', 'edit-txt-bgcolor', ['class'=>'edit-txt-label']) ?> 
        <?= Html::textInput('new-bgcolor', null, ['class'=>'edit-txt', 'id' => 'edit-txt-bgcolor']) ?>
        <?= Html::label('Размер шрифта', 'edit-txt-size', ['class'=>'edit-txt-label']) ?> 
        <?= Html::textInput('new-size', null, ['class'=>'edit-txt', 'id' => 'edit-txt-size']) ?>
        <?= Html::label('X-координата', 'edit-txt-x-coord', ['class'=>'edit-txt-label']) ?> 
        <?= Html::textInput('new-x-coordinate', null, ['class'=>'edit-txt', 'id' => 'edit-txt-x-coord']) ?>
        <?= Html::label('Y-координата', 'edit-txt-y-coord', ['class'=>'edit-txt-label']) ?> 
        <?= Html::textInput('new-y-coordinate', null, ['class'=>'edit-txt', 'id' => 'edit-txt-y-coord']) ?>
        <?= Html::button('Изменить', ['id' => 'editAuthor', 'onClick' => 'editTxtNode();']) ?>
        <?= Html::button('Удалить', ['id' => 'editAuthor', 'onClick' => 'deleteTxtNode();']) ?>
    </div>
        
    <div class = "edit-ref" id = "edit-ref-div">
        <?= Html::hiddenInput('node_id', null, ['id'=>'edit-ref-id']) ?>
        <?= Html::label('Текст', 'edit-ref-txt', ['class'=>'edit-ref-label']) ?> 
        <?= Html::textInput('new-txt', null, ['class'=>'edit-ref', 'id' => 'edit-ref-txt']) ?>
        <?= Html::label('Цвет текста', 'edit-ref-color', ['class'=>'edit-ref-label']) ?> 
        <?= Html::textInput('new-color', null, ['class'=>'edit-ref', 'id' => 'edit-ref-color']) ?>
        <?= Html::label('Цвет фона', 'edit-ref-bgcolor', ['class'=>'edit-ref-label']) ?> 
        <?= Html::textInput('new-bgcolor', null, ['class'=>'edit-ref', 'id' => 'edit-ref-bgcolor']) ?>
        <?= Html::label('Размер шрифта', 'edit-ref-size', ['class'=>'edit-ref-label']) ?> 
        <?= Html::textInput('new-size', null, ['class'=>'edit-ref', 'id' => 'edit-ref-size']) ?>
        <?= Html::label('X-координата', 'edit-ref-x-coord', ['class'=>'edit-ref-label']) ?> 
        <?= Html::textInput('new-x-coordinate', null, ['class'=>'edit-ref', 'id' => 'edit-ref-x-coord']) ?>
        <?= Html::label('Y-координата', 'edit-ref-y-coord', ['class'=>'edit-ref-label']) ?> 
        <?= Html::textInput('new-y-coordinate', null, ['class'=>'edit-ref', 'id' => 'edit-ref-y-coord']) ?>
        <?= Html::label('Адрес', 'edit-ref-editress', ['class'=>'edit-ref-label']) ?> 
        <?= Html::textInput('new-editress', null, ['class'=>'edit-ref', 'id' => 'edit-ref-address']) ?>
        <?= Html::button('Изменить', ['id' => 'editAuthor', 'onClick' => 'editRefNode();']) ?>
        <?= Html::button('Удалить', ['id' => 'editAuthor', 'onClick' => 'deleteRefNode();']) ?>
    </div>
         
    <div class = "edit-img" id = "edit-img-div">
        <?= Html::beginForm("fake","POST",['enctype'=>'multipart/form-data', 'id'=> 'fakeEditForm'] ) ?>
        <?= Html::hiddenInput('node_id', null, ['id'=>'edit-img-id']) ?>
        <?= Html::fileInput('img', null, ['class'=>'edit-img', 'name' => 'edit-img-img', 'id' => 'edit-img-img']) ?>
        <?= Html::label('X-координата', 'edit-img-x-coord', ['class'=>'edit-img-label']) ?> 
        <?= Html::textInput('x_coordinate', null, ['class'=>'edit-img', 'id' => 'edit-img-x-coord']) ?>
        <?= Html::label('Y-координата', 'edit-img-y-coord', ['class'=>'edit-img-label']) ?> 
        <?= Html::textInput('y_coordinate', null, ['class'=>'edit-img', 'id' => 'edit-img-y-coord']) ?>
        <?= Html::label('Ширина', 'edit-img-width', ['class'=>'edit-img-label']) ?> 
        <?= Html::textInput('width', null, ['class'=>'edit-img', 'id' => 'edit-img-width']) ?>
        <?= Html::label('Высота', 'edit-img-height', ['class'=>'edit-img-label']) ?> 
        <?= Html::textInput('height', null, ['class'=>'edit-img', 'id' => 'edit-img-height']) ?>
        <?= Html::endForm() ?>
        <?= Html::button('Изменить', ['id' => 'editAuthor', 'onClick' => 'editImgNode();']) ?>
        <?= Html::button('Удалить', ['id' => 'editAuthor', 'onClick' => 'deleteImgNode();']) ?>
    </div>
</div>    
<div class = "main-board  leftFloat" id = "main-board">

</div>
</div>