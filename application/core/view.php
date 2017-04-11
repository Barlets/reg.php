<?php
class View
{

	public $base_url = "http://reg.task"; //Меняем на свой локальный адрес

	function generate($content_view, $template_view, $data = NULL, $error = NULL)
	{

		include 'application/views/'.$template_view;
	}
}