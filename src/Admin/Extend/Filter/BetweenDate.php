<?php


namespace Kiwi\Core\Admin\Extend\Filter;


use Carbon\Carbon;
use Illuminate\Support\Arr;

trait BetweenDate
{
	public function condition($inputs)
	{
		if ($this->ignore) {
			return;
		}

		if (!Arr::has($inputs, $this->column)) {
			return;
		}

		$this->value = Arr::get($inputs, $this->column);

		$value = array_filter($this->value, function ($val) {
			return $val !== '';
		});

		if (empty($value)) {
			return;
		}

		if (isset($value['end'])) {
			$value['end'] = Carbon::parse($value['end'])->addDay()->subSecond()->toDateTimeString();
		}

		if (!isset($value['start'])) {
			return $this->buildCondition($this->column, '<=', $value['end']);
		}

		if (!isset($value['end'])) {
			return $this->buildCondition($this->column, '>=', $value['start']);
		}

		$this->query = 'whereBetween';

		$this->value['end'] = $value['end'];
		return $this->buildCondition($this->column, $this->value);
	}
}