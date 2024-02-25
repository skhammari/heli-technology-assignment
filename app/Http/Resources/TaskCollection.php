<?php

	namespace App\Http\Resources;

	use Illuminate\Http\Request;
	use Illuminate\Http\Resources\Json\ResourceCollection;

	class TaskCollection extends ResourceCollection
	{
		/**
		 * Transform the resource collection into an array.
		 *
		 * @return array<int|string, mixed>
		 */
		public function toArray(Request $request): array
		{
			return [
				'data' => $this->collection
			];
		}

		public function paginationInformation(Request $request, array $paginated, array $default)
		{
			$default['meta'] = [
				'current_page' => $paginated['current_page'],
				'from'         => $paginated['from'],
				'last_page'    => $paginated['last_page'],
				'per_page'     => $paginated['per_page'],
				'total'        => $paginated['total']
			];
			unset($default['links']);
			return $default;
		}
	}
