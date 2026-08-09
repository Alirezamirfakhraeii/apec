{{-- Ranks tab --}}
<div class="tab-pane fade"
     id="ranks-panel-{{ $company->id }}"
     role="tabpanel"
     aria-labelledby="ranks-tab-{{ $company->id }}">

    @if($visibleRankGroups->isNotEmpty())
        <div class="company-ranks-help">
            <i class="fa fa-info-circle"></i>
            <span>
                فقط رشته‌هایی نمایش داده می‌شوند که برای این شرکت رتبه معتبر ثبت شده باشد.
            </span>
        </div>

        <div class="accordion company-ranks-accordion"
             id="companyRanksAccordion{{ $company->id }}">

            @foreach($visibleRankGroups as $groupIndex => $rankGroup)
                <div class="accordion-item company-rank-group">
                    <h2 class="accordion-header"
                        id="rankHeading{{ $company->id }}{{ $groupIndex }}">

                        <button class="accordion-button {{ $groupIndex !== 0 ? 'collapsed' : '' }}"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#rankCollapse{{ $company->id }}{{ $groupIndex }}"
                                aria-expanded="{{ $groupIndex === 0 ? 'true' : 'false' }}">

                            <span class="company-rank-group-icon">
                                <i class="fa {{ $rankGroup['icon'] }}"></i>
                            </span>

                            <span class="company-rank-group-heading">
                                <strong>{{ $rankGroup['title'] }}</strong>
                                <small>{{ $rankGroup['description'] }}</small>
                            </span>

                            <span class="company-rank-group-count">
                                {{ count($rankGroup['items']) }} رتبه
                            </span>
                        </button>
                    </h2>

                    <div id="rankCollapse{{ $company->id }}{{ $groupIndex }}"
                         class="accordion-collapse collapse {{ $groupIndex === 0 ? 'show' : '' }}"
                         data-bs-parent="#companyRanksAccordion{{ $company->id }}">

                        <div class="accordion-body">
                            <div class="company-rank-list">
                                @foreach($rankGroup['items'] as $rankItem)
                                    <div class="company-rank-item has-rank">
                                        <div class="company-rank-content">
                                            <strong class="company-rank-title">
                                                {{ $rankItem['title'] }}
                                            </strong>

                                            @if($rankItem['description'])
                                                <div class="company-rank-description">
                                                    {{ $rankItem['description'] }}
                                                </div>
                                            @endif
                                        </div>

                                        <div class="company-rank-result">
                                            <span class="company-rank-badge has-value">
                                                <i class="fa fa-award"></i>
                                                رتبه {{ $rankItem['rank'] }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="company-section-empty company-ranks-empty">
            <i class="fa fa-award"></i>
            <span>رتبه یا صلاحیتی برای این شرکت ثبت نشده است.</span>
        </div>
    @endif
</div>
