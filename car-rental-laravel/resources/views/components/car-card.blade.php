@props(['car', 'offerPercent' => 0])

<div class="card h-100 shadow-sm hover-shadow">
    @if($car->image_path)
        <img src="{{ asset('storage/' . $car->image_path) }}"
             class="card-img-top"
             alt="{{ $car->name }}"
             loading="lazy">
    @else
        <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
            <i class="fas fa-car fa-3x text-white"></i>
        </div>
    @endif

    <div class="card-body d-flex flex-column">
        <h5 class="card-title">{{ $car->name }}</h5>
        <p class="text-muted small mb-2">{{ $car->year }}</p>

        {{-- Car specifications --}}
        <div class="mb-3">
            <span class="badge bg-light text-dark me-2">
                <i class="fas fa-users"></i> {{ $car->capacity }}
            </span>
            @if($car->doors)
                <span class="badge bg-light text-dark me-2">
                    <i class="fas fa-door-open"></i> {{ $car->doors }}
                </span>
            @endif
            @if($car->luggage)
                <span class="badge bg-light text-dark me-2">
                    <i class="fas fa-suitcase"></i> {{ $car->luggage }}
                </span>
            @endif
            <span class="badge bg-light text-dark">
                <i class="fas fa-cog"></i>
                {{ $car->transmission === 'automatic' ? __('Automatic') : __('Manual') }}
            </span>
        </div>

        {{-- Features --}}
        @if($car->features)
            <p class="card-text small text-muted mb-3">
                {{ Str::limit($car->features, 100) }}
            </p>
        @endif

        {{-- Pricing --}}
        <div class="mt-auto">
            <div class="d-flex align-items-center mb-3">
                @if($offerPercent > 0)
                    <span class="text-muted text-decoration-line-through me-2">
                        {{ number_format($car->daily_price, 2) }}
                    </span>
                    <strong class="text-success fs-4">
                        ${{ number_format($car->daily_price * (100 - $offerPercent) / 100, 2) }}
                    </strong>
                    <span class="badge bg-success ms-2">-{{ $offerPercent }}%</span>
                @else
                    <strong class="text-primary fs-4">${{ number_format($car->daily_price, 2) }}</strong>
                @endif
                <span class="ms-2 text-muted">/ {{ __('day') }}</span>
            </div>

            {{-- Stock availability --}}
            @if($car->stock > 0)
                <p class="small text-success mb-2">
                    <i class="fas fa-check-circle"></i>
                    {{ __('Available') }} ({{ $car->stock }} {{ __('in stock') }})
                </p>
            @else
                <p class="small text-danger mb-2">
                    <i class="fas fa-times-circle"></i> {{ __('Out of stock') }}
                </p>
            @endif

            {{-- Action buttons --}}
            <div class="d-grid gap-2">
                <a href="{{ route('fleet.show', $car) }}" class="btn btn-outline-primary">
                    <i class="fas fa-info-circle"></i> {{ __('Details') }}
                </a>
                @auth
                    @if($car->isAvailable())
                        <button type="button"
                                class="btn btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#reserveModal{{ $car->id }}">
                            <i class="fas fa-calendar-check"></i> {{ __('Reserve Now') }}
                        </button>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i> {{ __('Login to Reserve') }}
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

{{-- Reservation Modal (only show for authenticated users) --}}
@auth
    @if($car->isAvailable())
        <div class="modal fade" id="reserveModal{{ $car->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('orders.store') }}">
                        @csrf
                        <input type="hidden" name="car_id" value="{{ $car->id }}">

                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('Reserve') }} {{ $car->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Start Date') }}</label>
                                <input type="date"
                                       class="form-control"
                                       name="start_date"
                                       min="{{ date('Y-m-d') }}"
                                       required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('End Date') }}</label>
                                <input type="date"
                                       class="form-control"
                                       name="end_date"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('Pickup Location') }}</label>
                                <input type="text"
                                       class="form-control"
                                       name="pickup_location"
                                       maxlength="120"
                                       required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('Return Location') }}</label>
                                <input type="text"
                                       class="form-control"
                                       name="return_location"
                                       maxlength="120"
                                       required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('Notes') }} ({{ __('optional') }})</label>
                                <textarea class="form-control"
                                          name="notes"
                                          rows="3"
                                          maxlength="500"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                {{ __('Cancel') }}
                            </button>
                            <button type="submit" class="btn btn-primary">
                                {{ __('Confirm Reservation') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endauth
