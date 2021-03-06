
/**
 * Функционал для кнопки удаления записи (в меню) при ее редактировании
 */
/*
$(function(){

    $(".remove-product-record").click(function() {
        var $this = this;
        $.SmartMessageBox({
            title : "Удалить данную позицию?",
            content : "Восстановить ее будет невозможно",
            buttons : '[Нет][Да]'
        },function(ButtonPressed) {
            if(ButtonPressed == "Да") {
                $.ajax({
                    url: $($this).attr('href'),
                    type: 'DELETE',
                    dataType: 'json',
                    beforeSend: function(){$($this).elementDisabled(true);},
                    success: function(response, textStatus, xhr){
                        if(response.status == true){
                            //showMessage.constructor('Удаление', response.responseText);
                            //showMessage.smallSuccess();
                            //$($this).parents('tr').fadeOut(500,function(){$(this).remove();});
                            location.href = $($this).attr('data-goto');
                            return false;
                        } else {
                            $($this).elementDisabled(false);
                            showMessage.constructor('Удаление', 'Возникла ошибка. Обновите страницу и повторите снова.');
                            showMessage.smallError();
                        }
                    },
                    error: function(xhr, textStatus, errorThrown){
                        $($this).elementDisabled(false);
                        showMessage.constructor('Удаление', 'Возникла ошибка. Повторите снова.');
                        showMessage.smallError();
                    }
                });
            }
        });
        return false;
    });
});
*/


/** 
 * Функционал для кнопки удаления записи (в списке)
 */
$(function(){
	
	$(".remove-attributes-group-list").click(function(e) {

        e.preventDefault();

        if ($(this).parents('.attributes_group').find('ul li').length) {
            $.SmartMessageBox({
                title : "Невозможно удалить непустую группу атрибутов",
                content : "Перенесите в другую группу или удалите все вложенные атрибуты - после этого данную группу можно будет удалить",
                buttons : '[Хорошо]'
            });
            return false;
        }

		var $this = this;

        $.SmartMessageBox({
			title : "Удалить группу атрибутов?",
			content : "Восстановить ее будет невозможно",
			buttons : '[Нет][Да]'
		}, function(ButtonPressed) {

			if(ButtonPressed == "Да") {

				$.ajax({
					url: $($this).parent('form').attr('action'),
					type: 'DELETE',
                    dataType: 'json',
					beforeSend: function(){$($this).elementDisabled(true);},
					success: function(response, textStatus, xhr){
						if(response.status == true){
							showMessage.constructor('Удалить запись', response.responseText);
							showMessage.smallSuccess();

							//$($this).parents('tr').fadeOut(500,function(){$(this).remove();});
                            $($this).parents('.attributes_group').slideUp();

						} else {
							$($this).elementDisabled(false);
							showMessage.constructor('Удалить запись', 'Возникла ошибка. Обновите страницу и повторите снова.');
							showMessage.smallError();
						}
					},
					error: function(xhr, textStatus, errorThrown){
						$($this).elementDisabled(false);
						showMessage.constructor('Удалить запись', 'Возникла ошибка. Повторите снова.');
						showMessage.smallError();
					}
				});

			}
		});
		return false;
	});
});
