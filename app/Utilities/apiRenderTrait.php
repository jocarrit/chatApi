<?php
namespace App\Utilities;

trait apiRenderTrait
{
	public function render($value)
	{
		if ($this->hasPagination($value)) {
			collect(['data' => $value->items(), 'meta' => ['pagination' => '']]);
		}
		collect(['data' => $value->items(), 'meta' => ['pagination' => '']]);
	}

	private function getPaginationOptions($value)
	{
		return collect([
                'current_page' => $value->currentPage(),
                'per_page' => $value->perPage(),
                'page_count' => $value->count(),
                'total_count' => $value->total(),
                ]);
	}

	/**
	 * determines if data is paginated
	 * @param  collection $data 
	 * @return boolean       
	 */
	private function hasPagination($data)
	{
		if ($data instanceof Iluminate\Pagination\LenghtAwarePaginator) {
			return true;
		}

		return false;
	}

}  