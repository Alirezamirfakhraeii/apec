{{-- Activities tab --}}
<div class="tab-pane fade"
     id="activities-panel-{{ $company->id }}"
     role="tabpanel"
     aria-labelledby="activities-tab-{{ $company->id }}">

    <div class="company-activity-help">
        <span class="company-activity-help-item selected">
            <i class="fa fa-check"></i>
            انتخاب‌شده برای شرکت
        </span>

        <span class="company-activity-help-item unselected">
            <i class="fa fa-minus"></i>
            انتخاب نشده
        </span>
    </div>

    <div class="company-activity-groups">
        @foreach($modalActivitySections as $sectionKey => $sectionInfo)
            @php
                $sectionFields = collect(
                    $activityFields->get($sectionKey, collect())
                )->sortBy('sort_order');
            @endphp

            <section class="company-activity-group">
                <div class="company-activity-group-header">
                    <span class="company-activity-group-icon">
                        <i class="fa {{ $sectionInfo['icon'] }}"></i>
                    </span>

                    <div>
                        <h5>{{ $sectionInfo['title'] }}</h5>
                        <p>
                            تمام گزینه‌های تعریف‌شده این بخش نمایش داده شده‌اند.
                        </p>
                    </div>
                </div>

                <div class="company-activity-options-display">
                    @forelse($sectionFields as $activityField)
                        @php
                            $isSelected = in_array(
                                (int) $activityField->id,
                                $companyActivityIds,
                                true
                            );
                        @endphp

                        <div class="company-activity-display-item {{ $isSelected ? 'is-selected' : 'is-unselected' }}">
                            <span class="company-activity-state-icon">
                                <i class="fa {{ $isSelected ? 'fa-check' : 'fa-minus' }}"></i>
                            </span>

                            <span>{{ $activityField->title }}</span>
                        </div>
                    @empty
                        <div class="company-section-empty">
                            گزینه‌ای برای این بخش تعریف نشده است.
                        </div>
                    @endforelse
                </div>
            </section>
        @endforeach
    </div>
</div>
