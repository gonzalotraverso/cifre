(function($){
	"use strict";

	var User = function(elems){
		this.$users = elems;
	}

	User.prototype = {
		show: function(container, url){
			for(var e in this.$users){
				var user = this.$users[e];
				console.log(user);
				var row = "<tr><td><a href='"+url+"/"+user.id+"'>"+user.username+"</a></td><td><a href='"+url+"/"+user.id+"'>"+user.email+"</a></td><td></td></tr>";
				container.prepend(row);
			}
		}
	}


	var DeleteButton = function(){
		this.$button = $('.delete-action');
		this.$message = $('.ga-message-container');
		this.$table = $('table');
		if(this.$button.length > 0)
			this.init();
	};

	DeleteButton.prototype = {
		init: function(){
			this.createWarning()
			this.bindEvents();
		},
		createWarning: function(){
			var $warning = document.createElement('div');
			$warning.setAttribute('class', 'aw-container');
			$warning.innerHTML = "<div class='aw-positioning'><p></p><div class='aw-buttons'><form method='POST' class='aw-form'><input type='hidden' name='_method' value='DELETE'><input type='submit' class='aw-ok' value='Ok'></form><button class='aw-cancel'>Cancel</button></div></div>";
			$('body').prepend($warning);
			this.$warning = $($warning);
		},
		bindEvents: function(){
			var self = this;
			this.$button.on('click', function(e){
				self.triggerWarning(e);
			});
			this.$warning.on('click', function(e){
				self.closeWarning(e);
			});
			this.$warning.find('.aw-cancel').on('click', function(e){
				self.closeWarning(e);
			});
			this.$warning.find('.aw-positioning').on('click', function(e){
				e.stopPropagation();
			});
			this.$warning.find('.aw-ok').on('click', function(e){
				self.sendForm(e)
			});
		},
		triggerWarning: function(e){
			e.preventDefault();
			var $elem = $(e.target); 
			var name = $elem.data('name');
			this.url = $elem.data('url');
			this.resource = $elem.data('resource');
			this.useAjax = ($elem.hasClass('use-ajax')) ? true : false;
			this.$warning.find('p').html('Delete '+name+'?');
			this.$warning.addClass('active');
		},
		closeWarning: function(e){
			this.$warning.removeClass('active');
		},
		sendForm: function(e){
			e.preventDefault();
			var self = this;
			if(this.useAjax){//not implemented (redo)
				$.ajax({
					url: self.url,
					type: 'DELETE',
					dataType: 'json'
				}).done(function(response) {
					self.flashMessage('Delete succesful.');
					self.reloadAll(response);
				});
			}else{
				$('.aw-form').attr('action', this.url).submit();
			}
		},
		flashMessage: function(msg){
			// RAW
			this.$message.html(msg);

		},
		reloadAll: function(response){
			this.clearTable()
			console.log(response);
			switch (this.resource){
				case 'users':
					var user = new User(response.elements);
					user.show(this.$table, response.url);
					break;
			}
		},
		clearTable: function(){
			var $rows = this.$table.find('tr');
			$rows.remove();
		}
	};

	var EditPass = function(){
		this.$clicker = $('.ga-edit-pass');
		this.$container = $('.ga-new-pass-container');
		this.$close = this.$container.find('.ga-close-pass-cont');
		this.init();
	}

	EditPass.prototype = {
		init: function(){
			this.$container.hide();
			this.bindEvents();
		},
		bindEvents: function(){
			var self = this;
			this.$clicker.on('click', function(e){
				self.showEditPass(e);
			});
			this.$close.on('click', function(e){
				self.closeEditPass(e);
			});
		},
		showEditPass: function(e){
			e.preventDefault();
			this.$container.css('display', 'inline-block');

			this.$clicker.hide();

		},
		closeEditPass: function(e){
			e.preventDefault();
			this.$container.hide();
			this.$container.find('input').val('');
			this.$clicker.show();

		}
	};


	var EditImg = function(){
		this.$container = $('.ga-img-edit-cont');
		this.$img = this.$container.find('img');
		this.$input = this.$container.find('input');
		this.$edit = this.$container.find('.ga-img-edit-change');
		this.$cancel = this.$container.find('.ga-img-edit-cancel');
		this.init();
	}

	EditImg.prototype = {
		init: function(){
			
			this.bindEvents();
		},
		bindEvents: function(){
			var self = this;
			this.$edit.on('click', function(e){
				self.showInput(e);
			});
			this.$cancel.on('click', function(e){
				self.hideInput(e);
			});
		},
		showInput: function(e){
			e.preventDefault();
			this.$img.hide();
			this.$input.show();
			this.$edit.hide();
			this.$cancel.show();
		},
		hideInput: function(e){
			e.preventDefault();
			this.$img.show();
			this.$input.hide();
			this.$edit.show();
			this.$cancel.hide();

		}
	}


	$(document).ready(function(){
		var deleteBtn = new DeleteButton();
		var editPass = new EditPass();
		var editImg = new EditImg();


	});

})(jQuery);
