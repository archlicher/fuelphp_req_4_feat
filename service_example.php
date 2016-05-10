<?php

namespace Services;

class Examples
{
	public static function action_index()
	{
		$examples = \DB::select()->from('examples');

		return $examples;
	}

	public static function action_view($id)
	{
		$example = \Model_Example::find($id);

		if ( ! $example)
		{
			return false;
		}

		$data['example'] = $example;

		return $data;
	}

	public static function action_create($example_field_1, $example_field_2)
	{
		$example = \Model_Example::forge(array(
			'example_field_1' => $example_field_1,
			'example_field_2' => $example_field_2,
		));

		if ($example and $example->save())
		{
			return $example;
		}
		else
		{
			return false;
		}
	}

	public static function action_edit($example, $example_field_1, $example_field_2)
	{
		$example->example_field_1 = $example_field_1;
		$example->example_field_2 = $example_field_2;

		if ($example->save())
		{
			return $example;
		}
		else
		{
			return false;
		}
	}

	public static function action_delete($example = null)
	{
		if ($example->delete())
		{
			return true;
		}

		return false;
	}
}