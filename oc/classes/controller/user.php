<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * 
 * Display user profile
 * @throws HTTP_Exception_404
 */
class Controller_User extends Controller {
		
	public function action_index()
	{
		$seoname = $this->request->param('seoname',NULL);
		if ($seoname!==NULL)
		{
			$user = new Model_User();
			$user->where('seoname','=', $seoname)
				 ->limit(1)->cached()->find();
			
			if ($user->loaded())
			{
				$this->template->title = $user->name;
				
				//$this->template->meta_description = $user->name;//@todo phpseo
				
				$this->template->bind('content', $content);

				$ads = new Model_Ad();
				$ads = $ads->where('id_user', '=', $user->id_user)->order_by('created','desc')->cached()->find_all();
				
				$category = new Model_Category();
				$category = $category->find_all();
				
				// case when user dont have any ads
				if($ads->count() == 0) $profile_ads = NULL;

				$this->template->content = View::factory('pages/userprofile',array('user'=>$user, 'profile_ads'=>$ads));
			}
			//not found in DB
			else
			{
				//throw 404
				throw new HTTP_Exception_404();
			}
			
		}
		else//this will never happen
		{
			//throw 404
			throw new HTTP_Exception_404();
		}
	}

	
}// End Userprofile Controller

