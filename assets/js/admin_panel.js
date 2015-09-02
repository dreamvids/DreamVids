function unFlagVideo(vidId) {
	if(confirm("Voulez-vous annuler le report de cette video ?")) {
		$.ajax({
			type: "PUT",
			url: _webroot_ + 'videos/' + vidId,
			data: { flag: false },
			success: function(result) {
				window.location.reload();
			}
		});
	}
}

function flagVideo(vidId) {
	if(confirm("Voulez-vous report cette video ?")) {
		$.ajax({
			type: "PUT",
			url: _webroot_ + 'videos/' + vidId,
			data: { flag: true },
			success: function(result) {
				window.location.reload();
			}
		});
	}
}

function suspendVideo(vidId) {
	if(confirm("Voulez-vous vraiment suspendre cette video ?")) {
		$.ajax({
			type: "PUT",
			url: _webroot_ + 'videos/' + vidId,
			data: { suspend: true },
			success: function(result) {
				window.location.reload();
			}
		});
	}
}

function unSuspendVideo(vidId) {
	if(confirm("Voulez-vous vraiment annuler la suspension de cette video ?")) {
		$.ajax({
			type: "PUT",
			url: _webroot_ + 'videos/' + vidId,
			data: { suspend: false },
			success: function(result) {
				window.location.reload();
			}
		});
	}
}

function eraseVideo(vidId) {
	if(confirm("Voulez-vous vraiment effacer cette video DEFINITIVEMENT ?")) {
		$.ajax({
			type: "DELETE",
			url: _webroot_ + 'videos/' + vidId,
			data: {},
			success: function(result) {
				window.location.reload();
			}
		});
	}
}



function unflagComment(commentId) {
	if(confirm("Voulez-vous vraiment annuler le report de ce commentaire ?")) {
		$.ajax({
			type: "PUT",
			url: _webroot_ + 'comments/' + commentId,
			data: { flag: false },
			success: function(result) {
				window.location.reload();
			}
		});
	}
}

function eraseComment(commentId) {
	if(confirm("Voulez-vous vraiment effacer ce commentaire DEFINITIVEMENT ?")) {
		$.ajax({
			type: "DELETE",
			url: _webroot_ + 'comments/' + commentId,
			data: {},
			success: function(result) {
				window.location.reload();
			}
		});
	}
}

function deleteEgg(egg_id){
		if(confirm("ATTENTION ! Supprimer un oeuf déjà trouvé entraine la supression des points de la personne qu'il l'a trouvé.")){
			$.ajax({
				type: "DELETE",
				url: _webroot_ + 'admin/egg/' + egg_id,
				data: {},
				success: function(result) {
					window.location.reload();
				}
			});
		}			
}

function checkSpace(id, srv){
	var element = document.getElementById(id);
	if(element){
		setInterval(function (el, srv) {
			$.ajax({
				url: _webroot_ + 'admin/statistic/space/' + srv,
				success: function(result){
					if(result.error){
						el.innerHTML = result.error;
					}else{
						var sizes = {
							1: '',
							1000: 'K',
							1000000: 'M',
							1000000000: 'G',
							1000000000000: 'T',
							1000000000000000: 'P',
							1000000000000000000: 'E'
						}
						var unity = 1;
						for(var size in sizes){
							if(result.empty_space/(size) > 1){
								unity = size;
							}
						}
						el.innerHTML = (result.empty_space/unity).toFixed(0) + sizes[unity] + "o";
					}
				}
			})
		}, 2000, element, srv);
	}
}

(function(servers){
	servers.forEach(function(v,i,ar){
		checkSpace(v+'_space', v);
	})
})(servers);

$('#news_modal').on('show.bs.modal', function (event) {
	
	var button = $(event.relatedTarget)
	
	var title = button.data('title');
	var content = button.data('content');
	var level = button.data('level');
	var icon = button.data('icon');
	
	var modal = $(this);
	var form = $("#news_form");
	
	form.data('method', button.data('method'));
	switch(button.data('method')){
		case 'PUT' :
						form.data('id', button.data('id'));
						modal.find('#input-level option[value="'+level+'"]').prop('selected', true);
						modal.find('.modal-title').text('Modifier la news "' + title + '"');
						modal.find('.modal-body #input-title').val(title);
						modal.find('.modal-body #input-content').val(content);
						modal.find('.modal-body #input-icon').val(icon);
			break;
		case 'POST' : 
						modal.find('.modal-title').text('Ajouter une news');
						modal.find('#input-level option[value=""]').prop('selected', true);
						modal.find('.modal-body #input-title').val('');
						modal.find('.modal-body #input-content').val('');
						modal.find('.modal-body #input-icon').val('');
						form.data('id', '');
			break;
	}
});

$('#news_form').submit(function(event) {
	
	var form_data = {};
	$(this).serializeArray().forEach(function(v){
		form_data[v.name] = v.value;
	});
	$.ajax({
		method: $(this).data('method'),
		data:form_data,
		url: _webroot_ + 'admin/news/' + $(this).data('id'),
		success: function(result) {
				if(result.success == true){
					window.location.reload();
				}else{
					var alert_el = document.createElement('div');
					alert_el.innerHTML = '<div class="alert alert-danger fade in" role="alert"><strong>Oups !</strong> Une erreur s\'est produite lors de l\'envoi</div>';
					$('#news_modal').find(".modal-header").append(alert_el);
					
					setTimeout(function(){
						$(alert_el).fadeOut();
					}, 2000);
				}
		}
	});
	
	
	event.preventDefault();
});

function deleteNew(el){
	if(confirm('Supprimer cette news ?')){
		$.ajax({
			method: 'delete',
			url: _webroot_ + 'admin/news/' + el.dataset.id,
			success: function(result) {
					window.location.reload();
			}
		});
		
	}
}