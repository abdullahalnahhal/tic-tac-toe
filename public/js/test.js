/** 
* These function has the configuered variables and methods
* @constructor
*/
Configs = function()
{
	// initiate command class to call cross the window Class using text 
	window.command = new Command();
	this.orders = {
		"add" : "create",
		"update" : "update",
		"remove" : "confirm",
		"readAll" : "list",
		"read" : "details",
	}
	// base url to send http requests
	this.base_url = "http://localhost/crud/public";
	// url that stores the storage files
	this.storage_url = "http://localhost/crud/public/storage";
}
/**
* Create commands of CRUD
* @constructor
*/
Command = function()
{
	
	/**
	* Make a creation command
	* @param {DOM Object} element the HTML element that has the command
	*/
	this.create = function(element)
	{
		// initial the action as create
		Action = "C";
		// validate forms
		validate = forms.validate();
		// if validated
		if (validate) {
			// get all input values
			form = forms.getAll();
			// create url to create
			url = configs.base_url+"/create";
			// send create request
			server.call("POST", url, form, function(data)
				{
					// if the flag is true
					data = JSON.parse(data);
					if (isset(data.flag) && data.flag == 1) {
						// creation is success
						actions.success(data.message);
						// add the created item
						Items[data.items.id] = data.items;
					}
				}, function(){}, 
				function()
				{
					// waiting
					actions.waiting(element);
				}, function()
				{
					// completed
					actions.completed();
					// refresh and reload items from items object
					actions.loadItems();
				});
		}
	}
	/**
	* Make a delete command
	* @param {DOM Object} element the HTML element that has the command
	*/
	this.delete = function(element)
	{
		// check if the user realy want to delete item
		delete_check = confirm("Do You Realy Want To Delete This");
		if (delete_check) {
			// initiate the form
			form = new FormData;
			// get the id
			if (isset(element.attr("delete"))) {
				id = element.attr("delete");
			}else{
				id = $(element).attr("delete");
			}
			// append the id to the form
			form.append("id",id);



			// send delete request
			server.call("post","delete",form,function(data)
				{
					data = JSON.parse(data);
					id = data.items.id;
					if (isset(data.flag) && data.flag == 1) {
						actions.success(data.message);
						delete Items[data.items.id];
						actions.delete(id);
					}
				},function(){},function(){},function(data)
				{
					actions.loadItems()
				});
		}
	}
	/**
	* Make a view command
	* @param {DOM Object} element the HTML element that has the command
	*/
	this.view = function(element)
	{
		actions.view(element);
	}
	/**
	* Make a cancel command
	* @param {DOM Object} element the HTML element that has the command
	*/
	this.cancel = function(element)
	{
		actions.cancel();
	}
	/**
	* Make a update command
	* @param {DOM Object} element the HTML element that has the command
	*/
	this.update = function(element)
	{
		// initiate action to update
		Action = "U";
		id = element.attr('update');
		// validate form
		validate = forms.validate();
		if (validate) {
			// get the form
			form = forms.getAll();
			form.append("id", id);
			url = configs.base_url+"/update";



			server.call("POST", url, form, function(data)
				{
					data = JSON.parse(data);
					// if respond is correct
					if (isset(data.flag) && data.flag == 1) {
						// success
						actions.success(data.message);
						// update object
						Items[data.items.id].title = data.items.title;
						Items[data.items.id].category = data.items.category;
						Items[data.items.id].image = data.items.image;
					}
				}, function(){}, 
				function()
				{
					actions.waiting(element);
				}, function()
				{
					// cancel update view
					actions.cancel();
					actions.completed();
					// reload and refresh items using items object
					actions.loadItems();
				});
		}
	}
}
/**
* Forms Processes
* @constructor
*/
Forms = function()
{
	// if the element is focused in 
	$(".form-input").focusin(function(event) {
		// remove error heighlights 
		actions.removeErrors();
	});
	/**
	* validate form
	*/
	this.validate = function()
	{
		validate = true;
		// loop through inputs
		$(".form-input").each(function(index, el) {
			is_required = $(el).prop('required');
			type = $(el).attr('type');
			value = $(el).val();
			// if the input is required 
			if (is_required) {
				// if the value is empty in creation or empty and not file input in update
				if ((value =="" && Action == "C") || (value =="" && Action == "U" && type != "file")) {
					// not validated
					validate = false;
					// heighlight empty fields
					$(el).addClass("input-alert");
				}
			}
		});
		return validate;
	}
	/**
	* get all form inputss
	*/
	this.getAll = function()
	{

		cat = JSON.stringify(sec.encrypt($("#category").val())) ;
		title = JSON.stringify(sec.encrypt($("#title").val())) ;
		file = $("#img")[0].files[0];
		form = new FormData($("form")[0]);
		form.append('category', cat);
		form.append('title', title);
		form.append('img', file);
		return form;
	}
}
/**
* Make server requests
* @constructor
*/
Server = function()
{
	/**
	* Call to server
	* @param {string} type the request method post or get
	* @param {string} url to call and send requests
	* @param {Object} data to send through http
	* @param {callback} success to call when request is success
	* @param {callback} failuer to call when request is failuer
	* @param {callback} waiting to call when request is waiting
	* @param {callback} completed to call when request is completed
	*/
	this.call = function(type, url, data, success, failuer, waiting, completed)
	{
		waiting();
		$.ajax({
				url: url,
				type: type,
				data: data,
				async: false,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function (data) 
				{
					success(data);
				},
				error: function(xhr, error)
				{
			        failuer(xhr, error);
			 	},
			 	complete: function()
			 	{
			 		completed();
			 	}
			});
	}
}
/**
* Make actions when do commands
* @constructor
*/
Actions = function()
{
	/**
	* Action of waiting respoding of command
	* @param {DOM Object} element will do the action into it
	*/
	this.waiting = function(element)
	{
		element.append(template.waiting);
	}
	/**
	* Action of waiting respoding of command
	* @param {string} message message that will appear in success
	*/
	this.success = function(message)
	{
		alert = template.success(message);
		$("html").append(alert);
	}
	/**
	* Action of completed request
	*/
	this.completed = function(){
		$(".fa-spin").hide();
		$(".alert").fadeOut(2000);
		$(".form-input").val("");
	}
	/**
	* Action that load all elements in the Items object
	*/
	this.loadItems = function () {
		html_items ="";
		// loop through items
		for (element in Items) {
			// get the element
			item = Items[element];
			// get the template 
			item_template = template.item(item);
			// concat all items templates
			html_items += item_template;
		}
		// replace old items
		$("#item-group").html(html_items);
	}
	/**
	* Action that will delete specefic item
	* @param {integer} id the id of the element want to be deleted
	*/
	this.delete = function(id)
	{
		$("#item-"+id).hide();
	}
	/**
	* Action that view the item
	* @param {DOM Object} element the element that will do the view
	*/
	this.view = function(element)
	{
		// remove all error heighlight
		actions.removeErrors();
		id = element.attr("view");
		item = Items[id];
		// replace form inputs
		$("#title").val(item.title);
		$("#category").val(item.category);
		// show update view
		$(".visible").hide("slow",function()
		{
			$(".update").show("slow");
			$(".update").attr("update",id);
			$(".update").removeClass("invisible");
		});
	}
	/**
	* Action that cancel update view
	*/
	this.cancel = function()
	{
		$(".update").hide("slow",function()
		{
			$(".form-input").val("");
			$(".visible").show("slow");
		});
		actions.removeErrors();
	}
	this.removeErrors = function()
	{
		$(".form-input").removeClass('input-alert');
	}
}
/**
* all needed template
* @constructor
*/
Template = function()
{
	// waiting template
	this.waiting = "<i class='fa fa-spinner fa-spin' ></i>";
	/**
	* success alert template
	* @param {String} message message that will appear
	*/
	this.success = function(message)
	{
		return "<div class='alert alert-success col col-lg-4 col-md-4 col-sm-4 col-xs-4'><h4 class='alert-heading'> <i class='fa fa-check-square-o'></i> "+message+"</h4></div>";
	}
	/**
	* item template
	* @param {Object} item represents the item information
	*/
	this.item = function(item)
	{
		// if there is error dont parse result and use it as it is
		try {
			item.title = JSON.parse(item.title);
			item.title = sec.decrypt(item.title.cipher, item.title.pek);
		} catch(e) {
			item.title = item.title;
		}
		try {
			item.category = JSON.parse(item.category);
			item.category = sec.decrypt(item.category.cipher, item.category.pek);
		} catch(e) {
			item.category = item.category;
		}
				
		return"<div class=\"row item\" id=\"item-"+item.id+"\" item=\""+item.id+"\" dir=\"rtl\" style=\"background: yellow\">"+
				"<div class=\"col col-lg-3 middle-height title \" align=\"center\">"+
                    item.title + 
                "</div>"+
                "<div class=\"col col-lg-3 middle-height category\" align=\"center\">"+
                    item.category +
                "</div>"+
                "<div class=\"col col-lg-3 img\" align=\"center\">"+
                    "<img class=\"img-responsive img-thumbnail\" src=\""+item.image+"\" alt=\"\">"+
                "</div>"+
                "<div class=\"col col-lg-3 middle-height\" align=\"center\">"+
                    "<i delete=\""+item.id+"\" onclick=\"command.delete($(this))\" command=\"delete\" class=\"command-btn fa fa-window-close-o item-control\" ></i> "+
                    "<i view=\""+item.id+"\" onclick=\"command.view($(this))\" command=\"view\" class=\"command-btn fa fa-eye item-control\"></i>"+
                "</div>"+
               "</div>";
	}
}
/**
* all needed template
* @param {String} class_name the constructor name that will be called
* @param {String} function_name the function that wil be executed
* @param {Mixed} param parameters sent to these function
* @constructor
*/
call = function(class_name , function_name , param)
{
	window[class_name][function_name](param) ;
}
/**
* check if the value is undefiend
* @param {String} value the value to check
*/
isset = function(value)
{
	if (typeof value === "undefined") {
		return false;
	}
	return true;
}
isString = function(string)
{
	if (typeof string === "string") {
		return true;
	}
	return false;
}
/**
*
*
*
*/
Sec = function () {}
sec = new Sec();
configs = new Configs();
forms = new Forms();
server = new Server();
actions = new Actions();
template = new Template();
var Items = {};
var Action = "";