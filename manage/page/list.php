<?php

$page->html
(
	# 定义父节点的类型、属性等（整个page的节点）
	array('ul', 'class="am-pagination"'), 
	# 定义子节点的类型、属性等（每个page的节点）
	array('li', 'class=""'), 
	# 定义上一页的名称、样式
	array('上一页', 'btn p1'), 
	# 定义下一页的名称、样式
	array('下一页', 'btn p2'), 
	# 定义每个页数的样式，当前页的样式 样式写在哪
	array('', 'am-disabled', 'parent'),
	# 定义首页的名称、样式，为空则不显示
	array('首页', ''),
	# 定义末页的名称、样式，为空则不显示
	array('末页', '')
);
