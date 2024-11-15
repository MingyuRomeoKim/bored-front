@if(isset($pagination) && $pagination !== null)
    <div class="pagination-bar text-center">
        <ul class="pagination">
            @php
                $totalRecordCount = $pagination['totalRecordCount'];
                $totalPageCount = $pagination['totalPageCount'];
                $currentPageNo = $pagination['currentPageNo'];
                $firstPage = 1;
                $lastPage = $totalPageCount;
                $adjacent = 2; // 현재 페이지 주변에 표시할 페이지 수
                $start = $currentPageNo - $adjacent;
                $end = $currentPageNo + $adjacent;

                if($start < $firstPage) {
                    $end += $firstPage - $start;
                    $start = $firstPage;
                }

                if($end > $lastPage) {
                    $start -= $end - $lastPage;
                    $end = $lastPage;
                    if($start < $firstPage) {
                        $start = $firstPage;
                    }
                }
            @endphp

                    <!-- Previous Page Link -->
            @if($currentPageNo == 1)
                <li class="disabled"><span>&laquo;</span></li>
            @else
                <li><a href="?currentPageNo={{ $currentPageNo - 1 }}" rel="prev">&laquo;</a></li>
            @endif
            <!-- First Page Link -->
            @if($start > $firstPage)
                <li><a href="?currentPageNo={{ $firstPage }}">{{ $firstPage }}</a></li>
                @if($start > $firstPage + 1)
                    <li class="disabled"><span>...</span></li>
                @endif
            @endif

            <!-- Pagination Elements -->
            @for($i = $start; $i <= $end; $i++)
                @if($i == $currentPageNo)
                    <li class="active"><span>{{ $i }}</span></li>
                @else
                    <li><a href="?currentPageNo={{ $i }}">{{ $i }}</a></li>
                @endif
            @endfor

            <!-- Last Page Link -->
            @if($end < $lastPage)
                @if($end < $lastPage - 1)
                    <li class="disabled"><span>...</span></li>
                @endif
                <li><a href="?currentPageNo={{ $lastPage }}">{{ $lastPage }}</a></li>
            @endif

            <!-- Next Page Link -->
            @if($currentPageNo == $lastPage)
                <li class="disabled"><span>&raquo;</span></li>
            @else
                <li><a href="?currentPageNo={{ $currentPageNo + 1 }}" rel="next">&raquo;</a></li>
            @endif
        </ul>
    </div>

@endif