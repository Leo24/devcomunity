jQuery(document).ready(function($){

	var phpRequest = 500;
	var chunkAmount = 100;
	var breath = 500;

	var progress = $('#send_message_progress').hide();

	var send, notice, form;

	function unique(array){
	    return $.grep(array, function(element, index){
	        return index === $.inArray(element, array);
	    });
	}

	function validation_error(validation){
		send.prop('disabled', false);

		notice.html('<div id="message" class="bp-template-notice error"><p>'+validation.join('<br />')+'</p></div>').show();
		form.show();
		progress.hide();
	}

	function get_recipients(type, value, callback){
		var data = {
			'action': 'get_message_recipients',
		};

		data[type] = value;

		$.post(ajaxurl, data, function(response){
			response = $.parseJSON(response);

			if(response.success){
				callback(response.members);
			}else{
				validation_error(response.validation);
			}
		});
	}

	function message_chunk(subject, message, thread, noemail, members, total){
		var data = {
			'action': 'chunk_send_messages',
			'subject': subject,
			'content': message,
			'thread': thread,
			'noemail': noemail,
			'members': members.splice(0, chunkAmount)
		};

		var done = total - members.length;
		var percentage = Math.round((done / total) * 100);

		progress.find('.information').text('Sending messages ('+done+'/'+total+')');
		progress.find('.progress-bar').css('width', percentage + '%');

		$.post(ajaxurl, data, function(response){
			response = $.parseJSON(response);

			if(response.success){

				if(members.length > 0){

					setTimeout(function(){
						message_chunk(subject, message, thread, noemail, members, total);
					}, breath);

				}else{

					send.prop('disabled', false);

					var plural = (thread && total > 1) ? 's' : '';
					var people = (total === 1) ? '1 person' : total + ' people';

					notice.html('<div id="message" class="bp-template-notice updated"><p>Message'+plural+' sent to '+people+'.</p></div>').show();
					form.show();
					progress.hide();

				}

			}else{

				send.prop('disabled', false);

				notice.html('<div id="message" class="bp-template-notice error"><p>An unknown error occured.</p></div>').show();
				form.show();
				progress.hide();
			}
		});
	}

	function get_data_for(members, groups, blogs, callback){
		if(groups.length > 0){
			var phpGroups = groups.splice(0, phpRequest);
			get_recipients('groups', phpGroups, function(newMembers){
				members = members.concat(newMembers);
				get_data_for(members, groups, blogs, callback);
			});
			return;
		}

		if(blogs.length > 0){
			var phpBlogs = blogs.splice(0, phpRequest);
			get_recipients('blogs', phpBlogs, function(newMembers){
				members = members.concat(newMembers);
				get_data_for(members, groups, blogs, callback);
			});
			return;
		}

		callback(members);
	}

	$('#mass_messaging_in_buddypress_checkboxes').on('change', 'input[type="checkbox"]', function(){
		var self = $(this);
		var allClass = 'mass_messaging_in_buddypress_select_all';
		var parent = self.parent();
		var otherChecks = parent.parent().children();
		var selectAll = otherChecks.filter('.'+allClass).children('input[type="checkbox"]');
		var checked = $(this).prop('checked');

		if(parent.hasClass(allClass)){
			otherChecks.children('input[type="checkbox"]').prop('checked', checked);
		}else{
			var mainChecks = otherChecks.not('.'+allClass);

			var total = mainChecks.length;
			var allChecked = 0;

			mainChecks.each(function(){
				var check = $(this);
				var is = check.children('input[type="checkbox"]').prop('checked');
				if(is){
					allChecked++;
				}else{
					return allChecked === 0;
				}
			});

			if(allChecked === total){
				selectAll.prop({
					indeterminate: false,
					checked: true
				});
			}else if(allChecked === 0){
				selectAll.prop({
					indeterminate: false,
					checked: false
				});
			}else{
				selectAll.prop({
					indeterminate: true,
					checked: false
				});
			}
		}
	});

	form = $('#send_message_form.mass_messaging_in_buddypress');
	if(form.length > 0){
		notice = $('#send_message_notice');
		send = form.find('#send');

		send.on('click', function(event){
			event.preventDefault();

			var subject = $('#subject').val(), content = $('#message_content').val();
			var validated = true, validation = [];

			if(subject === ""){
				validated = false;
				validation.push("No message subject");
			}

			if(content === ""){
				validated = false;
				validation.push("No message content");
			}

			if(validated){

				send.prop('disabled', true);

				notice.hide();
				form.hide();

				progress.html('<div class="information">Getting list of members</div><div class="progress"><div class="progress-bar" style="width: 0%"></div></div>').show();

				var members = [], groups = [], blogs = [];

				var membersList = $('#mass_messaging_in_buddypress_list_members');
				var groupList = $('#mass_messaging_in_buddypress_list_groups');
				var blogsList = $('#mass_messaging_in_buddypress_list_blogs');

				if(membersList.length > 0){
					var membersTicked = membersList.find('input:checked');
					members = membersTicked.map(function(){ return this.value !== "ignore" ? this.value : null; }).get();
				}

				if(groupList.length > 0){
					var groupsTicked = groupList.find('input:checked');
					groups = groupsTicked.map(function(){ return this.value !== "ignore" ? this.value : null; }).get();
				}

				if(blogsList.length > 0){
					var blogsTicked = blogsList.find('input:checked');
					blogs = blogsTicked.map(function(){ return this.value !== "ignore" ? this.value : null; }).get();
				}

				var thread = $('#thread').is(':checked');
				var noemail = $('#noemail').is(':checked');

				get_data_for(members, groups, blogs, function(members){
					if(members.length === 0){
						validation_error(["No users selected"]);
					}else if(members.length > chunkAmount && thread){
						validation_error(["Sending to more than " + chunkAmount + " members in a single thread is currently not supported"]);
					}else{
						form.find('#subject, #message_content').val('');
						form.find('input[type="checkbox"]').prop('checked', false);

						members = unique(members);
						message_chunk(subject, content, thread, noemail, members, members.length);
					}
				});
			}else{
				validation_error(validation);
			}

			$('body, html').scrollTop(notice.offset().top);
		});
	}

});
