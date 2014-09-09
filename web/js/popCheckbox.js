(function($) {
$.fn.extend({
	popCheckbox : function(width, items, itemGenerator, chooseHandler) {
		var view = $('<div class="popCheckbox" style="width:' + width + 'px;border:1px solid rgb(211,211,211);background-color:white;zoom:1;overflow:auto;display:none;"></div>');
		this.click(function() {
			view.css('display') == 'none' ? view.show() : view.hide();
			return false;
		})
		var me = this;
		for (var i in items) {
			var item = items[i];
			var itemView = itemGenerator(item, i);
			itemView.click(function(){
				chooseHandler.call(me, me.items[this.getAttribute('index')]);
				me.view.hide();
			});
			view.append(itemView);
		};
		this.view = view;
		this.items = items;

		//layout
		this.parent().append(view);
		this.parent().css('position', 'relative');
		var x = this.position().left + this.width()/2 - this.view.width()/2;
		var y = this.position().top - this.view.height();
		this.view.css({position : 'absolute', left : x + 'px', top : y + 'px'});
	},
	checkboxFill : function(data) {
		var str = data;
		var d = this[0];
		if(document.selection){
			d.focus();
			var sel = document.selection.createRange();
			sel.text = str;
			d.focus();
		}else{
			if(d.selectionStart || d.selectionStart == "0") {
				var c = d.selectionStart;
				var b = d.selectionEnd;
				var e = b;
				d.value = d.value.substring(0,c) + str + d.value.substring(b, d.value.length);
				e += str.length;
				d.focus();
				d.selectionStart = e;
				d.selectionEnd = e;
			}else {
				d.value  += str;
				d.focus();
			}
		}	
	}
})
$(document.body).ready(function() {
	$(document.body).click(function(e) {
		var src = e.target ? e.target : e.srcElement;
		if ($(src).hasClass('popCheckbox')) {
			return true;
		}
		$('.popCheckbox').hide();
		return true;
	})	
})


})(jQuery)