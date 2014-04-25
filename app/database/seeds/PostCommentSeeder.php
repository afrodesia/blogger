<?php

class PostCommentSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$content = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. ';

		for($i = 1; $i <= 20; $i++ )
		{
			$post = new Post;
			$post->title = "Post no $i";
			$post->read_more = substr($content, 0, 120);
			$post->content = $content;
			$post->save();

			$maxComments = mt_rand(3,15);
			for($j = 1; $j <= $maxComments; $j++)
			{
				$comment = new Comment;
				$comment->commenter = 'xyz';
				$comment->comment = substr($content, 0, 120);
				$comment->email = 'xyz@xmail.com';
				$comment->approved = 1;
				$post->comments()->save($comment);
				$post->increment('comment_count');
			}
		}
	}  
}