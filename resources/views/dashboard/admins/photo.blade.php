<div class="symbol-label fs-3 rounded-circle p-3 bg-light d-flex justify-content-center align-items-center aspect-ratio aspect-ratio-1x1">
    {{ substr(Auth::guard('admin')->user()->name, 0, 1) }}
</div>
