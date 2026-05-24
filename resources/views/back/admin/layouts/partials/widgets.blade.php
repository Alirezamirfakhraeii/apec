<!-- ردیف کارت‌های آمار کلیدی -->
<div class="row row-sm">

    <!-- کارت اول: سفارشات امروز -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-primary-gradient">
            <div class="ps-3 pt-3 pe-3 pb-2">
                <div>
                    <h6 class="mb-3 tx-12 text-white">سفارشات امروز</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div>
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                {{ isset($todayOrdersAmount) ? number_format($todayOrdersAmount) . ' تومان' : '۰' }}
                            </h4>
                            <p class="mb-0 tx-12 text-white op-7">در مقایسه با هفته گذشته</p>
                        </div>
                        <span class="float-right my-auto ms-auto">
                            <i class="fas fa-arrow-circle-up text-white"></i>
                            <span class="text-white op-7"> +۴۲٪</span>
                        </span>
                    </div>
                </div>
            </div>
            <span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
        </div>
    </div>

    <!-- کارت دوم: درآمد ماهانه -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-danger-gradient">
            <div class="ps-3 pt-3 pe-3 pb-2">
                <div>
                    <h6 class="mb-3 tx-12 text-white">درآمد ماه جاری</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div>
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                {{ isset($monthlyEarnings) ? number_format($monthlyEarnings) . ' تومان' : '۰' }}
                            </h4>
                            <p class="mb-0 tx-12 text-white op-7">در مقایسه با ماه گذشته</p>
                        </div>
                        <span class="float-right my-auto ms-auto">
                            <i class="fas fa-arrow-circle-down text-white"></i>
                            <span class="text-white op-7"> -۲۳٪</span>
                        </span>
                    </div>
                </div>
            </div>
            <span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
        </div>
    </div>

    <!-- کارت سوم: کاربران ثبت‌نامی -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-success-gradient">
            <div class="ps-3 pt-3 pe-3 pb-2">
                <div>
                    <h6 class="mb-3 tx-12 text-white">کاربران جدید امروز</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div>
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                {{ $todayUsersCount ?? 0 }} کاربر
                            </h4>
                            <p class="mb-0 tx-12 text-white op-7">کاربران فعال سیستم</p>
                        </div>
                        <span class="float-right my-auto ms-auto">
                            <i class="fas fa-arrow-circle-up text-white"></i>
                            <span class="text-white op-7"> +۵۲٪</span>
                        </span>
                    </div>
                </div>
            </div>
            <span id="compositeline3" class="pt-1">1,3,4,4,7,5,9,10,14,18,14,11,9,5,4,2,3,4,6,1</span>
        </div>
    </div>

    <!-- کارت چهارم: کل فروش (ERP / سایت) -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-warning-gradient">
            <div class="ps-3 pt-3 pe-3 pb-2">
                <div>
                    <h6 class="mb-3 tx-12 text-white">کل فروش سیستم</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div>
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                {{ isset($totalSalesAmount) ? number_format($totalSalesAmount) . ' تومان' : '۰' }}
                            </h4>
                            <p class="mb-0 tx-12 text-white op-7">همگام‌سازی شده با سیستم مالی</p>
                        </div>
                        <span class="float-right my-auto ms-auto">
                            <i class="fas fa-arrow-circle-up text-white"></i>
                            <span class="text-white op-7"> +۱۲٪</span>
                        </span>
                    </div>
                </div>
            </div>
            <span id="compositeline4" class="pt-1">3,4,4,7,5,9,10,6,4,4,7,5,9,10,12,14,11,9,5,1</span>
        </div>
    </div>

</div>
