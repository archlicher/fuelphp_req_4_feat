<?php
class Controller_Example extends Controller_Hybrid
{
	public function action_index()
	{
		$data['example'] = \Services\Examples::action_index();

		$this->template->title = "Examples";
		$this->template->content = View::forge('examples/index', $data);
	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('examples');

		$data = \Services\Examples::action_view($id);

		if ( ! $data)
		{
			Session::set_flash('error', 'Could not find example #'.$id);
			Response::redirect('examples');
		}

		$this->template->title = "Examples";
		$this->template->content = View::forge('examples/view', $data);
	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Example::validate('create');

			if ($val->run())
			{
				$example_field_1 =\Input::post('example_field_1');
				$example_field_2 =\Input::post('example_field_2');

				if ($example = \Services\Examples::action_create($example_field_1, $example_field_2))
				{
					Session::set_flash('success', 'Added example #'.$example->id.'.');
					Response::redirect('examples/view/'.$example->id);
				}

				else
				{
					Session::set_flash('error', 'Could not save example.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Examples";
		$this->template->content = View::forge('examples/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('examples');

		if ( ! $example = \Services\Examples::action_view($id)['example'])
		{
			Session::set_flash('error', 'Could not find example #'.$id);
			Response::redirect('examples');
		}

		$val = Model_Example::validate('edit');

		if ($val->run())
		{
			$example_field_1 =\Input::post('example_field_1');
			$example_field_2 =\Input::post('example_field_2');

			if (\Services\Examples::action_edit($example, $example_field_1, $example_field_2) !== false)
			{
				Session::set_flash('success', 'Updated example #' . $id);
				Response::redirect('examples/view/'.$id);
			}

			else
			{
				Session::set_flash('error', 'Could not update example #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$example_field_1 =\Input::post('example_field_1');
				$example_field_2 =\Input::post('example_field_2');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('example', $example, false);
		}

		$this->template->title = "Examples";
		$this->template->content = View::forge('examples/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('examples');

		if ( ! $example = \Services\Examples::action_view($id)['example'])
		{
			Session::set_flash('error', 'Could not find example #'.$id);
			Response::redirect('examples');
		}

		if (\Services\Examples::action_delete($example))
		{
			Session::set_flash('success', 'Deleted example #'.$id);
		}
		else
		{
			Session::set_flash('error', 'Could not delete example #'.$id);
		}

		Response::redirect('examples');
	}
}