jQuery(document).ready(function($) {
	$(document).delegate('form[name^="unisender_"]', 'submit', function() {
		var $form = $(this);
		$form.find('input[type=submit]').attr('disabled', 'disabled');
		$form.find('img').show();
		$.post(self.location, $(this).serialize(), function(response) {
			if (getValueOrFalse(response.redirectUrl) != false) {
				if (getValueOrFalse(response.message) != false) {
					alert(response.message);
				}
				self.location = response.redirectUrl;
				return false;
			}

			var noticeClass = 'updated';
			if (response.status == 'error') {
				noticeClass = 'error';
			}

			$form.find('div.notice').remove();
			$form.find('h3').append('<div class="notice ' + noticeClass + '"><p>' + response.message + '</p></div>');

			$form.find('input[type=submit]').removeAttr('disabled');
			$form.find('img').hide();
			return false;
		}, 'json');

		return false;
	});

	$(document).delegate('.unisender-standard-fields a', 'click', function() {
		$('#connect').val($(this).text());
		return false;
	});
});

function unisenderSync() {
	jQuery.post(location.protocol + '//' + location.host + location.pathname, { action: 'unisender_sync' }, function(response) {
		if (response.status == 'success') {
			alert(response.message);
			self.location.reload();
			return false;
		}

		jQuery.find('.unisenderSyncBlock div.notice').remove();
		jQuery.find('.unisenderSyncBlock').append('<div class="notice error"><p>' + response.message + '</p></div>');
		return false;
	}, 'json');
	return false;
}

function actionDelete(id, requestUrl) {
	if (confirm(unisenderJsTrans.deleteQuestion + ' #' + id + '?')) {
		jQuery.post(requestUrl, {action: 'unisender_delete'}, function(response) {
			if (getValueOrFalse(response.redirectUrl) != false) {
				alert(response.message);
				self.location = response.redirectUrl;
				return false;
			}
			if (response.status == 'error') {
				noticeClass = 'error';
			}

			alert(response.message);
			return false;
		}, 'json');
	}
	return false;
}

function actionDefault(id, requestUrl) {
	if (confirm(unisenderJsTrans.defaultQuestion + id + '?')) {
		jQuery.post(requestUrl, {action: 'unisender_default'}, function(response) {
			if (getValueOrFalse(response.redirectUrl) != false) {
				alert(response.message);
				self.location = response.redirectUrl;
				return false;
			}
			if (response.status == 'error') {
				noticeClass = 'error';
			}

			$form.find('div.notice').remove();
			$form.find('h3').append('<div class="notice ' + noticeClass + '"><p>' + response.message + '</p></div>');
			return false;
		}, 'json');
	}
	return false;
}

function getValueOrFalse(value)
{
	if (typeof(value) == 'undefined' || value == 'false') {
		return false;
	}
	return value;
}



//DnD
var dragSrcEl = null;

function handleDragStart(e) {
	this.style.opacity = '0.4';
console.log(this.innerHTML);
	dragSrcEl = this;
	e.dataTransfer.effectAllowed = 'move';
	e.dataTransfer.setData('text/html', this.innerHTML);
}

function handleDragOver(e) {
	if (e.preventDefault) {
		e.preventDefault();
	}

	e.dataTransfer.dropEffect = 'move';

	return false;
}

function handleDragEnter(e) {
	this.classList.add('over');
}

function handleDragLeave(e) {
	this.style.opacity = '1';
	this.classList.remove('over');
}

function handleDrop(e) {
	if (e.stopPropagation) {
		e.stopPropagation();
	}
console.log(dragSrcEl.innerHTML);
	if (dragSrcEl != this) {
		dragSrcEl.innerHTML = this.innerHTML;
		this.innerHTML = e.dataTransfer.getData('text/html');
	}

	return false;
}

function handleDragEnd(e) {
	this.style.opacity = '1';
	[].forEach.call(cols, function (col) {
		col.classList.remove('over');
	});
}

var cols = document.querySelectorAll('#columns .column');
[].forEach.call(cols, function(col) {
	col.addEventListener('dragstart', handleDragStart, false);
	col.addEventListener('dragenter', handleDragEnter, false);
	col.addEventListener('dragover', handleDragOver, false);
	col.addEventListener('dragleave', handleDragLeave, false);
	col.addEventListener('drop', handleDrop, false);
	col.addEventListener('dragend', handleDragEnd, false);
});