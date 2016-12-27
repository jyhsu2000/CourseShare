@if($public)
    <i class="fa fa-globe fa-fw" aria-hidden="true" title="公開"></i>
@else
    <i class="fa fa-lock fa-fw" aria-hidden="true" title="私人"></i>
@endif
{{ $name }}
