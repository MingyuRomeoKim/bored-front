<?php

namespace App\Dtos\Requests;

use App\Traits\BuilderTrait;
use App\Traits\SingletonTrait;

class PageableDto
{
    use SingletonTrait, BuilderTrait;

    //@Schema(description = "페이지당 레코드 수", example = "15")
    public int $recordsPerPage;
    //@Schema(description = "현재 페이지 번호", example = "1")
    public int $currentPageNo;
    //@Schema(description = "페이지 개수", example = "10")
    public int $pageSize;
    //@Schema(description = "정렬", example = "payDate,desc")
    public string $sort;

    public function toArray(): array
    {
        return [
            'recordsPerPage' => $this->recordsPerPage,
            'currentPageNo' => $this->currentPageNo,
            'pageSize' => $this->pageSize,
            'sort' => $this->sort,
        ];
    }
}