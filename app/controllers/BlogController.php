<?php

class BlogController extends BaseController {


	public function __construct()
	{
		// updated: prevents re-login
		$this->beforeFilter('guest',['only' => ['getLogin']]);
		$this->beforeFilter('auth',['only' => ['getLogout']]);
	}

	public function getIndex()
	{
		$posts = Post::orderBy('id', 'desc')->paginate(10);
		$posts->getEnvironment()->setViewname('pagination::simple');

		$this->layout->title = 'Home Page | Blogger';
		$this->layout->main = View::make('home')->nest('content', 'index', compact('posts'));
	}

	public function getSearch()
	{
		$searchTerm = Input::get('s');
		$posts = Post::whereRaw('match(title,content) against(? in boolean mode', [$searchTerm])->paginate(10);
		$post->getEnvironment()->setViewName('pagination::slider');
		$post->appends(['s'=>$searchTerm]);

		$this->layout->with('title', 'Search: '.$searchTerm);
		$this->layout->main = View::main('home')->nest('content','index',($posts->isEmpty()) ? ['notFound' => true ] : compact('posts'));	
	}

	public function postLogin()
	{
		$credentials = [
			'username' => Input::get('username'),
			'password' => Input::get('password')

		];
		$rules = [
			'username' => 'required',
			'password' => 'required'

		];
		$validator = Validator::make($credentials, $rules);
		if($validator->passes())
		{
			if(Auth::attempt($credentials))
				return Redirect::to('admin/dash-board');
			return Redirect::back()->withErrord($validator)->withInputs()->with('failure', 'username or password invalid');
		}
		else
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
	}

	public function getLogout()
	{
		Auth::logout();
		return Redirect::to('/');
	}
}