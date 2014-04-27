<?php

class PostController extends BaseController{

	public function listPost()
	{
		$post = Post::orderBy('id', 'desc')->paginate(10);
		$this->layout->title = 'Post listings';
		$this->layout->main = View::make('dash')->nest('content', 'post.list', compact('post'));
	}

	public function showPost()
	{
		$comments = $post->comments()->where('approved', '=', 1)->get();
		$this->layout->title = $post->title;
		$this->layout->main = View::make('home')->nest('content', 'post.single', compact('post', 'comments'));
	}

	public function newPost()
	{
		$this->layout->title = 'New Post';
		$this->layout->main = View::make('dash')->nest('content', 'post.new');
	} 

	public function editPost(Post $post)
	{
		$this->layout->title = 'Edit Post';
		$this->layout->main = View::make('dash')->nest('content', 'post.edit', compact('post'));
	}

	public function deletePost(Post $post)
	{
		$post->delete();
		return Redirect::route('post.list')->with('sucess', 'Post is deleted!');
	}

	public function savePost()
	{
		$post = [
			'title' => Input::get('title'),
			'content' => Input::get('content'),
		];

		$rules = [
			'title' => 'required',
			'content' => 'required',
		];

		$valid = Validator::make($post, $rules);
		if($valid->passes())
		{
			$post = new Post($post);
			$post->comment_count = 0;
			$post->read_more = (strlen($post->content) > 120 ) ? substr($post->content, 0, 120) : $post->content;
			$post->save();
			return Redirect::to('admin/dash-board')->('success', 'Post is saved!');
		}
		else
			return Redirect::back()->withErrors($valid)->withInput();
	}

	public function updatePost(Post $post)
	{
		$data = [
			'title' => Input::get('title'),
			'content' => Input::get('content'),
		];
		$rules = [
			'title' => 'required',
			'content' => 'required',
		];

		$valid = Validator::make($data, $rules);
		if($valid->passes())
		{
			$post->title = $data['title'];
			$post->title = $data['content'];
			$post->coontent = 0;
			$post->read_more = (strlen($post->content) > 120 ) ? substr($post->content, 0, 120) : $post->content;
			

			if(count($post->getDirty()) > 0)
			{
				$post->save();
				return Redirect::back()->with('sucess', 'Post is updted');

			}
			else
				return Redirect::back()->with('sucess', 'Nothing to Update');
			
		}
		else
			return Redirect::back()->withErrors($valid)->withInput();
	}

}