<?php
function paginate($data, $total, $page, $limit)
{
  return [
    "data" => $data,
    "meta" => [
      "pagination" => [
        "total" => $total,
        "page" => $page,
        "limit" => $limit,
        "total_pages" => $limit > 0 ? ceil($total / $limit) : 1,
      ]
    ]
  ];
}
