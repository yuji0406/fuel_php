<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.8
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2016 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Original extends Controller
{
	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */

	 public function action_mail()
	 {
f
		Package::load('email');


		 $email = Email::forge();

		 $email->from('uver_35@yahoo.co.jp', '川口勇次郎');

		 $email->to('ky19930305@gmail.com', 'ほんわか侍');

		 $email->subject('This is test mail');

		 $email->body('Hi! go to hell!!');


	 }

	 public function action_upload()
	 {
		// このアップロードのカスタム設定
		$config = array(
				'randomize' => true,
				'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
		);
		
		// $_FILES 内のアップロードされたファイルを処理する
		Upload::process($config);
		
		// 有効なファイルがある場合
		if (Upload::is_valid())
		{
				// 設定にしたがって保存する
				Upload::save();
		
				// モデルを呼び出してデータベースを更新する
				// Model_Uploads::add(Upload::get_files());
		}
		
		// エラーを処理する
		foreach (Upload::get_errors() as $file)
		{
				// $file はファイル情報の配列
				// $file['errors'] は発生したエラーの内容を含む配列で、
				// 配列の要素は 'error' と 'message' を含む配列
				foreach($file['errors'] as $error) {
					echo $error['message'];
																					 }	
		}
		 return View::forge('upload');
	 }

	 public function action_insert()
	 {
		 $result = DB::delete('friends')
		 ->where('id', '=', '3')
		 ->execute();
	 }

	public function action_index()
	{
		echo "original！";
		// return Response::forge(View::forge('welcome/index'));
	}

	public function action_form()
	{

		if(Input::post()){
			$val = Validation::forge();
			$val->add_field('last_name', '姓', 'required');
			$val->add_field('first_name', '名', 'required');
			$val->add_field('age', '年齢', 'numeric_between[18, 35]');
			$val->add_field('email', 'メールアドレス', 'required|valid_email');
			if($val->run()) {
				echo "成功！";
				exit;
			} else {
				foreach($val->error() as $key => $value ) {
					echo $value->get_message();
					echo'<br>';
				}
				exit;
			}
		}

		// DB::insert('friends')->set(array(
		// 	'first_name' => Input::post('first_name'),
		// 	'last_name' => Input::post('last_name'),
		// 	'age' => Input::post('age'),
		// 	'email' => Input::post('email')

		// ))->execute();
		return View::forge('form');
	}

	public function action_viewtest()
	{

		$data = array();
		$data['fruits'] = ['りんご',
											 'オレンジ',
											 'パイナップル',
											 '葡萄',
											 'もも',
											 'いちご'];
		return View::forge('content.twig', $data);
	}

	/**
	 * A typical "Hello, Bob!" type example.  This uses a Presenter to
	 * show how to use them.
	 *
	 * @access  public
	 * @return  Response
	 */

	public function action_hello()
	{
		return Response::forge(Presenter::forge('welcome/hello'));
	}

	/**
	 * The 404 action for the application.
	 *
	 * @access  public
	 * @return  Response
	 */

	public function action_404()
	{
		return Response::forge(Presenter::forge('welcome/404'), 404);
	}
}
