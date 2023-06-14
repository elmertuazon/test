<div class="card">
    <div class="card-header">
        Posts by month
    </div>
    <div class="card-body">
        <ul>
            @foreach($postsByMonth as $month)
                <li><a href="{{ route('home') }}?month={{ $month->post_year }}-{{ $month->post_month }}">{{ $month->post_month_name }} {{ $month->post_year }} ({{ $month->post_count }})</a></li>
            @endforeach
        </ul>
    </div>
</div>
