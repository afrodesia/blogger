<?php

class PostController extends BaseController{

	public function listPost()
	{
		$post = Post::orderBy('id', 'desc')->paginate(10);
		$this->layout->title = 'Post listings';
		$this->layout->main = View::make('dash')->nest('content', 'post.list', compact('post'));
	}

	public funtion showPost()
	{
		$comments = $post->comments()->where('approved', '=', 1)->get();
		$this->layout->title = $post->title;
		$this->layout->main = View::make('home')->nest('content', 'post.single', compact('post', 'comments'));
	}

}