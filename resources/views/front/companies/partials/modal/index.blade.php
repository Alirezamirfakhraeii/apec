@php
    extract(\App\Support\CompanyModalData::make($company));
@endphp

<div class="modal fade company-modal"
     id="companyModal{{ $company->id }}"
     tabindex="-1"
     aria-labelledby="companyModalLabel{{ $company->id }}"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            @include('front.companies.partials.modal.header')

            @include('front.companies.partials.modal.navigation')

            <div class="modal-body company-modal-body">
                <div class="tab-content" id="companyTabsContent{{ $company->id }}">

                    @include('front.companies.partials.modal.tabs.identity')

                    @include('front.companies.partials.modal.tabs.ranks')

                    @include('front.companies.partials.modal.tabs.activities')

                    @include('front.companies.partials.modal.tabs.projects')

                    @include('front.companies.partials.modal.tabs.contact')

                </div>
            </div>

            @include('front.companies.partials.modal.footer')

        </div>
    </div>
</div>
