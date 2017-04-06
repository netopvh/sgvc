@if ($breadcrumbs)
    <div class="page-header">
        <div class="breadcrumb-line breadcrumb-line-component">
            <ul class="breadcrumb">
                @foreach ($breadcrumbs as $breadcrumb)
                    @if (!$breadcrumb->last)
                        <li><a href="{{ $breadcrumb->url }}">
                                @if($breadcrumb->first)
                                    <i class="icon-home2 position-left"></i>
                                 @endif
                                 {{ $breadcrumb->title }}</a></li>
                    @else
                        <li class="active">{{ $breadcrumb->title }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
@endif