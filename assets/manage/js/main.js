//define define(id?, deps?, factory)

//define 也可以接受两个以上参数。字符串 id 表示模块标识，数组 deps 是模块依赖。
//define('../js/main', ['jquery'], function(require, exports, module)
define(function(require, exports, module)
{
	// 通过 require 引入依赖
	//var $ = require('jquery');
	//var Spinning = require('./spinning');

	$(document).ready(function()
	{
		edit();
		del();
		checkbox();
	});
	
	/**
	 *  处理多选问题，处理全选按钮
	 */
	function checkbox()
	{
		var name = 'checkbox-checkall';
		var checkbox = $("." + name);
		if(checkbox.length)
		{
			checkbox.click(function()
			{
				var self = $(this);
				$("." + name + "-" + $(this).val()).each(function()
				{
					$(this).get(0).checked = self.get(0).checked;
				})
			});

			checkbox.each(function()
			{
				var self = $(this);
				$("." + name + "-" + $(this).val()).each(function()
				{
					if($(this).get(0).checked == true)
					{
						self.get(0).checked = true;
					}
				})
			})
		}
	}
	
	/**
	 *  处理双击编辑
	 */
	function edit()
	{
		if($(".edit").length)
		{
			$(".edit").each(function()
			{
				$(this).bind('dblclick', function()
				{
					var url = $(this).attr('data-url');
					var html = $(this).attr('data-content');
					var type = $(this).attr('data-type');
					if($(this).find(".edit-content").length)
					{
						html = $(this).find(".edit-content").html();
						html = html.replace('<!--', '<');
						html = html.replace('-->', '>');
					}
					
					if(html.indexOf('input') == -1)
					{
						if(type && type == 'textarea')
						{
							$(this).html('<textarea type="text" name="edit" id="edit" rows="20" cols="80">'+html+'</textarea>');
						}
						else
						{
							$(this).html('<input type="text" name="edit" id="edit" value="'+html+'">');
						}
						var self = $(this);
						$("#edit").blur(function()
						{
							var value = $("#edit").val();
							if(!value)
							{
								alert('不能为空');
								return;
							}
							
							if($(this).find(".edit-content").length)
							{
								$(this).find(".edit-content").html(value);
							}
							else
							{
								self.attr('data-content', value);
							}
							
							if(!type)
							{
								self.html(value);
							}
							$.post(url, {value:value}, function(t)
							{
								if(type && type == 'textarea')
								{
									self.html(t);
								}
							})
						})
					}
				});
			})
		}
	}

	function del()
	{
		if($(".oper_6").length)
		{
			$(".oper_6").each(function()
			{
				var href = $(this).attr('href');

				$(this).attr('href', '#');

				$(this).unbind('click');
			
				$(this).bind('click', function()
				{
					del_act(href);
				});
			})
		}
	}
	
	/**
	 *  处理删除
	 */
	function del_act(href)
	{
		if(confirm('确定进行此项操作吗？'))
		{
			$.getJSON(href, {}, function(t)
			{
				msg(t);
			})
		}
	}
	
	/*
	var test = 
	{
		refreshPage: false,
		addAjaxFlag: true,
		//添加收藏
		add: function(cfg)
		{
		}
	}
	*/
	
	// 通过 exports 对外提供接口
	//exports.init = init;
	// 或者通过 module.exports 提供整个接口
	//module.exports = test
});
