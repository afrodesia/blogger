<?php

class PostController extends BaseController{

	public function listPost()
	{
		$post = Post::orderBy('id', 'desc')->paginate(10);
		$this->layout->title = 'Post listings';
	}

}